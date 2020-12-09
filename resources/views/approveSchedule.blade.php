@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Approve Schedules..</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($schedules)  )
                <form id="schedule-form"
                    action="{{ route('schedule.edit') }}" method="POST">
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

                                        @if($schedule->emails_sent_user_id)
                                            <br><span class="text-success">Schedule Emails Sent on {{ $schedule->emails_sent_at }}</span>
										@elseif ( $schedule->approved_user_id )
										
											                         
											<button type="button" 
													id="btnSendScheduleEmails_{{ $schedule->id }}"
													name="btnSendScheduleEmails_{{ $schedule->id }}" 
													onClick="sendScheduleEmails({{ $schedule->id }})"
													class="btn btn-sm btn-secondary ml-4">
														Send Emails
											</button>
											
											<div id="spinnerSendEmails_{{ $schedule->id }}" 
													class="spinner-border text-primary ml-2" 
													style="visibility:hidden">
											</div>    
                                        @endif
                                        
                                    </td>
                                    
									<td>
										<button type="submit" name="schedule_id" value ="{{ $schedule->id }}"  class="btn btn-sm btn-secondary">
												Edit</button>

                                        @if(! $schedule->approved_user_id && ! $schedule->prepared_user_id)
                                            <button type="button" 
                                                id="btnSubmitForApproval"
                                                name="btnSubmitForApproval" 
                                                onClick="submitForApproval({{ $schedule->id }})"
                                                class="btn btn-sm btn-secondary">
                                                    Submit</button>
                                        @endif

                                        @can('aprv_schedule')
                                            @if(! $schedule->approved_user_id &&  $schedule->prepared_user_id)
                                                <button type="button" 
                                                    id="btnApproved"
                                                    name="btnApproved" 
                                                    onClick="approve_schedule({{ $schedule->id }})"
                                                    class="btn btn-sm btn-secondary">
                                                        Approve</button>
                                            @endif
										@endcan	
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
    

    function submitForApproval(schedule_id) {
        event.preventDefault();
        var element = document.getElementById("btnSubmitForApproval");
        element.disabled = true;
       // 
       jQuery.ajax({
			url: "{{ url('/submitForApproval') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'schedule_id' :schedule_id,
			},
			success: function(response){
				if (response)
				{
                    dispayAlerrtMessage('Schedule Successfully Submitted for Approval');
                   // reload the schedule page
                    setTimeout(function(){
                        window.location.href = "/schedule";
                    }, 1000);
				
				}
			},
			error: function(data) {
				console.log(data);
				
			}
		});			



    }


    function approve_schedule(schedule_id)
    {
        event.preventDefault(schedule_id);
        var element = document.getElementById("btnApproved");
        element.disabled = true;

        jQuery.ajax({
			url: "{{ url('/approveSchedule') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'schedule_id' :schedule_id,
			},
			success: function(response){
                console.log(response)
				if (response)
				{
					dispayAlerrtMessage('Schedule has been Approved.');
                    // reload the schedule page
                    setTimeout(function(){
                        window.location.href = "/approveSubmittedSchedules";
                        }, 1000);
                    }
			},
			error: function(data) {
				console.log(data);
				
			}
		});			

    }


    
    function sendScheduleEmails(schedule_id)
    {
        event.preventDefault(schedule_id);
        let element1 = document.getElementById("btnSendScheduleEmails_"+schedule_id);
		element1.innerText = 'Sending Emails ...';
        element1.disabled = true;
		// display spinner and submit form
        let element2 = document.getElementById("spinnerSendEmails_"+schedule_id);
        element2.style.visibility='visible';

        jQuery.ajax({
			url: "{{ url('/sendScheduleEmails') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'schedule_id' :schedule_id,
			},
			success: function(response){
				if (response)
				{
					console.log(response);
					dispayAlerrtMessage('Schedule Emails have been Sent.');
                    // reload the schedule page
                    setTimeout(function(){
                       window.location.href = "/approveSubmittedSchedules";
                        }, 1000);
                    }
			},
			error: function(data) {
				console.log(data);
				
			}
		});			

    }


</script>

