@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>View Schedules</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($schedules)  )
                <form id="schedule-form"
                    action="{{ route('schedule.viewDetails') }}" method="POST">
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
                                        {{ $schedule->id}}
                                        <button type="submit" 
                                                name="schedule_id"
                                                value = "{{$schedule->id}}"
                                                class="btn btn-primary">
                                                View
                                         </button>
										
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
    function submitForm() {
		console.log('submit forn');
		
        // disable Submit button
        event.preventDefault();
        var element = document.getElementById("submitButton");
        element.disabled = true;
        // display spinner and submit form
        var element = document.getElementById("spinner");
        element.style.visibility='visible';
        document.getElementById('new-schedule-form').submit();
    }

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

 */
</script>

