@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Subscribe to our newsletter</div>

          <div class="card-body">

            <form method="POST" action="{{route('contact.store')}}">
              @csrf
              <div class="form-group row">
                <label for="subject" class="col-md-4 col-form-label text-md-right">Subject</label>

                <div class="col-md-6">
                  <input id="subject" 
                        type="subject" 
                        class="form-control @error('subject') is-invalid @enderror" 
                        name="subject" 
                        value="{{ old('subject') }}"  required autofocus>
                  @error('subject')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>

                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                <div class="col-md-6 mt-2">
                  <input id="email" 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" 
                        value="{{ old('email') }}"  autocomplete="email" autofocus>
                  @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-outline-primary">
                    Contact Us
                  </button>
                </div>
              </div>

                @if (session('message'))
                <div class="text-success">
                    {{session('message') }}
                </div>

                @endif

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
