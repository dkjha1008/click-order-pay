@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-12">
		
		<div class="box-body">
			
		</div>
			
		<div class="card">
			<div class="card-header">
                <h3 class="card-title">{{ @$title['slug'] }}</h3>
				
                <div class="card-tools pull-right">
					<a href="{{ route('attributes.create') }}" title="Add" class="btn btn-success btn-icon"><i class="fa fa-plus"></i></a>
				</div>
			</div>			
			
			<div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
					<thead>
						<tr>
							<th>Sr.</th>
							<th>Attribute</th>
							<th>Value</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@php $j=0; @endphp
						@foreach($attributes as $i => $attribute)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>
								
								{{ $attribute->attribute }}
							</td>
							<td>
								{{ $attribute->value}}
							</td>
							
							<td>
								<div class="btn-icon-list">
									<a href="{{ route('attributes.edit', $attribute->id) }}" class="btn btn-warning btn-icon">
										<i class="fa fa-edit"></i>
									</a>
									
									<a data-method="Delete" data-confirm="Are you sure?" href="{{ route('attributes.destroy', $attribute->id) }}" class="btn btn-danger btn-icon">
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
		
	</div>
</div>
@endsection