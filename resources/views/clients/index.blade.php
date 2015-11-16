@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS THE ALL CLIENTS PAGE</p>
	</div>
	<div>
		<table> 
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Credit Limit</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($clients as $client)
				<tr>
					<td>{{ $client->name }}</td>
					<td>{{ $client->email }}</td>
					<td>{{ $client->credit_limit }}</td>
				</tr>
				@endforeach
			</tbody> 
		</table>
	</div>
	<a href="{{ url('/clients/create') }}">New Client</a>
	<a href="{{ url('/') }}">Home</a>
</div>
@stop
