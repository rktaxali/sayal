@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="col-lg-10 col-md-12 border border-secondary rounded p-2 m-2">
        <form id="housings-form"
                    action="{{ route('housing.revokeAllotment'  ) }}" 
                    method="POST">
                @csrf
            <input hidden name="revoke_housing_id" type="text" value="{{ $revoke_housing_id }}">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h4>Revoke Housing</h4>
                </div>
            </div>

            <div class="row mb-16">
                <div class="col-2">Address</div>
                <div class="col-10">
                                {{$housing->address}} <br>
                                {{$housing->city}} &nbsp;&nbsp;{{$housing->province}} - {{$housing->postalcode}}
                </div>
            </div> 

            <div class="row ">
                <div class="col-2">Allotted to</div>
                <div class="col-10">
                                {{$client->client_name}} since  {{$client->start_date}} 
                </div>
            </div> 

            <div class="row mt-4">
            </div>

            <div class="row">
                <div class="col-8" style="max-width: 300px;">
                    <div class="form-group ">
                        <label for="end_date">Allotment End Date:</label>
                        <input type="date"
                                required
                                class="form-control @error('end_date') is-invalid @enderror " 
                                style="margin-top:-6px;" 
                                placeholder="YYYY-MM-DD" 
                                    pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" 
                                    title="Enter a date in this formart YYYY-MM-DD"
                                value="{{old('end_date')}}"
                                name ="end_date"
                                id="end_date">

                                @error ('end_date')
                                    <p class="text-danger">{{ $errors->first('end_date') }}</p>
                                @enderror  
                    </div>
                </div>
            </div>

            

            <div class="row ml-1 mt-2">
                <div class="col-8">
                    <button class="btn btn-primary" type="submit" >Submit</button>
                </div>
            </div>


        </form>

    </div>
  

@endsection

