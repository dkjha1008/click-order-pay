<div class="card card-default">
	<div class="card-header">
		<h3 class="card-title">Store Hours</h3>
	</div>
	<div class="card-body">
		<div class="row">
			
			<div class="form-group {!! ($errors->has('store_online') ? 'has-error' : '') !!}">
				{!! Form::label('store_online','Is Store', ['class' => 'control-label']) !!}</br>
				{!! Form::radio('store_online', 1) !!} online
				{!! Form::radio('store_online', 0) !!} offline
				</br>
				{!! $errors->first('store_online', '<span class="help-block">:message</span>') !!}
			</div>
			
			<div class="col-12">
			
				<div class="form-group {!! ($errors->has('store') ? 'has-error' : '') !!}">
					{!! Form::label('store_modal','Store Offline Modal', ['class' => 'control-label']) !!}</br>
					{!! Form::radio('store_modal', 1) !!} Show
					{!! Form::radio('store_modal', 0) !!} Hide
					</br>
					{!! $errors->first('store_modal', '<span class="help-block">:message</span>') !!}
				</div>

				<div class="form-group {!! ($errors->has('store_offline_message') ? 'has-error' : '') !!}">
					{!! Form::label('store_offline_message','Store offline message', ['class' => 'control-label']) !!}
					{!! Form::textarea('store_offline_message', null, ['class' => 'form-control' . ($errors->has('store_offline_message') ? ' is-invalid' : ''), 'rows'=>3 ]) !!}
					{!! $errors->first('store_offline_message', '<span class="help-block">:message</span>') !!}
				</div>
			</div>
			
			<div class="col-12">
				<h4>Sunday - Wednesday:</h4>
				<div class="row">
					<div class="col-6">
						<div class="form-group {!! ($errors->has('start_time') ? 'has-error' : '') !!}">
							{!! Form::label('start_time','Start Time', ['class' => 'control-label']) !!}
							{!! Form::time('start_time', null, ['class' => 'form-control' . ($errors->has('start_time') ? ' is-invalid' : '') ]) !!}
							{!! $errors->first('start_time', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<div class="col-6">
						<div class="form-group {!! ($errors->has('close_time') ? 'has-error' : '') !!}">
							{!! Form::label('close_time','Close Time', ['class' => 'control-label']) !!}
							{!! Form::time('close_time', null, ['class' => 'form-control' . ($errors->has('close_time') ? ' is-invalid' : '') ]) !!}
							{!! $errors->first('close_time', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-12">
				<h4>Thursday - Saturday:</h4>
				<div class="row">
					<div class="col-6">
						<div class="form-group {!! ($errors->has('start_time_second') ? 'has-error' : '') !!}">
							{!! Form::label('start_time_second','Start Time', ['class' => 'control-label']) !!}
							{!! Form::time('start_time_second', null, ['class' => 'form-control' . ($errors->has('start_time_second') ? ' is-invalid' : '') ]) !!}
							{!! $errors->first('start_time_second', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<div class="col-6">
						<div class="form-group {!! ($errors->has('close_time_second') ? 'has-error' : '') !!}">
							{!! Form::label('close_time_second','Close Time', ['class' => 'control-label']) !!}
							{!! Form::time('close_time_second', null, ['class' => 'form-control' . ($errors->has('close_time_second') ? ' is-invalid' : '') ]) !!}
							{!! $errors->first('close_time_second', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
				</div>
			</div>
				
			
		</div>
	</div>
</div>



<div class="card card-default">
	<div class="card-header">
		<h3 class="card-title">Social Links</h3>
	</div>
	<div class="card-body">	
		<div class="form-group {!! ($errors->has('linkedin') ? 'has-error' : '') !!}">
			{!! Form::label('linkedin','Linked In', ['class' => 'control-label']) !!}
			{!! Form::text('linkedin', null, ['class' => 'form-control' . ($errors->has('linkedin') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('linkedin', '<span class="help-block">:message</span>') !!}
		</div>
		
		<div class="form-group {!! ($errors->has('instagram') ? 'has-error' : '') !!}">
			{!! Form::label('instagram','Instagram', ['class' => 'control-label']) !!}
			{!! Form::text('instagram', null, ['class' => 'form-control' . ($errors->has('instagram') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('instagram', '<span class="help-block">:message</span>') !!}
		</div>
		
		<div class="form-group {!! ($errors->has('tiktok') ? 'has-error' : '') !!}">
			{!! Form::label('tiktok','Tiktok', ['class' => 'control-label']) !!}
			{!! Form::text('tiktok', null, ['class' => 'form-control' . ($errors->has('tiktok') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('tiktok', '<span class="help-block">:message</span>') !!}
		</div>
	</div>
</div>


<div class="card card-default">
	<div class="card-header">
		<h3 class="card-title">Store Charges</h3>
	</div>
	<div class="card-body">	
		<div class="form-group {!! ($errors->has('store_tax') ? 'has-error' : '') !!}">
			{!! Form::label('store_tax','Store Tax', ['class' => 'control-label']) !!}
			<div class="input-group">
				{!! Form::text('store_tax', null, ['class' => 'form-control' . ($errors->has('store_tax') ? ' is-invalid' : '') ]) !!}				
				<div class="input-group-prepend">
					<span class="input-group-text">%</span>
				</div>
			</div>
			{!! $errors->first('store_tax', '<span class="help-block">:message</span>') !!}
		</div>
		
		<div class="form-group {!! ($errors->has('delivery_charges') ? 'has-error' : '') !!}">
			{!! Form::label('delivery_charges','Delivery Charges', ['class' => 'control-label']) !!}
			<div class="input-group">
                <div class="input-group-prepend">
					<span class="input-group-text">$</span>
				</div>
				{!! Form::text('delivery_charges', null, ['class' => 'form-control' . ($errors->has('delivery_charges') ? ' is-invalid' : '') ]) !!}
			</div>
			{!! $errors->first('delivery_charges', '<span class="help-block">:message</span>') !!}
		</div>
	</div>
</div>

<div class="card card-default">
	<div class="card-header">
		<h3 class="card-title">Home Page</h3>
	</div>
	<div class="card-body">	
		<div class="form-group {!! ($errors->has('delivery_time') ? 'has-error' : '') !!}">
			{!! Form::label('delivery_time','Delivery Time', ['class' => 'control-label']) !!}
			{!! Form::text('delivery_time', null, ['class' => 'form-control' . ($errors->has('delivery_time') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('delivery_time', '<span class="help-block">:message</span>') !!}
		</div>
		
		<div class="form-group {!! ($errors->has('students_served') ? 'has-error' : '') !!}">
			{!! Form::label('students_served','Students Served', ['class' => 'control-label']) !!}
			{!! Form::text('students_served', null, ['class' => 'form-control' . ($errors->has('students_served') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('students_served', '<span class="help-block">:message</span>') !!}
		</div>
	</div>
</div>


@if(@$promocode)
<div class="card card-default">
	<div class="card-header">
		<h3 class="card-title">Promocode Modal</h3>
	</div>
	<div class="card-body">
		<div class="form-group {!! ($errors->has('promocode_show') ? 'has-error' : '') !!}">
			{!! Form::label('promocode_show','Promocode Modal', ['class' => 'control-label']) !!}</br>
			{!! Form::radio('promocode_show', 1) !!} Show
			{!! Form::radio('promocode_show', 0) !!} Hide
			</br>
			{!! $errors->first('promocode_show', '<span class="help-block">:message</span>') !!}
		</div>
		
		<div class="form-group {!! ($errors->has('promocode_text') ? 'has-error' : '') !!}">
			{!! Form::label('promocode_text','Promocode text', ['class' => 'control-label']) !!}
			{!! Form::text('promocode_text', null, ['class' => 'form-control' . ($errors->has('promocode_text') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('promocode_text', '<span class="help-block">:message</span>') !!}
		</div>
		
		<div class="form-group {!! ($errors->has('promocode') ? 'has-error' : '') !!}">
			{!! Form::label('promocode','Promocode', ['class' => 'control-label']) !!}
			{!! Form::select('promocode', $promocode, null, ['class' => 'form-control' . ($errors->has('promocode') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('promocode', '<span class="help-block">:message</span>') !!}
		</div>
		
		<div class="form-group {!! ($errors->has('promocode_message') ? 'has-error' : '') !!}">
			{!! Form::label('promocode_message','Promocode message', ['class' => 'control-label']) !!}
			{!! Form::textarea('promocode_message', null, ['class' => 'form-control' . ($errors->has('promocode_message') ? ' is-invalid' : ''), 'rows'=>3 ]) !!}
			{!! $errors->first('promocode_message', '<span class="help-block">:message</span>') !!}
		</div>
	</div>
</div>
@endif


<div class="card card-default">
	<div class="card-header">
		<h3 class="card-title">Settings</h3>
	</div>
	<div class="card-body">	
		<div class="form-group {!! ($errors->has('low_quantity') ? 'has-error' : '') !!}">
			{!! Form::label('low_quantity','Low Quantity', ['class' => 'control-label']) !!}
			{!! Form::number('low_quantity', null, ['class' => 'form-control' . ($errors->has('low_quantity') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('low_quantity', '<span class="help-block">:message</span>') !!}
		</div>

		<div class="form-group {!! ($errors->has('order_limit') ? 'has-error' : '') !!}">
			{!! Form::label('order_limit','Order Limit', ['class' => 'control-label']) !!}
			{!! Form::number('order_limit', null, ['class' => 'form-control' . ($errors->has('order_limit') ? ' is-invalid' : '') ]) !!}
			{!! $errors->first('order_limit', '<span class="help-block">:message</span>') !!}
		</div>
		
		
	</div>
</div>



@section('script')
<script>
	$('.checkbox').on('click', function(){
		if ( $(this).get(0).checked) {
			$(this).parents('.days').find('.col-4').hide();
		}
		else {
			$(this).parents('.days').find('.col-4').show();
		}
	});
	
	$(function () {
		
		$("input[name=store_tax], input[name=delivery_charges]").keydown(function (event) {

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


