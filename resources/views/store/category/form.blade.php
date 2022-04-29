<div class="form-group {!! ($errors->has('name') ? 'has-error' : '') !!}">
    {!! Form::label('name','Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('image') ? 'has-error' : '') !!}">
    {!! Form::label('image','Image', ['class' => 'control-label']) !!}</br>
    {!! Form::file('image', null, ['class' => '' . ($errors->has('name') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('image', '</br><span class="help-block">:message</span>') !!}
	@if(@$category && $category->image)
		</br>
		<img width="200" src="{{ asset('storage/category/'.$category->image) }}">
	@endif
</div>

<div class="form-group {!! ($errors->has('status') ? 'has-error' : '') !!}">
    {!! Form::label('status','Status', ['class' => 'control-label']) !!}</br>
    {!! Form::radio('status', 0) !!} De-active
    {!! Form::radio('status', 1) !!} Active
	</br>
    {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
</div>