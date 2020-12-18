@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-12">
          <h2>Employees' Schedule Details for Week Starting {{ $schedule->start_date }}</h2>
      </div>
  </div>

  <div class = "row ">
    <div class="col-12 ">
        
        @if ( count($scheduleDetails)  )
            <form id="schedule-form"
                action="{{ route('schedule.edit') }}" method="POST">
                            @csrf
                <table class="table table-striped table-bordered table-responsive-lg">
                  <thead>
                    <tr>
                      <th scope="col" >Name</th>
                      <th scope="col">Schedule</th>
                      <th scope="col" >Accepted?</th>
                        
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($scheduleDetails as $schedule)
                      <tr scope="row"  style="padding:2px 5px 2px 5px">
                        <td style="padding:2px 5px 2px 5px">
                          {{ $schedule->name}}<br>
						   Hrs: <span title="Min:{{$schedule->min_hours}}, Max:{{$schedule->max_hours}} ">{{ $schedule->weekly_hours}}</span>
                        </td>
                                        
                        <td style="padding:2px 5px 2px 5px">
                          <div class="row">
                            @foreach($schedule->schedule as $data)
                              
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-3">{{ $data->date }}</div>
                                        <div class="col-4">{{ $data->starttime }} - {{ $data->endtime }}</div>
                                        <div class="col-3">{{ $data->store_name }}</div>
                                    </div>
                                </div>
                              
                            @endforeach 
                          </div>

                        </td>
                        <td style="padding:2px 5px 2px 5px">
                          @if( $schedule->schedule_accepted )
                            

                            <span class="material-icons text-success" style="font-size:xx-large;" >
                              check_circle
                            </span>
                          @else
                            <span class="material-icons text-info" style="font-size:xx-large;" >
                                pending_actions
                            </span>

                          @endif	
                        </td>  
                                
                      </tr>
                  @endforeach
                  </tbody>
                        
                </table>
                  
            </form>
        @endif
  
    </div>

  </div>
 
</div>

  @section('footer-scripts')
          @include('scripts.scheduleDetails')
  @endsection


@endsection


<script>
   
	
	

</script>

