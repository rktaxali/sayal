@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                
                
                

                @if($noAssignedStore)

                    <h6>You have not been assigned any store! </h6>


                @else
                    <div class="card-header">
                    <h6>Schedule for the {{$schedule->store_name }} Store for Week Starting {{$schedule->start_date }} </h6>
                    {{$approvalType}}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                          

                        @foreach($schedule->store_schedule as $daySchedule)
                            <div class="mb-3">
                            
                                @foreach($daySchedule as $employeeSchedule)
                                
                                <div class="row">
                                    <div class="col-4">{{ $employeeSchedule->date}}  &nbsp;&nbsp;    {{ $employeeSchedule->name}}</div>
                                    <div class="col-6">{{ substr($employeeSchedule->starttime,0,5)}} - {{ substr($employeeSchedule->endtime,0,5)}}</div>
                                </div>
                                    

                                @endforeach
                            </div>
                        @endforeach
                        
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
