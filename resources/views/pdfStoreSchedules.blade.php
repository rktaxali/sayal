<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store Schedule</title>
    
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-3">Schedule for the {{$schedule->store_name }} Store for Week Starting {{$schedule->start_date }}</h2>

        @if($schedule->approved_user_id)
			<h3>Status: Approved - {{$approvalType}}</h3>
		@else
			<h3>Status: Not Approved</h3>
		@endif
		
        <table class="table table-bordered mb-5">
            <thead>
                <tr class="table-danger">
                    <th scope="col" width="200px;" align='left' >Date</th>
                    <th scope="col" width="200px;" align='left'>Name</th>
                    <th scope="col" width="300px;" align='left'>Timings</th>
                </tr>
            </thead>
            <tbody>
                 @foreach($schedule->store_schedule as $daySchedule)
					 @foreach($daySchedule as $employeeSchedule) 
						<tr>
							
							<td>{{ $employeeSchedule->date }}</td>
							<td>{{ $employeeSchedule->name }}</td>
							<td>{{ substr($employeeSchedule->starttime,0,5)}} - {{ substr($employeeSchedule->endtime,0,5)}}</td>
						</tr>
					 @endforeach
					 <tr>
						<td>&nbsp;</td>
					 </tr>
                @endforeach
            </tbody>
        </table>

    </div>

   
</body>

</html>






