@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Manage Schedule Details for Week Starting {{ $schedule->start_date }}</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($scheduleDetails)  )
                <form id="schedule-form"
                    action="{{ route('schedule.edit') }}" method="POST">
                                @csrf
                        <table class="table table-striped table-bordered table-responsive-lg">
							<thead>
								<tr>
									<th scope="col" >Name</th>
									<th scope="col">Schedule</th>
									<th scope="col" >Action</th>
								   
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
										@if( $schedule->howmany )
											

											<span class="material-icons" 
                          style="color:blue; cursor:pointer"  
                          onClick="editSchedule({{ $schedule->user_id }})" >
                            edit
                      </span>
											<span class="material-icons" 
                          style="color:red; cursor:pointer" 
                          onClick="deleteSchedule( '{{ $schedule->user_id  }}','{{ $schedule->name  }}'  )" >
                              delete
                      </span>

                      <br>
                      <a href=""
                          onClick="saveAsDefaultSchedule({{ $schedule->user_id }})" >
                          Save as Default
                      </a>
												<div id="spinnerEdit" class="spinner-border text-primary ml-2" style="visibility:hidden"></div>
										@else
											<span class="material-icons" style="color:green; cursor:pointer" onClick="createSchedule({{ $schedule->user_id }})" >add_circle</span>
											<div id="spinnerCreate_{{$schedule->user_id}}" class="spinner-border text-primary ml-2" 
												style="visibility:hidden"></div>	
										@endif	
                                    </td>  

                                    
                                    
                                </tr>
							@endforeach
							</tbody>
                           
                        </table>

                      
                </form>
				
				
            @endif
     
        </div>
		@include('components.schedule_create_modal')
		@include('components.schedule_edit_modal')



<!-- Button trigger modal -->
<button type="button" id="btnDeleteEmployeeSchedule" class="btn btn-primary" data-toggle="modal" data-target="#deleteConfirmModal" hidden >
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmModalLabel">Delete Employee Schedule?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="divdDeleteConfirmModalBody">
        Are you sure that you want to Delete the Employee Schedule?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary"  onClick="deleteScheduleNow()" >Yes Delete</button>
      </div>
    </div>
  </div>
</div>

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

