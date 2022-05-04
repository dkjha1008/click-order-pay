

<div class="form-group {!! ($errors->has('name') ? 'has-error' : '') !!}">
    {!! Form::label('attribute','Attribute', ['class' => 'control-label']) !!}
    {!! Form::text('attribute', null, ['class' => 'form-control' . ($errors->has('attribute') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('attribute', '<span class="help-block">:message</span>') !!}
</div>
@if(@$attribute)

@php 

$values = explode(',',$attribute->value);

@endphp


@foreach($values as $i => $value)
<div class="child">
    <div class="form-group {!! ($errors->has('value') ? 'has-error' : '') !!}">
        {!! Form::label('value','Value', ['class' => 'control-label']) !!}</br>
        {!! Form::text('value[]', $value, ['class' => 'form-control' . ($errors->has('value') ? ' is-invalid' : '') ]) !!}
        {!! $errors->first('value', '</br><span class="help-block">:message</span>') !!}
    </div>
    <div class="col-md-1">
                    <i class="deleteId revertId fa fa-trash" title="Delete"></i>
                    <i class="revertId fa fa-times" title="Revert" style="display:none"></i>
    </div>
</div>
@endforeach
@else
<div class="form-group {!! ($errors->has('value') ? 'has-error' : '') !!}">
    {!! Form::label('value','Value', ['class' => 'control-label']) !!}</br>
    {!! Form::text('value[]', null, ['class' => 'form-control' . ($errors->has('value') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('value', '</br><span class="help-block">:message</span>') !!}
	
</div>
@endif

<div class="rand"></div>

<!-- <div class="form-group {!! ($errors->has('status') ? 'has-error' : '') !!}">
    {!! Form::label('status','Status', ['class' => 'control-label']) !!}</br>
    {!! Form::radio('status', 0) !!} De-active
    {!! Form::radio('status', 1) !!} Active
	</br>
    {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
</div> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('#add').on('click', function() {
            
			var our_html =  `<div class="child">
					<div class="row">
						<div class="col-md-11">
						<div class="form-group {!! ($errors->has('value') ? 'has-error' : '') !!}">
                            {!! Form::label('value','Value', ['class' => 'control-label']) !!}</br>
                            {!! Form::text('value[]', '', ['class' => 'form-control' . ($errors->has('value') ? ' is-invalid' : '') ]) !!}
                            {!! $errors->first('value', '</br><span class="help-block">:message</span>') !!}
                            
                        </div>

						</div>
						<div class="col-md-1">
							<i class="delete fa fa-trash" title="Delete"></i>
						</div>
					</div>

					
				</div>`;
			$('.rand').append(our_html);
		});
		
		$(document).on('click', '.delete', function(event) {
			event.preventDefault();
			$(this).parents('.child').remove();
		});
		
		$(document).on('click', '.deleteId', function(event) {
			event.preventDefault();
			$(this).parents('.child').addClass('remove');
			$(this).parents('.child').find('.delId').val('yes');
		});
		
		$(document).on('click', '.revertId', function(event) {
			event.preventDefault();
			$(this).parents('.child').remove();
			$(this).parents('.child').find('.delId').val('no');
		});
	});
</script>