@extends('layouts.app')  

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Manage Holidays</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($holidays)  )
                <form id="holiday-form"
                    action="#" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Action</th>
                               
                            </tr>

							@foreach ($holidays as $holiday)
                                <tr>
                                    <td>
									    {{ $holiday->name}}
                                    </td>

                                    <td>
                                        {{ $holiday->date}}

                                        
                                        
                                    </td>
                                    
									<td>
                                    <span class="material-icons" 
                                            style="color:red; cursor:pointer" 
                                            onClick="deleteHoliday( '{{ $holiday->id  }}','{{ $holiday->name  }}'  )" >
                                         delete
                                    </span>

                                       

                                       
                                    </td>  

                                    
                                    
                                </tr>
							@endforeach
                           
                        </table>

                      
                </form>
				
				
            @endif
     
        </div>

    </div>
	
	
	<div class = "row ">
        <div class="col-12 ">
			
            <button
                id="btnAddHoliday"
                    type="button" 
                    onClick="document.getElementById('btnAddHolidayLaunchModal').click()"
                    class="btn btn-primary ml-3">
                Add New Holiday
            </button>

                   
		</div>
	</div>

<!-- Button trigger modal -->
<button type="button" id="btnDeleteHoliday" class="btn btn-primary" data-toggle="modal" data-target="#deleteConfirmModal" hidden >
  Launch demo modal
</button>

<!-- Modal to Delete a Holiday-->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmModalLabel">Delete Holiday?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="divdDeleteConfirmModalBody">
        Are you sure that you want to Delete the Holiday?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary"  onClick="deleteHolidayNow()" >Yes Delete</button>
      </div>
    </div>
  </div>
</div>





<!-- Button trigger modal -->
<button type="button" id="btnAddHolidayLaunchModal" class="btn btn-primary" data-toggle="modal" 
    data-target="#AddHolidayConfirmModal" hidden >
  Launch demo modal
</button>

<!-- Modal to Add a Holiday-->
<div class="modal fade" id="AddHolidayConfirmModal" tabindex="-1" role="dialog" aria-labelledby="AddHolidayConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddHolidayConfirmModalLabel">Add Holiday</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    
        <div class="modal-body" id="divdAddHolidayConfirmModalBody">
            
            <div class="row mb-2">
                <div class="col-4">Holiday Name</div>
                <div class="col-6">
                    <input type="text" 
                        id="holidayName" 
                         name="holidayName"
                         onClick="addholiday_elementClicked('holidayName')"
                    class="form-control" required></div>
                <div class="text-danger" id="holidayNameErrorMsg" style="display:none;">Required</div>
            </div>

            <div class="row">
                <div class="col-4 ">Date</div>
                <div class="col-6">
                    <input type="date"  
                        id="holidayDate" 
                         name="holidayDate"
                         onClick="addholiday_elementClicked('holidayDate')"
                        class="form-control" 
                        required></div>
                <div class="text-danger" id="holidayDateErrorMsg" style="display:none;">Required</div>
            </div>

        </div>
       


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary"  onClick="AddHolidayNow()" >Save</button>
      </div>
    </div>
  </div>
</div>








 
</div>

@endsection


<script>
    
    function deleteHoliday(id,holiday_name ) 
    {
		delete_holiday_id = id;
		$('#divdDeleteConfirmModalBody').text('Are you sure that you want to delete the holiday - ' + holiday_name + '?');
		$('#btnDeleteHoliday').click(); 
	} 

	

    function deleteHolidayNow() 
    {
		
		jQuery.ajax({
			url: "{{ url('/deleteHoliday') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'holiday_id' :delete_holiday_id,
			},
			success: function(response){
				if (response)
				{
					window.location.href ='/holiday';
				
				}
			},
			error: function(data) {
				console.log(data);
				
			}
        });	
        
    


    }


    function addholiday_elementClicked(element)
    {
        $('#'+element).removeClass('is-invalid');
        $('#'+element+'ErrorMsg').hide();
    }


    function AddHolidayNow()
    {
        $("#holidayNameErrorMsg").hide();
        $("#holidayDateErrorMsg").hide();

        let holidayName = $("#holidayName").val().trim();
        let holidayDate = $("#holidayDate").val().trim();
        let ok= true;

        if (holidayName =='')
        {
            $("#holidayNameErrorMsg").show();
            $('#holidayName').addClass('is-invalid');
            ok = false;
        }
        if (holidayDate =='')
        {
            $("#holidayDateErrorMsg").show();
            $('#holidayDate').addClass('is-invalid');
            ok = false;
        }

        if (ok) 
        {
          jQuery.ajax({
            url: "{{ url('/createHoliday') }}",
            method: 'post',
            data: {
                      "_token": "{{ csrf_token() }}",
                      'date' : holidayDate,
                      'name' : holidayName,

            },
              success: function(response){
            if (response)
            {
                        dispayAlerrtMessage(holidayName + " holiday added successfully.");
                        setTimeout(() => {
                            window.location.href ='/holiday';
                        }, 2000);
              
            
            }
          },
          error: function(data) {
            console.log(data);
            
			    }
        });	 
        }

    }

 
    

</script>

