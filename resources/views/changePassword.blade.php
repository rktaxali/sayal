@extends('layouts.app')

@section('content')

<div class="container">
    <h3> Chnage Password </h3>
        <form class="border border-secondary rounded p-2" 
            style="max-width:700px;" 
        
             action="{{ route('client.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-10 col-md-4">
                    <div class="form-group ">
                        <label for="currentPassword">Current Password:</label>
                        <input type="password" 
								required
								class="form-control @error('currentPassword') is-invalid @enderror " 
                                style="margin-top:-6px;" 
                                value="{{old('currentPassword')}}"
                                name ="currentPassword"
                                id="currentPassword">

                                @error ('currentPassword')
                                    <p class="text-danger">{{ $errors->first('currentPassword') }}</p>
                                @enderror  
                    </div>
				</div>
            </div>

           <div class="row">
                <div class="col-10 col-md-4">
                    <div class="form-group ">
                        <label for="newPassword">New Password:</label>
                        <input type="password" 
								class="form-control @error('newPassword') is-invalid @enderror " 
                                style="margin-top:-6px;" 
								required
                                value="{{old('newPassword')}}"
                                name ="newPassword"
                                id="newPassword">

                                @error ('newPassword')
                                    <p class="text-danger">{{ $errors->first('newPassword') }}</p>
                                @enderror  
                    </div>
				</div>
            </div>			
			
		           <div class="row">
                <div class="col-10 col-md-4">
                    <div class="form-group ">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" 
								class="form-control @error('confirmPassword') is-invalid @enderror " 
                                style="margin-top:-6px;" 
                                name ="confirmPassword"
                                id="confirmPassword">

                                @error ('confirmPassword')
                                    <p class="text-danger">{{ $errors->first('confirmPassword') }}</p>
                                @enderror  
                    </div>
				</div>
            </div>
            
            <div class="row mt-4" >
                <button type="submit" class="btn btn-primary ml-3">Submit</button>

                <a href="{{ route('home') }}"  class="ml-2"><button type="button"  class="btn btn-secondary" >Cancel</button></a>
            </div>

        </form>
    
</div>
@endsection
