@extends('layouts.admin')
@section('content')
@php
$tprice=0;
$tipPrice=0;
@endphp
<div class="row">
	<div class="col-12">
		<div class="invoice p-3 mb-3">
			<div class="row">
                <div class="col-12">
					<h4>
						<i class="fas fa-globe"></i> {{ @$title['slug'] }}
						<small class="float-right">Date: {{ @$user->created_at->timezone('America/Chicago')->format('d/m/Y') ?? null }}</small>
					</h4>
				</div>
			</div>
			
			<div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
					<address>
						<strong>Name: {{ $user->name }}</strong><br>
						Address: {{ $user->address }}<br>
						Phone: {{ $user->phone_number }}<br>
					</address>
				</div>
			</div>
			
			<div class="row">
                <div class="col-12 table-responsive">
					@include('admin.orders.table', ['data'=>$user->payment])
				</div>
			</div>
			
			
		</div>
	</div>
</div>
@endsection