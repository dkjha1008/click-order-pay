@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
		
		<div class="box-body">
			<h4>Search</h4>
			
			{!! Form::open(['route' => 'admin.products', 'method'=>'get']) !!}
			<div class="row">
				
				<div class="col-md-2 form-group">
					{!! Form::text('search', request()->search ?? null, ['class' => 'form-control' . ($errors->has('search') ? ' is-invalid' : ''), 'placeholder'=>'Search' ]) !!}
				</div>
				
				<div class="col-md-2 form-group">
					{!! Form::select('category', $category, request()->category ?? null, ['class' => 'form-control' . ($errors->has('category') ? ' is-invalid' : ''), 'placeholder'=>'Category' ]) !!}
				</div>
				
				<div class="col-md-2 form-group">
					{!! Form::number('quantity', request()->quantity ?? null, ['class' => 'form-control' . ($errors->has('quantity') ? ' is-invalid' : ''), 'placeholder'=>'Quantity', 'min'=>0, 'max'=>10000 ]) !!}
				</div>
				
				<div class="col-md-2 form-group">
					{!! Form::select('status', ['active'=>'Active', 'deactive'=>'De-active'], request()->status ?? null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder'=>'All' ]) !!}
				</div>
				
				<div class="col-md-4 form-group">
					<button class="btn btn-primary" type="submit">Search</button>
					<div class="form-group" style="float: right;">
						<button class="btn btn-success" type="button" data-toggle="modal" data-target="#csvImport">CSV Import</button>
						<a class="btn btn-warning" href="{{ route('admin.products.csvExport') }}">CSV Export</a>
					</div>
				</div>
				
			</div>
			{!! Form::close() !!}
			
		</div>
		
		<div class="card">
			<div class="card-header">
                <h3 class="card-title">{{ @$title['slug'] }}</h3>
				
                <div class="card-tools pull-right">
					<a href="{{ route('admin.products.create') }}" title="Add" class="btn btn-success btn-icon"><i class="fa fa-plus"></i></a>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Sku</th>
							<th>Title</th>
							<th>Qty</th>
							@if(request()->category)
							<th>Position</th>
							@endif
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php $j=0; @endphp
						@foreach($products as $i => $product)
						<tr>
							<td>{{ $j = $products->firstItem()+$i }}</td>
							<td>{{ $product->sku }}</td>
							<td>
								@if($product->image)
								<img width="20" height="40" src="{{ asset('storage/products/'.$product->image) }}">
								@endif
								{{ $product->title }}
							</td>
							<td>{{ $product->qty }}</td>
							
							@if(request()->category)
							<td>
								@if($j>1)
								<a href="{{ route('admin.products.position', [$product->id, 'up']) }}">
									<i class="fa fa-arrow-up"></i>
								</a>
								@endif
								
								@if($j < $products->total())
								<a href="{{ route('admin.products.position', [$product->id, 'down']) }}">
									<i class="fa fa-arrow-down"></i>
								</a>
								@endif
							</td>
							@endif
							
							<td>
								@if($product->status=='1')
								<span class="badge badge-success">Active</span>
								@else
								<span class="badge badge-danger">De-active</span>
								@endif
							</td>
							<td>
								<div class="btn-icon-list">
									<a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-icon">
										<i class="fa fa-edit"></i>
									</a>
									
									<a data-method="Delete" data-confirm="Are you sure?" href="{{ route('admin.products.destroy', $product->id) }}" class="btn btn-danger btn-icon">
										<i class="fa fa-trash"></i>
									</a>
								</div>
							</td>	
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="pagination">
			@if(@request()->search || request()->category || request()->status || request()->quantity)
				{{ $products->appends([
					'search' => request()->search,
					'category' => request()->category,
					'status' => request()->status,
					'quantity' => request()->quantity,
				])->links() }}
			@else
				{{ $products->links() }}
			@endif
		</div>
		
	</div>	
</div>


<div id="csvImport" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">CSV Import</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
			{!! Form::open(['route' => 'admin.products.csv', 'enctype' => 'multipart/form-data']) !!}
			<div class="modal-body">
			
				{!! Form::label('csv','Select Csv', ['class' => 'control-label']) !!}</br>
				<input type="file" name="file" accept=".csv" required>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
			{!! Form::close() !!}
		</div>		
	</div>
</div>
@endsection