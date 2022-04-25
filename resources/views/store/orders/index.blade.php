@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="box-body">
			<h4>Search</h4>
			
			{!! Form::open(['route' => 'store.orders', 'method'=>'get']) !!}
			<div class="row">
				<div class="col-md-2 form-group">
					{!! Form::select('user', $users, request()->user ?? null, ['class' => 'form-control search' . ($errors->has('user') ? ' is-invalid' : ''), 'placeholder'=>'Select User' ]) !!}
				</div>
				<div class="col-md-2 form-group">
					{!! Form::select('payment_type', ['authorize'=>'Authorize', 'venmo'=>'Venmo'], request()->payment_type ?? null, ['class' => 'form-control search' . ($errors->has('payment_type') ? ' is-invalid' : ''), 'placeholder'=>'Select Payment Type' ]) !!}
				</div>
				<div class="col-md-2 form-group">
					{!! Form::select('status', $status, request()->status ?? null, ['class' => 'form-control search' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder'=>'Select Delivery Status' ]) !!}
				</div>
				<div class="col-md-2 form-group">
					{!! Form::date('from_date', request()->from_date ?? null, ['class' => 'form-control search' . ($errors->has('from_date') ? ' is-invalid' : '')]) !!}
				</div>
				<div class="col-md-2 form-group">
					{!! Form::date('to_date', request()->to_date ?? null, ['class' => 'form-control search' . ($errors->has('to_date') ? ' is-invalid' : '')]) !!}
				</div>				
				
				<div class="col-md-2 form-group">
					<button class="btn btn-primary" type="submit">Search</button>
					<a href="{{ route('store.orders.csv') }}?user={{@request()->user}}&payment_type={{@request()->payment_type}}&status={{@request()->status}}&from_date={{@request()->from_date}}&to_date={{@request()->to_date}}" class="btn btn-success csv">CSV</a>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		
		<div class="card">
			<div class="card-header">
                <h3 class="card-title">{{ @$title['slug'] }}</h3>
			</div>
			<div class="card-body table-responsive p-0">
                @include('store.orders.table', ['data'=>$orders])
			</div>
		</div>
		
		<div class="pagination">
			@if(@request()->user || request()->status || request()->payment_type || request()->from_date || request()->to_date)
				{{ $orders->appends([
					'user' => request()->user,
					'status' => request()->status,
					'payment_type' => request()->payment_type,
					'from_date' => request()->from_date,
					'to_date' => request()->to_date,
				])->links() }}
			@else
				{{ $orders->links() }}
			@endif
		</div>

	</div>
</div>
@endsection


@section('script')
<script>
	jQuery('input[name=from_date]').on('change', function(){
		var from_date = $(this).val();
		jQuery('input[name=to_date]').attr('min', from_date);  
	});
	jQuery('input[name=to_date]').on('change', function(){
		var to_date = $(this).val();
		jQuery('input[name=from_date]').attr('max', to_date);  
	});
	
	$('form .search').on('change', function(){
		$('.csv').hide();	
	});
</script>
@endsection