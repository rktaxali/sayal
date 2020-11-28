<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;


class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
	}
	
	// returns current schedules 
	public function index()
	{
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedules = Schedule::all();
			//dd($schedules);
			return view('schedule',compact('schedules'));
		}
	}
	
	
	/**
	  * Display Schedule details for the selected schedule 
	  * Also display all employees (active or scheduable) along with their schedules for each employees 
	  * Need to have Edit/Create button to create/edit employee schedule 
	  */
	
	public function edit(Request $request)
	{
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedule_id = $request->schedule_id;
			// save $schedule_id for use at the time of saving data 
			session()->put('schedule_id', $schedule_id);  
			// fetch data from all active employees for all days for the selcted schedules 
			
			$scheduleObject = Schedule::where('id','=',$schedule_id)->get()->first();
			$schedule_date = $scheduleObject->start_date;
			dd($schedule_date);
			
		}
	}
	
	
	// Create the next schedule record in the schedules table
	// Also create 7 records (one for each day) in the schedule_dates table
	// TODO: Create Default schdule records for employees in the employee_schedules table <<----
	public function createSchedule()
	{
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			// first create a record in the schedules table with a date 7 days from the last start_date
			$query = "SELECT DATE_ADD(start_date, INTERVAL 7 DAY) AS start_date, DATE_ADD(start_date, INTERVAL 6 DAY) AS schedule_start_date
					FROM schedules
					ORDER BY id DESC LIMIT 1";
			$result =  DB::select( DB::raw($query)); 
			$row = $result[0];	
			$start_date = $row->start_date;
			$schedule_start_date = $row->schedule_start_date;
			if (DB::table('schedules')->insert( 
					[
						'start_date' => $start_date,
						
					]
				))
			{
				$schedule_id = DB::getPdo()->lastInsertId();
				
				// create 7 records in the schedule_details table
				if ($schedule_id)
				{
					$i=1; 
					while ($i<8)
					{
						$query = "INSERT INTO schedule_dates 
							(schedule_id, `day_id`, `date` )
							VALUES
							($schedule_id,$i,DATE_ADD('$schedule_start_date', INTERVAL $i DAY))";
						DB::insert($query);
						$i++;
					}
					
				}
				
			}
			 return back()
				->with('success','New Schedule Created Successfully');
			
		}
	}
	
	
	
	
}
