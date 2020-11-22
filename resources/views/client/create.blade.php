@extends('layouts.app')

@section('content')

<div class="container">
    <h3> Add Client </h3>
        <form class="border border-secondary rounded p-2" 
            style="max-width:900px;" 
        
             action="{{ route('client.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-4">
                    <div class="form-group ">
                        <label for="firstname">First Name:</label>
                        <input type="text" class="form-control @error('firstname') is-invalid @enderror " 
                                style="margin-top:-6px;" 
                                placeholder="Enter First Name"
                                value="{{old('firstname')}}"
                                name ="firstname"
                                id="firstname">

                                @error ('firstname')
                                    <p class="text-danger">{{ $errors->first('firstname') }}</p>
                                @enderror  
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="lastname">Last Name:</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" 
                            style="margin-top:-6px;" placeholder="Enter Last Name" 
                            value="{{old('lastname')}}"
                            name ="lastname"
                            id="lastname">
                            @error ('lastname')
                                    <p class="text-danger">{{ $errors->first('lastname') }}</p>
                            @enderror 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="address" >Address:</label>
                        <input type="text" class="form-control" style="margin-top:-6px;" 
                            placeholder="Address" 
                            value="{{old('address')}}"
                            name ="address"
                            id="address">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" class="form-control" style="margin-top:-6px;"
                        placeholder="City" 
                        value="{{old('city')}}"
                        name ="city"
                        id="city">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="postalcode">Postal Code:</label>
                        <input type="text" class="form-control" style="margin-top:-6px;" 
                        placeholder="Enter Postal Code"
                        value="{{old('postalcode')}}"
                        name ="postalcode"
                        id="postalcode">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" style="margin-top:-6px;" 
                            placeholder="Phone"  
                            value="{{old('phone')}}"
                            name="phone" id="phone">
                    </div>
                </div>
            </div>
            

            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" 
                            style="margin-top:-6px;" 
                            placeholder="Enter email"
                            value="{{old('email')}}"
                            name ="email"
                            id="email">
                            @error ('email')
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
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
