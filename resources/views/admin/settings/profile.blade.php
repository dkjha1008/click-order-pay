@extends('layouts.admin')
@section('content')
<div class="row">	
	
    <div class="col-md-12">
		<div class="card card-default">
			<div class="card-header">
				<h3 class="card-title">Update {{ $title['title'] }}</h3>
			</div>
			
			<div class="card-body">
				
				{!! Form::model($user, ['route' => 'admin.profile.update']) !!}				
				
				<div class="form-group {!! ($errors->has('name') ? 'has-error' : '') !!}">
					{!! Form::label('name','Name', ['class' => 'control-label']) !!}
					{!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '') ]) !!}
					{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
				</div>
				
				<div class="form-group {!! ($errors->has('email') ? 'has-error' : '') !!}">
					{!! Form::label('email','Email', ['class' => 'control-label']) !!}
					{!! Form::email('email', null, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : '') ]) !!}
					{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
				</div>				
				
				<div class="form-group {!! ($errors->has('phone_number') ? 'has-error' : '') !!}">
					{!! Form::label('phone_number','Contact Number', ['class' => 'control-label']) !!}
					{!! Form::number('phone_number', null, ['class' => 'form-control' . ($errors->has('phone_number') ? ' is-invalid' : '') ]) !!}
					{!! $errors->first('phone_number', '<span class="help-block">:message</span>') !!}
				</div>
				
				<button class="btn btn-warning">Update</button>
				<a href="{{ route('admin.change.password') }}" class="btn btn-default float-right">Change Password</a>
				{!! Form::close() !!}
				
			</div>
		</div>
	</div>
</div>
@endsection