@extends('layouts.app')  <!-- views/layouts/app.blade.php -->

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2>Housing</h2>
        </div>
    </div>

    @if (! empty($success_message))
        <div class="row justify-content-md-center">
            <div class="col-md-10 col-lg-6 ml-12">
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $success_message }}</strong>
                </div>
            </div>
        </div>
    @endif

    <div class = "row ">
        <div class="col-12 ">
            
            @if ( count($housings)  )
                <form id="housings-form"
                    action="{{ route('housing.manage') }}" method="POST">
                                @csrf
                        <table class="table table-bordered table-responsive-lg">
                            <tr>
                                <th>Address</th>
                                <th>Availability Status</th>
                               
                            </tr>

                            @foreach ($housings as $housing)
                                <tr>
                                    <td>
                                        {{ $housing->address }}<br>
                                        {{ $housing->city }}, {{ $housing->province }} - {{ $housing->postalcode }}
                                        @if ($housing->client_name )
                                             <p class="mt-2">{{ $housing->client_name }}
                                                @if ($housing->start_date )
                                                    <br>Allotment Date: {{ $housing->start_date }}    
                                                @endif
                                             </p>
                                        @endif
                                    </td>
                                    
                                    <td>
                                       
                                        @if ($housing->availability_status ==='Available' )
                                            <div class="mt-2">
                                                    <button type="submit" name="allot_housing_id" value ="{{ $housing->id }}"  class="btn btn-sm btn-secondary">
                                                        Allot to Client</button>
                                            </div>
                                        @endif 


                                        @if ($housing->availability_status ==='Allotted' )
                                            <div class="mt-2">
                                                {{ $housing->availability_status  }} 
                                                <div class="mt-2">
                                                    <button type="submit" name="revoke_housing_id" value ="{{ $housing->id }}"  class="btn btn-sm btn-secondary">
                                                        Revoke</button> 
                                                </div>
                                            </div>
                                        @endif 

                                        @if ( !($housing->availability_status ==='Available' || $housing->availability_status ==='Allotted')  )
                                            {{ $housing->availability_status }}
                                        @endif



                                    </td>

                                  
                                    
                                    
                                </tr>
                            @endforeach
                        </table>

                                

                                
                    </form>
            @endif
     
        </div>

    </div>
 
</div>

@endsection


<script>
    function submitForm() {
        // disable Submit button
        event.preventDefault();
        var element = document.getElementById("submitButton");
        element.disabled = true;
        // display spinner and submit form
        var element = document.getElementById("spinner");
        element.style.visibility='visible';
        document.getElementById('housings-form').submit();
    }

</script>

