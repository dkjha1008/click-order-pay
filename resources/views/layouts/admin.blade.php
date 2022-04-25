<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>{{ @$title['title'] }} - ClickOrderPay</title>
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
		@yield('style')
	</head>
	<body class="hold-transition sidebar-mini">
		<div class="wrapper">
			
			@include('layouts.admins.navbar')
			@if(auth()->user()->role=='admin')
			  @include('layouts.admins.sidebar')
			@endif
			@if(auth()->user()->role=='store')
			@include('layouts.store.sidebar')
			@endif
			
			<div class="content-wrapper">
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0">{{ @$title['title'] }}</h1>
							</div>
						</div>
					</div>
				</div>
				
				<div class="content">
					<div class="container-fluid">
						@include('layouts.alerts')
						@yield('content')
					</div>
				</div>
			</div>			
			
		</div>
		
		<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
		
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
		<script src="{{ asset('js/delete.js') }}"></script>
		@yield('script')
	</body>
</html>
