@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit User') }}  {{$user->firstname}}  {{$user->lastname}} </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.update') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="firstname" class="col-md-2 col-form-label text-md-right">First Name</label>

                            <div class="col-md-4">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" 
                                        name="firstname" value="{{$user->firstname}}"
                                        required autocomplete="firstname" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
							
							<label for="lastname" class="col-md-2 col-form-label text-md-right">Last Name</label>

                            <div class="col-md-4">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" 
                                    name="lastname" 
									value="{{$user->lastname}}"
                                    required autocomplete="lastname" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

   
      

      

                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-4">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" 
										value="{{ $user->email }}" 
										required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
							
							@if ($stores)
								<label for="store_id" class="col-md-2 col-form-label text-md-right">Default Store</label>
								<div class="col-md-4">
									
										<select name="store_id" id="store_id" class="form-control" >
										@foreach($stores as $store )
											<option value="{{ $store->id }}">
												{{ $store->text}}
											</option>
											@endforeach
										</select>
										
								</div>
							@endif
                        </div>
						
	                  <div class="form-group row">
                            <label for="min_hours" class="col-md-2 col-form-label text-md-right">Min Hours</label>

                            <div class="col-md-4">
                                <input id="min_hours" type="text" class="form-control @error('min_hours') is-invalid @enderror" 
                                        name="min_hours" value="{{$user->min_hours}}"
										pattern="[0-9]{2}[.][0-9]{1,}" title="99.99"
                                         autocomplete="min_hours" autofocus>

                                @error('min_hours')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
							
							<label for="max_hours" class="col-md-2 col-form-label text-md-right">Max Hours</label>

                            <div class="col-md-4">
                                <input id="max_hours" type="text" class="form-control @error('max_hours') is-invalid @enderror" 
                                    name="max_hours" 
									pattern="[0-9]{2}[.][0-9]{1,}" title="99.99"
									value="{{$user->max_hours}}"
                                     autocomplete="max_hours" autofocus>

                                @error('max_hours')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>					
						

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-4 offset-md-4">
							
								<a href="{{ route('user.list') }}"   class="btn btn-secondary" role="button"   >Cancel</a>
							  
								<span style="padding-left:12px;"></span>
                                <button type="submit" 
									class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
							
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
