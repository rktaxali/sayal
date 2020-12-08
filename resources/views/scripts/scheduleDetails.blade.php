<script>

  document.addEventListener('DOMContentLoaded', function() 
  {
		const hoursData = [];
		const sch_dataErrors = [];
		const delete_employee_schedule_user_id = null;
		
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
	
	 function createSchedule(user_id) 
	{
		
		// reset data in the schedule_create_modal 
		// for each day, ensure that if starttime is entered, the endtime is not empty and endtime > starttime and the differerce is at least 3 hors
		for( let i=1; i < 8; i++ )
		{
			$('#starttime_'+i).val('');
			$('#endtime_'+i).val('');
			$('#endtimeErrorMsg_'+i).text('');
			$('#starttimeErrorMsg_'+i).text('');
			$('#sch_ok_'+i).hide();
		}
		hoursData = [];
		sch_dataErrors = [];

		document.getElementById("scheduleCreate_user_id").value = user_id;
        event.preventDefault();
        var element = document.getElementById("createScheduleBtn");
		
		jQuery.ajax({
					url: "{{ url('/userScheduleBasicData') }}",
					method: 'post',
					data: {
						"_token": "{{ csrf_token() }}",
						'user_id' :user_id,
					},
					success: function(emplSchedule){
						if (emplSchedule)
						{
							$('#createUserName').text(emplSchedule[0].name);
							$('#min_hours').text(emplSchedule[0].min_hours);
							$('#max_hours').text(emplSchedule[0].max_hours);
						//	console.log(emplSchedule);
							
							// Update default store for each day
							emplSchedule.forEach((element,index) => {
								let element_index = index+1;
								$('#store_id_' +element_index ).val(element.store_id); 
								$('#starttime_' +element_index ).val(element.starttime);
								$('#endtime_' +element_index ).val(element.endtime);
								checkDayData(element_index);
							}  );
							updateWeeklyHours();
							 document.getElementById('btnModelCreateEvent').click();
							 return;
							
							
							
							
						}
					},
					error: function(data) {
						console.log(data);
						
					}
				});
			 
		
		
		
		
       
    }
	
	function elementClicked(day_id)
	{
		// Check if shift timings for the selected day are okay 
		checkDayData(day_id);
	}
	
	function checkDayData(i)
	{
		let day_schedule_OK = false;
		let chkDataError = false; 
		let starttime = $('#starttime_'+i).val();
		let endtime = $('#endtime_'+i).val();
		$('#endtimeErrorMsg_'+i).text('');
		$('#starttimeErrorMsg_'+i).text('');
		$('#store_idErrorMsg_'+i).text('');
	    sch_dataErrors[i] = false; 
		
		if (starttime ||  endtime)
		{
			if (starttime &&  endtime==='')
			{
				$('#endtimeErrorMsg_'+i).text('Required');
				chkDataError = true;
			}
			else if (endtime && starttime ==='')
			{
				$('#starttimeErrorMsg_'+i).text('Required');
				chkDataError = true;
			}
			else if  ( !(starttime==='') &&  !(endtime==='') &&  (starttime>= endtime))
			{
				$('#endtimeErrorMsg_'+i).text('End time must be greater than the start time' );
				chkDataError = true;
			}
			else if ( timeDiff_minutes(endtime,starttime) < 180)
			{
				// ensure that endtime is greater than starttime by 3 hours 
				$('#endtimeErrorMsg_'+i).text('At leaset 3 hours shift required');
				chkDataError = true;
			} 
			else if ( ! $('#store_id_'+i).val())
			{
				$('#store_idErrorMsg_'+i).text('Please Select Store');
				chkDataError = true;
			}
			else 
			{
				day_schedule_OK = true;
			}
			if (endtime && starttime)
			{
				hoursData[i] = timeDiff_minutes(endtime,starttime);
			}
			
			if (chkDataError)
			{
				sch_dataErrors[i] = chkDataError ? true : false; 
			}
		}
		else
		{
			day_schedule_OK = false;
			sch_dataErrors[i] = false;
		}
		
		day_schedule_OK? $('#sch_ok_'+i).show() : $('#sch_ok_'+i).hide();
		hoursData[i] ? $('#delete_schedule_'+i).show() : $('#delete_schedule_'+i).hide();
	
		let errorsCount = 0;
		for (let j=1; j<8; j++) 
		{
			if (sch_dataErrors[j])
			{
				errorsCount++;
			}
		}
		errorsCount ? $('#btnCreateEmployeeSchedule').addClass('disabled') : $('#btnCreateEmployeeSchedule').removeClass('disabled');
		

		updateWeeklyHours();
	}
	
	function edit_elementClicked(day_id)
	{
		// Check if shift timings for the selected day are okay while editing a schedule
		checkDayDataEditing(day_id);
	}
	
	
	function updateWeeklyHours()
	{
		let totalMinutes = 0 
		for(let i=1; i <hoursData.length; i++)
		{
			totalMinutes += hoursData[i];
		}
		let weeklyHours = (totalMinutes/60).toFixed(2);
		$('#weeklyHours').text(weeklyHours);

		// Update Weekly hours OK?  scheduled_hours_ok
		if (  weeklyHours >= parseFloat($('#min_hours').text()) && weeklyHours <= parseFloat($('#max_hours').text()) )
		{
			$('.scheduled_hours_ok').show();
		}
		else
		{
			$('.scheduled_hours_ok').hide();
		}
		
		(weeklyHours > parseFloat($('#max_hours').text()) ) ? $('.scheduled_hours_exeeded').show() : $('.scheduled_hours_exeeded').hide();
		let errorsCount = 0;
		for (let j=1; j<8; j++) 
		{
			if (sch_dataErrors[j])
			{
				errorsCount++;
			}
		}
		errorsCount ? $('#btnUpdateEmployeeSchedule').addClass('disabled') : $('#btnUpdateEmployeeSchedule').removeClass('disabled');

	
	}

	
	// Ensure that the schedule data is valid. If yes, create the schedule else
	// display suitable error messatge. 
	function createEmployeeSchedule()
	{
		// Proceed only if hoursData[] contains some data 
		if (hoursData.length == 0) 
		{
			hideModal();
			return;	
        }

		// create Employee Schedule
		jQuery.ajax({
				url: "{{ url('/createEmployeeSchedule') }}",
				method: 'post',
				data: {
					"_token": "{{ csrf_token() }}",
					'scheduleCreate_user_id' :$('#scheduleCreate_user_id').val(),
					'date_1' : $('#date_1').val(),
					'starttime_1' : $('#starttime_1').val(),
					'endtime_1' : $('#endtime_1').val(),
					'store_id_1' : $('#store_id_1').val(),
					'date_1' : $('#date_1').val(),
					'date_2' : $('#date_2').val(),
					'starttime_2' : $('#starttime_2').val(),
					'endtime_2' : $('#endtime_2').val(),
					'store_id_2' : $('#store_id_2').val(),
					'date_3' : $('#date_3').val(),
					'starttime_3' : $('#starttime_3').val(),
					'endtime_3' : $('#endtime_3').val(),
					'store_id_3' : $('#store_id_3').val(),
					'date_4' : $('#date_4').val(),
					'starttime_4' : $('#starttime_4').val(),
					'endtime_4' : $('#endtime_4').val(),
					'store_id_4' : $('#store_id_4').val(),
					'date_5' : $('#date_5').val(),
					'starttime_5' : $('#starttime_5').val(),
					'endtime_5' : $('#endtime_5').val(),
					'store_id_5' : $('#store_id_5').val(),
					'date_6' : $('#date_6').val(),
					'starttime_6' : $('#starttime_6').val(),
					'endtime_6' : $('#endtime_6').val(),
					'store_id_6' : $('#store_id_6').val(),
					'date_7' : $('#date_7').val(),
					'starttime_7' : $('#starttime_7').val(),
					'endtime_7' : $('#endtime_7').val(),
					'store_id_7' : $('#store_id_7').val(),
				
				},
				success: function(response){
					if (response)
					{
						// Display that schdeule has been created successfully
						$('#divCreateAlert').show();
						setTimeout(function(){ 
							hideModal();
							// Reload schedules data for the current schedule page after 500 m seconds
							// Note: schedule_id will be picked up from session()
							window.location.href ='/scheduleEdit';
						}, 500);
						
					}
				},
				error: function(data) {
					console.log(data);
					
				}
			});

	}



	function editSchedule(user_id)
	{
		// load data for user_id and populate it in components/schedule_edit_modal.blade.php 
		sch_dataErrors = [];
		jQuery.ajax({
			url: "{{ url('/userScheduleData') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'user_id' :user_id,
			},
			success: function(emplSchedule){
				if (emplSchedule)
				{
					hoursData = [];
				
					$('#editUserName').text(emplSchedule[0].name);
					$('#edit_min_hours').text(emplSchedule[0].min_hours);
					$('#edit_max_hours').text(emplSchedule[0].max_hours);
				//	console.log(emplSchedule);
					
					// Update default store for each day
					emplSchedule.forEach((element,index) => {
						let element_index = index+1;
						$('#edit_starttime_' +element_index ).val(element.starttime);
						$('#edit_endtime_' +element_index ).val(element.endtime);
						$('#edit_store_id_' +element_index ).val(element.store_id); 
						if ( typeof element.endtime == 'string' && typeof element.starttime == 'string' )
						{
							hoursData[element_index] = timeDiff_minutes(element.endtime,element.starttime);
						}
						checkDayDataEditing(element_index);
						
					}  );
					updateWeeklyHoursEdit();
					 document.getElementById('btnModalUpdateSchedule').click();
					 return;
					
					
					
					
				}
			},
			error: function(data) {
				console.log(data);
				
			}
		});
			 
	}
	

	function checkDayDataEditing(i)
	{
		let day_schedule_OK = false;
		let chkDataError = false; 
		let starttime = $('#edit_starttime_'+i).val();
		let endtime = $('#edit_endtime_'+i).val();
		$('#edit_endtimeErrorMsg_'+i).text('');
		$('#edit_starttimeErrorMsg_'+i).text('');
		$('#edit_store_idErrorMsg_'+i).text('');
		sch_dataErrors[i] = false; 
	
		
		if (starttime ||  endtime)
		{
			if (starttime &&  endtime==='')
			{
				$('#edit_endtimeErrorMsg_'+i).text('Required');
				chkDataError = true; 
			}
			else if (endtime && starttime ==='')
			{
				$('#edit_starttimeErrorMsg_'+i).text('Required');
				chkDataError = true; 
			}
			else if  ( !(starttime==='') &&  !(endtime==='') &&  (starttime>= endtime))
			{
				$('#edit_endtimeErrorMsg_'+i).text('End time must be greater than the start time' );
				chkDataError = true; 
			}
			else if ( timeDiff_minutes(endtime,starttime) < 180)
			{
				// ensure that endtime is greater than starttime by 3 hours 
				$('#edit_endtimeErrorMsg_'+i).text('At leaset 3 hours shift required');
				chkDataError = true; 
			} 
			else if ( ! $('#edit_store_id_'+i).val())
			{
				$('#edit_store_idErrorMsg_'+i).text('Please Select Store');
				chkDataError = true; 
			}
			else 
			{
				day_schedule_OK = true;
				
			}
			
			if (endtime && starttime)
			{
				hoursData[i] = timeDiff_minutes(endtime,starttime);
			}
			if (chkDataError)
			{
				sch_dataErrors[i] = chkDataError ? true : false; 
			}
		}
		else
		{
			day_schedule_OK = false;
		}
		
		day_schedule_OK? $('#edit_sch_ok_'+i).show() : $('#edit_sch_ok_'+i).hide();
		hoursData[i] ? $('#edit_delete_schedule_'+i).show() : $('#edit_delete_schedule_'+i).hide();

		let errorsCount = 0;
		for (let j=1; j<8; j++) 
		{
			if (sch_dataErrors[j])
			{
				errorsCount++;
			}
		}
		errorsCount ? $('#btnUpdateEmployeeSchedule').addClass('disabled') : $('#btnUpdateEmployeeSchedule').removeClass('disabled');


		updateWeeklyHoursEdit();
	}
	

	
	function updateWeeklyHoursEdit()
	{
		let totalMinutes = 0 
		for(let i=1; i <hoursData.length; i++)
		{
			totalMinutes += hoursData[i];
		}
		let weeklyHours = (totalMinutes/60).toFixed(2);
		$('#edit_weeklyHours').text(weeklyHours);

		// Update Weekly hours OK?  scheduled_hours_ok
		if (  weeklyHours >= parseFloat($('#edit_min_hours').text()) && weeklyHours <= parseFloat($('#edit_max_hours').text()) )
		{
			$('.scheduled_hours_ok').show();
		}
		else
		{
			$('.scheduled_hours_ok').hide();
		}
		
		(weeklyHours > parseFloat($('#edit_max_hours').text()) ) ? $('.scheduled_hours_exeeded').show() : $('.scheduled_hours_exeeded').hide();

	
	}
	
	function edit_DeleteDaySchedule(day_id)
	{
		$('#edit_starttime_'+day_id).val('');
		$('#edit_endtime_'+day_id).val('');
		$('#edit_store_id_'+day_id).val('');
		hoursData[day_id] = 0;
		edit_elementClicked(day_id);
		updateWeeklyHoursEdit();
	}
	
	
	function deleteDaySchedule(day_id)
	{
		$('#starttime_'+day_id).val('');
		$('#endtime_'+day_id).val('');
		$('#store_id_'+day_id).val('');
		hoursData[day_id] = 0;
		elementClicked(day_id);
		updateWeeklyHours();
	}


	// Save updated schedule for the employee
	function updateEmployeeSchedule()
	{
		// Data has already been verified except for store_id
		jQuery.ajax({
				url: "{{ url('/updadeUserScheduleData') }}",
				method: 'post',
				data: {
					"_token": "{{ csrf_token() }}",
				//	'scheduleCreate_user_id' :$('#scheduleCreate_user_id').val(),
					'date_1' : $('#edit_date_1').val(),
					'starttime_1' : $('#edit_starttime_1').val(),
					'endtime_1' : $('#edit_endtime_1').val(),
					'store_id_1' : $('#edit_store_id_1').val(),
					'date_1' : $('#edit_date_1').val(),
					'date_2' : $('#edit_date_2').val(),
					'starttime_2' : $('#edit_starttime_2').val(),
					'endtime_2' : $('#edit_endtime_2').val(),
					'store_id_2' : $('#edit_store_id_2').val(),
					'date_3' : $('#edit_date_3').val(),
					'starttime_3' : $('#edit_starttime_3').val(),
					'endtime_3' : $('#edit_endtime_3').val(),
					'store_id_3' : $('#edit_store_id_3').val(),
					'date_4' : $('#edit_date_4').val(),
					'starttime_4' : $('#edit_starttime_4').val(),
					'endtime_4' : $('#edit_endtime_4').val(),
					'store_id_4' : $('#edit_store_id_4').val(),
					'date_5' : $('#edit_date_5').val(),
					'starttime_5' : $('#edit_starttime_5').val(),
					'endtime_5' : $('#edit_endtime_5').val(),
					'store_id_5' : $('#edit_store_id_5').val(),
					'date_6' : $('#edit_date_6').val(),
					'starttime_6' : $('#edit_starttime_6').val(),
					'endtime_6' : $('#edit_endtime_6').val(),
					'store_id_6' : $('#edit_store_id_6').val(),
					'date_7' : $('#edit_date_7').val(),
					'starttime_7' : $('#edit_starttime_7').val(),
					'endtime_7' : $('#edit_endtime_7').val(),
					'store_id_7' : $('#edit_store_id_7').val(),
				
				},
				success: function(response){
					if (response)
					{
						// Display that schdeule has been created successfully
						$('#divEditScheduleAlert').show();
						setTimeout(function(){ 
							hideModal();
							// Reload schedules data for the current schedule page after 500 m seconds
							// Note: schedule_id will be picked up from session()
							window.location.href ='/scheduleEdit';
						}, 500);
						
					}
				},
				error: function(data) {
					console.log(data);
					
				}
			});

	}

    function deleteSchedule(user_id,delete_user_name ) 
    {
		delete_employee_schedule_user_id = user_id;
		$('#divdDeleteConfirmModalBody').text('Are you sure that you want to Delete the Schedule for ' + delete_user_name + '?');
		$('#btnDeleteEmployeeSchedule').click(); 
	} 

	

    function deleteScheduleNow() 
    {
		
		jQuery.ajax({
			url: "{{ url('/deleteUserScheduleData') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'user_id' :delete_employee_schedule_user_id,
			},
			success: function(response){
				if (response)
				{
					window.location.href ='/scheduleEdit';
				
				}
			},
			error: function(data) {
				console.log(data);
				
			}
		});		



    }

	// Save the current schedule for the user as default schedule 
	function saveAsDefaultSchedule(user_id)
	{
		jQuery.ajax({
			url: "{{ url('/saveAsDefaultSchedule') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'user_id' :user_id,
			},
			success: function(response){
				if (response)
				{
					dispayAlerrtMessage('Employee Schedule saved as default schedule.',10000);
				
				}
			},
			error: function(data) {
				console.log(data);
				
			}
		});			
		


	}
	

</script>
