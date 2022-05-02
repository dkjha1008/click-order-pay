@extends('layouts.admin')
@section('content')

@if(@$products>0)
<div class="alert alert-danger">
	<a href="{{ route('store.products') }}?quantity={{@$settings->low_quantity}}"><strong>Alert</strong> You have {{ $products }} product{{ $products>1 ? 's' : '' }} with low quantity</a>
</div>
@endif

<div class="row">
	
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-sort-amount-up"></i></span>
			
			<a href="{{ route('store.orders') }}?status=1" class="info-box-content">
                <span class="info-box-text">Pending Orders</span>
                <span class="info-box-number">
					{{ $newOrder }}
				</span>
			</a>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>
			
			<a href="{{ route('store.orders') }}" class="info-box-content">
                <span class="info-box-text">Total Orders</span>
                <span class="info-box-number">
					{{ $totalOrders }}
				</span>
			</a>
		</div>
	</div>	
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
			
			<a href="#" class="info-box-content">
                <span class="info-box-text">Total Sales</span>
                <span class="info-box-number">${{ number_format($sales, 2) }}</span>
			</a>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
			
			<a href="#" class="info-box-content">
                <span class="info-box-text">Total Admin Sales</span>
                <span class="info-box-number">${{ number_format($sales/100, 2) }}</span>
			</a>
		</div>
	</div>
</div>
	
<div class="row">	
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-sort-amount-up"></i></span>
			
			<a href="{{ route('store.orders') }}" class="info-box-content">
                <span class="info-box-text">Daily Orders</span>
                <span class="info-box-number">
					{{ $dailyOrder }}
				</span>
			</a>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-ban"></i></span>
			
			<a href="{{ route('store.orders') }}?status=3" class="info-box-content">
                <span class="info-box-text">Daily Canceled Requests</span>
                <span class="info-box-number">
					{{ $dailyCancleOrder }}
				</span>
			</a>
		</div>
	</div>	
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
			
			<a href="{{ route('store.dailysales') }}" class="info-box-content">
                <span class="info-box-text">Daily Sales</span>
                <span class="info-box-number">${{ number_format($dailySales, 2) }}</span>
			</a>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<div class="info-box mb-3">
			<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
			<a href="{{url('/shop?store='.Auth()->user()->store->slug)}}" target="_blank" class="info-box-content">
                <span class="info-box-text">View Store</span>
                <span class="info-box-number"></span>
			</a>
		</div>
	</div>
</div>

<div class="row">

	<div class="col-md-12">
		<div class="box box-danger">
			<div class="box-header">
				<h3 class="box-title"><a href="javascript:void(0)">Monthly Sales</a></h3>
			</div>
			
			{!! Form::open(['method'=>'get']) !!}
				<div class="row">
					<div class="col-md-2 form-group">
						<input type="number" class="form-control" name="year" value="{{ $year = request()->year ?? date('Y') }}" min="2021" max="{{ date('Y') }}" required>
					</div>
					<div class="col-md-1 form-group">
						<button class="btn btn-primary" type="submit">Search</button>
					</div>
				</div>
				{!! Form::close() !!}
			</div>
			
			
			<div class="box-body no-padding">
				<div id="salesDetails"></div>
			</div>
		</div>
	</div>
</div>

@endsection



@section('script')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
	// Load google charts
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(sessionDetails);
	
	
	@php
	$months=array('1'=>'Jan', '2'=>'Feb', '3'=>'Mar', '4'=>'Apr', '5'=>'May', '6'=>'June', '7'=>'July', '8'=>'Aug', '9'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec');
	@endphp
	
	
	// Session Details
	function sessionDetails() {
		
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Month');
		data.addColumn('number', 'Sales Details');
		
		data.addRows([
		@foreach($months as $k => $month)
		['{{ $month }}', {{ storesalesDetails($k, $year) }}],
		@endforeach
		]);
		
		var options = {
			hAxis: {
				title: 'Months'
			},
			vAxis: {
				title: 'Monthly Sales'
			},
			seriesType: 'bars',
			series: {1: {type: 'line'}},
			tooltip: { isHtml: true },
			legend: { position: 'top' }
		};
		
		var chart = new google.visualization.ComboChart(document.getElementById('salesDetails'));
		
		chart.draw(data, options);
	}
	
	
	
</script>
@endsection
