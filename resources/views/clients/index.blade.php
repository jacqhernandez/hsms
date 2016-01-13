@extends('layouts.app')
@section('content')
<br>
<h2>Clients</h2>
<hr>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Name</th>
			<th>Telephone Number</th>
			<th>Email</th>
			<th>Credit Limit</th>
			<th>Status</th>
			<th>Sales Employee</th>
		</tr>
	</thead>
	
	<tbody>
		@foreach ($clients as $client)
		<tr>
			<td>{{ $client->name }}</td>
			<td>{{ $client->telephone_number }}</td>
			<td>{{ $client->email }}</td>
			<td>{{ $client->credit_limit }}</td>
			<td>{{ $client->status }}</td>
			<td>{{ $client->User->username }}</td>
			<td><a href="{{ action ('ClientsController@show', [$client->id]) }}">View</a></td>
		</tr>
		@endforeach
	</tbody> 
</table>
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/clients/create') }}">New Client</a>
@endif

@stop
