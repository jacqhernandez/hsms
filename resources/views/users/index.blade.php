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
	</tr>
	@endforeach
	</tbody>
</table>
<br>
<a href="{{ url('/auth/register') }}">New User</a>

@stop