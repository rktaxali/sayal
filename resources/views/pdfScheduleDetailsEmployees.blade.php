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
			   
					<table class="table table-striped table-bordered table-responsive-lg">
					  <thead>
						<tr>
						  <th scope="col" >Name</th>
						  <th scope="col">Schedule</th>
						  <th scope="col" >Accepted?</th>
							
						</tr>
					  </thead>
					  <tbody>
					  @foreach ($scheduleDetails as $schedule)
						  <tr scope="row"  style="padding:2px 5px 2px 5px">
							<td style="padding:2px 5px 2px 5px">
							  {{ $schedule->name}}
							</td>
											
							<td style="padding:2px 5px 2px 5px">
							  <div class="row">
								@foreach($schedule->schedule as $data)
								  
									<div class="col-6">
										<div class="row">
											<div class="col-3">{{ $data->date }}</div>
											<div class="col-4">{{ $data->starttime }} - {{ $data->endtime }}</div>
											<div class="col-3">{{ $data->store_name }}</div>
										</div>
									</div>
								  
								@endforeach 
							  </div>

							</td>
							<td style="padding:2px 5px 2px 5px">
							  @if( $schedule->schedule_accepted )
								

								<span class="material-icons text-success" style="font-size:xx-large;" >
								  check_circle
								</span>
							  @else
								<span class="material-icons text-info" style="font-size:xx-large;" >
									pending_actions
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


 