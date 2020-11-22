<!-- Modal box to edit an event -->
 
		<!-- Button trigger modal -->
            <button hidden id="btnEditModal" type="button" class="btn btn-primary" 
					data-toggle="modal"
					data-backdrop="static" data-keyboard="false" 
					data-target="#modelEditEvent">
                Launch Edit Model (modelEditEvent)
            </button>
			
				
		
		
            <!-- Modal Edit Event-->
            <div class="modal fade" id="modelEditEvent" tabindex="-1" role="dialog" aria-labelledby="modelEditEventLabel" aria-hidden="true">
			
				<div class="modal-dialog" style="max-width:900px;" role="document">
				
					<div class="modal-content">
					
					<div id="divEventUpdatedAlert" style="display:none;">
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <strong>Event Updated Successfully...</strong> 
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
					</div>
					
					
					<div class="modal-header">
						<h5 class="modal-title" id="modelEditEventLabel">Edit Appointment</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form 
								style="max-width:900px;" 
							
								action="{{ route('calendar.update') }}" method="POST">
								@csrf
															
								<div class="row mt-4">
									<div class="col-12">
										<div class="form-group ">
											<!--
											<label for="title">Appointment Title:</label>
											-->
											<input type="text" class="form-control  " 
													style="margin-top:-6px;" 
													placeholder="Enter Appointment Title "
													onClick="elementClicked('edit_title')"
													name ="edit_title"
													id="edit_title">
											
											<div class="text-danger" id="edit_titleErrorMsg"></div>
												   
										</div>
									</div>
								</div>
								
								<!-- Currently description is not in use, therefore add hidden attribute -->
								<div hidden class="row">
									<div class="col-12">
										<div class="form-group ">
											<textarea id="edit_description" name="edit_description" 
											 placeholder="Enter Appointment Details (optional)"
											 class="form-control  " 
												rows="3" 
												
												
												>
											</textarea>
												  
										</div>
									</div>
								</div>

								<!-- current client notes -->
								<div  id="divCurrent_note" class="row d-none">
									<div class="col-12 mt-2">
										<label for="current_note">Current Note:</label>
										<div class="form-group " >
											<textarea id="current_note" name="current_note" 
											
											 class="form-control  " 
												style="margin-top:-6px"
												rows="4" 
												readonly
												>
											</textarea>
												  
										</div>
									</div>
								</div>
								
								
								<!-- New client_note.note -->
								<div class="row">
									<div class="col-12">
										<div class="form-group ">
											<textarea id="note" name="note" 
											 placeholder="Add Note (optional)"
											 class="form-control  " 
												rows="3" 
												
												
												>
											</textarea>
												  
										</div>
									</div>
								</div>	
								
								<div class="row">
									<div class="col-sm-8 col-md-2 col-lg-1">
										Date: 
									</div>
									<div class="col-sm-4 col-md-4 col-lg-4">
										<input readonly type='text' class="form-control  " 
											style="max-width:150px"
										id="event_date" name="event_date">
									</div>
								</div>

								
								<div class="row">
								
									<div class="col-6 col-sm-4 col-md-3">
										<div class="form-group ">
											<label for="edit_eventType">Type:</label>
											<select name="edit_eventType" id="edit_eventType" 
													class="form-control" 
													onClick="elementClicked('edit_eventType')"
													style="margin-top:-6px" >
												@foreach ($eventTypeCodesWithoutSelect as $eventTypeCode)
													 <option value="{{$eventTypeCode->id }}">{{$eventTypeCode->text }}</option>
												@endforeach 
											</select>
											
										</div>
									</div>
								
								
									<div class="col-6 col-sm-4 col-md-3">
										<div class="form-group ">
											<label for="starttime">Start Time:</label>
											<input type="time" 
													class="form-control  " 
													style="margin-top:-6px;" 
													onClick="elementClicked('edit_starttime')"
													min="06:00" max="20:00" 
													required
													name ="edit_starttime"
													id="edit_starttime">
											
											<div class="text-danger" id="edit_starttimeErrorMsg"></div>
													   
										</div>
									</div>
									
									<div class="col-6 col-sm-4 col-md-3">
										<div class="form-group ">
											<label for="endtime">End Time:</label>
											<input type="time" 
													class="form-control  " 
													style="margin-top:-6px;" 
													onClick="elementClicked('edit_endtime')"
													min="06:00" max="20:00" 
													required
													name ="edit_endtime"
													id="edit_endtime">
											
											<div class="text-danger" id="edit_endtimeErrorMsg"></div>
													   
										</div>
									</div>
									
									<div class="col-6 col-sm-4 col-md-3">
										<div class="form-group ">
											<label for="edit_event_status">Status:</label>
											<!-- Options will be populated through JS code when events are fetched -->
											<select name="edit_event_status" id="edit_event_status" class="form-control" style="margin-top:-6px" >
												@foreach ($eventStatusCodes as $eventStatusCode)
													 <option value="{{$eventStatusCode->id }}">{{$eventStatusCode->text }}</option>
												@endforeach 
											</select>
										</div>
									</div>
								
								
								</div>

								
								<div class="row">
									
								</div>
															

								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
									<button type="button"  class="btn btn-primary"  onClick="editCalendarEvent()" >Submit</button>
								</div>                
							</form>
						
						</div>
					
					</div>
				</div>

            
            </div>
			
				
			
