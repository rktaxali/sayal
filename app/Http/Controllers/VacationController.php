<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;
use Redirect,Response;


class VacationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
	}
	
	// returns  holidays for the current year oward for edit/delete
	public function index()
	{
		if(auth()->user()->hasPermissionTo('holiday_vacation') )
       {
            $users = User::orderBy('name')->get();
         
         //   $vacations = Vacation::where('year','>=',date('Y'))
          //          ->orderBy('date')
			//		->get();
			return view('vacation',compact('users'));
       }
       else
       {
        return view('notAuthorized');
       }
    }
    

/*
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
 */   

	public function deleteVacation(Request $request)
    {
		$retval = false;
		if(auth()->user()->hasPermissionTo('holiday_vacation'))
        {
			$id = $request->holiday_id;
			Vacation::where('id',$id)->delete();
			$retval = true;
		}
		return Response::json($retval);
    }
    
    public function createVacation(Request $request)
    {
        $retval = false;
		if(auth()->user()->hasPermissionTo('holiday_vacation'))
        {
            $holiday =  Vacation::create([
                'name' => $request->name,
                'date' => $request->date,
                'year' => substr($request->date,0,4),
                'created_user_id' => auth()->user()->id,
                'created_at' =>  date('Y-m-d H:i:s'),
            ]);
            
			$retval = true;
		}
		return Response::json($retval);
    }


}



