@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">{{ __('Weekly Schedule') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
    
                        <div class="row">
                            @foreach($schedules as $schedule)
                                <div class="col-5 m-1">
                                    <div class="row border" >
                                        <div class="col-12"> 
                                            <div class="row">
                                                <div class="col-12">
                                                    <h6>Week Starting  {{$schedule->start_date }} </h6>
                                                </div>
                                            </div>

                                            @if($schedule->sch_data)
                                                @foreach($schedule->sch_data as $data)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-3">{{ $data->date }}</div>
                                                                <div class="col-4">{{ $data->starttime }} - {{ $data->endtime }}</div>
                                                                <div class="col-5">{{ $data->store_name }}</div>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                @endforeach 
                                                <div class="row">
                                                    <div class="col-12">
                                                    Total hours: {{$schedule->weekly_hours }} 
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-danger">No Schedule Available</span>
                                            @endif
                                        </div>
                                    </div>
                                  
                                  
                                </div>
                            @endforeach

							
							
							
                        </div>

                            


                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
