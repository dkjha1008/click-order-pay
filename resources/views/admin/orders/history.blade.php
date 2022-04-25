<div class="row">
	<div class="col-12">
		<h4>
			<i class="fas fa-clipboard"></i> Order History
		</h4>
	</div>
</div>

<div class="timeline">
	@foreach($order->allStatus as $status)
	<div>
		<i class="fas fa-user bg-blue"></i>
		<div class="timeline-item">
			<span class="time"><i class="fas fa-clock"></i> {{ $status->created_at->timezone('America/Chicago')->format('d/m/Y h:ia') }}
			</span>
			<h3 class="timeline-header">
				@if($status->user->role=='admin')
				<a href="javascript:void(0)">Admin</a>
				@else
				<a href="{{ route('admin.user.show', $status->user->id) }}">{{ $status->user->name }}</a>
				@endif
				
				<span class="right badge badge-danger">{{ $status->order_status->name }}</span>
			</h3>			
			<div class="timeline-body">
				{{ $status->comment }}
			</div>
		</div>
	</div>
	@endforeach
</div>


@if(@$allstatus && in_array($order->order_status, ['1', '2', '5']))
<div class="row" id="status">
	<div class="col-md-12">
		<div class="card card-default">
			
			{!! Form::open(['route' => ['orders.status', $order->id], 'class' => 'form-horizontal']) !!}
				<div class="card-body">					
					<div class="form-group {!! ($errors->has('status') ? 'has-error' : '') !!}">
						{!! Form::label('status','Status', ['class' => 'control-label']) !!}
						{!! Form::select('status', $allstatus, null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : '') ]) !!}
						{!! $errors->first('status', '<span class="help-block">:message</span>') !!}
					</div>
					
					<div class="form-group {!! ($errors->has('comment') ? 'has-error' : '') !!}">
						{!! Form::label('comment','Comment', ['class' => 'control-label']) !!}
						{!! Form::textarea('comment', null, ['class' => 'form-control' . ($errors->has('comment') ? ' is-invalid' : ''), 'rows'=>2 ]) !!}
						{!! $errors->first('comment', '<span class="help-block">:message</span>') !!}
					</div>
					
				</div>
				<div class="card-footer">
					<button type="submit" class="btn btn-info float-right">Submit</button>
				</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endif