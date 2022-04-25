@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
	
		<div class="box-body">
			<h4>Search</h4>
			
			{!! Form::open(['route' => 'admin.promocode', 'method'=>'get']) !!}
			<div class="row">
				<div class="col-md-4 form-group">
					{!! Form::text('promocode', request()->promocode ?? null, ['class' => 'form-control' . ($errors->has('promocode') ? ' is-invalid' : ''), 'placeholder'=>'Search promocode' ]) !!}
				</div>
				<div class="col-md-2 form-group">
					{!! Form::select('status', ['1'=>'Active', '0'=>'De-active'], request()->status ?? null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'placeholder'=>'Select status' ]) !!}
				</div>
				<div class="col-md-2 form-group">
					{!! Form::select('archive', ['0'=>'No', '1'=>'Yes'], request()->archive ?? null, ['class' => 'form-control' . ($errors->has('archive') ? ' is-invalid' : ''), 'placeholder'=>'Archive' ]) !!}
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
					<a href="{{ route('admin.promocode.create') }}" title="Add" class="btn btn-success btn-icon"><i class="fa fa-plus"></i></a>
				</div>
			</div>
			<div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Code</th>
							<th>Start Date</th>
							<th>Expire Date</th>
							<th>Discount</th>
							<th>Limit uses</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($promocode as $i => $code)
						<tr>
							<td>{{ $promocode->firstItem()+$i }}</td>
							<td>{{ $code->promocode }}</td>
							<td>{{ $code->start_date }}</td>
							<td>{{ $code->expire_date }}</td>
							<td>{{ $code->coupon_type=='fixed'?'$':'' }}{{ $code->discount }}{{ $code->coupon_type=='percentage'?'%':'' }}</td>
							<td>{{ $code->uses_limit }}</td>
							<td>
								@if($code->status=='1')
								<span class="badge badge-success">Active</span>
								@else
								<span class="badge badge-danger">De-active</span>
								@endif
							</td>
							<td>
								<div class="btn-icon-list">
									<a href="{{ route('admin.promocode.edit', $code->id) }}" class="btn btn-warning btn-icon">
										<i class="fa fa-edit"></i>
									</a>
									
									@if($code->is_delete=='1')
									<a data-method="Delete" data-confirm="Are you sure to retrieve?" href="{{ route('admin.promocode.destroy', $code->id) }}" class="btn btn-danger btn-icon">
										<i class="fa fa-reply"></i>
									</a>
									@else
									<a data-method="Delete" data-confirm="Are you sure?" href="{{ route('admin.promocode.destroy', $code->id) }}" class="btn btn-danger btn-icon">
										<i class="fa fa-trash"></i>
									</a>
									@endif
								</div>
							</td>	
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="pagination">
			@if(@request()->promocode || request()->status || request()->archive)
				{{ $promocode->appends([
					'promocode' => request()->promocode,
					'status' => request()->status,
					'archive' => request()->archive,
				])->links() }}
			@else
				{{ $promocode->links() }}
			@endif
		</div>
		
	</div>
</div>
@endsection