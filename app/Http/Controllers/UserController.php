<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Rules\HoursRule;
use App\Rules\maxHoursRule;
use App\Rules\minHoursRule;


class UserController extends Controller
{
    //
	
	public function __construct()
    {
		$this->middleware('auth');
		/*
		if ( ! session()->get('pcre_jit'))
		{
			ini_set("pcre.jit", "0");
			session()->put('pcre_jit', 1); 
		}
		*/
		
    }
	
	
	
	
	public function index($exclueNonStore_warehouse_Staff=false )
	{
		// displays list of users 
		if (auth()->user()->hasPermissionTo('create_user'))
		{
			// get list of users and pass it to the userlist view
			if( $exclueNonStore_warehouse_Staff)
			{
				$users = User::where('empl_type','<>','Front Office')->orderBy('name')->get();
			}
			else
			{
				$users = User::orderBy('name')->get();
			}
			
			return view('userlist',compact('users','exclueNonStore_warehouse_Staff'));
		}
			
		else
			return view('notAuthorized');
	}
	
	
	public function edit (Request $request)
	{
		
		$id = $request->edit_user_id;
		$request->session()->put('user_id', $id);     // save user_id in session variable 
		$user = User::find($id);
		$stores = $this->getStoreCodes();
		$emplTypes = $this->getEmplTypes();
		$emplStatus  =  $this->getStatusTypes();
	//	dd($emplStatus, $user->status);
		return view('auth.edit',['user'=>$user, 'stores'=>$stores,
								 'emplTypes'=> $emplTypes, 
								 'emplStatus'=> $emplStatus, 
								 ]);
	}
	
	
	
	
	/**
	  * Creates a new user 
	  * Validates that email address is unique 
	  * and passwords are min 8 characters long
	  * On success: Returns  calling program with 'User created Successfully' message
	  * 
	  */
	 protected function create(Request $request)
    {
		 $request->validate([
             'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
		
        $user =  User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'name' => $request->firstname . ' '. $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
		
        return back()
            ->with('success','User ' . $request->firstname . ' ' . $request->lastname . ' Created Successfully');
        
    }
	
	
	
	/**
	  * Update user
	  * Validates that email address is unique 
	  * and passwords are min 8 characters long
	  * On success: Returns  calling program with 'User created Successfully' message
	  * 
	  */
	 protected function update(Request $request)
    {

		$id = session()->get('user_id');
		$request->validate([
             'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($id)],
		    "min_hours" => ["required", new minHoursRule(),  new maxHoursRule() ],
            "max_hours" => ["required", new HoursRule($request->min_hours), new minHoursRule(),  new maxHoursRule() ],

        ]);
		
		
		$user = User::find($id);

        $user->firstname = request('firstname');
        $user->lastname = request('lastname');
		$user->name = request('firstname') . ' ' . request('lastname');
        $user->min_hours = request('min_hours');
        $user->max_hours = request('max_hours');
        $user->email = request('email');
		$user->store_id = request('store_id');
		$user->empl_type = request('empl_type');
		$user->status = request('status');
        $user->save();
	
	return redirect('/userList')
         ->with('success','User ' . $request->firstname . ' ' . $request->lastname . ' Updated Successfully');
        
    }
	
	
	
	
	public static function getStoreCodes()
	{
		$query = "SELECT id, `name` AS text
								FROM stores 
				UNION 
					SELECT '', '-- Select --' 
				ORDER BY 1";
		return   DB::select( DB::raw($query));  

	}

	
	public static function getEmplTypes()
	{
		$emplTypes = [
			''=> '-- Select --',
			'Store'=>'Store',
			'Warehouse'=>'Warehouse',
			'Store/Warehouse'=>'Store/Warehouse',
			'Front Office'=>'Front Office',
		];
	
		return  $emplTypes;  

	}
	

	public static function getStatusTypes()
	{
		$staticTypes = [
			'Active'=>'Active',
			'Inactive'=>'Inactive',
			'Archive'=>'Archive',
		];
	
		return  $staticTypes;  
	}

	
}
