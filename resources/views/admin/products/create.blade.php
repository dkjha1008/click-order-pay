@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="card card-default">
			<div class="card-header">
				<h3 class="card-title">{{ @$title['slug'] }}</h3>
				<div class="card-tools pull-right">
					<a href="{{ route('admin.products') }}" title="Add" class="btn btn-warning btn-icon"><i class="fa fa-arrow-left"></i></a>
				</div>
			</div>
			@if($errors->any())
				<div class="alert alert-danger">
					<!-- <p><strong>Opps Something went wrong</strong></p> -->
					<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
					</ul>
				</div>
            @endif

			{!! Form::open(['route' => 'admin.products.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
				<div class="card-body">					
					@include('admin.products.form')
				</div>

				

				<div class="card-footer">
					<button type="submit" class="btn btn-info float-right">Submit</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection	