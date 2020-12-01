<script>

  document.addEventListener('DOMContentLoaded', function() 
  {
		hoursData = [];
		
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

		
		document.getElementById("scheduleCreate_user_id").value = user_id;
        event.preventDefault();
        var element = document.getElementById("createScheduleBtn");
   //     element.disabled = true;
		
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
								}  );

							
								
								
							//	return;
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
		let starttime = $('#starttime_'+i).val();
		let endtime = $('#endtime_'+i).val();
		$('#endtimeErrorMsg_'+i).text('');
		$('#starttimeErrorMsg_'+i).text('');
		$('#store_idErrorMsg_'+i).text('');
		console.log(starttime ,endtime);
		
		if (starttime ||  endtime)
		{
			if (starttime &&  endtime==='')
			{
				$('#endtimeErrorMsg_'+i).text('Required');
			}
			else if (endtime && starttime ==='')
			{
				$('#starttimeErrorMsg_'+i).text('Required');
			}
			else if  ( !(starttime==='') &&  !(endtime==='') &&  (starttime>= endtime))
			{
				$('#endtimeErrorMsg_'+i).text('End time must be greater than the start time' );
			}
			else if ( timeDiff_minutes(endtime,starttime) < 180)
			{
				// ensure that endtime is greater than starttime by 3 hours 
				$('#endtimeErrorMsg_'+i).text('At leaset 3 hours shift required');
			} 
			else if ( ! $('#store_id_'+i).val())
			{
				$('#store_idErrorMsg_'+i).text('Please Select Store');
			}
			else 
			{
				day_schedule_OK = true;
				hoursData[i] = timeDiff_minutes(endtime,starttime);
			}
		}
		
		
		day_schedule_OK? $('#sch_ok_'+i).show() : $('#sch_ok_'+i).hide();
		updateWeeklyHours();
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
			$('#scheduled_hours_ok').show();
		}
		else
		{
			$('#scheduled_hours_ok').hide();
		}
		
		(weeklyHours > parseFloat($('#max_hours').text()) ) ? $('#scheduled_hours_exeeded').show() : $('#scheduled_hours_exeeded').hide();

	
	}
	
	
	// Ensure that the schedule data is valid. If yes, create the schedule else
	// display suitable error messatge. 
	function createEmployeeSchedule()
	{
		// for each day, ensure that if starttime is entered, the endtime is not empty and endtime > starttime and the differerce is at least 3 hors
		for( let i=1; i < 8; i++ )
		{
			
			let starttime = $('#starttime_'+i).val();
			let endtime = $('#endtime_'+i).val();
			
			
			
			
			if (starttime &&  endtime==='')
			{
				$('#endtimeErrorMsg_'+i).text('Required');
			}
		
			
			if ( !(starttime==='') &&  !(endtime==='') &&  (starttime>= endtime))
			{
				$('#endtimeErrorMsg_'+i).text('End time must be greater than the start time' );
			}
			else if ( timeDiff_minutes(endtime,starttime) < 180)
			{
				// ensure that endtime is greater than starttime by 3 hours 
				$('#endtimeErrorMsg_'+i).text('At leaset 3 hours shift required');
			} else 
			{
				$('#sch_ok_'+i).show();
			}
			
			
		}
		
	}





</script>