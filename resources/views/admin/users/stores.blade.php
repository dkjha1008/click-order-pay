@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
	
		<!-- <div class="box-body">
			<h4>Search</h4>
			
			{!! Form::open(['route' => 'admin.users', 'method'=>'get']) !!}
			<div class="row">
				<div class="col-md-4 form-group">
					{!! Form::text('search', request()->search ?? null, ['class' => 'form-control' . ($errors->has('search') ? ' is-invalid' : ''), 'placeholder'=>'Search name, address, phone number' ]) !!}
				</div>
				
				<div class="col-md-3 form-group">
					{!! Form::select('verified', ['1'=>'Verified', '0'=>'Not Verified'], request()->verified ?? null, ['class' => 'form-control' . ($errors->has('verified') ? ' is-invalid' : ''), 'placeholder'=>'Select ID Verified' ]) !!}
				</div>
				
				<div class="col-md-2 form-group">
					{!! Form::select('status', ['1'=>'Active', '0'=>'De-active'], request()->payment_type ?? null, ['class' => 'form-control' . ($errors->has('payment_type') ? ' is-invalid' : ''), 'placeholder'=>'Select Status' ]) !!}
				</div>
				
				<div class="col-md-1 form-group">
					<button class="btn btn-primary" type="submit">Search</button>
				</div>

				<div class="col-md-2 form-group">
				<div class="form-group" style="float: right;">
						<a class="btn btn-warning" href="{{ route('admin.users.create') }}">Add User</a>
					</div>
					<div class="form-group" style="float: right;">
						<a class="btn btn-warning" href="{{ route('admin.user.csvExport') }}">CSV Export</a>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div> -->
		
		<div class="card">
			<div class="card-header">
                <h3 class="card-title">Stores</h3>
			</div>
			<div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Name</th>
							<th>Phone Number</th>
							<th>Address</th>
							<th>Status</th>
							<th>Type</th>
							<th>ID</th>
							<th>View Store</th>
							<th>Login as</th>
						</tr>
					</thead>
					<tbody>
						@foreach($stores as $i => $user)
						<tr>
							<td>{{ $i+1 }}</td>
							<td>
								<a href="{{ route('admin.user.show', $user->id) }}">
								{{ $user->name }}
								</a>
							</td>
							<td>
								{{ $user->phone_number }}
							</td>
							<td>
								{{ $user->address }}
							</td>
							<td>
								@if($user->status=='1')
								Active
								@elseif($user->status=='2')
								Blocked
								@else
								Not Active
								@endif
							</td>
							<td>{{$user->role}}</td>
							<td>
								@if($user->verified=='1')
								<i  class="fa fa-check"></i>
								@else
								<i  class="fa fa-times"></i>
								@endif
							</td>
							<td>@if($user->status=='1' && $user->verified=='1')
								<a class="btn btn-success btn-icon"  href="{{url('/shop?store='.$user->store_slug)}}" target="_blank">view</a>
							   @else
							<a class="btn btn-success btn-icon disabled" href="{{url('/shop?store='.$user->store_slug)}}" target="_blank">view</a>
							@endif
						</td>

								<td>
								<div class="btn-icon-list">
								@if($user->status=='1' && $user->verified=='1')
									<a href="{{ route('admin.stores.login', $user->id) }}" class="btn btn-warning btn-icon">
										Login
									</a>
									@else
									<a href="{{ route('admin.stores.login', $user->id) }}" class="btn btn-warning btn-icon disabled">
										Login
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
			@if(@request()->search || request()->verified || request()->status)
				{{ $stores->appends([
					'search' => request()->search,
					'verified' => request()->verified,
					'status' => request()->status,
				])->links() }}
			@else
				{{ $stores->links() }}
			@endif
		</div>
		
	</div>
</div>
@endsection