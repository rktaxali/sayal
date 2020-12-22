<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Redirect,Response;


class HolidayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
	}
	
	// returns  holidays for the current year oward for edit/delete
	public function index()
	{
       
		//if(auth()->user()->hasPermissionTo('holiday_vacation') )
       // {
			
            $holidays = Holiday::where('year','>=',date('Y'))
                    ->orderBy('date')
					->get();
			return view('holiday',compact('holidays'));
		//}
    }
    

	public function deleteHoliday(Request $request)
    {
		$retval = false;
		if(auth()->user()->hasPermissionTo('holiday_vacation'))
        {
			$id = $request->holiday_id;
			Holiday::where('id',$id)->delete();
			$retval = true;
		}
		return Response::json($retval);
    }
    
    public function createHoliday(Request $request)
    {
        $retval = false;
		if(auth()->user()->hasPermissionTo('holiday_vacation'))
        {
            $holiday =  Holiday::create([
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



