@extends ('layouts.app')
@section('content')
	@include('includes.required_errors')
		<h2>{{ $item['name'] }}</h2>
		<table class="table">
			<tbody>
				<tr>
					<td>Description: </td>
					<td>{{ $item['description'] }}</td>
				</tr>
			</tbody>
		</table>

	<table>
	<tr>

	@if (Auth::user()['role'] == 'General Manager')
	<td>
		{!! Form::open(['route' => ['items.edit', $item->id], 'method' => 'get' ]) !!}
			<button class="btn btn-warning">Edit</button>
		{!! Form::close() !!}		
	</td>
	<td>
		{!! Form::open(['route' => ['item.destroy', $item->id], 'method' => 'delete' ]) !!}
			<button class="btn btn-danger">Delete</button>
		{!! Form::close() !!}
	</td>
	@endif
	<td>
	<a href="{{ action ('ItemsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>	
	</td>
	</table>
						
@stop