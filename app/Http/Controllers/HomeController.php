<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userAcceptSchedule(Request $request, $uuid)
    {
        // Does the uuid exist 
        $query = "SELECT s.start_date, s.id AS schedule_id, u.name, ess.id 
            FROM employee_schedules_summary ess
            INNER JOIN schedules s ON ess.schedule_id = s.id
            INNER JOIN `users` u ON ess.user_id = u.id
            WHERE ess.uuid = '" . $uuid . "'  ";
        $result = DB::select($query);
        if ($result)
        {
            $row = $result[0];

            $message = "<span style='color: green;'>Hello $row->name, your Schedule for  the week starting " . 
                    $row->start_date . ' has been marked as Accepted.</span>';
         //       $message = "Schedule for the week starting " .                     $row->start_date . ' marked as Accepted.';                    
        }
        else
        {
            $message = "<span style='color: red;'>Invalid data Passed!</span>";
        }


        DB::table('employee_schedules_summary')
			->where('id', $row->id)
            ->update(['schedule_accepted' => date('Y-m-d H:i:s')]);
        
        return view('userScheduleAccepted', compact('message'));
    }
}
