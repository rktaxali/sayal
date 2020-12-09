<!doctype html>

<html>

  <head>
    <title>Your Schedule</title>
    <meta charset="utf-8" />
  </head>

  <body>
    Store Manager,

    <p>This is the Weekly schedule for the {{ $store_name }} store for the week starting {{ $start_date }}</p>
   
    <h3>{{ $store_name }} Schedule </h3>
    <table style="width:600px; border-collapse: collapse; padding:2px;">
        <thead>
            <tr>
				<th style="width:100px;text-align:left;  border: 1px solid black;">Date</th>
				<th style="width:200px;text-align:left;  border: 1px solid black;">Employee Name</th>
				<th style="width:200px;text-align:left;  border: 1px solid black;">Timings</th>
            </tr>
        </thead>

        <tbody>
            @foreach($schedule as $key=>$daySchedule)
                <tr>
                    <td colspan="3">  &nbsp;&nbsp;   </td>
                </tr>
				
				@foreach($daySchedule as $employeeSchedule)
					<tr>
						<th style="width:100px;text-align:left;  border: 1px solid black;">{{ $key}}</th>
						<th style="width:200px;text-align:left;  border: 1px solid black;">{{ $employeeSchedule->name}}</th>
						<th style="width:200px;text-align:left;  border: 1px solid black;">{{ substr($employeeSchedule->starttime,0,5)}} - {{ substr($employeeSchedule->endtime,0,5)}}</th>
					</tr>
	                                    
                @endforeach
            @endforeach
        </tbody>
    </table>
    

    
  </body>
  
  
  
 
  

</html>
