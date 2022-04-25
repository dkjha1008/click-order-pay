@if(!$data->isEmpty())
<table class="table table-hover text-nowrap">
	<thead>
		<tr>
			<th>Order Id.</th>
			<th>User Name</th>
			<th>Phone #</th>
			<th>ID</th>
			{{--<th>Producs</th>--}}
			<th>Amount</th>
			<th>Payment Type</th>
			<th>Promocode</th>
			<th>Status</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $i => $order)
		@if(@$order->user)
		<tr>
			<td><a href="{{ route('store.orders.show', $order->id) }}">{{ $order->id }}</a></td>
			<td>
				<!-- <a href=" }}"> -->
				{{ $order->user->name }}
				</a>
			</td>
			<td>
				{{ $order->user->phone_number }}
			</td>
			<td>
				@if($order->user->verified=='1')
				<i  class="fa fa-check"></i>
				@else
				<i  class="fa fa-times"></i>
				@endif
			</td>
			{{--
			<td>
				<a href="{{ route('store.orders.show', $order->id) }}">
				@foreach($order->carts->products as $k => $product)
					{{ $k>0?', ':''.$product->title }}
				@endforeach
				</a>
			</td>
			--}}
			<td>
				${{ $order->amount }}
			</td>
			<td>
				{{ ucfirst($order->payment_type) }}
			</td>
			<td>
				{{ @$order->carts->promocode }}
			</td>
			<td>
				@if($order->payment_status=='pending' && $order->order_status!='3')
					<a href="{{ route('store.orders.show', $order->id) }}#status">Order Payment Pending</a>
				@else
					<a href="{{ route('store.orders.show', $order->id) }}#status">{{ @$order->status->order_status->name }}</a>
				@endif
			</td>
			<td>
			{{ $order->created_at->timezone('America/Chicago')->format('d/m/Y - h:ia') }}
			</td>
		</tr>
		@endif
		@endforeach
	</tbody>
</table>
@endif