@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">All Stores' Schedule for </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        
                        @foreach($stores as $store)
                            
                            <div class="row" >
                                <div class="col-12">
                                    <h6> {{$store->name }} </h6>
                                </div>
                            </div>

                            @foreach($store->schedule as $daySchedule)
                                <div class="mb-3">
                                
                                 @foreach($daySchedule as $employeeSchedule)
                                 
                                    <div class="row">
                                        <div class="col-4">{{ $employeeSchedule->date}}  &nbsp;&nbsp;    {{ $employeeSchedule->name}}</div>
                                        <div class="col-6">{{ substr($employeeSchedule->starttime,0,5)}} - {{ substr($employeeSchedule->endtime,0,5)}}</div>
                                    </div>
                                
                                    

                                @endforeach
                                </div>
                            @endforeach

                                    
                               

                                
                                
                        @endforeach

							
							
							
                        </div>

                            


                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
