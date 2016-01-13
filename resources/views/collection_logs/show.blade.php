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
					<td>Credit Limit: </td>
					<td>{{ $client['credit_limit'] }}</td>
				</tr>
				
				<tr>
					<td>Status:</td>
					<td>{{ $client['status'] }}</td>
				</tr>
			</tbody>
		</table>

	<table>
	<tr>
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
	<td>
	<a href="{{ action ('ClientsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>	
	</td>
	</table>
						
@stop