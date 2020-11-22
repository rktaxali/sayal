@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="col-lg-10 col-md-12 border border-secondary rounded p-2 m-2">
        <form id="housings-form"
                    action="{{ route('housing.storeAllotment', [ 'housing_id'=>$housing_id]) }}" 
                    method="POST">
                @csrf
            
            <div class="row justify-content-center">
                <div class="col-12">
                    <h4>Allot Housing</h4>
                </div>
            </div>

            <div class="row mb-16">
                <div class="col-2">Address</div>
                <div class="col-10">
                                {{$housing->address}} <br>
                                {{$housing->city}} &nbsp;&nbsp;{{$housing->province}} - {{$housing->postalcode}}
                </div>
            </div> 

            <div class="row mt-4">
            </div>

            @if ($clients)
                <div class="row">
                    <div class="col-6">
                        <div class="form-group ">
                            <label for="client_id">Choose Client:</label>
                            <select name="client_id" id="client_id" class="form-control" >
                            @foreach($clients as $client )
                                <option value="{{ $client->client_id }}">
                                    {{ $client->client_name}}
                                </option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-8" style="max-width: 300px;">
                    <div class="form-group ">
                        <label for="start_date">Allotment Start Date:</label>
                        <input type="date"
                                required
                                class="form-control @error('start_date') is-invalid @enderror " 
                                style="margin-top:-6px;" 
                                placeholder="YYYY-MM-DD" 
                                    pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" 
                                    title="Enter a date in this formart YYYY-MM-DD"
                                value="{{old('start_date')}}"
                                name ="start_date"
                                id="start_date">

                                @error ('start_date')
                                    <p class="text-danger">{{ $errors->first('start_date') }}</p>
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

