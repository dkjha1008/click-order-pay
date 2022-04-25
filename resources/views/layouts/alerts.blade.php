@if ($message = Session::get('success'))
<div class="alert alert-dismissible alert-success">
	<button class="close" type="button" data-dismiss="alert">×</button>
	{!! $message !!}
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-dismissible alert-danger">
	<button class="close" type="button" data-dismiss="alert">×</button>
	{!! $message !!}
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-dismissible alert-warning">
	<button class="close" type="button" data-dismiss="alert">×</button>
	{!! $message !!}
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-dismissible alert-info">
	<button class="close" type="button" data-dismiss="alert">×</button>
	{!! $message !!}
</div>
@endif