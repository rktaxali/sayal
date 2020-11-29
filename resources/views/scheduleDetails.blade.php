@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Manage Schedule Details</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($scheduleDetails)  )
                <form id="schedule-form"
                    action="{{ route('schedule.edit') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Name</th>
								<th>Schedule</th>
                                <th>Action</th>
                               
                            </tr>

							@foreach ($scheduleDetails as $schedule)
                                <tr>
                                    <td>
									{{ $schedule->name}}
                                    </td>
                                    
									 <td>
									 {{ $schedule->schedule}}
									 </td>
									<td>
										@if( $schedule->howmany )
											<button type="button" 
												onClick="editSchedule({{ $schedule->user_id }})"
												name="editScheduleBtn" 
												id="editScheduleBtn" 
												value ="{{ $schedule->user_id }}"  
													class="btn btn-sm btn-secondary" style="width:70px;">
												Edit</button>
												<div id="spinnerEdit" class="spinner-border text-primary ml-2" style="visibility:hidden"></div>
										@else
										<button type="button" 
											onClick="createSchedule({{ $schedule->user_id }})"
											name="createScheduleBtn" 
											id="createScheduleBtn"
											value ="{{ $schedule->user_id }}"  class="btn btn-sm btn-secondary" style="width:70px;">
												Create</button>
											<div id="spinnerCreate_{{$schedule->user_id}}" class="spinner-border text-primary ml-2" style="visibility:hidden"></div>	
										@endif	
                                    </td>  

                                    
                                    
                                </tr>
							@endforeach
                           
                        </table>

                      
                </form>
				
				
            @endif
     
        </div>
		@include('components.schedule_create_modal')
		@include('components.schedule_edit_modal')

    </div>
	
	
	
 
</div>

 @section('footer-scripts')
        @include('scripts.scheduleDetails')
@endsection


@endsection


<script>
   
	
	function editSchedule(user_id) {
		
        // disable Submit button
        event.preventDefault();
        var element = document.getElementById("editScheduleBtn");
        element.disabled = true;
        // display spinner and submit form
        var element = document.getElementById("spinnerEdit_"+user_id);
        element.style.visibility='visible';
        document.getElementById('btnScheduleEditModal').click();
    }

</script>

