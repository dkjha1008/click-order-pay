@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
	
		<div class="box-body">
			<h4>Search</h4>
			
			{!! Form::open(['route' => 'admin.users', 'method'=>'get']) !!}
			<div class="row">
				<div class="col-md-3 form-group">
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

				<div class="col-md-3 form-group d-flex justify-content-around">
				<div class="form-group " >
						<a class="btn btn-warning" href="{{ route('admin.users.create') }}">Add User</a>
					</div>
					<div class="form-group" >
						<a class="btn btn-warning" href="{{ route('admin.user.csvExport') }}">CSV Export</a>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
		
		<div class="card">
			<div class="card-header">
                <h3 class="card-title">{{ @$title['slug'] }}</h3>
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
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $i => $user)
						<tr>
							<td>{{ $users->firstItem()+$i }}</td>
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
							<td>
								<div class="btn-icon-list">
									<a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-icon">
										<i class="fa fa-edit"></i>
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
			@if(@request()->search || request()->verified || request()->status)
				{{ $users->appends([
					'search' => request()->search,
					'verified' => request()->verified,
					'status' => request()->status,
				])->links() }}
			@else
				{{ $users->links() }}
			@endif
		</div>
		
	</div>
</div>
@endsection