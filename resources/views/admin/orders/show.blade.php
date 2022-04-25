@extends('layouts.admin')
@section('content')
@php
$tprice=0;
$tipPrice=0;
@endphp

<div class="row">
	<div class="col-12">
	
		@if(@$order->order_status=='3')
			<div class="alert alert-danger">
				<strong>Alert</strong> Order Canceled
			</div>			
			
			@if($order->is_refund=='0' && $order->payment_type=='authorize')
			<div class="alert alert-info">
				<a href="{{route('admin.orders.refund', $order->id)}}">Click to Refund ${{ $order->carts->total_price }}</a>
			</div>
			@endif
		@endif
		
		@if($order->is_progress=='1')
		<div class="alert alert-info">
			Payment in progress
		</div>
		@endif
		
		@if($order->is_refund=='1')
			<div class="alert alert-info">
				Payment Refunded
			</div>
		@endif
		
		@if($order->payment_status=='pending' && $order->order_status!='3')
			<div class="alert alert-warning">
				Order Payment Pending
			</div>
			
			<a class="btn btn-primary" href="{{ route('admin.orders.payment', $order->id) }}">Complete Payment</a>
		@endif
		
		@if($order->order_status=='1' || $order->order_status=='5')		
			<a class="btn btn-danger" href="{{ route('admin.orders.cancle', $order->id) }}">Cancel Order</a>
		@endif
		
	
		<div class="invoice p-3 mb-3">
			<div class="row">
                <div class="col-12">
					<h4>
						<i class="fas fa-globe"></i> {{ @$title['slug'] }}
						<small class="float-right">Date: {{ @$order->created_at->timezone('America/Chicago')->format('d/m/Y - h:ia')?? null }}</small>
					</h4>
				</div>
			</div>
			
			<div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
					To
					<address>
						<strong>{{ $order->user->name }}</strong><br>
						Phone: {{ $order->user->phone_number }}<br>
					</address>
				</div>
				<div class="col-sm-4 invoice-col">
					Delivery Address
					<address>
						<strong>Address: {{ @$order->user->address }}</strong><br>
						Special Instructions: {{ @$order->user->notes }}
					</address>
				</div>

				<div class="col-sm-4 invoice-col">
					Pickup Date/Time
					<address>
						@php
					$timestamp = strtotime(@$order->carts->pickup_date);
 
                     $new_date = date("d/m/Y", $timestamp);
					 @endphp
						<strong>Date: {{   $new_date }}</strong><br>
						Time: {{ @$order->carts->pickup_time }}
					</address>
				</div>
			</div>
			
			@if(!$order->carts->products->isEmpty())
			<div class="row">
                <div class="col-12 table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Image</th>
								<th>Product</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Size</th>
								<th>Total Price</th>
							</tr>
						</thead>
						<tbody>
							@foreach($order->carts->products as $k => $product)
						@php 
                           $cartProduct = App\Models\CartProducts::where('products_id',$product->id)->where('carts_id',$order->carts->id)->first();
						@endphp
							<tr>
								<td><img width="50" src="{{ asset('storage/products/'.$product->image) }}"></td>
								<td>{{ $product->title }}<br>{{ $product->description }}</td>
								@if($cartProduct->size!=null && $cartProduct->price!=null)	
								<td>${{$cartProduct->price}}
								@else
								<td>${{ $product->price }}</td>
								@endif
								
								<td>{{ $product->pivot->quantity }}</td>
								@if($cartProduct->size!=null && $cartProduct->price!=null)	
								<td>{{ $cartProduct->size }}</td>

								<td>${{ $tprice = $product->pivot->quantity * $cartProduct->price }}</td>
								@else
								<td></td>
								<td>${{ $tprice = $product->pivot->quantity * $product->price }}</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="row">
                <div class="col-6">
				</div>
				
                <div class="col-6">					
					<div class="table-responsive">
						<table class="table">
						
							<tbody>
								<tr>
									<th style="width:50%">Subtotal:</th>
									<td>${{ $order->carts->price }}</td>
								</tr>
								
								@if($order->carts->tax && $order->carts->tax>0)
								<tr>
									<th style="width:50%">Tax:</th>
									<td>${{ $order->carts->tax }}</td>
								</tr>
								@endif
								
								@if($order->carts->tip && $order->carts->tip>0)
								<tr>
									<th style="width:50%">Tip:</th>
									<td>${{ $order->carts->tip }}</td>
								</tr>
								@endif
								
								@if($order->carts->delivery_charges && $order->carts->delivery_charges>0)
								<tr>
									<th style="width:50%">Delivery Charges:</th>
									<td>${{ $order->carts->delivery_charges }}</td>
								</tr>
								@endif
								
								
								@if($order->carts->promocode)
								@php
								$promo = $order->carts->promo;
								@endphp
								<tr>
									<th style="width:50%">Discount:</th>
									<td>
										{{$promo->coupon_type=='fixed'?'$':''}}
										{{ $promo->discount }}
										{{$promo->coupon_type=='percentage'?'%':''}}	
									</td>
								</tr>
								@endif
								
								<tr>
									<th style="width:50%">Total:</th>
									<td>${{ $order->carts->total_price }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@endif
		</div>		
		
		@if($order->payment_status=='captured')
		@include('admin.orders.history', ['order' => $order, 'allstatus' => $status])
		@endif
	</div>
</div>
@endsection