<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Redirect,Response;
use PDF;


class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
	}
	
	// returns current schedules for the latest 4 schedueles. For Edit/create
	public function index()
	{
		if(auth()->user()->hasPermissionTo('create_store_schedule') )
        {
			
			$schedules = Schedule::orderBy('id', 'desc')
					->take(4)
					->get();
			return view('schedule',compact('schedules'));
		}
	}


	public function viewAllSchedules()
	{
		if(auth()->user()->hasPermissionTo('view_all_schedules') )
        {
			
			$schedules = Schedule::orderBy('id', 'desc')
					->take(8)
					->get();
			return view('viewSchedules',compact('schedules'));
		}
	}



	// display 4 lateset schedules for the logged in user or the passed user_id
	public function userSchedules($user_id = null)
	{
		$user_id = $user_id ? $user_id : auth()->user()->id; 
		$empl_type =  auth()->user()->empl_type;
		$showSchedule = $empl_type === 'Store' || $empl_type ==='Warehouse' || $empl_type === 'Store/Warehouse';
		
		$query = "SELECT s.id, s.start_date, '' as sch_data, 
			 if(ess.weekly_hours, ess.weekly_hours,'') as weekly_hours,
			 ess.id AS ess_id,
			 if(ess.schedule_accepted,date(schedule_accepted),'') as schedule_accepted
			FROM schedules s
			LEFT JOIN employee_schedules_summary ess ON ess.schedule_id = s.id AND ess.user_id = $user_id
			WHERE s.approved_user_id IS NOT NULL 
			ORDER BY s.id DESC LIMIT 4";

		$schedules = DB::select($query);
		$i=0;
		foreach ($schedules as $schedule)
		{
			// get weekly schedule and assign it to $schedule->sch_data
			$schedules[$i]->sch_data = $this->getEmplScheduleData($schedule->id, $user_id);
			$i++;
		}
		return view('home',compact('schedules','showSchedule'));
	}


	public function getEmplScheduleData($schedule_id, $user_id)
	{
		// get weekly schedule and assign it to $schedule->sch_data
		$query = "SELECT s.date, LEFT(s.starttime,5) AS starttime, LEFT(s.endtime,5) AS endtime, s.store_id,
			stores.name AS store_name,
			'' as holiday
			FROM employee_schedules s
			INNER JOIN stores ON s.store_id = stores.id
			WHERE s.schedule_id = '" .$schedule_id  ."' AND s.user_id = '$user_id'";
		$data = DB::select($query);
		return $data;
	}
	

	// returns number of hours allocated for the weekly schdele for the passed 
	// $user_id & $scheule_id 
	public static function getEmplScheduledHours( $schedule_id,$user_id)
	{
		$hours = 0;
		$minutes = 0 ;
		$query = "SELECT s.user_id, 
			left(TIMEDIFF(endtime,starttime),2) AS hours, 
			substring(TIMEDIFF(endtime,starttime),4,2) AS minutes
			FROM employee_schedules s
			WHERE s.schedule_id = $schedule_id AND s.user_id = $user_id";
		
	
		$schedules = DB::select($query);
	
		foreach ($schedules as $schedule)
		{
			$hours += intval($schedule->hours);
			
			$minutes += intval($schedule->minutes);
		}
		$hours = $hours + intval($minutes/60);
		$minutes =  ($minutes % 60);
		$hours+= $minutes/60;
	   return number_format(round($hours,2),2);

	}



	// returns schedules available to be approved
	public function approveSubmittedSchedules()
	{
		if(auth()->user()->hasPermissionTo('aprv_schedule') )
        {
			//	$schedules = Schedule::where('prepared_user_id','>',0)->get();
			$query = "SELECT *
					FROM schedules s
					WHERE s.prepared_user_id > 0
					ORDER BY id desc 
					LIMIT 6
					";
			$schedules = DB::select($query);
			return view('approveSchedule',compact('schedules'));
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
				if (! empty($request->schedule_id))
				{
					$schedule_id = $request->schedule_id;
				}
				elseif (! empty(session()->get('reopened_schedule_schedule_id')))
				{
					// we might have schedule_id saved in session 
					$schedule_id = session()->get('reopened_schedule_schedule_id');
				}
				else
				{
					die("something went wrong while editing a schedule..");
				}
				
				session()->put('schedule_id', $schedule_id);  
			}
			else
			{
				$schedule_id = session()->get('schedule_id');
			}

			$schedule = Schedule::where('id','=',$schedule_id)->get()->first();
			// fetch data from all active employees for all days for the selcted schedules 
	
			// display all active employees and an Add/Edit button 
			$query = "SELECT u.id as user_id, concat(u.firstname, ' ', u.lastname) AS name, '' as schedule, 
					u.min_hours, u.max_hours,
					COUNT(s.id) AS howmany,
						0 as weekly_hours, 
						'' as holiday
						FROM users u
						LEFT JOIN employee_schedules s ON u.id = s.user_id AND s.schedule_id = $schedule_id
						WHERE u.`status` = 'active' 
						     AND u.empl_type IN ('Store','Warehouse','Store/Warehouse')
						GROUP BY u.id, 2,3,4,5";
			$scheduleDetails = DB::select($query);
			
			if ($scheduleDetails)
			{
				// Update $scheduleDetails->schedule from $schArray
				for($i=0; $i< count($scheduleDetails); $i++)
				{
					$scheduleDetails[$i]->weekly_hours = $this->getEmplScheduledHours($schedule_id,$scheduleDetails[$i]->user_id);
					$scheduleDetails[$i]->schedule = $this->getEmplScheduleData($schedule_id, $scheduleDetails[$i]->user_id) ; // (! empty($schArray[$scheduleDetails[$i]->user_id]))  ? $schArray[$scheduleDetails[$i]->user_id] : '';
				}
			}

			$scheduleDays = $this->getScheduleDays();
			return view('scheduleDetails',compact('schedule','scheduleDetails','stores','scheduleDays'));
			
		}
	}
	

	// Save $scheule_id in session 
	public function save_schedule_id_in_Session(Request $request)
	{
		$retVal = false;
		if ( $request->schedule_id)
		{
			session()->put('reopened_schedule_schedule_id', $request->schedule_id);  
			$retVal = true;
		}
		return Response::json($retVal);
	}


	
	// Create the next schedule record in the schedules table
	// Also create 7 records (one for each day) in the schedule_dates table
	// TODO: Create Default schdule records for employees in the employee_schedules table <<----
	public function createSchedule()
	{
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {


			// first create a record in the schedules table with a date 7 days from the last start_date
			$query = "SELECT DATE_ADD(start_date, INTERVAL 7 DAY) AS start_date, DATE_ADD(start_date, INTERVAL 6 DAY) AS start_date_minus_one
					FROM schedules
					ORDER BY id DESC LIMIT 1";
			$result =  DB::select( DB::raw($query)); 
			if ($result)
			{
				$row = $result[0];
				$start_date = $row->start_date;
				$start_date_minus_one = $row->start_date_minus_one;
			}
			else
			{
				// use next Monday as the start_date
				$start_date = date("Y-m-d", strtotime('next monday'));
				//$from_unix_time = mktime(0, 0, 0, $month, $day, $year);
				$from_unix_time = mktime(0, 0, 0, substr($start_date,5,2), substr($start_date,8,2), substr($start_date,0,4));
				$day_before = strtotime("yesterday", $from_unix_time);
				$start_date_minus_one = date('Y-m-d', $day_before);
			}	

			
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
							($schedule_id,$i,DATE_ADD('$start_date_minus_one', INTERVAL $i DAY))";
						DB::insert($query);
						$i++;
					}
					
				}
				// Generate employee schedule records as per the default schedules available in the 
				// employee_default_schedules table for $schedule_id
				// for users that have 'status' = 'Active' and empl_type  in 'Store,Warehouse, Store/WareHouse'


			
				$query = "SELECT id AS user_id FROM users u
					WHERE u.`status` = 'Active' 
						AND u.empl_type IN ('Store','Warehouse','Store/Warehouse')";
				$users = DB::select($query);
				
				foreach($users as $user)
				{
					// create a record in employee_schedules_summary table 
					$ess_id = $this->generateEmployeeSchedule($schedule_id, $user->user_id);

					$query = "INSERT INTO employee_schedules
							(
								ess_id,   schedule_id, user_id, day,   date,  store_id, starttime, endtime, created_at
							)
							SELECT   $ess_id AS ess_id,  $schedule_id AS schedule_id, e.user_id, e.day, 
									sd.date,  e.store_id, starttime, endtime, NOW() AS created_at
										FROM employee_default_schedules e
										INNER JOIN schedule_dates sd ON sd.schedule_id = $schedule_id 
												AND e.day = sd.day_id
										# Also ensure that sd.date is not a holiday and the user is not on vacation on that day 
											AND sd.date NOT IN (SELECT `date` FROM holiday)
											  	AND sd.date NOT IN (SELECT `date` FROM vacation_details WHERE user_id = " . $user->user_id . ")
										WHERE 
											e.user_id = " . $user->user_id . "
										ORDER BY sd.day_id
										";
					DB::insert($query);
					// Update weekly_hours in employee_schedules_summary table
					$query = "SELECT id, user_id
							FROM employee_schedules_summary 
							WHERE schedule_id = $schedule_id";
					$usersToUpdate = DB::select($query);
					foreach($usersToUpdate as $userToUpdate)
					{				
						// Update weekly_hours in the employee_schedules_summary table
						DB::table('employee_schedules_summary')
						->where('id', $userToUpdate->id)
						->update(['weekly_hours' => $this->getEmplScheduledHours( $schedule_id,$userToUpdate->user_id)]);
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
					sd.date, d.day_abbr, u.min_hours, u.max_hours, eds.starttime, eds.endtime,
					if(v.date is NULL,'','Vacation') AS vacation
				FROM users u 
				INNER JOIN schedule_dates sd ON sd.schedule_id = '$schedule_id'
				INNER JOIN days d ON sd.day_id = d.id 
				LEFT JOIN employee_default_schedules eds ON u.id = eds.user_id AND d.id = eds.day
				LEFT JOIN vacation_details v ON sd.date = v.date AND v.user_id = u.id
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
		$query = "SELECT u.name,  sd.date, d.day_abbr, u.min_hours, u.max_hours, 
					left(s.starttime,5) as starttime, left(s.endtime,5) as endtime,
					s.store_id,
					if(v.date is NULL,'','Vacation') AS vacation
				FROM users u 
				INNER JOIN schedule_dates sd ON sd.schedule_id = '$schedule_id'
				INNER JOIN days d ON sd.day_id = d.id 
				LEFT JOIN employee_schedules s ON s.schedule_id = '$schedule_id' AND s.user_id = u.id AND d.id = s.day
				LEFT JOIN vacation_details v ON sd.date = v.date  AND v.user_id = u.id
				WHERE u.id = '$user_id'
					ORDER BY date
				";
		$emplSchedule =  DB::select( DB::raw($query)); 		
		
		
		
		// get basic data for the user and schedule_id 
		
		return Response::json($emplSchedule);
	}
	
	
	// get date, day_abbr and holiday for the current schedule
	// used while createing/editing the schedule for an employee in components/schedule_edit_modal.blade.php 
	// and components/schedule_create_modal.blade.php 
	public function getScheduleDays() 
	{
		$schedule_id = session()->get('schedule_id');
		$query = "SELECT d.id as day_id, sd.date, d.day_abbr, 
					h.name as holiday
				FROM  schedule_dates sd 
				INNER JOIN days d ON sd.day_id = d.id 
				LEFT JOIN holiday h ON sd.date = h.date
				WHERE sd.schedule_id = '$schedule_id'
				ORDER BY day_id
				";
		$scheduleDays =  DB::select( DB::raw($query)); 		
		return $scheduleDays;
	
	}
	
	

	
	public function createEmployeeSchedule(Request $request)
	{
		$retval = false;
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedule_id = session()->get('schedule_id');	
			$user_id = $request->input('scheduleCreate_user_id');
			$ess_id = $this->generateEmployeeSchedule($schedule_id,$user_id);
			for($i=1; $i<8; $i++)
			{
				$starttime = $request->input('starttime_'.$i);
				$endtime = $request->input('endtime_'.$i);
				if ($starttime && $endtime)
				{
					DB::table('employee_schedules')->insert(
						[
							'schedule_id' => $schedule_id,
							'ess_id' =>$ess_id,
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
			// Update weekly_hours in the employee_schedules_summary table
			DB::table('employee_schedules_summary')
              ->where('id', $ess_id)
              ->update(['weekly_hours' => $this->getEmplScheduledHours( $schedule_id,$user_id)]);
		
			$retval = true;
			 
		}
		return Response::json($retval);
	}



	// creates a record in the employee_schedules_summary table 
	public function  generateEmployeeSchedule($schedule_id, $user_id)
	{
		DB::table('employee_schedules_summary')->insert(
			[
				'schedule_id' => $schedule_id,
				'user_id'=> $user_id,
				'created_user_id' => auth()->user()->id,
				'created_at'=> date('Y-m-d H:i:s'),
				'uuid' =>bin2hex(random_bytes(16)),
			]
		);		
		return  DB::getPdo()->lastInsertId();
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
			// Update weekly_hours in the employee_schedules_summary table
			DB::table('employee_schedules_summary')
			  ->where('user_id', $user_id)
			  ->where('schedule_id',$schedule_id)
              ->update(['weekly_hours' => $this->getEmplScheduledHours( $schedule_id,$user_id)]);

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


	public function submitForApproval(Request $request)
	{
		$retVal = false;
		if(auth()->user()->hasPermissionTo('create_store_schedule'))
        {
			$schedule_id = $request->schedule_id;
			$user_id =auth()->user()->id;
			$retVal = Schedule::where('id', $schedule_id)->update(['prepared_user_id' => $user_id]);
		}
		return Response::json($retVal);
	}


	
	public function approveSchedule(Request $request)
	{
		$retVal = false;
		if(auth()->user()->hasPermissionTo('aprv_schedule'))
        {
			$schedule_id = $request->schedule_id;
			$user_id =auth()->user()->id;
			$retVal = Schedule::where('id', $schedule_id)->update(['approved_user_id' => $user_id]);
		}
		return Response::json($retVal);
	}

	
	/**
	 * Prepares AllEmployees or AllStores Schedule for display or download 
	 * When it prepares schedule for employees, it also lists total weekly Hours
	 * 
	 For the passed $schedule_id, return a collection of schedules for each store 
	 * Each store schedule list all employees, their daily schedule and total weekly hours.
	 * 
	 * 
	 * 
	 * array:8 [▼
  0 => {#365 ▼
    +"id": 1
    +"name": "Scarborough"
    +"phone": null
    +"email": "scarborough@sayal.com"
    +"address": null
    +"city": null
    +"postalcode": null
    +"created_at": "2020-11-25 11:20:49"
    +"schedule": array:7 [▼
      "2020-12-14" => array:3 [▼
        0 => {#1306 ▼
          +"id": 7
          +"name": "Ajay Sharma"
          +"ess_id": 142
          +"schedule_id": 1
          +"user_id": 16
          +"day": 1
          +"date": "2020-12-14"
          +"store_id": 1
          +"starttime": "08:30:00"
          +"endtime": "17:30:00"
          +"created_at": null
          +"updated_at": null
	 */
	public function viewScheduleDetails(Request $request)
	{
		// There are 4 Submit Buttons: stores_schedule_id, employees_schedule_id, downloadEmployeeSchedule &&  downloadAllStoresSchedule. 
		// All contain schedule_id
		if ( ! empty($request->stores_schedule_id) )
		{
			$schedule_id = $request->stores_schedule_id;
			$schedule = Schedule::find($schedule_id);
			$stores = DB::select('Select * from stores');
			$store_schedules = [];
			$i=0;
			foreach ($stores as $store)
			{
				$store_schedule = $this->getStoreSchedule($schedule_id,$store->id);
				//$store_schedules[] = $store_schedule;
				$stores[$i]->schedule = $store_schedule;
				$i++;
			}
			return view('viewAllStoresSchedule',compact('schedule','stores'));
		}
		elseif  ( ! empty($request->employees_schedule_id) )
		{
			$schedule_id = $request->employees_schedule_id;
			$schedule = Schedule::find($schedule_id);
			// Display schedule for each employee 
			//$schedule = Schedule::where('id','=',$schedule_id)->get()->first();
			// fetch data from all active employees for all days for the selcted schedules 
			
			// display all active employees and schedule accepted/pending icon 
			$query = "SELECT u.id as user_id, concat(u.firstname, ' ', u.lastname) AS name, '' as schedule, 
							0 as weekly_hours, u.min_hours, u.max_hours,
							s.schedule_accepted
						FROM users u
						LEFT JOIN employee_schedules_summary s ON u.id = s.user_id AND s.schedule_id = $schedule_id
						WHERE u.`status` = 'active' AND u.empl_type in ('Store','Warehouse','Store/Warehouse')
						";
			$scheduleDetails = DB::select($query);
			if ($scheduleDetails)
			{
				// Update $scheduleDetails->schedule from $schArray
				for($i=0; $i< count($scheduleDetails); $i++)
				{
					$scheduleDetails[$i]->weekly_hours = $this->getEmplScheduledHours($schedule_id,$scheduleDetails[$i]->user_id);
					$scheduleDetails[$i]->schedule = $this->getEmplScheduleData($schedule_id, $scheduleDetails[$i]->user_id) ; // (! empty($schArray[$scheduleDetails[$i]->user_id]))  ? $schArray[$scheduleDetails[$i]->user_id] : '';
				}
			}


			$scheduleDays = $this->getScheduleDays();
			return view('viewScheduleDetailsEmployees',compact('schedule','scheduleDetails','scheduleDays'));
		}
		elseif ( ! empty($request->downloadEmployeeSchedule)) 
		{
			// PDF for each employee 
			$schedule_id = $request->downloadEmployeeSchedule; 
			return redirect('/createAllEmployeesSchedulePDF/'.$schedule_id);
		}
		elseif ( ! empty($request->downloadAllStoresSchedule)) 
		{
			// PDF for all stores
			$schedule_id = $request->downloadAllStoresSchedule; 
			return redirect('/createAllStoresSchedulePDF/'.$schedule_id);
		}
		
	}


	public function viewStoreSchedule()
	{
		
		if(auth()->user()->hasPermissionTo('view_store_schedule') )
        {
			$store_id = auth()->user()->store_id;
			$schedules = Schedule::orderBy('id', 'desc')
					->take(8)
					->get();
			return view('viewStoreSchedules',compact('schedules'));
		}
		

	}

	// The form will be posted either on clicking the  viewStoreSchedule button or 
	// the downloadStoreSchedule button
	public function viewStoreScheduleDetails(Request $request)
	{
		if (! empty( $request->viewStoreSchedule))
		{
			$schedule_id = $request->viewStoreSchedule; 
			$store_id = auth()->user()->store_id;

			$schedule = Schedule::find($schedule_id);
			// get store name
			$store = DB::select("SELECT  `name` FROM stores where id = '$store_id ' ");
			$row = $store[0];
			$schedule->store_name = $row->name;

			$schedule->store_schedule = $this->getStoreSchedule($schedule_id,$store_id);
		
			return view('viewSpecificStoresSchedule',compact('schedule'));	
		}
		elseif (! empty( $request->downloadStoreSchedule))
		{
			
			$schedule_id = $request->downloadStoreSchedule; 
			return redirect('/createStoreSchedulePDF/'.$schedule_id);
			
		}
	}


	// Returns schedule data for a specific store
	public function getStoreScheduleDetails($schedule_id, $store_id)
	{
		$schedule = Schedule::find($schedule_id);
		$schedule->schedule = $this->getStoreSchedule($schedule_id,$store->id);
		return view('viewStoresSchedule',compact('schedule'));
	}
	

	// Returns store schedule for the passed schedule id
	public function getStoreSchedule($schedule_id, $store_id)
	{
		$returnArray = [];
		$dates = DB::table('schedule_dates')->where('schedule_id','=',$schedule_id)->get();
	
		foreach($dates as $date)
		{
		//	dd($date->date, $date->id);
			$query = "SELECT s.id, u.name, es.*
				FROM schedules s
				INNER JOIN employee_schedules es ON s.id = es.schedule_id 
						AND es.store_id = '$store_id' AND es.day = $date->day_id
				INNER JOIN users u ON es.user_id = u.id
				WHERE s.id = '$schedule_id'
				ORDER BY  es.date, u.name";
			
			$returnArray[$date->date] = DB::select($query);
		}
		
		return $returnArray;
	}

	
	public function userAcceptSchedule(Request $request)
	{
		DB::table('employee_schedules_summary')
			->where('id', $request->ess_id)
			->update(['schedule_accepted' => date('Y-m-d H:i:s')]);
		return back()
			->with('success','Schedule marked as Acccepted.');

	}
	
	public function sendScheduleEmails(Request $request)
	{
		$emailsCount = 0 ;
		ini_set('max_execution_time', 900);  // 15 minutes 
		// Fetch employees to send the schedule emails for the passed $schedule_id 
		$retVal = [];
		$schedule_id = $request->schedule_id;
		$query = "SELECT ess.user_id, u.email, u.name
			FROM employee_schedules_summary ess 
			INNER JOIN users u ON ess.user_id = u.id
			WHERE ess.schedule_id = '$schedule_id' ";
		$result = DB::select($query);
		foreach ($result as $user)
		{
			$this->sendUserScheduleEmail($schedule_id, $user->user_id,$user->email );
			$emailsCount++;
		}
		
		// store emails 
		$query = "SELECT id as store_id, email FROM stores";
		$result = DB::select($query);
		foreach ($result as $store)
		{
			$this->sendStoresScheduleEmail($schedule_id, $store->store_id,$store->email );
			$emailsCount++;
		}
	
		$retVal = $emailsCount;
		// Update schedules->email_sent_user_id
		DB::table('schedules')
			->where('id', $schedule_id)
			->update(['emails_sent_user_id' => auth()->user()->id,
					'emails_sent_at' => date('Y-m-d H:i:s')
			]);
		
		
		return Response::json($retVal);
		
	}

	public function sendUserScheduleEmail($schedule_id, $user_id, $email)
	{
		$email = 'rktaxali@gmail.com';
		\Mail::to($email)
			->send(new \App\Mail\UserSchedule($schedule_id,$user_id));


	}

	public function sendStoresScheduleEmail($schedule_id, $store_id, $email)
	{
		$email = 'rktaxali@gmail.com';
		\Mail::to($email)
			->send(new \App\Mail\StoreSchedule($schedule_id,$store_id));


	}
	
	public function createStoreSchedulePDF($schedule_id)
	{
		$store_id = auth()->user()->store_id;
		$query = "Select `name` FROM stores WHERE id = '$store_id'";
		$result = DB::select($query);
		$store_name = $result[0]->name;
		
		
		$schedule = Schedule::find($schedule_id);
		$schedule->store_name = $store_name;
		$schedule->store_schedule = $this->getStoreSchedule($schedule_id,$store_id);
	
		  // share data to view
		  view()->share('pdfStoreSchedules',compact('schedule'));
		  $pdf = PDF::loadView('pdfStoreSchedules', compact('schedule'));

		  // download PDF file with download method
		  $filename = 'Schedule_' . $store_name  .'_' . $schedule->start_date . ".pdf";
		  return $pdf->download( $filename);
	}


	public function createAllEmployeesSchedulePDF($schedule_id)
	{
		$schedule = Schedule::find($schedule_id);
		// Display schedule for each employee 
		//$schedule = Schedule::where('id','=',$schedule_id)->get()->first();
		// fetch data from all active employees for all days for the selcted schedules 
		
		// Get each active Employee  active employees and schedule accepted/pending icon 
		$query = "SELECT u.id as user_id, concat(u.firstname, ' ', u.lastname) AS name, '' as schedule, 
						0 as weekly_hours,u.max_hours, u.min_hours,
						s.schedule_accepted
					FROM users u
					LEFT JOIN employee_schedules_summary s ON u.id = s.user_id AND s.schedule_id = $schedule_id
					WHERE u.`status` = 'active' AND u.empl_type in ('Store','Warehouse','Store/Warehouse')
					";
		$scheduleDetails = DB::select($query);
		if ($scheduleDetails)
		{
			// Update $scheduleDetails->schedule from $schArray
			for($i=0; $i< count($scheduleDetails); $i++)
			{
				$scheduleDetails[$i]->weekly_hours = $this->getEmplScheduledHours($schedule_id,$scheduleDetails[$i]->user_id);
				$scheduleDetails[$i]->schedule = $this->getEmplScheduleData($schedule_id, $scheduleDetails[$i]->user_id) ; // (! empty($schArray[$scheduleDetails[$i]->user_id]))  ? $schArray[$scheduleDetails[$i]->user_id] : '';
			}
		}

		$scheduleDays = $this->getScheduleDays();
					
			// share data to view
		view()->share('pdfScheduleDetailsEmployees',compact('schedule','scheduleDetails','scheduleDays'));
		$pdf = PDF::loadView('pdfScheduleDetailsEmployees', compact('schedule','scheduleDetails','scheduleDays'));

		  // download PDF file with download method
		  $filename = 'EmployeesSchedule_' . $schedule->start_date . ".pdf";
		  return $pdf->download( $filename);
			
	}
	
	
	
	public function createAllStoresSchedulePDF($schedule_id)
	{
		$schedule = Schedule::find($schedule_id);
		$stores = DB::select('Select * from stores');
		$store_schedules = [];
		$i=0;
		foreach ($stores as $store)
		{
			$store_schedule = $this->getStoreSchedule($schedule_id,$store->id);
			//$store_schedules[] = $store_schedule;
			$stores[$i]->schedule = $store_schedule;
			$i++;
		}
		
		// share data to view
		view()->share('pdfAllStoresSchedule',compact('schedule','stores'));
		$pdf = PDF::loadView('pdfAllStoresSchedule', compact('schedule','stores'));

		// download PDF file with download method
		$filename = 'AllStoresSchedule_' . $schedule->start_date . ".pdf";
		return $pdf->download( $filename);
	}
	
	
	
	public function deleteSchedule($schedule_id)
	{
		// delete all records related to a schedule
		$query = "DELETE  es, ess
			FROM employee_schedules es 
			LEFT JOIN employee_schedules_summary ess ON  ess.schedule_id = es.schedule_id AND es.ess_id = ess.id
			WHERE es.schedule_id = '$schedule_id'
			";
		DB::statement($query);
		$query = "
			DELETE s, sd
			FROM schedules s
			INNER JOIN schedule_dates sd ON s.id = sd.schedule_id
			WHERE s.id = '$schedule_id'";
		DB::statement($query);
		return "Schedule deleted";
		
	}

}	



