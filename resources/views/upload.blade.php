@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">Upload File</div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                        @if (Session::get('isImage'))
                            @if ($uploadFilename = Session::get('uploadFilename'))
                                <!-- Note: file path is storage/app/public/uploads
                                            but is linked to storage/uploads through 
                                            php artisan storage:link -->
                                    <img src='{{asset("storage/uploads/$uploadFilename")}}' 
                                        width="100px;" alt="asset"
                                    >
                            @endif
                        @endif
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif 


        <div class="card-body">
            <form method="POST" action="{{route('upload.upload-file')}}" enctype="multipart/form-data">
            @csrf
                <div class="form-group">

                    <label for='file'>Choose File</label>
                    <input type="File" class="form-control" name="file" id="file">
                    
                </div>
                <button type="submit" class="btn btn-success">Upload</button>
            </form>
            
        </div>
        
       
</div>

@endsection
