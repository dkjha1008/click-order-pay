@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card card-default">
			<div class="card-header">
				<h3 class="card-title">{{ @$title['slug'] }}</h3>
				<div class="card-tools pull-right">
					<a href="{{ route('admin.users') }}" title="Back" class="btn btn-warning btn-icon"><i class="fa fa-arrow-left"></i></a>
				</div>
			</div>
			
			{!! Form::model( ['route' => ['admin.user.store'], 'method' => 'post', 'class' => 'form-horizontal']) !!}
				<div class="card-body">					
                <div class="form-group {!! ($errors->has('name') ? 'has-error' : '') !!}">
    {!! Form::label('name','Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('phone_number') ? 'has-error' : '') !!}">
    {!! Form::label('phone_number','Phone Number', ['class' => 'control-label']) !!}
    {!! Form::number('phone_number', null, ['class' => 'form-control' . ($errors->has('phone_number') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('phone_number', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('password') ? 'has-error' : '') !!}">
    {!! Form::label('password','Password', ['class' => 'control-label']) !!}
    {!! Form::text('password', null, ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
</div>


<div class="form-group {!! ($errors->has('address') ? 'has-error' : '') !!}">
    {!! Form::label('address','Address', ['class' => 'control-label']) !!}
    {!! Form::text('address', null, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('address', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('notes') ? 'has-error' : '') !!}">
    {!! Form::label('notes','(Optional) Special Instructions/Directions', ['class' => 'control-label']) !!}
    {!! Form::text('notes', null, ['class' => 'form-control' . ($errors->has('notes') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('notes', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('verified') ? 'has-error' : '') !!}">
    {!! Form::label('verified','ID verified', ['class' => 'control-label']) !!}</br>
    {!! Form::radio('verified', 0) !!} No
    {!! Form::radio('verified', 1) !!} Yes
	</br>
    {!! $errors->first('verified', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('status') ? 'has-error' : '') !!}">
    {!! Form::label('status','Status', ['class' => 'control-label']) !!}</br>
    {!! Form::radio('status', 0) !!} De-active
    {!! Form::radio('status', 1) !!} Active
    {!! Form::radio('status', 2) !!} Block
	</br>
    {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
</div>


<div class="form-group {!! ($errors->has('verified') ? 'has-error' : '') !!}">
    {!! Form::label('type','Type', ['class' => 'control-label']) !!}</br>
    {!! Form::radio('type', 'user') !!} user
    {!! Form::radio('type', 'store') !!} store
	</br>
    {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
</div>


				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-info float-right">Create</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection	