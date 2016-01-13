@extends('layouts.app')
@section('content')

<h2>Users</h2>
<hr/>
<table class="table table-hover">
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
			{!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete' ]) !!}
				<button class="btn btn-warning login-email span2 btn-half" data-singleton="true" data-popout="true" data-toggle="confirmation" data-placement="right" data-btn-ok-label="Delete" data-btn-ok-icon="glyphicon glyphicon-trash" data-btn-ok-class="btn-warning" data-btn-cancel-label="Cancel" data-btn-cancel-icon="glyphicon glyphicon-ban-circle" data-title="<center><b>Are you sure you want to delete User {{$user->name}}?</b></center>">
					Delete
				</button>
			{!! Form::close() !!}
		</td>
		<td>
			{!! Form::open(['route' => ['users.edit', $user->id], 'method' => 'get' ]) !!}
			{!! Form::button('Edit', ['type' => 'submit', 'class' => 'btn login-email span2 btn-half btn-right']) !!}
			{!! Form::close() !!}
		</td>
	</tr>
	@endforeach
	</tbody>
</table>
<br>
<a href="{{ url('/auth/register') }}">New User</a>

@stop