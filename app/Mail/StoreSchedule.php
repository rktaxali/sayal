<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

class StoreSchedule extends Mailable
{
    use Queueable, SerializesModels;
	
	public $schedule_id;
    public $store_id;
	private $scheduleData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($schedule_id, $store_id)
    {
        $this->schedule_id =$schedule_id; 
        $this->store_id =$store_id; 
        $this->schedule = [];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		// get store name & the schedule start_date
		$store = DB::select("SELECT  `name`,  s.start_date 
				FROM stores 
				INNER JOIN schedules s ON s.id = $this->schedule_id
				where stores.id = '$this->store_id ' ");
		$row = $store[0];
		$store_name = $row->name;
		$start_date = $row->start_date;
		$schedule = $this->getStoreSchedule();
		
		$this->subject('Your Weekly Schedue for Week Starting '  );

        return $this->view('emails.storeSchedule',[ 'store_name'=> $store_name,  'start_date'=>$start_date , 'schedule'=>  $schedule]);
    }
	
	// Returns store schedule for the passed schedule id
	public function getStoreSchedule()
	{
		$returnArray = [];
		$dates = DB::table('schedule_dates')->where('schedule_id','=',$this->schedule_id)->get();
	
		foreach($dates as $date)
		{
			$query = "SELECT s.id, u.name, es.*
				FROM schedules s
				INNER JOIN employee_schedules es ON s.id = es.schedule_id 
						AND es.store_id = '$this->store_id' AND es.day = $date->day_id
				INNER JOIN users u ON es.user_id = u.id
				WHERE s.id = '$this->schedule_id'
				ORDER BY  es.date, u.name";
			
			$returnArray[$date->date] = DB::select($query);
		}
		return $returnArray;
	}
}
