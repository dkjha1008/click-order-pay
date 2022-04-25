@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-md-12">
		
			
			{!! Form::model($setting, ['route' => 'admin.settings.store', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
			
				@include('admin.settings.form')
				
				<button type="submit" class="btn btn-warning btn-block">Submit</button>
				
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection	