<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sayal Scheduling') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/helper.js') }}" ></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	@stack('head')

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js"
        integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous">
    </script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js"integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous">
    </script>
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
	
	
    <style>
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #9C27B0;
            color: white;
            text-align: center;
        }

    </style>

	
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand" href="{{ url('/') }}">
                    <!--
                    {{ config('app.name', 'Laravel') }}
                    -->
                    <img src="{{ asset('images/SAYAL_Electronics&Hobbies2013_Logo_long.png') }}" class="css-class" style="height:80px;" alt="Cota Logo">
                </a>



               
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            
                        @else
                           

                            <li class="nav-item dropdown">
                                <a href="{{ route('home')}}" class="nav-link">Home</a>
                            </li>
							
							@can('create_user')
								 <li class="nav-item dropdown">
									<a href="{{ route('user.list')}}" class="nav-link">Manage Users</a>
								</li>
							@endcan
                            
                            @can('view_all_schedules')
								 <li class="nav-item dropdown">
									<a href="{{ route('schedule.view')}}" class="nav-link">View Schedules</a>
								</li>
							@endcan

							@can('create_store_schedule')
								 <li class="nav-item dropdown">
									<a href="{{ route('schedule.index')}}" class="nav-link">Schedules</a>
								</li>
							@endcan

                            @can('aprv_schedule')
								 <li class="nav-item dropdown">
									<a href="{{ route('schedule.approveSubmittedSchedules')}}" class="nav-link">Schedules</a>
								</li>
							@endcan

                                                     
                            <li class="nav-item dropdown">
                                <a  class="nav-link dropdown-toggle"
                                    id="navbarDropdown"
                                         href="#" 
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }}  {{ Auth::user()->lastname }}
                                </a>

                                

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    @can('Permission')
                                        <a class="dropdown-item" href="{{ route('permission.index') }}">User Permissions</a>

                                        
                                    @endcan


                                    @if (Route::has('register')) 
                                        @can('create_user')
                                            <a class="dropdown-item" href="{{ route('register') }}">Create User</a>
                                        @endcan
                                    @endif
									
									

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>


                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @section('sidebar')

        @show

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-6 ml-12">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div  class="row">
                <div class="col-2">
                </div>

                <div id="divAlertMessage" class="col-6"  style="display:none;" >
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="font-weight-bold" id="alertMessage"></span> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                </div>
            </div>
            
            
            @yield('content')
        </main>


       


    </div>

</body>
</html>
@yield('footer-scripts') 
