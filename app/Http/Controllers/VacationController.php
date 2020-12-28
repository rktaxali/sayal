<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
            $users = User::where('status','=','Active')->orderBy('name')->get();
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



	/**
	 * Returns vacation records for the current year and later for the passed user id
	 */
	public function viewVacations(Request $request)
    {
		// Save passed user_id. It will be used while saving the vacation record 
		if ($request->view_vacation_user_id)
		{
			session()->put('view_vacation_user_id',$request->view_vacation_user_id);
		}
		$view_vacation_user_id = session()->get('view_vacation_user_id');
		$year = date('Y');
		$vacations = Vacation::where('year','>=',$year)
					->where('user_id',$view_vacation_user_id)
					->orderBy('start_date')
					->get();
		$user = User::find($view_vacation_user_id);
		return view('vacationDetails',compact('vacations','user'));					

	}

	/**
	 * Delete vacation records for the passed vacation id
	 * Deletes records from the vacation & vacation_details tables
	 */

	public function deleteVacation(Request $request)
    {
		
		$retval = false;
		if(auth()->user()->hasPermissionTo('holiday_vacation'))
        {
			$id = $request->vacation_id;
			Vacation::where('id',$id)->delete();
			// Next, delete records from the vacation_detail table
			DB::table('vacation_details')->where('vacation_id',$id)->delete();
			$retval = true;
		}
		return Response::json($retval);
	}
	


    /**
	 * First creates a record in the vacation table and then create 
	 * records in the vacation_details table, one record for each day of the vacation, e.g.
	 * for 2020-12-03 to 2020-12-05, it creates 3 records in the vacation_details table
	 */
    public function createVacation(Request $request)
    {
		$retval = false;
		if(auth()->user()->hasPermissionTo('holiday_vacation'))
        {
            $vacation =  Vacation::create([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
				'year' => substr($request->start_date,0,4),
				'user_id' =>  session()->get('view_vacation_user_id'),
                'create_user_id' => auth()->user()->id,
				'created_at' =>  date('Y-m-d H:i:s'),
				'updated_at' =>  date('Y-m-d H:i:s'),

			]);
			$vacation_id = DB::getPdo()->lastInsertId();
			// Next create records in the vacation_details table
			$time = strtotime($request->start_date);
			$end = strtotime($request->end_date);
			
			do {
				$date = date('Y-m-d',$time);
				DB::table('vacation_details')->insert( 
						[
							'vacation_id' =>$vacation_id,
							'date' => $date,
							'user_id' =>session()->get('view_vacation_user_id'),
						]
					);
				$time += 24*60*60;
			} while ($end  >= $time );
            
			$retval = true;
		}
		return Response::json($retval);
    }


}



