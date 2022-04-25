@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="card card-default">
			<div class="card-header">
				<h3 class="card-title">{{ @$title['slug'] }}</h3>
				<div class="card-tools pull-right">
					<a href="{{ route('store.products') }}" title="Back" class="btn btn-warning btn-icon"><i class="fa fa-arrow-left"></i></a>
				</div>
			</div>
			
			{!! Form::model($product, ['route' => ['store.products.update', $product->id], 'method' => 'PATCH', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
				<div class="card-body">					
					@include('store.product.form')
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-info float-right">Update</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
	</div>
@endsection	