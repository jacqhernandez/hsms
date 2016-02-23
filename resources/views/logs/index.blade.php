@extends('layouts.app')
@section('content')
<br>
<h2>Logs</h2>
<hr>

{!!  Form::open(['route' => ['logs.filter'], 'method' => 'get', 'class' => 'navbar-form navbar-right'])  !!}
<div class="form-group">
<?php $users[''] = "Filter by User"; ?>
{!! Form::select('filter', $users,
					 	old('filter'), ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
</div>
{!!  Form::close() !!}

{!! Form::open(['route' => ['logs.delete'], 'method' => 'get', 'class' => 'navbar-form navbar-right']) !!}
	<button class="btn btn-danger">Delete Oldest 50 Records</button>
{!! Form::close() !!}		


<br><br>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Action</th>
			<th>User</th>
			<th>Date and Time</th>
		</tr>
	</thead>
	
	<tbody>
		@foreach ($activities as $activity)
		<tr>
			<td>{{ $activity->text }}</td>
			@if ($activity->user !== null)
				<td>{{ $activity->user->username }}</td>
			@else
				<td>User Deleted</td>
			@endif
			<td>{{ $activity->created_at->format('F j, Y h:i:s A') }}</td>
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $activities->render(); ?>


@stop
