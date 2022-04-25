<div class="form-group {!! ($errors->has('promocode') ? 'has-error' : '') !!}">
    {!! Form::label('promocode','Promocode', ['class' => 'control-label']) !!}
    {!! Form::text('promocode', null, ['class' => 'form-control' . ($errors->has('promocode') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('promocode', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group{!! ($errors->has('users') ? ' has-error' : '') !!}">
    {!! Form::label('users', 'Select User') !!}
	{!! Form::select('users[]', $users, @$code ? json_decode($code->users) : null, ['class' => 'selectpicker'.($errors->has('users') ? ' is-invalid' : ''), "multiple" => "multiple", "data-live-search"=>"true" ]) !!}
	{!! $errors->first('users', '<span class="help-block">:message</span>') !!}
</div>

{{--
<div class="form-group{!! ($errors->has('products') ? ' has-error' : '') !!}">
    {!! Form::label('products', 'Select Product') !!}
	{!! Form::select('products[]', $products, @$code ? json_decode($code->products) : null, ['class' => 'selectpicker'.($errors->has('products') ? ' is-invalid' : ''), "multiple" => "multiple", "data-live-search"=>"true" ]) !!}
	{!! $errors->first('products', '<span class="help-block">:message</span>') !!}
</div>
--}}

<div class="form-group {!! ($errors->has('start_date') ? 'has-error' : '') !!}">
    {!! Form::label('start_date','Start Date', ['class' => 'control-label']) !!}
    {!! Form::date('start_date', null, ['class' => 'form-control' . ($errors->has('start_date') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('expire_date') ? 'has-error' : '') !!}">
    {!! Form::label('expire_date','Expire Date', ['class' => 'control-label']) !!}
    {!! Form::date('expire_date', null, ['class' => 'form-control' . ($errors->has('expire_date') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('expire_date', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('coupon_type') ? 'has-error' : '') !!}">
    {!! Form::label('coupon_type','Coupon Type', ['class' => 'control-label']) !!}
    {!! Form::select('coupon_type', ['percentage'=>'Percentage', 'fixed'=>'Fixed Price'], null, ['class' => 'form-control' . ($errors->has('coupon_type') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('coupon_type', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('discount') ? 'has-error' : '') !!}">
    {!! Form::label('discount','Discount', ['class' => 'control-label']) !!}
    {!! Form::text('discount', null, ['class' => 'form-control' . ($errors->has('discount') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('discount', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('uses_limit') ? 'has-error' : '') !!}">
    {!! Form::label('uses_limit','Number of allowed users for that promocode per users', ['class' => 'control-label']) !!}
    {!! Form::text('uses_limit', null, ['class' => 'form-control' . ($errors->has('uses_limit') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('uses_limit', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('new_users') ? 'has-error' : '') !!}">
	<input name="new_users" type="checkbox" value="yes" {{ @($code->new_users=='yes') ? 'checked' : '' }}>
	{!! Form::label('new_users','For new Users', ['class' => 'control-label']) !!}
	</br>
    {!! $errors->first('new_users', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('status') ? 'has-error' : '') !!}">
    {!! Form::label('status','Status', ['class' => 'control-label']) !!}</br>
    {!! Form::radio('status', 0) !!} De-active
    {!! Form::radio('status', 1) !!} Active
	</br>
    {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
</div>

@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css	">
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<script>
	jQuery('input[name=start_date]').on('change', function(){
		var start_date = $(this).val();
		jQuery('input[name=expire_date]').attr('min', start_date);  
	});
	jQuery('input[name=expire_date]').on('change', function(){
		var expire_date = $(this).val();
		jQuery('input[name=start_date]').attr('max', expire_date);  
	});	
	
	$(function () {
		$('.selectpicker').selectpicker();
		
		$("input[name=discount], input[name=user_limit]").keydown(function (event) {

			if (event.shiftKey == true) {
				event.preventDefault();
			}

			if ((event.keyCode >= 48 && event.keyCode <= 57) || 
				(event.keyCode >= 96 && event.keyCode <= 105) || 
				event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 ||
				event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {

			} else {
				event.preventDefault();
			}

			if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
				event.preventDefault(); 
			//if a decimal has been added, disable the "."-button

		});
	});
</script>
@endsection