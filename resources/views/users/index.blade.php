@extends('layouts.app')
@section('content')

<h2>Users</h2>
<hr/>
<table class="table table-hover sortable">
<thead>
	<tr>
		<th>Username</th>
		<th>Role</th>
	</tr>
</thead>
<tbody>
	@foreach($users as $user)
	<tr>
		<td>{{ $user->username }}</td>
		<td>{{ $user->role }}</td>
		<td>
			{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete', 'id' => 'delete' ]) !!}
				<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete">
				Delete
		</button>
			{!! Form::close() !!}
		</td>
		<td>
			{!! Form::open(['route' => ['users.edit', $user->id], 'method' => 'get' ]) !!}
			{!! Form::button('Edit', ['type' => 'submit', 'class' => 'btn']) !!}
			{!! Form::close() !!}
		</td>
	</tr>
	@endforeach
	</tbody>
</table>
<?php echo $users->render(); ?>
<br>
<a href="{{ url('/auth/register') }}">New User</a>
@include('includes.delete_confirm')	
@stop