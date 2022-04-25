@extends('layouts.app')

@section('content')
<div class="login-page-wrapper auth-padd">
	<div class="container">
		<div class="blue-page-heading">
			<h2>{{ __('Reset Password') }}</h2>
		</div>
		<div class="Form-Wrapper">
		
			@if (session('status'))
				<div class="alert alert-success" role="alert">
					{{ session('status') }}
				</div>
			@endif
			
			{!! Form::open(['route' => 'password.email']) !!}
				<div class="form-grouph input-design form-field{!! ($errors->has('email') ? ' has-error' : '') !!}">
					{!! Form::email('email', null, ['class' => ($errors->has('email') ? 'is-invalid' : ''), 'required'=>'required' ]) !!}
					{!! Form::label('email','E-Mail Address', ['class' => 'floating-element']) !!}
					{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
				</div>
				
				<div class="form-grouph submit-design text-center">
					<button class="highball-bg-btn" type="submit">{{ __('Reset Password') }}</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection