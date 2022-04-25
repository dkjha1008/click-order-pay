@extends('layouts.app')

@section('content')
<div class="login-page-wrapper auth-padd">
	<div class="container">
		<div class="blue-page-heading">
			<h2>{{ __('Reset Password') }}</h2>
		</div>
		<div class="Form-Wrapper">			
			{!! Form::open(['route' => 'password.update']) !!}
				<input type="hidden" name="token" value="{{ request()->route('token') }}">
				
				<div class="form-grouph input-design form-field{!! ($errors->has('email') ? ' has-error' : '') !!}">
					{!! Form::email('email', request()->email, ['class' => ($errors->has('email') ? 'is-invalid' : ''), 'required'=>'required' ]) !!}
					{!! Form::label('email','E-Mail Address', ['class' => 'floating-element']) !!}
					{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
				</div>
				
				<div class="form-grouph input-design form-field{!! ($errors->has('password') ? ' has-error' : '') !!}">
					<input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required>
					{!! Form::label('password','Password', ['class' => 'floating-element']) !!}
					{!! $errors->first('password', '<span class="help-block">:message</span>') !!}
				</div>
				
				<div class="form-grouph input-design form-field">
					<input id="password-confirm" type="password" name="password_confirmation" required>
					{!! Form::label('password_confirmation','Confirm Password', ['class' => 'floating-element']) !!}
					<span class="caption-form-info">6–40 characters; at least one uppercase letter and digit</span>
				</div>
				
				<div class="form-grouph submit-design text-center">
					<button class="highball-bg-btn" type="submit">{{ __('Reset Password') }}</button>
				</div>				
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection