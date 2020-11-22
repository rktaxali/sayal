@extends('layouts.app')

@section('content')

<div class="container">
    <h3> Edit Note for Client {{ $client_name}}</h3>
    <form class="border border-secondary rounded p-2" 
        style="max-width:900px;" 
    
            action="{{ route('client.noteUpdate') }}" method="POST">
        @csrf

        <!-- Original Note is displayed. It can't be edited -->
        <div class="row">
            <div class="col-12">
                <div class="form-group ">
                    <label for="note">Note:</label>
                    <textarea 
                        readonly
                        class="form-control  @error('note') is-invalid @enderror " 
                        style="height:200px" name="note"
                        >{{ $note->note  }}
                    </textarea>
                </div>
            </div>
        </div>

        <!-- Additional text that will be appended to original 'note' -->
        <div class="row">
            <div class="col-12">
                <div class="form-group ">
                    <label for="addNote">Add:</label>
                        
                    <textarea 
                        class="form-control  @error('addNote') is-invalid @enderror " 
                        style="height:100px" name="addNote"
                        >
                    </textarea>
                    <p class="text-danger">{{ $errors->first('addNote') }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12" >
                <button type="submit" class="btn btn-primary ml-3">Submit</button>

                <a href="{{$cancelRoute }}"  class="ml-2"><button type="button"  class="btn btn-secondary" >Cancel</button></a>
            </div>
        </div>

    </form>
    
</div>
@endsection
