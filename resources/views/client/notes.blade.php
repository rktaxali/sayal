@extends('layouts.app')


@push('head')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 @endpush

@section('content')

<div class="container">
    <h3> Notes Re. {{$client_name}}</h3>
	
		<input id="returnURL" value = "\client\notes\" hidden >


    @if ( count($notes)  )
        <!-- Notes -->
        <div class='row mt-4'>
      
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">Note</th>
                           
                        </tr>
                    </thead>
                    @foreach ($notes as $note)
                        <tr>
                            <td>{!! $note->note !!}
                                <br> 
								@if($note->note_type=='regular_note')
									<a  href="{{  route('client.noteEdit', ['id'=>$note->id, 'source'=>'notes']) }}"
										 class="nav-link">
										<span class="material-icons">edit</span>
									</a>
								@endif
								
								@if($note->note_type=='appointment_note')
									Appointment on {{$note->appointment_datetime}}  for  {{$note->client_name}} re {{ $note->title}} 
									<a  onClick="getEventDetails( {{ $note->event_id }} )"
										 class="nav-link"
										 
										 
										 >
										<span class="material-icons" style="color:blue; cursor:pointer">edit</span>
									</a>
										 
								@endif
								
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
		<!--
        <div class="row ">
            <div class="col-8">
                        $notes->links() 
            </div>
        </div>   
        -->		

		@include('components.event_edit_modal')
		
        <div class="row">
            <div class="col-8">
            
                <a href=" {{ route('client.show',['id'=>$client_id]) }}" >Back to Client</a>
            </div>
        </div>
    

    @else
            <p>There are no notes for the Client</p>
    @endif
    <div class="row">
		<div class="col-8">
			<!-- Through Modeal window components.event_create_modal -->
			 <a href="#" onClick="document.getElementById('btnModelCreateEvent').click()"  >Add a Note</a>
		</div>
    </div>
	
	<div>
	
	</div>
	
	@include('components.event_create_modal')

	
</div>


    @section('footer-scripts')
        @include('scripts.notes')
    @endsection

@endsection
