@extends('layouts.app')

@section('content')

<div class="container">
    <h3> Create Note for Client {{ $client_name}}</h3>
        <form class="border border-secondary rounded p-2" 
            style="max-width:900px;" 
        
             action="{{ route('client.noteStore') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-12">
                    <div class="form-group ">
                        <label for="note">Note:</label>
                            
                        <textarea class="form-control  @error('note') is-invalid @enderror " 
                            style="height:200px" name="note"
                            >
                            {{old('note')}}
                        </textarea>
                        <p class="text-danger">{{ $errors->first('note') }}</p>
                </div>
            </div>


                


            <div class="row">
                <div class="col-12" >
                    <button type="submit" class="btn btn-primary ml-3">Submit</button>

                    <a href="{{ url()->previous() }}"  class="ml-2"><button type="button"  class="btn btn-secondary" >Cancel</button></a>
                </div>
            </div>

        </form>
    
</div>

@include('components.event_create_modal')
@endsection
