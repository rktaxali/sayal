@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@push('head')
	<!-- FullCalendar -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
  	<script src="{{ asset('js/fullcalendar.js') }}" ></script>

	<!-- For calendar tooltip -->
	<!--
	<script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>
	<script src="https://unpkg.com/tooltip.js/dist/umd/tooltip.min.js"></script>
	-->
	
	
@endpush

@section('content')

    <div class="container">

        <div>
            <!-- Button trigger modal -->
            <button hidden id="btnModal" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelCreateEvent">
                Launct #modelCreateEvent Model
            </button>

            <!-- Modal Create Event-->
            <div class="modal fade" id="modelCreateEvent" tabindex="-1" role="dialog" aria-labelledby="modelCreateEventLabel" aria-hidden="true">
				
				<div class="modal-dialog" style="max-width:900px;" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="modelCreateEventLabel">Create Appointment</h5>
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
											
										   <div hidden class="row">
												<div class="col-12">
													<div class="form-group ">
														<textarea id="description" name="description" 
														 placeholder="Enter Appointment Details (optional)"
														 class="form-control  " 
															rows="3" 
															
															
															>
														</textarea>
															  
													</div>
												</div>
											</div>	

																				
											
											@if ($clients)
												<div class="row">
													<div class="col-6">
														<div class="form-group ">
															<label for="client_id">Choose Client:</label>
															<select name="client_id" 
																	id="client_id" 
																	onClick="elementClicked('client_id')"
																	class="form-control" >
																@foreach($clients as $client )
																	<option value="{{ $client->id }}">
																		{{ $client->firstname}} {{ $client->lastname}}
																	</option>
																@endforeach
															</select>
															<div class="text-danger" id="client_idErrorMsg"></div>
															
														</div>
													</div>
												</div>
											@endif	

											<div class="row">
											
											<div class="col-6 col-sm-4 col-md-3">
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
											
											
												<div class="col-6 col-sm-4 col-md-3 col-lg-3">
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
												
												<div class="col-6 col-sm-4 col-md-3 col-lg-3">
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
											</div>
											
											<div class="row">
												<div class="col-sm-6 col-md-4 col-lg-3">
													@if ($repeatFrequency)
														<div class="form-group ">
															<label for="frequency">Choose Repeat:</label>
															<select name="frequency" 
																	id="frequency" 
																	onClick="repeatClicked()"
																	class="form-control" >
																@foreach($repeatFrequency as $repeat )
																	<option value="{{ $repeat['value'] }}">
																		{{ $repeat['text'] }}
																	</option>
																@endforeach
															</select>
														</div>
													@endif	
												</div>
												
												<div   id="divRepeatEndDate" class="col-sm-6 col-md-4 col-lg-3 d-none">
													<label for="enddate">End Date:</label>
													<input type="date" 
														class="form-control  " 
														onClick="elementClicked('enddate')"
														placeholder="YYYY-MM-DD" 
														pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" 
													id="enddate" name="enddate">
													<div class="text-danger" id="enddateErrorMsg"></div>
												
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

			@include('components.event_edit_modal')
      
		
		</div>
        
		


        <div class="response alert alert-success mt-2" style="display: none;"></div>
        <div id='calendar'></div>  
    </div>

    @section('footer-scripts')
        @include('scripts.fullCalendarDates')
    @endsection

@endsection



