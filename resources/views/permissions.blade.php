@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>User Permissions</h2>
        </div>
    </div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($users)  )
                <form id="permisisons-form"
                    action="{{ route('permission.store') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>User</th>
                                <th>Create User</th>
                                <th>Create Store Schedule</th>
                                <th>Create Warehouse Schedule</th>
								<th>Approve Schedule</th>
								<th>View All Schedule</th>
                                <th>View Store Schedule</th>
                                <th>Holiday/Vacation</th>
                            </tr>

                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        {{ $user->firstname }} {{ $user->lastname }}
                                    </td>
                                    
									<td>
                                        <input type="checkbox" id="create_user_{{$user->id}}" name="create_user_{{$user->id}}" 
                                            @if($user->create_user) Checked @endif 
                                            value="1">       
                                    </td>  

                                    <td>
                                        <input type="checkbox" id="create_store_schedule_{{$user->id}}" name="create_store_schedule_{{$user->id}}" 
                                            @if($user->create_store_schedule) Checked @endif 
                                            value="1">       
                                    </td>
                                    <td>
                                        <input type="checkbox" id="create_warehouse_schedule_{{$user->id}}" name="create_warehouse_schedule_{{$user->id}}" 
                                            @if($user->create_warehouse_schedule) Checked @endif 
                                            value="1">       
                                    </td>
									 <td>
                                        <input type="checkbox" id="aprv_schedule_{{$user->id}}" name="aprv_schedule_{{$user->id}}" 
                                            @if($user->aprv_schedule) Checked @endif 
                                            value="1">       
                                    </td>
                                     <td>
                                        <input type="checkbox" id="view_all_schedules_{{$user->id}}" name="view_all_schedules_{{$user->id}}" 
                                            @if($user->view_all_schedules) Checked @endif 
                                            value="1">       
                                    </td>

                                    <td>
                                        <input type="checkbox" id="view_store_schedule_{{$user->id}}" name="view_store_schedule_{{$user->id}}" 
                                            @if($user->view_store_schedule) Checked @endif 
                                            value="1">       
                                    </td>

                                    <td>
                                        <input type="checkbox" id="holiday_vacation_{{$user->id}}" 
                                                name="holiday_vacation_{{$user->id}}" 
                                            @if($user->holiday_vacation) Checked @endif 
                                            value="1">       
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </table>

                        <div class="row mt-4" >
                                <button
                                    id="submitButton"
                                     type="button" 
                                        onClick="submitForm()"
                                        class="btn btn-primary ml-3">
                                    Submit
                                </button>

                                <div id="spinner" class="spinner-border text-primary ml-2" style="visibility:hidden"></div>

                                <a href="/home"  class="ml-4">
                                    <button type="button" 
                                            class="btn btn-secondary"  >
                                        Cancel
                                    </button>
                                </a>
                    </div>
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
        document.getElementById('permisisons-form').submit();
    }

</script>

