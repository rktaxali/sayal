@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>View Store Schedules</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($schedules)  )
                <form id="schedule-form"
                    action="{{ route('schedule.viewStoreScheduleDetails') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Week Starting</th>
                                <th>Status</th>
                                <th>Action</th>
                               
                            </tr>

							@foreach ($schedules as $schedule)
                                <tr>
                                    <td>
									    {{ $schedule->start_date}}
                                    </td>

                                    <td>
                                        @if($schedule->approved_user_id)
                                            <span class="text-success">Approved</span>
                                        @elseif(($schedule->revised_user_id))
                                            <span class="text-warning"> Waiting for Approval</span>
                                        @elseif($schedule->prepared_user_id)
                                            <span class="text-primary"> Waiting for Approval</span>
                                        @else
                                            Being Prepared
                                        @endif

                                        
                                    </td>
                                    
									<td>
										<div class="float-left">
											<button type="submit" 
												name="viewStoreSchedule"
												value = "{{$schedule->id}}"
												class="btn btn-primary">
												View
											</button>
										 </div>
										<div class="float-left ml-4 "> 
										
											<button type="submit"
													name="downloadStoreSchedule"
													id="downloadStoreSchedule"
													class="btn btn-default"
													value = "{{$schedule->id}}"
													 >

											
												<span 
													class="material-icons text-success"
													
													title="Download" style="font-size: 32px; cursor: pointer; margin-top:-4px;">
												get_app
												</span>
											</button>
										
											
										</div>
                                    </td>  

                                    
                                    
                                </tr>
							@endforeach
                           
                        </table>

                      
                </form>
				
				
            @endif
     
        </div>

    </div>
	
	
	
 
</div>

@endsection


<script>


/*
    function downloadSchedule(schedule_id) {
        event.preventDefault();
        document.getElementById("downloadStoreSchedule_"+schedule_id).disabled = true ;
       // 
       jQuery.ajax({
			url: "{{ url('/createStoreSchedulePDF') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'schedule_id' :schedule_id,
			},
			success: function(response){
			if (response)
			{
				dispayAlerrtMessage('Store Schedule downloaded Successfully.');
				document.getElementById("downloadStoreSchedule_"+schedule_id).disabled = false ;
			}
			},
			error: function(data) {
				console.log(data);
				
			}
		});			



    }
*/


    

 
</script>

