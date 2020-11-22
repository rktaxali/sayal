@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>  </h2>
            </div>
            <div class="pull-left">
                <a class="btn btn-primary" href="/products" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

  
    <div class="row">
        <div class="col-1">
            <div class="form-group">
                <strong>Name:</strong>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                 {{$product->name}}

            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-1">
            <div class="form-group">
                <strong>Description:</strong>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                 {{$product->description}}

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-1">
            <div class="form-group">
                <strong>Price:</strong>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                 {{$product->price}}

            </div>
        </div>
    </div>  

    <div class="row">
        <div class="col-1">
            <div class="form-group">
                <strong>Date Created:</strong>
            </div>
        </div>
        <div class="col-3">
            <div class="form-group">
                 {{$product->created_at}}

            </div>
        </div>
    </div>      

     
@endsection
