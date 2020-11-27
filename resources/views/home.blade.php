@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        <div class="row">
							<div class="col-5   col-sm-4   col-md-4 col-lg-4">
								<form action="{{ route('home.post') }}" method="POST">
									
									@csrf
									

									
									
								</form>
							</div>
							
							
							
                        </div>

                            


                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
