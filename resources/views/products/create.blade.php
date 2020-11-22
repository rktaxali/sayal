@extends('layouts.app')

@section('content')
<div class='container'>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="/products" title="Go back"> <i class="fas fa-backward "></i> </a>
            </div>
        </div>
    </div>

    <form action="/products" method="POST" >
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" 
                        name="name" 
                        class="form-control      @error('name') is-invalid @enderror "
                        value="{{old('name')}}"
                        placeholder="Name">
                    @error ('name')
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                    @enderror  
                            
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control  @error('description') is-invalid @enderror " style="height:50px" name="description"
                        placeholder="description">{{old('description')}}</textarea>
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="float" 
                        name="price" 
                        class="form-control  @error('price') is-invalid @enderror  " 
                        value="{{old('price')}}"
                        placeholder="Put the price">
                    @error ('price')
                                <p class="text-danger">{{ $errors->first('price') }}</p>
                    @enderror  
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
         
    </form>
</div>
@endsection
