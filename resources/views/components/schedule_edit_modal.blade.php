<!-- Modal box to edit an event -->
 
		<!-- Button trigger modal -->
            <button hidden id="btnScheduleEditModal" type="button" class="btn btn-primary" 
					data-toggle="modal"
					data-backdrop="static" data-keyboard="false" 
					data-target="#modelEditEvent">
                Launch Edit Model (modelEditEvent)
            </button>
			
				
		
		
            <!-- Modal Edit Schedule-->
            <div class="modal fade" id="modelEditEvent" tabindex="-1" role="dialog" aria-labelledby="modelEditEventLabel" aria-hidden="true">
			
				<div class="modal-dialog" style="max-width:900px;" role="document">
				
					<div class="modal-content">
					
					<div id="divEventUpdatedAlert" style="display:none;">
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <strong>Schedule Updated Successfully...</strong> 
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						  </button>
						</div>
					</div>
					
					
					<div class="modal-header">
						<h5 class="modal-title" id="modelEditEventLabel">Edit Schedule</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form 
								style="max-width:900px;" 
							
								action="" method="POST">
								@csrf
															
	
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
			
				
			
