@extends ('layouts.app')
@section('content')
		<h2>{{ $supplier['name'] }}</h2>
		<table class="table">
			<tbody>
				<tr>
					<td>Description: </td>
					<td>{{ $supplier['description']}}</td>
				</tr>
				<tr>
					<td>Telephone Number: </td>
					<td>{{ $supplier['telephone_number']}}</td>
				</tr>
			
				<tr>
					<td>TIN: </td>
					<td>{{ $supplier['tin']}}</td>
				</tr>
				
				<tr>
					<td>Address: </td>
					<td>{{ $supplier['address']}}</td>
				</tr>
				
				<tr>
					<td>E-mail: </td>
					<td>{{ $supplier['email']}}</td>
				</tr>

				<tr>
					<td>Contact Person: </td>
					<td>{{ $supplier['contact_person']}}</td>
				</tr>

				<tr>
					<td>Payment Terms: </td>
					<td>{{ $supplier['payment_terms']}}</td>
				</tr>
			</tbody>
		</table>

	<table>
	<tr>
	@if (Auth::user()['role'] == 'General Manager')
	<td>
	{!! Form::open(['route' => ['suppliers.edit', $supplier->id], 'method' => 'get' ]) !!}
		<button class="btn btn-warning">Edit</button>
	{!! Form::close() !!}		
	</td>
	<td>
	{!! Form::open(['route' => ['suppliers.destroy', $supplier->id], 'method' => 'delete' ]) !!}
		<button class="btn btn-danger">Delete</button>
	{!! Form::close() !!}
	</td>
	@endif
	<td>
	<a href="{{ action ('SuppliersController@index') }}"><button type="button" class="btn btn-info">Back</button></a>	
	</td>
	</table>
						
@stop
				