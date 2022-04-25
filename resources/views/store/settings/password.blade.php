@extends('layouts.admin')
@section('content')
<section class="content">
	<div class="row">
        <div class="col-md-8">
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">{{ $title['title'] }}</h3>
				</div>
				
				<div class="card-body">
					{!! Form::open(['route' => ['store.change.password']]) !!}
					
					<div class="form-group {!! ($errors->has('current-password') ? 'has-error' : '') !!}">
						{!! Form::label('current-password','Current Password', ['class' => 'control-label']) !!}
						<input name="current-password" type="password" class="form-control {!! ($errors->has('current-password') ? ' is-invalid' : '') !!}" id="current-password">
						{!! $errors->first('current-password', '<span class="help-block">:message</span>') !!}
					</div>
					
					<div class="form-group {!! ($errors->has('new-password') ? 'has-error' : '') !!}">
						{!! Form::label('new-password','New Password', ['class' => 'control-label']) !!}
						<input name="new-password" type="password" class="form-control {!! ($errors->has('new-password') ? ' is-invalid' : '') !!}" id="new-password">
						{!! $errors->first('new-password', '<span class="help-block">:message</span>') !!}
					</div>
					
					<div class="form-group {!! ($errors->has('new-password_confirmed') ? 'has-error' : '') !!}">
						{!! Form::label('new-password_confirmed','Confirm Password', ['class' => 'control-label']) !!}
						<input name="new-password_confirmed" type="password" class="form-control {!! ($errors->has('new-password_confirmed') ? ' is-invalid' : '') !!}" id="new-password_confirmed">
						{!! $errors->first('new-password_confirmed', '<span class="help-block">:message</span>') !!}
					</div>
					
					<button class="btn btn-warning">Submit</button>
					
					{!! Form::close() !!}
					
				</div>
			</div>
		</div>
	</div>
</section>
@endsection