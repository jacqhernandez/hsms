@extends ('layouts.app')
@section('content')
	@include('includes.required_errors')
	<div>
		<p>THIS IS THE SHOW CLIENTS PAGE</p>
		<table width="100%">
			<tbody>
				<tr>
					<td>Name: {{ $client['name']}}</td>
				</tr>
				<tr>
					<td>Email: {{ $client['email']}}</td>
				</tr>
				<tr>
					<td>Credit Limit: {{ $client['credit_limit']}}</td>
				</tr>
			</tbody>
		</table>
	</div>
	{!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete' ]) !!}
		<button>Delete Client</button>
	{!! Form::close() !!}
	{!! Form::open(['route' => ['clients.edit', $client->id], 'method' => 'get' ]) !!}
		<button>Edit Client</button>
	{!! Form::close() !!}										
@stop
				