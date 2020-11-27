<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    //
	
	 public function create()
    {
		
	//	date_default_timezone_set("America/Toronto");
       dd(date('Y-m-d H:i:s'));
	   $query = "SET time_zone = '-8:00'";
	   DB::select( DB::raw($query));  
	   
	   $task = new Task;

        $task->task = 'new task';

        $task->save();
		dd(phpinfo());
	   
	   
    }
}
