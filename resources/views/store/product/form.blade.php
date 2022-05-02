

<div class="form-group {!! ($errors->has('category') ? 'has-error' : '') !!}">
    {!! Form::label('category','Select Category', ['class' => 'control-label']) !!}
    {!! Form::select('category', $category, null, ['class' => 'form-control' . ($errors->has('category') ? ' is-invalid' : ''),'placeholder' => '-- Select Category --' ]) !!}
    {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('title') ? 'has-error' : '') !!}">
    {!! Form::label('title','Title', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('title', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('description') ? 'has-error' : '') !!}">
    {!! Form::label('description','Description', ['class' => 'control-label']) !!}
    {!! Form::text('description', null, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('qty') ? 'has-error' : '') !!}">
    {!! Form::label('qty','Qty', ['class' => 'control-label']) !!}
    {!! Form::number('qty', null, ['class' => 'form-control' . ($errors->has('qty') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('qty', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('sku') ? 'has-error' : '') !!}">
    {!! Form::label('sku','SKU', ['class' => 'control-label']) !!}
    {!! Form::text('sku', null, ['class' => 'form-control' . ($errors->has('sku') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('sku', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('price') ? 'has-error' : '') !!}">
    {!! Form::label('price','Price', ['class' => 'control-label']) !!}
    {!! Form::text('price', null, ['class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('price', '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group {!! ($errors->has('tag') ? 'has-error' : '') !!}">
    {!! Form::label('nutrition_info','Nutritional Information', ['class' => 'control-label']) !!}
    {!! Form::textarea('nutrition_info', null, ['class' => 'form-control' . ($errors->has('nutrition_info') ? ' is-invalid' : '')]) !!}
    {!! $errors->first('nutrition_info', '<span class="help-block">:message</span>') !!}
</div>
<div class="form-group {!! ($errors->has('image') ? 'has-error' : '') !!}">
    {!! Form::label('image','Image', ['class' => 'control-label']) !!}</br>
    {!! Form::file('image', null, ['class' => '' . ($errors->has('name') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('image', '</br><span class="help-block">:message</span>') !!}
	@if(@$product && $product->image)
		</br>
		<img width="200" src="{{ asset('storage/products/'.$product->image) }}">
	@endif
</div>
@php
$relatedProduct = [];
if(@$product){
    $ids = explode(',',$product->related_products);
	
}
@endphp

<div class="form-group {!! ($errors->has('related_products') ? 'has-error' : '') !!}">
    {!! Form::label('related_products','Select Related Products', ['class' => 'control-label']) !!}
    {!! Form::select('related_products[]', $relatedProducts, $ids ?? null, ['multiple'=>'multiple', 'class' => 'form-control js-example-basic-multiple-limit js-states' . ($errors->has('related_products') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('related_products', '<span class="help-block">:message</span>') !!}
</div> 


<div class="form-group {!! ($errors->has('product_type') ? 'has-error' : '') !!}">
    {!! Form::label('product_type','Select Product Type', ['class' => 'control-label']) !!}
    {!! Form::select('product_type', ['Simple'=>'Simple','Variable'=>'Variable'], $type ?? null, ['id'=>'product_type' ,'class' => 'form-control js-states' . ($errors->has('product_type') ? ' is-invalid' : '') ]) !!}
    {!! $errors->first('product_type', '<span class="help-block">:message</span>') !!}
</div>
<div class="attribute_fun" style="">
@if(@$product)
 @if(@$product->product_type==='Variable')
   @php 
    $proAttrs = \App\Models\ProductAttribute::where('products_id',$product->id)->get();
   @endphp

  @foreach($proAttrs as $proAttr)
  <div class="child">
  <div class="attribute-scope ">

<div class="form-group {!! ($errors->has('attribute') ? 'has-error' : '') !!}">
    {!! Form::label('attribute','Select Product Attributes', ['class' => 'control-label']) !!}
    {!! Form::select('attribute[]', $attributes, $proAttr->attributes_id ?? null, [ 'class' => 'form-control js-states attribute-val' . ($errors->has('attribute') ? ' is-invalid' : '')]) !!}
    {!! $errors->first('attribute', '<span class="help-block">:message</span>') !!}
</div>
<input type="hidden" name="attr_id[]" value="{{$proAttr->id}}">
@php 
$attrs = \App\Models\Attribute::where('id',$proAttr->attributes_id)->first();

$arr = @explode(',',$attrs->value);
$attrValues  = array_combine($arr,$arr);

@endphp


    <div class="form-group {!! ($errors->has('store') ? 'has-error' : '') !!}">
        {!! Form::label('attribute_values','Select Attribute Value', ['class' => 'control-label']) !!}
        {!! Form::select('attribute_values[]',$attrValues, $proAttr->value ?? null, ['required'=>'required', 'class' => 'form-control js-states attr-val' . ($errors->has('attribute_values') ? ' is-invalid' : '') ]) !!}
        {!! $errors->first('attribute_values', '<span class="help-block">:message</span>') !!}
    </div>
 </div>  
    
        <div class="form-group {!! ($errors->has('price') ? 'has-error' : '') !!}">
            {!! Form::label('attribute_price','Attribute Price', ['class' => 'control-label']) !!}
            {!! Form::number('attribute_price[]',$proAttr->price ?? null , ['class' => 'form-control' . ($errors->has('attribute_price') ? ' is-invalid' : '') ]) !!}
            {!! $errors->first('attribute_price', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="col-md-1">
                    <i class="deleteId revertId fa fa-trash" title="Delete"></i>
                    <i class="revertId fa fa-times" title="Revert" style="display:none"></i>
    </div>
</div>
  @endforeach

  <div class="rand"></div>
    <button type="button" class="btn btn-success" id="add">Add More </button>
 @endif
</div>
@else
<div class="attribute_fun" style="display:none">

   <div class="attribute-scope">

    <div class="form-group {!! ($errors->has('attribute') ? 'has-error' : '') !!}">
        {!! Form::label('attribute','Select Product Attributes', ['class' => 'control-label']) !!}
        {!! Form::select('attribute[]', $attributes, $type ?? null, [ 'class' => 'form-control js-states attribute-val' . ($errors->has('attribute') ? ' is-invalid' : '') ]) !!}
        {!! $errors->first('attribute', '<span class="help-block">:message</span>') !!}
    </div>


    @php 
    $sizes = ['S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','XXL'=>'XXL'];
    $size = explode(',',@$product->sizes);
    @endphp
   
        <div class="form-group {!! ($errors->has('store') ? 'has-error' : '') !!}">
            {!! Form::label('attribute_values','Select Attribute Value', ['class' => 'control-label']) !!}
            {!! Form::select('attribute_values[]', $sizes, $size ?? null, ['required'=>'required', 'class' => 'form-control js-states attr-val' . ($errors->has('attribute_values') ? ' is-invalid' : '') ]) !!}
            {!! $errors->first('attribute_values', '<span class="help-block">:message</span>') !!}
        </div>
     </div>  
            <div class="form-group {!! ($errors->has('price') ? 'has-error' : '') !!}">
                {!! Form::label('attribute_price','Attribute Price', ['class' => 'control-label']) !!}
                {!! Form::number('attribute_price[]', null, ['class' => 'form-control' . ($errors->has('attribute_price') ? ' is-invalid' : '') ]) !!}
                {!! $errors->first('attribute_price', '<span class="help-block">:message</span>') !!}
            </div>
      
   
    <div class="rand"></div>
    <button type="button" class="btn btn-success" id="add">Add More </button>
</div> 
</div> 
@endif

<div class="form-group {!! ($errors->has('tag') ? 'has-error' : '') !!}">
    {!! Form::label('tag','Tag', ['class' => 'control-label']) !!}
    {!! Form::text('tag', null, ['class' => 'form-control' . ($errors->has('tag') ? ' is-invalid' : '')]) !!}
    {!! $errors->first('tag', '<span class="help-block">:message</span>') !!}
</div>

<div class="form-group {!! ($errors->has('status') ? 'has-error' : '') !!}">
    {!! Form::label('status','Status', ['class' => 'control-label']) !!}</br>
    {!! Form::radio('status', 0) !!} De-active
    {!! Form::radio('status', 1) !!} Active
	</br>
    {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
</div>


@section('script')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
<script>

$( document ).ready(function() {

    $(".js-example-basic-multiple-limit").select2({
        tokenSeparators: [',', ' ']
    });
    $(".product-type").select2({
        tokenSeparators: [',', ' ']
    });
    
 
		var editor =  CKEDITOR.replace( 'nutrition_info' );
	});

    $('#product_type').on('change',function(){
        //debugger;
        const productType = $(this).val();
        productType=='Variable' ? $('.attribute_fun').show() : $('.attribute_fun').hide()
    })

	$(function () {
		
		$("input[name=price]").keydown(function (event) {

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



	
		$('#add').on('click', function() {
            debugger;
			var our_html =  `<div class="child">
					<div class="row">
						<div class="col-md-11">
                    <div class="attribute-scope">
                        <div class="form-group {!! ($errors->has('attribute') ? 'has-error' : '') !!}">
                            {!! Form::label('attribute','Select Product Attributes', ['class' => 'control-label']) !!}
                            {!! Form::select('attribute[]',$attributes, $type ?? null, [ 'class' => 'form-control js-states attribute-val' . ($errors->has('attribute') ? ' is-invalid' : '') ]) !!}
                            {!! $errors->first('attribute', '<span class="help-block">:message</span>') !!}
                        </div>


                            <div class="form-group {!! ($errors->has('store') ? 'has-error' : '') !!}">
                                {!! Form::label('attribute_values','Select Attribute Value', ['class' => 'control-label']) !!}
                                {!! Form::select('attribute_values[]', [],  null, ['required'=>'required', 'class' => 'form-control js-states attr-val' . ($errors->has('attribute_values') ? ' is-invalid' : '') ]) !!}
                                {!! $errors->first('attribute_values', '<span class="help-block">:message</span>') !!}
                            </div>
                     </div>
                        <div class="form-group {!! ($errors->has('price') ? 'has-error' : '') !!}">
                            {!! Form::label('attribute_price','Attribute Price', ['class' => 'control-label']) !!}
                            {!! Form::number('attribute_price[]', null, ['class' => 'form-control' . ($errors->has('attribute_price') ? ' is-invalid' : '') ]) !!}
                            {!! $errors->first('attribute_price', '<span class="help-block">:message</span>') !!}
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
            //debugger;
			$(this).parents('.child').remove();
			$(this).parents('.child').find('.delId').val('yes');
		});
		
		$(document).on('click', '.revertId', function(event) {
			event.preventDefault();
			$(this).parents('.child').remove();
			$(this).parents('.child').find('.delId').val('no');
		});

        $(document).on('click','.attribute-val',function (){
            //debugger;
            let scope = $(this);
            let attrId = parseInt(scope.val());
         
            $.ajax({
                url: "/store/attribute/"+attrId,
                type: "get",
                headers: {
             
               
                },
                success: function(data) {
                   // debugger;
                        console.log(data)
                    if(data.data.length>0){
                        let html = '';
                        for(let i = 0; i < data.data.length; i++){

                           html += `<option value="${data.data[i]}">
                                        ${data.data[i]}
                                   </option>`;
                        }
                       
                        scope.parents('.attribute-scope').find('.attr-val').html(html);
                      
                    }
                    //debugger;
                },
                error:function(err){
//debugger;
                }
            
               
            });
            });
        })

</script>
@endsection