@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Manage Users @if($exclueNonStore_warehouse_Staff) - Excludes Front Office Staff  @endif</h2>
        </div>
    </div>
	
	<div class = "row mb-2">
		<div class="col-12 ">
			@if($exclueNonStore_warehouse_Staff)
				<a href="/userList">Show All Staff Members</a>
			@else
				<a href="/userList/true">Hide Front Office Staff</a>
			@endif
		</div>
	</div>

   
    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($users)  )
                <form id="userList-form"
                    action="{{ route('user.edit') }}" method="GET">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Name</th>
								<th>Employee Type</th>
                                <th>Status</th>
                                <th>Edit</th>
                               
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
                                        {{ $user->status }} 
                                    </td>
									
									<td>
											<button type="submit" name="edit_user_id" value ="{{ $user->id }}"  class="btn btn-sm btn-secondary">
												Edit
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

