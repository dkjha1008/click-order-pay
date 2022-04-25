@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
		
		<div class="box-body">
			<h4>Search</h4>
			
			{!! Form::open(['route' => 'admin.category', 'method'=>'get']) !!}
			<div class="row">
				
				<div class="col-md-4 form-group">
					{!! Form::text('search', request()->search ?? null, ['class' => 'form-control' . ($errors->has('search') ? ' is-invalid' : ''), 'placeholder'=>'Search' ]) !!}
				</div>
				
				<div class="col-md-1 form-group">
					<button class="btn btn-primary" type="submit">Search</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
			
		<div class="card">
			<div class="card-header">
                <h3 class="card-title">{{ @$title['slug'] }}</h3>
				
                <div class="card-tools pull-right">
					<a href="{{ route('admin.category.create') }}" title="Add" class="btn btn-success btn-icon"><i class="fa fa-plus"></i></a>
				</div>
			</div>			
			
			<div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Name</th>
							<th>Position</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php $j=0; @endphp
						@foreach($category as $i => $cat)
						<tr>
							<td>{{ $j = $category->firstItem()+$i }}</td>
							<td>
								@if(@$cat->image)
									<img width="50" src="{{ asset('storage/category/'.$cat->image) }}">
								@endif
								{{ $cat->name }}
							</td>
							<td>
								@if($j>1)
								<a href="{{ route('admin.category.position', [$cat->id, 'up']) }}">
									<i class="fa fa-arrow-up"></i>
								</a>
								@endif
								
								@if($j < $category->total())
								<a href="{{ route('admin.category.position', [$cat->id, 'down']) }}">
									<i class="fa fa-arrow-down"></i>
								</a>
								@endif
							</td>
							<td>
								@if($cat->status=='1')
								<span class="badge badge-success">Active</span>
								@else
								<span class="badge badge-danger">De-active</span>
								@endif
							</td>
							<td>
								<div class="btn-icon-list">
									<a href="{{ route('admin.category.edit', $cat->id) }}" class="btn btn-warning btn-icon">
										<i class="fa fa-edit"></i>
									</a>
									
									<a data-method="Delete" data-confirm="Are you sure?" href="{{ route('admin.category.destroy', $cat->id) }}" class="btn btn-danger btn-icon">
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
			@if(@request()->search)
				{{ $category->appends([
					'search' => request()->search,
				])->links() }}
			@else
				{{ $category->links() }}
			@endif
		</div>
	</div>
</div>
@endsection