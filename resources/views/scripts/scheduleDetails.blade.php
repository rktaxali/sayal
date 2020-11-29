<script>

  document.addEventListener('DOMContentLoaded', function() 
  {
	
		
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

  
	});
	
	/**
	  * For the passed user_id, fetch some basic details like min_hours, max_hours, name, etc. 
	  * Fill 
	  */
	
	 function createSchedule(user_id) {
		//alert('createSchedule ' + user_id );
		
		document.getElementById("scheduleCreate_user_id").value = user_id;
        event.preventDefault();
        var element = document.getElementById("createScheduleBtn");
        element.disabled = true;
		
			jQuery.ajax({
						url: "{{ url('/userScheduleBasicData') }}",
						method: 'post',
						data: {
							"_token": "{{ csrf_token() }}",
							'user_id' :user_id,
						},
						success: function(data){
							if (data)
							{
								console.log(data);
								return;
								 document.getElementById('btnModelCreateEvent').click();
								
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





</script>