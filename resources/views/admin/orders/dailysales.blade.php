@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">		
		
		<div class="card">
			<div class="card-header">
                <h3 class="card-title">{{ @$title['slug'] }}</h3>
			</div>
			<div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Date</th>
							<th>Sales for the day</th>
							<th>Number of orders</th>
							<th>Total registered user</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $order)
						@php
						$data = dailySales($order->date);
						@endphp
						<tr>
							<td>
								<a href="{{ route('admin.orders') }}?from_date={{ $order->date }}&to_date={{ $order->date }}">{{ $order->date }}</a>
							</td>
							<td>
								${{ $data['totalOrders'] }}
							</td>
							<td>
								{{ $data['totalSales'] }}
							</td>
							<td>
								{{ $data['users'] }}
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="pagination">
			{{ $orders->links() }}
		</div>
		
	</div>
</div>
@endsection
