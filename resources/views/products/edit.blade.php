@extends('layouts.app')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>
  
  
    <form action="{{ route('products.update',$product->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
         <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" 
                        name="name" 
                        class="form-control      @error('name') is-invalid @enderror "
                        value="{{$product->name}}"
                        placeholder="Name">
                    @error ('name')
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                    @enderror  
                            
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control  @error('description') is-invalid @enderror " 
                    style="height:50px" name="description"
                        placeholder="description">{{$product->description}}</textarea>
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price:</strong>
                    <input type="float" 
                        name="price" 
                        class="form-control  @error('price') is-invalid @enderror  " 
                        value="{{$product->price}}"
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
@endsection
