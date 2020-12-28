@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Manage User Vacations </h2>
        </div>
    </div>
	
	
   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($users)  )
                <form id="viewUserVacations-form"
                    action="{{ route('vacation.viewVacations') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Name</th>
								<th>Employee Type</th>
                                <th>Vacations</th>
                               
                            </tr>

                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->firstname }} {{ $user->lastname }}
                                    </td>
									
                                    <td>
                                        {{ $user->empl_type }} 
                                    </td>
									
									<td>
											<button type="submit" 
                                                name="view_vacation_user_id" 
                                                value ="{{ $user->id }}"  
                                                class="btn btn-sm btn-secondary">
											    	View/Create
											</button>

                                            
                                    </td>  

                                    
                                    
                                </tr>
                            @endforeach
                        </table>

                       
                </form>
            @endif
     
        </div>

    </div>
 
</div>

@endsection


<script>
    function submitForm() {
        // disable Submit button
        event.preventDefault();
        var element = document.getElementById("submitButton");
        element.disabled = true;
        // display spinner and submit form
        var element = document.getElementById("spinner");
        element.style.visibility='visible';
        document.getElementById('userList-form').submit();
    }

</script>

