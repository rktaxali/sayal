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
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg12 col-xl-12">
						<form action="" method="POST">
								@csrf
								
								<input type="text" id="scheduleCreate_user_id" name="scheduleCreate_user_id" hidden  >
								
								<div class="row">
								
									<div class="col-2">
									    
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
											<label for="starttime">End Time:</label>
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