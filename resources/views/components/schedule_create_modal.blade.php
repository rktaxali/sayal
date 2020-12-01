<!-- Modal box to create an event for the current client -->

<!-- Button trigger modal -->
<button hidden id="btnModelCreateEvent" type="button" class="btn btn-primary" data-toggle="modal" 
		data-target="#modelCreateEvent" 
		data-backdrop="static" data-keyboard="false"  >
	Launct #modelCreateEvent Model
</button>


<!-- Modal Create Event-->
<div class="modal fade" id="modelCreateEvent" tabindex="-1" role="dialog" aria-labelledby="modelCreateEventLabel" aria-hidden="true">


	
	<div class="modal-dialog" style="max-width:900px;" role="document">
	
		
		
	
	
		<div class="modal-content">
		
			<div id="divCreateAlert" style="display:none;">
				<div class="alert alert-success alert-dismissible fade show" role="alert">
				  <strong>Schedule Created Successfully...</strong> 
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
			</div>
		
			<div class="modal-header">
				<h5 class="modal-title" id="modelCreateEventLabel">Create Schedule for <span id="createUserName"></span> </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			
			
			<div class="modal-body">
				
				<form action="" method="POST">
					@csrf
					
					<input type="text" id="scheduleCreate_user_id" name="scheduleCreate_user_id" hidden  >
					
					<div class="row border-bottom bg-light" style="margin-top:-12px; margin-bottom:12px;">
						<div class="col-3">
								Date
						</div>
						
						<div class="col-3">
								Start
						</div>
						
						<div class="col-3">
								End
						</div>
						
						<div class="col-3">
								Store
						</div>
					
					</div>
					
					
					
								
					@foreach($scheduleDays as $sch)			
						<div class="row">
						
							<div class="col-3">
								{{$sch->date}}  {{$sch->day_abbr}} <div id="sch_ok_{{$sch->day_id}}" class="material-icons text-success" style="display:none">check</div>
							</div>
						
							
							
							<div class="col-3">
								<div class="form-group ">
									<input type="time" 
											class="form-control  " 
											style="margin-top:-6px;" 
											onfocusout="elementClicked({{$sch->day_id}})"
											min="06:00" max="20:00" 
											required
											name ="starttime_{{$sch->day_id}}"
											id="starttime_{{$sch->day_id}}">
									
									<div class="text-danger" id="starttimeErrorMsg_{{$sch->day_id}}"></div>
											   
									</div>
							</div>
							
							<div class="col-3">
								<div class="form-group ">
									<input type="time" 
											class="form-control  " 
											style="margin-top:-6px;" 
											onfocusout="elementClicked({{$sch->day_id}})"
											min="06:00" max="20:00" 
											required
											name ="endtime_{{$sch->day_id}}"
											id="endtime_{{$sch->day_id}}">
									
									<div class="text-danger" id="endtimeErrorMsg_{{$sch->day_id}}"></div>
											   
									</div>
							</div>
							
							<div class="col-3">
								
									<select name="store_id" id="store_id_{{$sch->day_id}}" class="form-control" 
										onClick="elementClicked({{$sch->day_id}})"
										style="margin-top:-6px;"  >
									@foreach($stores as $store )
										<option value="{{ $store->id }}">
											{{ $store->text}}
										</option>
										@endforeach
									</select>
									<div class="text-danger" id="store_idErrorMsg_{{$sch->day_id}}"></div>
							</div>
						
						
						</div>
					@endforeach

					<div class="row">
						<div class="col-12">
							Min Hours: <span id='min_hours' class="ml-1 mr-4"></span>Max Hours: <span id='max_hours' class="ml-1 mr-4"></span>
							Scheduled Hours: <span id="weeklyHours" class="ml-1 mr-4"></span>
							<div id="scheduled_hours_ok" class="material-icons text-success" style="display:none">check</div>
							<span id="scheduled_hours_exeeded" class="text-danger" style="display:none">Scheduled Hours Exceed Max Limit</span>
						</div>
					</div>
					
					<div class="row modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="button"  class="btn btn-primary"  onClick="createEmployeeSchedule()" >Submit</button>
					</div>  
								
				</form>
					
			</div>
		</div>
	</div>


</div>