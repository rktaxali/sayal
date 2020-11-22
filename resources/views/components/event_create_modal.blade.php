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
				  <strong>Event Created Successfully...</strong> 
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
			</div>
		
			<div class="modal-header">
				<h5 class="modal-title" id="modelCreateEventLabel">Create Event for {{ $client->firstname }} {{ $client->lastname }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg12 col-xl-12">
						<form action="{{ route('calendar.create') }}" method="POST">
								@csrf
								
								<input type="text" id="startDate" name="startDate" hidden >

								<div class="row">
									<div class="col-12">
										<div class="form-group ">
											<!--
											<label for="title">Appointment Title:</label>
											-->
											<input type="text" class="form-control  " 
													style="margin-top:-6px;" 
													placeholder="Enter Appointment Title "
													onClick="elementClicked('title')"
													name ="title"
													id="title">
											
											<div class="text-danger" id="titleErrorMsg"></div>
												   
										</div>
									</div>
								</div>
															
								<div class="row">
									<div class="col-sm-6 col-md-4">
										<div class="form-group ">
											<label for="eventType">Type:</label>
											<select name="eventType" id="eventType" 
													class="form-control" 
													onClick="elementClicked('eventType')"
													style="margin-top:-6px" >
												@foreach ($eventTypeCodes as $eventTypeCode)
													 <option value="{{$eventTypeCode->id }}">{{$eventTypeCode->text }}</option>
												@endforeach 
											</select>
											<div class="text-danger" id="eventTypeErrorMsg"></div>
										</div>
									</div>
								</div>
							
								<!-- New client_note.note -->
								<div class="row">
									<div class="col-12">
										<div class="form-group ">
											<textarea id="eventnote" name="eventnote" 
											 placeholder="Event Note"
											 class="form-control  " 
												rows="3" 
												onClick="elementClicked('eventnote')"
												
												
												>
											</textarea>
											<div class="text-danger" id="eventnoteErrorMsg"></div>
												  
										</div>
									</div>
								</div>	
								
								<div class="row">
									<div id="divEventDate" class="col-sm-6 col-md-3 col-lg-3 ">
											<label for="eventdate">Event Date:</label>
											<input type="date" 
												class="form-control  " 
												onClick="elementClicked('eventdate')"
												style="margin-top:-6px;" 
												placeholder="YYYY-MM-DD" 
												pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" 
											id="eventdate" name="eventdate">
											<div class="text-danger" id="eventdateErrorMsg"></div>
									</div>
									
									<div class="col-sm-6 col-md-3 col-lg-3">
										<div class="form-group ">
											<label for="starttime">Start Time:</label>
											<input type="time" 
													class="form-control  " 
													style="margin-top:-6px;" 
													onClick="elementClicked('starttime')"
													min="06:00" max="20:00" 
													required
													name ="starttime"
													id="starttime">
											
											<div class="text-danger" id="starttimeErrorMsg"></div>
													   
										</div>
									</div>
									
									<div class="col-sm-6 col-md-3 col-lg-3">
										<div class="form-group ">
											<label for="endtime">End Time:</label>
											<input type="time" 
													class="form-control  " 
													style="margin-top:-6px;" 
													onClick="elementClicked('endtime')"
													min="06:00" max="20:00" 
													required
													name ="endtime"
													id="endtime">
											
											<div class="text-danger" id="endtimeErrorMsg"></div>
													   
										</div>
									</div>


									<div class="col-sm-6 col-md-3">
										<div class="form-group ">
											<label for="event_status_id">Status:</label>
											<!-- Options will be populated through JS code when events are fetched -->
											<select name="event_status_id" id="event_status_id" 
													class="form-control" 
													style="margin-top:-6px" >
												@foreach ($eventStatusCodes as $eventStatusCode)
													 <option value="{{$eventStatusCode->id }}">{{$eventStatusCode->text }}</option>
												@endforeach 
											</select>
										</div>
									</div>

									
					
								</div>
						
							<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
									<button type="button"  class="btn btn-primary"  onClick="createNewEvent()" >Submit</button>
								</div>  
								
						</form>
					</div>
						
				</div>
			</div>
		</div>
	</div>


</div>