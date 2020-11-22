@extends('layouts.app')

@section('content')

<div class="container">
    <h3> Housing Details for {{$client_name}}</h3>

    @if ( count($housings)  )
        <!-- housings -->
       
                
        @foreach ($housings as $housing)
            <div class="row mt-4">
                @if($housing->allotment_status ==='Current')
                        {{$housing->allotment_status}} - Allotment Date: {{$housing->start_date}}
                @else
                    {{$housing->allotment_status}} - From: {{$housing->start_date}} - {{$housing->end_date}}
                @endif
            </div>  
            <div class="row ml-2">
                {{$housing->address}}, {{$housing->city}}<br>
                {{$housing->province}} - {{$housing->postalcode}}
            </div>
            
        @endforeach
 
        <div class="row mt-4">
            <a href="{{  route('client.show',['id'=> $client_id]) }}">Back to Client</a>
        </div>
    

    @else
            <p>No housing details are available for the Client</p>
            
        <div class="row mt-4">
        <a href="{{  route('client.show',['id'=> $client_id]) }}">Back to Client</a>
        </div>
    @endif
    
</div>
@endsection
