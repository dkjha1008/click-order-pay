@extends('layouts.auth')

@section('content')
<div class="card">
	<div class="card-body login-card-body">
		<p class="login-box-msg">Sign in to start your session</p>
		
		{!! Form::open(['route' => 'login']) !!}			
			<div class="input-group mb-3{!! ($errors->has('email') ? ' has-error' : '') !!}">
				{!! Form::email('email', request()->email ?? null, ['placeholder'=>'Email', 'class' => 'form-control'.($errors->has('email') ? ' is-invalid' : ''), 'required'=>'required' ]) !!}
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-envelope"></span>
					</div>
				</div>
				{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
			</div>
			
			<div class="input-group mb-3{!! ($errors->has('password') ? ' has-error' : '') !!}">
				<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required>
				<div class="input-group-append">
					<div class="input-group-text">
						<span class="fas fa-lock"></span>
					</div>
				</div>
				{!! $errors->first('password', '<span class="help-block">:message</span>') !!}
			</div>
			
			<div class="row">
				<button type="submit" class="btn btn-primary btn-block">Sign In</button>
			</div>
		{!! Form::close() !!}
		
		
	</div>
</div>
@endsection