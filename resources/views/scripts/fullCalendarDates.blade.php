<script>

  document.addEventListener('DOMContentLoaded', function() {
	

      var user_id = "{{ $user_id}}"
	  var SITEURL = "{{url('/')}}";
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
        url = "{{ url('/calendar/getEvents') }}"


        jQuery.ajax({
            url: "{{ url('/call/getEvents') }}",
            method: 'post',
            data: {
                user_id : user_id
            },
            success: function(response)
			{
				//console.log(response['events']);
				/**
				* response array returns 'events' and 'status_array'
				* 'status_array is used to creat the SELECT element for updating status of the event
				*/
				
				// Define Event Status options
				var $el = $("#edit_event_status");
				$el.empty(); // remove old options
				obj = response['status_array'];
				Object.keys(obj).forEach(key => {
					$el.append($("<option></option>").attr("value", obj[key]['id']).text(obj[key]['text']));
				});
				
				
                var calendarEl = document.getElementById('calendar');
				

                    // Using ver FullCalendar v5.3.2
                    calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
							left: 'prev,next today',
							center: 'title',
							right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        initialDate: getCurrentDate(),
                        navLinks: true, // can click day/week names to navigate views
                        selectable: true,
                        selectMirror: true,
						nextDayThreshold: '00:00:00',
					//	defaultView:'dayGridWeek',
						
						
						/**
						* To display tooltip for calendar events
						* Uses event.description as tooltip 
						* Currently does not work. It may be due to interaction of btootstrap tooltip vs popper.js's tooltip
						* Based on: https://codepen.io/pen/?&editable=true&editors=001=https%3A%2F%2Ffullcalendar.io%2F
						* https://fullcalendar.io/docs/event-tooltip-demo
						**/
						
						/*
						// uncomment popper.js and tooltip.js
						eventDidMount: function(info) {
						  var tooltip = new Tooltip(info.el, {
							title: info.event.extendedProps.description,
							placement: 'top',
							trigger: 'hover',
							container: 'body'
						  });
						},
						*/
						
						
						
                        select: function(dateOrObj, endDate) 
                        {
							addEvent(dateOrObj.startStr);
                         },
						 
						 
						

                        eventClick: function(info) {
							getEventDetails( info.event.id);
						},
						
						// Dropping event to a new date 
						eventDrop: function(info) {
							
							let start = info.event.start.toISOString();
							if (!confirm("Are you sure that you wnat to move the appointment " + info.event.title + ' to ' + start.substring(0, 10))) 
							{
							  info.revert();
							}
							else
							{
								moveEvent(info.event);
							}
						},					
						
					

                        editable: true,
                        dayMaxEvents: true, // allow "more" link when too many events

                        events: response['events']
                    });




                calendar.render();
	        
            }}); 

       
	
	
  });
  

  function displayMessage(message) 
  {
        $(".response").css('display','block');
        $(".response").html(""+message+"");
        setInterval(function() { $(".response").fadeOut(); }, 6000);
  }

  function addEvent(startDate)
  {
		// Adding a new event. Details entered through a model box
		$('#title').val('');
		$('#description').val('');
		$('#title').removeClass('is-invalid');
		$('#titleErrorMsg').text('');  
		$('#client_id').removeClass('is-invalid');
		$('#client_idErrorMsg').text('');  		
		$('#eventType').removeClass('is-invalid');
		$('#eventTypeErrorMsg').text(''); 
		
		$('#startDate').val(startDate);
		$('#starttime').removeClass('is-invalid');
		$('#endtime').removeClass('is-invalid');
		$('#starttimeErrorMsg').text('');  
		$('#endtimeErrorMsg').text('');  

		
		
		// open modal box 
		 $('#btnModal').click();
	}
	
	function elementClicked(element)
	{
		$('#'+element).removeClass('is-invalid');
		$('#' +element+ 'ErrorMsg').text('');  
	}

  
  
  
  function createNewEvent()
    {
		var user_id = "{{ $user_id}}"
		var title = $('#title').val();
		let client_id = $('#client_id').val();
		let eventType = $('#eventType').val().trim();

		let dataError = false;
		
		
		if (! title) 
		{
			$('#title').addClass('is-invalid');
			$('#titleErrorMsg').text('Please Enter Title');
			dataError = true;
		}
	
		if (! eventType) 
		{
			$('#eventType').addClass('is-invalid');
			$('#eventTypeErrorMsg').text('Please Select Event Type');
			dataError = true;
		}
		
		if (! client_id) 
		{
			$('#client_id').addClass('is-invalid');
			$('#client_idErrorMsg').text('Please Select Client');
			dataError = true;
		}
		
		let starttime =  $('#starttime').val();
		if (typeof starttime == 'undefined' || ! starttime) 
		{
			$('#starttime').addClass('is-invalid');
			$('#starttimeErrorMsg').text('Please Enter Appointment Start Time');
			dataError = true;
		}
		
		let endtime =  $('#endtime').val();
		if (typeof endtime == 'undefined' ||  ! endtime) 
		{
			$('#endtime').addClass('is-invalid');
			$('#endtimeErrorMsg').text('Please Enter Appointment End Time');
			dataError = true;
		} 
		else if (endtime <= starttime)
		{
			$('#endtime').addClass('is-invalid');
			$('#endtimeErrorMsg').text('End time must be more than Start time!');
			dataError = true;
		}
		
		if ($('#frequency').val() && ! $('#enddate').val() )
		{
			$('#enddate').addClass('is-invalid');
			$('#enddateErrorMsg').text('Repeat Appoinatment End date is required');
			dataError = true;	
		}
		
		
		
		
		if (dataError)  
		{
			return;
		}
		
		
		let startDate = $('#startDate').val();
		$('#title').val('');
		 hideModal();
        //console.log(calendar);

        // calendar.currentData.dateSelection.range.start
        // calendar.currentData.dateSelection.range.end
        // Fri Nov 20 2020 19:00:00 GMT-0500 (Eastern Standard Time)

      //  let str = "Fri Nov 20 2020 19:00:00 GMT-0500 (Eastern Standard Time)";

       // let title = 'New Event Title';
       // var title = prompt('Event Title:');
        if (title) {
            hideModal();
			
			let start = startDate + ' '+starttime+':00';
			let end = startDate  + ' '+endtime+':00';
			

			// Add the event on calendar
			// However, this will not add the event to the events array, 
			// therefore, the edit event will not work correctly 
			// The best option will be to refresh the page and reload events
			
			/*
            calendar.addEvent({
                title: title,
                start: start,
                end: end ,
                allDay: false
            })
			*/
			
			// Create the event in the events table 
			jQuery.ajax({
				url: "{{ url('/calendar/create') }}",
				method: 'post',
				data: {
					"_token": "{{ csrf_token() }}",
					'title' : title,
					'startDate' : startDate,
					'event_status_id' : 1,   // By default, all events are pending
					'event_type_id' : eventType,
                    'start' : start,
                    'end' : end,
					'client_id' : client_id,
					'description' : $('#description').val(),
					'frequency' : $('#frequency').val(),
					'enddate' : $('#enddate').val(),
					'user_id': "{{ $user_id}}"
					
					
					
					
				},
				success: function(response){
					if (response)
					{
						displayMessage('Appointment Added Successfully. The Calendar will be refresed...');
						setTimeout(function(){ 
								window.location.href ="/calendar";
										}, 500);
					}
				},
				error: function(data) {
					console.log(data);
					
				}
			});
                   
			
             
        }
        calendar.unselect()
    }
	
			
			function editCalendarEvent()
				{
				var title = $('#edit_title').val();
				let dataError = false;
				if (! title) 
				{
					$('#edit_title').addClass('is-invalid');
					$('#edit_titleErrorMsg').text('Please Enter Title');
					dataError = true;
				}
				
				let starttime =  $('#edit_starttime').val();
				if (typeof starttime == 'undefined' || ! starttime) 
				{
					$('#edit_starttime').addClass('is-invalid');
					$('#edit_starttimeErrorMsg').text('Please Enter Appointment Start Time');
					dataError = true;
				}
				
				let endtime =  $('#edit_endtime').val();
				if (typeof endtime == 'undefined' ||  ! endtime) 
				{
					$('#edit_endtime').addClass('is-invalid');
					$('#edit_endtimeErrorMsg').text('Please Enter Appointment End Time');
					dataError = true;
				}
				
				if (endtime <= starttime)
				{
					$('#edit_endtime').addClass('is-invalid');
					$('#edit_endtimeErrorMsg').text('End time must be less than Start time!');
					dataError = true;
				}
				
				if (dataError)  
				{
					return;
				}
				
				
				let startDate = $('#event_date').val();
				let start = startDate + ' '+starttime+':00';
				let end = startDate  + ' '+endtime+':00';
				console.log(start, end);
			
			
				// Create the event in the events table 
				jQuery.ajax({
					url: "{{ url('/calendar/update') }}",
					method: 'post',
					data: {
						
						'title' : title,
						'startDate' : startDate,
						'event_status_id' : $('#edit_event_status').val(),
						'event_type_id' : $('#edit_eventType').val(),
						'start' : start, 
						'end' : end,
						'description': $('#edit_description').val(),
						'note' : $('#note').val(),
					},
					success: function(response){
						if (response)
						{
							hideModal();
							displayMessage('Appointment Update Successfully.');
						}
					},
					error: function(data) {
						console.log(data);
						
					}
				});
		 
			}
					
				


			  function getEventDetails(event_id)
			  {
				  
					$('#edit_title').removeClass('is-invalid');
					$('#edit_titleErrorMsg').text('');  
					$('#edit_startDate').val('');  // sartDate
					$('#edit_starttime').removeClass('is-invalid');
					$('#edit_endtime').removeClass('is-invalid');
					$('#edit_starttimeErrorMsg').text('');  
					$('#edit_endtimeErrorMsg').text('');  
				  
				  
					// get Event Details for the passed event_id 
					
					/*
						client_id: 6
						color: "orange"
						created_at: "2020-11-08 19:08:58"
						details: null
						end: "2020-11-13 10:00:00"
						event_status_id: 5
						firstname: "Andrew"
						id: 17
						lastname: "Lee"
						start: "2020-11-13 09:00:00"
						status: "Transferred"
						title: "Meet Brian for Medication Delivery"
						updated_at: "2020-11-09 07:54:56"
						user_id: 2
					*/
					jQuery.ajax({
						url: "{{ url('/calendar/getEvent') }}",
						method: 'post',
						data: {
							
							'event_id' : event_id,
						},
						success: function(data){
							if (data)
							{
								//console.log(data);
								 let newLine = "\r\n";
								let event = data['event'];
								let note = data['note'];
								let formattedNote = '';
								
								if (typeof note == 'object')
								{
								
									// returned note contains array of notes containing created_by and note
									// create a string to use as val() for the current_note_element 
									note.forEach(element => formattedNote += element['created_by'] + newLine +element['note'] +newLine + newLine );
									$('#current_note').val(formattedNote);
								}
								if (formattedNote)
								{
									$('#divCurrent_note').addClass('d-block').removeClass('d-none');
								}
								else
								{
									$('#divCurrent_note').addClass('d-none').removeClass('d-block');
								}
								
								
								
								// formattedNote =note.replace('<br>',newLine);
								//return;
								let startDatetime = event.start;
								let endDatetime = event.end;
								let event_date = startDatetime.substr(0, 10);
								
								//start.substr(0, 10)
								$('#note').val('');
								$('#modelEditEventLabel').text('Edit Appointment for ' + event.firstname + ' ' + event.lastname);
								$('#edit_title').val(event.title);
								$('#edit_description').val(event.description);
								$('#edit_eventType').val(event.event_type_id);
								$('#edit_event_status').val(event.event_status_id);
								$('#event_date').val(event_date);
								$('#edit_starttime').val(startDatetime.substr(11,5));
								$('#edit_endtime').val(endDatetime.substr(11,5));
								$('#btnEditModal').click();
								
								
							}
						},
						error: function(data) {
							console.log(data);
							
						}
					});
			  }
			  
							
		
	
	function repeatClicked()
	{
		if ($('#frequency').val())
		{
			$('#divRepeatEndDate').addClass('d-block').removeClass('d-none');
		}
		else
		{
			$('#divRepeatEndDate').addClass('d-none').removeClass('d-block');	
		}
	}
	
	
	/* Moves event to a new date */
	function moveEvent(event)
	{
		//console.log(event);
		let event_id = event.id;
		let start = (event.startStr).substring(0,19);  // 2020-11-20T09:00:00
		let end =  (event.endStr).substring(0,19);
		let date = (event.startStr).substring(0,10);
		// Move the event in the events table 
		jQuery.ajax({
			url: "{{ url('/calendar/moveEvent') }}",
			method: 'post',
			data: {
				
				'event_id' : event_id,
				'date' : date,
				'start' : start, 
				'end' : end,
			},
			success: function(response){
				if (response)
				{
					displayMessage('Appointment Moved Successfully.');
				}
			},
			error: function(data) {
				console.log(data);
				
			}
		});
		
		
	}

	

</script>
