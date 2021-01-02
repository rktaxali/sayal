<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employees' Schedule</title>
    
</head>

	<body>
		<div class="container mt-5">
		
		 <h2 class="text-center mb-3">Employees' Schedule for the  Week Starting {{$schedule->start_date }}</h2>

        @if($schedule->approved_user_id)
			<h3>Status: Approved - {{$approvalType}}</h3>
		@else
			<h3>Status: Not Approved</h3>
		@endif
		
			   
					<table class="table table-striped table-bordered table-responsive-lg">
					  <thead>
						<tr>
						  <th scope="col" width="100" align='left' >Name</th>
						  <th scope="col" width="300" align='left'>Schedule</th>
						  <th scope="col" width="75" align='left' >Accepted?</th>
							
						</tr>
					  </thead>
					  <tbody>
					  @foreach ($scheduleDetails as $schedule)
						  <tr scope="row" >
							<td   style="padding:2px 5px 2px 5px; text-align:left;vertical-align:top;"   >
							  {{ $schedule->name}}<br>
							   Hours: {{ $schedule->weekly_hours}}<br>
							   Min: {{ $schedule->min_hours}}<br>
							   Max : {{ $schedule->max_hours}}<br>
							</td>
											
							<td style="padding:2px 5px 2px 5px">
								<table>
									<tbody>
									@foreach($schedule->schedule as $data)
									  
										<tr scope="row" >
												<td scope="col" width="75" align='left'>{{ $data->date }}</td>
												<td scope="col" width="100" align='left'>{{ $data->starttime }} - {{ $data->endtime }}</td>
												<td scope="col" width="100" align='left'>{{ $data->store_name }}</td>
										</tr>
									  
									@endforeach 
									</tbody>
								</table>

							</td>
							<td  style="padding:2px 5px 2px 5px; text-align:left;vertical-align:top;"   >
							  @if( $schedule->schedule_accepted )
								

								<span class="text-success"  >
								  Accepted
								</span>
							  @else
								<span class="text-warning"  >
									Pennding
								</span>

							  @endif	
							</td>  
									
						  </tr>
					  @endforeach
					  </tbody>
							
					</table>
					  
				

	  </div>
	 

	   
	</body>

</html>


 