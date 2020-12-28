@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Vacations Details for {{$user->name}}</h2>
        </div>
    </div>
	
	
   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($vacations)  )
                <form id="viewUserVacations-form"
                    action="{{ route('vacation.list') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Start Date</th>
								                <th>End Date</th>
                                <th>Action</th>
                               
                            </tr>

                            @foreach ($vacations as $vacation)
                                <tr>
                                    <td>
                                        {{ $vacation->start_date }} 
                                    </td>
									
                                    <td>
                                        {{ $vacation->end_date }} 
                                    </td>
									
									
                                    <td>
                                        <span class="material-icons"  
                                            id="vacation_id_{{$vacation->id}}"   
                                            onclick="deleteVacation({{$vacation->id}})"  
                                            title="Delete"
                                            style=" cursor:pointer; color:red;" >
                                            delete
                                        </span>

                                    </td>  

                                    
                                    
                                </tr>
                            @endforeach
                        </table>

                       
                </form>
            @else
              <div class="mt-2 mb-4">
                <h5>No Vacation Details Found</h5>
              </div>
            @endif
     
        </div>

    </div>

    <div class = "row ">
        <div class="col-12 ">
          <a href="{{ route('vacation.list') }}">
            <button
                      type="button" 
                      class="btn btn-secondary ">
                  Back to Vacations Page
              </button>
          </a>
          
            <span class="ml-4"></span>

            <button
                id="btnAddVacation"
                    type="button" 
                    onClick="document.getElementById('btnAddVacationLaunchModal').click()"
                    class="btn btn-primary ">
                Add Vacation
            </button>

        </div>
    </div>



    <!-- Button trigger modal -->
<button type="button" id="btnDeleteVacation" class="btn btn-primary" data-toggle="modal" data-target="#deleteConfirmModal" hidden >
  Launch demo modal
</button>

<!-- Modal to Delete a Vacation-->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmModalLabel">Delete Vacation?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="divdDeleteConfirmModalBody">
        Are you sure that you want to Delete the Vacation?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary"  onClick="deleteVacationNow()" >Yes Delete</button>
      </div>
    </div>
  </div>
</div>






<!-- Button trigger modal -->
<button type="button" id="btnAddVacationLaunchModal" class="btn btn-primary" data-toggle="modal" 
    data-target="#AddVacationConfirmModal" hidden >
  Launch demo modal
</button>

<!-- Modal to Add a Vacation-->
<div class="modal fade" id="AddVacationConfirmModal" tabindex="-1" role="dialog" aria-labelledby="AddVacationConfirmModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddVacationConfirmModalLabel">Add Vacation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

    
        <div class="modal-body" id="divdAddVacationConfirmModalBody">
  
          <div class="row mb-2">
              <div class="col-4 ">Start Date</div>
              <div class="col-6">
                  <input type="date"  
                      id="start_date" 
                        name="start_date"
                        onClick="addVacation_elementClicked('start_date')"
                      class="form-control" 
                      required>
                      <div class="text-danger" id="start_dateErrorMsg" style="display:none;">Required</div>
                </div>
                
          </div>

          <div class="row mb-2">
            <div class="col-4 ">End Date</div>
              <div class="col-6">
                  <input type="date"  
                      id="end_date" 
                        name="end_date"
                        onClick="addVacation_elementClicked('end_date')"
                      class="form-control" 
                      required>
                    <div class="text-danger" id="end_dateErrorMsg" style="display:none;"></div>
                </div>
                
          </div>

        </div>
       


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button"    id="btnAddVacationModal" class="btn btn-primary"  onClick="AddVacationNow()" >Save</button>
      </div>
    </div>
  </div>
</div>



 
</div>

@endsection


<script>
    

    function deleteVacation(vacation_id)
    {
        window.vacation_id = vacation_id
        $('#divdDeleteConfirmModalBody').text('Are you sure that you want to delete the selected vacation?' );
        $('#btnDeleteVacation').click();
    }


    function deleteVacationNow() 
    {
     
		jQuery.ajax({
			url: "{{ url('/deleteVacation') }}",
			method: 'post',
			data: {
				"_token": "{{ csrf_token() }}",
				'vacation_id' :window.vacation_id,
			},
			success: function(response){
				if (response)
				{
					window.location.href ='/viewVacations';
				
				}
			},
			error: function(data) {
				console.log(data);
				
			}
        });	
        
    


    }

    
    function addVacation_elementClicked(element)
    {
        $('#'+element).removeClass('is-invalid');
        $('#'+element+'ErrorMsg').hide();
    }

    function AddVacationNow()
    {
        $("#start_dateErrorMsg").hide();
        $("#end_dateErrorMsg").hide();

        let start_date = $("#start_date").val().trim();
        let end_date = $("#end_date").val().trim();
        let ok= true;

        if (start_date =='')
        {
            $("#start_dateErrorMsg").show();
            $('#start_date').addClass('is-invalid');
            ok = false;
        }
        if (end_date =='')
        {
            $("#end_dateErrorMsg").show();
            $('#end_date').addClass('is-invalid');
            $('#end_dateErrorMsg').text('Required');
            ok = false;
        }

        if (ok && end_date < start_date)
        {
          $('#end_dateErrorMsg').text("End Date can't be less than the Start Date");
          $("#end_dateErrorMsg").show();
          $('#end_date').addClass('is-invalid');
          ok = false;
        }

        

        if (ok) 
        {
            $('#btnAddVacationModal').prop('disabled',true);
            jQuery.ajax({
              url: "{{ url('/createVacation') }}",
              method: 'post',
              data: {
                        "_token": "{{ csrf_token() }}",
                        'start_date' : start_date,
                        'end_date' : end_date,

              },
              success: function(response){
                if (response)
                {
                  dispayAlerrtMessage(" Vacation added successfully.");
                  setTimeout(() => {
                      window.location.href ='/viewVacations';
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

