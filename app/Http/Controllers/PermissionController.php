<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Displays permissions for all users
    // TODO: Display users list filtered by first/last name
    public function index(Request $request)
    {
        if(auth()->user()->hasPermissionTo('Permission'))
        {
            $users =  DB::table("users")->orderBy('id')->get(); 
              
            $permissions =  DB::table("permissions")->get();
            foreach ( $permissions  AS  $permission)
            {
                // for each permission_id, findout users with that permission (available in the model_has_permissions table)
                $permission_id = $permission->id;
                $query = "SELECT u.id, if(mp.permission_id,1,0) As has_permission, permissions.name
                    FROM users u
                    LEFT JOIN permissions ON permissions.id =  $permission_id
                    LEFT  JOIN model_has_permissions mp ON u.id = mp.model_id AND mp.permission_id =  $permission_id
                   ORDER BY u.id 
                    ";
                $user_permissions   =  $client = DB::select( DB::raw($query));
                // $user_permissions contains user_ids and has_permission= 1 if user has permission for permissions.name
                // add the permission_name and permission value (has_permission)
                // in the $users collection
                $i=0;
                foreach ( $user_permissions AS $user_permission)
                {
                    $user_id = $user_permission->id;
                    $permission_name =  $user_permission->name;
                    $users[$i]->$permission_name =  $user_permission->has_permission;
                    $i++;
                }
                
            }
            return view('permissions',compact('users'));
        }
        else
        {
            return view('notAuthorized');
        }
   
    }

    // Update user permissions in the model_has_permissions table
    public function store(Request $request)
    {
        // Create an array containing 'name' as key and id as value 
         // based on checked permissions submitted from the premission view.
        // This will be used later to create records in model_has_permissions
        $items = DB::table('permissions')->pluck('id', 'name');
        $permissionArray = [];
        foreach ($items as $name => $id) {
            $permissionArray[$name]  = $id;
        }

        // Clear all permissions from the model_has_permissions except 'Permission' permission
        DB::table('model_has_permissions')->where('permission_id', '<>', 7)->delete();

        // For each request input (except '_token'), create a record in model_has_permissions
        // request input has format like name_userID, e.g. housing_4, create_client_3
        //  e.g. $key = housing_3 means user.id = 3 has permission for 'housing'
        foreach ($request->all() as $key=>$str)
        {
           if ($key ==='_token')  continue;
            $user_id = substr($key, strrpos($key, "_", -1) + 1);  
            $permission = substr($key, 0,strrpos($key, "_", -1));
            $permission_id = $permissionArray[ $permission];
            
            DB::table('model_has_permissions')->insert(
                ['permission_id' => $permission_id,
                 'model_id' =>  $user_id,
                 'model_type' => 'App\Models\User'
                 ]
            );
        }
        return  back()
             ->with('success','User permissions have been updated');
       
    }
}
