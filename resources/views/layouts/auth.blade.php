<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Admin - {{ @$title['title'] }}</title>
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
		<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
	</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<a href="{{ route('admin') }}"><b>Admin</b></a>
			</div>
			@yield('content')
		</div>
		
		<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
	</body>
</html>
