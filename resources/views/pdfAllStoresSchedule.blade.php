<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Stores' Schedule</title>
    
</head>

	<body>
		<div class="container mt-5">
		
			<h2 class="text-center mb-3">All Stores' Schedule for the  Week Starting {{$schedule->start_date }}</h2>

			@if($schedule->approved_user_id)
				<h3>Status: Approved</h3>
			@else
				<h3>Status: Not Approved</h3>
			@endif
		
			@foreach($stores as $store)
                            
				<div class="row" >
					<div class="col-12">
						<h2> {{$store->name }} </h2>
					</div>
				</div>
			
					
				<table class="table table-striped table-bordered table-responsive-lg mb-2" >
					<tbody>	 
						@foreach($store->schedule as $daySchedule)
							@foreach($daySchedule as $employeeSchedule)
								<tr scope="row" >
										<td scope="col" width="75" align='left'>{{ $employeeSchedule->date}} </td>
										<td scope="col" width="100" align='left'>{{ $employeeSchedule->name}}</td>
										<td scope="col" width="200" align='left'> {{ substr($employeeSchedule->starttime,0,5)}} - {{ substr($employeeSchedule->endtime,0,5)}}  </td>
								</tr>
							@endforeach 
							<tr>
								<td>&nbsp;</td>
							</tr>
						@endforeach
						
					</tbody>						
				</table>	  
			@endforeach 		

	  </div>
	 

	   
	</body>

</html>


 