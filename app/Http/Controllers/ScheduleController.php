<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Redirect,Response;


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
			
			// display all active employees and an Add/Edit button 
			$query = "SELECT u.id as user_id, concat(u.firstname, ' ', u.lastname) AS name, '' as schedule, COUNT(s.id) AS howmany
						FROM users u
						LEFT JOIN employee_schedules s ON u.id = s.user_id AND s.schedule_id = $schedule_id
						WHERE u.`status` = 'active'
						GROUP BY u.id, 2,3";
			$scheduleDetails = DB::select($query);
			if ($scheduleDetails)
			{
				// get employee_schedules data for each employee for the current schedule_id
				$query = "SELECT user_id, GROUP_CONCAT(' ',s.date, ': ', left(s.start_time,5), '-' ,left(s.end_time,5), ' ', st.name ) AS empl_schedule
						FROM employee_schedules s
						LEFT JOIN stores st ON s.store_id = st.id
						WHERE s.schedule_id = 1
						GROUP BY s.user_id";
				$result= DB::select($query);
				$array = (array)$result;
				$schArray=[];
				// convert $result into an associative array with user_id as key
				foreach ($array as $key=>$val)
				{
					$schArray[$val->user_id] = $val->empl_schedule;
				}
	
				// Update $scheduleDetails->schedule from $schArray
				for($i=0; $i< count($scheduleDetails); $i++)
				{
					$scheduleDetails[$i]->schedule = (! empty($schArray[$scheduleDetails[$i]->user_id]))  ? $schArray[$scheduleDetails[$i]->user_id] : '';
				}
			}
			//dd($scheduleDetails);
			return view('scheduleDetails',compact('scheduleDetails'));
			
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
	
	
	public function userScheduleBasicData(Request $request) 
	{
		return Response::json($request);
	}
	
	
	
	
}
