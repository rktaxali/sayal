<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;


class UserSchedule extends Mailable
{
    use Queueable, SerializesModels;

    public $schedule_id;
    public $user_id;
    private $scheduleData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($schedule_id, $user_id)
    {
        $this->schedule_id =$schedule_id; 
        $this->user_id =$user_id; 
        $this->schedule = [];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $query = "SELECT start_date,  u.name, u.firstname,ess.uuid
            FROM schedules s
            INNER JOIN employee_schedules_summary ess ON s.id = ess.schedule_id AND ess.user_id =  $this->user_id
            INNER JOIN users u ON u.id = ess.user_id
            WHERE s.id =  $this->schedule_id";
        $result = DB::select($query);
        $userData = $result[0];

        // fetch data for $schedule_id and  $user_id
        $query = "SELECT `date`, LEFT(starttime,5) AS starttime, 
                    LEFT(endtime,5) AS endtime, st.name AS store_name
                FROM employee_schedules s
                INNER JOIN stores st ON s.store_id = st.id
                WHERE s.schedule_id = $this->schedule_id AND s.user_id = $this->user_id";
        $this->scheduleData = DB::select($query);

        $this->subject('Your Weekly Schedue for Week Starting ' .$userData->start_date );

        return $this->view('emails.userSchedule',['userData'=>  $userData,'scheduleData'=>$this->scheduleData]);
    }
}
