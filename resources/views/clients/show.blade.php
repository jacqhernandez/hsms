@extends ('layouts.app')
@section('content')
	@include('includes.required_errors')
		<h2>{{ $client['name'] }}</h2>
		<table class="table">
			<tbody>
				<tr>
					<td>Telephone Number: </td>
					<td>{{ $client['telephone_number'] }}</td>
				</tr>
				
				<tr>
					<td>Address: </td>
					<td>{{ $client['address'] }}</td>
				
				<tr>
					<td>Email: </td>
					<td>{{ $client['email'] }}</td>
				</tr>
			
				<tr>
					<td>TIN: </td>
					<td>{{ $client['tin'] }}</td>
				</tr>

				<tr>
					<td>Contact Person: </td>
					<td>{{ $client['contact_person'] }}</td>
				</tr>
				
				<tr>
					<td>Credit Limit: </td>
					<td>{{ $client['credit_limit'] }}</td>
				</tr>
				
				<tr>
					<td>Payment Terms: </td>
					<td>{{ $client['payment_terms'] }}</td>
				</tr>

				<tr>
					<td>Status:</td>
					<td>{{ $client['status'] }}</td>
				</tr>

				<tr>
					<td>Sales Employee: </td>
					<td>{{ $client->User->username }}</td>
				</tr>
			</tbody>
		</table>

	<table>
	<tr>

	@if (Auth::user()['role'] == 'General Manager')
	<td>
		{!! Form::open(['route' => ['clients.edit', $client->id], 'method' => 'get' ]) !!}
			<button class="btn btn-warning">Edit</button>
		{!! Form::close() !!}		
	</td>
	<td>
		{!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete' ]) !!}
			<button class="btn btn-danger">Delete</button>
		{!! Form::close() !!}
	</td>
	@endif
	<td>
	<a href="{{ action ('ClientsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>	
	</td>
	</table>
						
@stop