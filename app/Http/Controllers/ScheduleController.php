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
			$stores = UserController::getStoreCodes();
			
			if ( $request->method() === 'POST') 
			{
				// save $schedule_id for use at the time of saving data 
				$schedule_id = $request->schedule_id;
				session()->put('schedule_id', $schedule_id);  
			}
			else
			{
				$schedule_id = session()->get('schedule_id');
			}
			
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
				$query = "SELECT user_id, GROUP_CONCAT(' ',s.date, ': ', left(s.starttime,5), '-' ,left(s.endtime,5), ' ', st.name ) AS empl_schedule
						FROM employee_schedules s
						LEFT JOIN stores st ON s.store_id = st.id
						WHERE s.schedule_id = $schedule_id
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
			
			$scheduleDays = $this->getScheduleDays();
			return view('scheduleDetails',compact('scheduleDetails','stores','scheduleDays'));
			
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
		$schedule_id = session()->get('schedule_id');
		$user_id =  $request->user_id;
		$query = "SELECT `name`, if(eds.store_id IS NULL, u.store_id, eds.store_id) AS store_id, 
				sd.date, d.day_abbr, u.min_hours, u.max_hours, eds.starttime, eds.endtime
				FROM users u 
				INNER JOIN schedule_dates sd ON sd.schedule_id = '$schedule_id'
				INNER JOIN days d ON sd.day_id = d.id 
				LEFT JOIN employee_default_schedules eds ON u.id = eds.user_id AND d.id = eds.day
				WHERE u.id = '$user_id' ";
		$emplSchedule =  DB::select( DB::raw($query)); 		
		
		
		
		// get basic data for the user and schedule_id 
		
		return Response::json($emplSchedule);
	}
	
	public function userScheduleData(Request $request) 
	{
		$schedule_id = session()->get('schedule_id');
		$user_id =  $request->user_id;
		session()->put('schedule_user_id',$user_id);
		$query = "SELECT `name`,  sd.date, d.day_abbr, u.min_hours, u.max_hours, 
				left(s.starttime,5) as starttime, left(s.endtime,5) as endtime,
				s.store_id
				FROM users u 
				INNER JOIN schedule_dates sd ON sd.schedule_id = '$schedule_id'
				INNER JOIN days d ON sd.day_id = d.id 
				LEFT JOIN employee_schedules s ON s.schedule_id = '$schedule_id' AND s.user_id = u.id AND d.id = s.day
				WHERE u.id = '$user_id'";
		$emplSchedule =  DB::select( DB::raw($query)); 		
		
		
		
		// get basic data for the user and schedule_id 
		
		return Response::json($emplSchedule);
	}
	
	
	// get date and day_abbr for the current schedule
	public function getScheduleDays() 
	{
		$schedule_id = session()->get('schedule_id');
		$query = "SELECT d.id as day_id, sd.date, d.day_abbr
				FROM  schedule_dates sd 
				INNER JOIN days d ON sd.day_id = d.id 
				WHERE sd.schedule_id = '$schedule_id'";
		$scheduleDays =  DB::select( DB::raw($query)); 		
		return $scheduleDays;
	
	}
	
	
	
	/*
"_token" => "G6tAHvLhZpQZ8bxaJ1trJFf6zJT3GCFWlOgFCs86"
       "_token" => "G6tAHvLhZpQZ8bxaJ1trJFf6zJT3GCFWlOgFCs86"
      "scheduleCreate_user_id" => "5"
      "date_1" => "2020-11-30"
      "starttime_1" => "08:00"
      "endtime_1" => "17:00"
      "store_id_1" => "1"
      "date_2" => "2020-12-01"
      "starttime_2" => "08:00"
      "endtime_2" => "17:00"
      "store_id_2" => "1"
      "date_3" => "2020-12-02"
      "starttime_3" => "08:00"
      "endtime_3" => "17:00"
      "store_id_3" => "1"
      "date_4" => "2020-12-03"
      "starttime_4" => "08:00"
      "endtime_4" => "17:00"
      "store_id_4" => "1"
      "date_5" => "2020-12-04"
      "starttime_5" => "08:00"
      "endtime_5" => "17:00"
      "store_id_5" => "1"
      "date_6" => "2020-12-05"
      "starttime_6" => null
      "endtime_6" => null
      "store_id_6" => "1"
      "date_7" => "2020-12-06"
      "starttime_7" => null
      "endtime_7" => null
      "store_id_7" => "1"
	
	
	
	*/
	
	public function createEmployee(Request $request)
	{
		$retval = false;
		//dd($request->scheduleCreate_user_id);
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedule_id = session()->get('schedule_id');	
			for($i=1; $i<8; $i++)
			{
				$starttime = $request->input('starttime_'.$i);
				$endtime = $request->input('endtime_'.$i);
				
				if ($starttime && $endtime)
				{
					DB::table('employee_schedules')->insert(
						[
							'schedule_id' => $schedule_id,
							'day' => $i,
							'starttime' => $starttime,
							'endtime' => $endtime,
							'user_id'=> $request->input('scheduleCreate_user_id'),
							'date'=> $request->input('date_'.$i),
							'store_id'=> $request->input('store_id_'.$i),
						]
					);		
				}
				
			}
			$retval = true;
			 
		}
		return Response::json($retval);
	}


	// Delete existing data from employee_schedules and create new records 
	public function updadeUserScheduleData(Request $request)
	{
		$retval = false;
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedule_id = session()->get('schedule_id');
			$user_id = session()->get('schedule_user_id');
			
			DB::table('employee_schedules')->where('schedule_id', '=', $schedule_id)->where('user_id', '=', $user_id)->delete();

			for($i=1; $i<8; $i++)
			{
				$starttime = $request->input('starttime_'.$i);
				$endtime = $request->input('endtime_'.$i);
				
				if ($starttime && $endtime)
				{
					DB::table('employee_schedules')->insert(
						[
							'schedule_id' => $schedule_id,
							'day' => $i,
							'starttime' => $starttime,
							'endtime' => $endtime,
							'user_id'=> $user_id,
							'date'=> $request->input('date_'.$i),
							'store_id'=> $request->input('store_id_'.$i),
						]
					);		
				}
				
			}
			$retval = true;
			 
		}
		return Response::json($retval);
	}


	// Deletes user schedule data as per 
	public function deleteUserScheduleData(Request $request)
    {
		$retval = false;
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedule_id = session()->get('schedule_id');
			$user_id = $request->user_id;
			
			DB::table('employee_schedules')->where('schedule_id', '=', $schedule_id)->where('user_id', '=', $user_id)->delete();
			$retval = true;
		}
		return Response::json($retval);
	}

	public function saveAsDefaultSchedule(Request $request)
    {
		$retval = false;
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedule_id = session()->get('schedule_id');
			$user_id = $request->user_id;
			DB::table('employee_default_schedules')->where('user_id', '=', $user_id)->delete();

			$query = "INSERT INTO employee_default_schedules
						(
							user_id, `day`, store_id, starttime, endtime
						)
						SELECT e.user_id, e.day, e.store_id, e.starttime, endtime
						FROM employee_schedules e
						WHERE e.schedule_id = '$schedule_id'
							AND e.user_id = '$user_id'
							ORDER BY day";
			DB::statement( $query );
			$retval = true;
		}
		return Response::json($retval);
	}

	
}
