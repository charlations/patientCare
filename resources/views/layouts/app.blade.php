<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MSPatientCare') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('js/fontawesome/all.js') }}"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> <!--Sweet Alert -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Styles -->
		<link href="{{ asset('css/bootstrap/bootstrap.css') }}" rel="stylesheet"> <!--load all styles -->
		<link href="{{ asset('css/fontawesome/all.css') }}" rel="stylesheet"> <!--load all styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/MSPatientCare.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
									{{ config('app.name', 'MSPatientCare') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
												@auth
												<li class="nav-item">
														<a class="nav-link" href="/patient"> {{ __('patientcare.patients') }} </a>
												</li>
												<li class="nav-item disabled">
														<a class="nav-link" href="#"> {{ __('patientcare.appointments') }} </a>
												</li>
												<li class="nav-item">
														<a class="nav-link" href="#"> {{ __('patientcare.calendar') }} </a>
												</li>
												@if (Auth::user()->hasPermission('user_index') || Auth::user()->hasPermission('user_create') || Auth::user()->hasPermission('user_show') || Auth::user()->hasPermission('user_delete'))
												<li class="nav-item">
														<a class="nav-link" href="/user"> {{ __('patientcare.users') }} </a>
												</li>
												@endif
												@if (Auth::user()->hasPermission('insurance_index') || Auth::user()->hasPermission('insurance_create') || Auth::user()->hasPermission('insurance_show') || Auth::user()->hasPermission('insurance_delete'))
												<li class="nav-item">
														<a class="nav-link" href="/insurance"> {{ __('patientcare.insurances') }} </a>
												</li>
												@endif
												@endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </li>
                        @else
                            <li class="nav-item dropdown">
															<a id="navbarDropdownButton" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																{{ Auth::user()->name }} <span class="caret"></span>
															</a>

															<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownButton">
																<a class="dropdown-item" href="{{ route('logout') }}"
																	onclick="event.preventDefault();
																	document.getElementById('logout-form').submit();">
																	{{ __('Logout') }}
																</a>

																<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
																	@csrf
																</form>
															</div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

		@yield('script')
		<script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
</body>
</html>
