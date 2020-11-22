@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">User Uploaded File</div>
            

           


        <div class="card-body">


            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
                

            @if ( count($uploaded_files)  )

                <table class="table table-bordered table-responsive-lg">
                    <tr>
                        <th>No</th>
                        <th>original_name</th>
                        <th>Saved Path</th>
                        <th >File Type</th>
                        <th class="text-right">Size</th>
                        <th>Actions</th>
                    </tr>

                    @foreach ($uploaded_files as $file)
                        <tr>
                            <td>{{ $file->id}}</td>
                            <td> {{ $file->original_name }} </td>
                            <td>{{ $file->upload_path}}</td>
                            <td >{{ $file->mimeType}}</td>
                            <td class="text-right">{{ $file->size}}</td>
                            <td>
                                <form action="{{ route('user-files.deleteFile',$file->id) }}" method="POST">
                        
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" 
                                        title="delete" style="border: none; background-color:transparent;">
                                        <i class="fas fa-trash fa-lg text-danger"></i>
                                    </button>
                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p>No uploaded files for the user</p>
            @endif

            
        </div>
        
</div>

@endsection
