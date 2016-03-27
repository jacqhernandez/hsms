@extends('layouts.app')
@section('content')

<h2>User Information</h2>
<hr>
<table id="form-blades">
	<tr>
		<td><label>Username:</label></td>
		<td>{{ Auth::user()['username'] }}</td>
	</tr>

	<tr>
		<td><label>Role:</label></td>
		<td>{{ Auth::user()['role'] }}</td>
	</tr>
</table>

@stop