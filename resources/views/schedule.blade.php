@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Manage Schedules</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($schedules)  )
                <form id="schedule-form"
                    action="{{ route('schedule.edit') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Name</th>
                                <th>Edit</th>
                               
                            </tr>

							@foreach ($schedules as $schedule)
                                <tr>
                                    <td>
									{{ $schedule->start_date}}
                                    </td>
                                    
									<td>
										<button type="submit" name="schedule_id" value ="{{ $schedule->id }}"  class="btn btn-sm btn-secondary">
												Edit</button>
											
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
			<form id="new-schedule-form"
							action="{{ route('schedule.create') }}" method="POST">
                   @csrf
				   
				     
                                <button
                                    id="submitButton"
                                     type="button" 
                                        onClick="submitForm()"
                                        class="btn btn-primary ml-3">
                                    Create New Schedule
                                </button>

                                <div id="spinner" class="spinner-border text-primary ml-2" style="visibility:hidden"></div>

                                
						
			</form>
		</div>
	</div>
 
</div>

@endsection


<script>
    function submitForm() {
		console.log('submit forn');
		
        // disable Submit button
        event.preventDefault();
        var element = document.getElementById("submitButton");
        element.disabled = true;
        // display spinner and submit form
        var element = document.getElementById("spinner");
        element.style.visibility='visible';
        document.getElementById('new-schedule-form').submit();
    }

</script>

