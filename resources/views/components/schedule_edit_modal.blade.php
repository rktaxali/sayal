<!-- Modal box to create an event for the current client -->

<!-- Button trigger modal -->
<button hidden id="btnModalUpdateSchedule" type="button" class="btn btn-primary" data-toggle="modal" 
		data-target="#modalUpdateSchedule" 
		data-backdrop="static" data-keyboard="false"  >
	Launch Update Employee Schedule
</button>


<!-- Modal Create Event-->
<div class="modal fade" id="modalUpdateSchedule" tabindex="-1" role="dialog" aria-labelledby="modelCreateEventLabel" aria-hidden="true">


	
	<div class="modal-dialog" style="max-width:1000px;" role="document">
	
		
		
	
	
		<div class="modal-content">
		
			<div id="divEditScheduleAlert" style="display:none;">
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				  <strong>Employee Schedule Updated Successfully.</strong> 
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
			</div>
		
			<div class="modal-header">
				<h5 class="modal-title" id="modelCreateEventLabel">Edit Schedule for <span id="editUserName"></span> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			
			<div class="modal-body">
				
				<form action="{{ route('schedule.createEmployeeSchedule') }}" method="POST">
					@csrf
					
					<input type="text" id="scheduleCreate_user_id" name="scheduleCreate_user_id" hidden  >
					
					<div class="row border-bottom bg-light" style="margin-top:-12px; margin-bottom:12px;">
						<div class="col-2">
								Date
						</div>
						
						<div class="col-2">
								Start
						</div>
						
						<div class="col-2">
								End
						</div>
						
						<div class="col-3">
								Store
						</div>
						
						<div class="col-2">
								Action
						</div>
					
					</div>
					
					
					
								
					@foreach($scheduleDays as $sch)			
						<div class="row">
						
							<div class="col-2">
								<input type="text" id="edit_date_{{$sch->day_id}}" name="edit_date_{{$sch->day_id}}" value="{{$sch->date}}" hidden  >
								{{$sch->date}}  {{$sch->day_abbr}} 
								
							</div>
						
							
							
							<div class="col-2">
								<div class="form-group ">
									<input type="time" 
											class="form-control  " 
											style="margin-top:-6px;" 
											onfocusout="edit_elementClicked({{$sch->day_id}})"
											min="06:00" max="20:00" 
											name ="edit_starttime_{{$sch->day_id}}"
											id="edit_starttime_{{$sch->day_id}}">
									
									<div class="text-danger" id="edit_starttimeErrorMsg_{{$sch->day_id}}"></div>
											   
									</div>
							</div>
							
							<div class="col-2">
								<div class="form-group ">
									<input type="time" 
											class="form-control  " 
											style="margin-top:-6px;" 
											onfocusout="edit_elementClicked({{$sch->day_id}})"
											min="06:00" max="20:00" 
											name ="edit_endtime_{{$sch->day_id}}"
											id="edit_endtime_{{$sch->day_id}}">
									
									<div class="text-danger" id="edit_endtimeErrorMsg_{{$sch->day_id}}"></div>
											   
									</div>
							</div>
							
							<div class="col-3">
								
									<select name="edit_store_id_{{$sch->day_id}}" id="edit_store_id_{{$sch->day_id}}" class="form-control" 
										onClick="edit_elementClicked({{$sch->day_id}})"
										style="margin-top:-6px;"  >
									@foreach($stores as $store )
										<option value="{{ $store->id }}">
											{{ $store->text}}
										</option>
										@endforeach
									</select>
									<div class="text-danger" id="edit_store_idErrorMsg_{{$sch->day_id}}"></div>
							</div>
							
							<div class="col-2">
								<span class="material-icons"  id="edit_delete_schedule_{{$sch->day_id}}"   
									onclick="edit_DeleteDaySchedule({{$sch->day_id}})"  
									title="Delete"
									style="display:none; cursor:pointer; color:red;" >
									delete
								</span>
								
								<span id="edit_sch_ok_{{$sch->day_id}}" class="material-icons text-success" style="display:none">check</span>
								
								
							</div>
						
						
						</div>
					@endforeach

					<div class="row">
						<div class="col-12">
							Min Hours: <span id='edit_min_hours' class="ml-1 mr-4"></span>Max Hours: <span id='edit_max_hours' class="ml-1 mr-4"></span>
							Scheduled Hours: <span id="edit_weeklyHours" class="ml-1 mr-4 weeklyHours"></span>
							<div id="scheduled_hours_ok" class="material-icons text-success scheduled_hours_ok" style="display:none">check</div>
							<span id="scheduled_hours_exeeded" class="text-danger scheduled_hours_exeeded" style="display:none">Scheduled Hours Exceed Max Limit</span>
						</div>
					</div>
					
					<div class="row modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="button" id="btnUpdateEmployeeSchedule" class="btn btn-primary" onClick="updateEmployeeSchedule()"  >Submit</button>
					</div>  
								
				</form>
					
			</div>
		</div>
	</div>


</div>
