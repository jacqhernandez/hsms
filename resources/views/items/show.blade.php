@extends ('layouts.app')
@section('content')
	@include('includes.required_errors')
	<div>
		<p>THIS IS THE SHOW itemS PAGE</p>
		<table width="100%">
			<tbody>
				<tr>
					<td>Name: {{ $item['name']}}</td>
				</tr>
				<tr>
					<td>Description: {{ $item['description']}}</td>
				</tr>
			</tbody>
		</table>
	</div>
	{!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete' ]) !!}
		<button>Delete Item</button>
	{!! Form::close() !!}
	{!! Form::open(['route' => ['items.edit', $item->id], 'method' => 'get' ]) !!}
		<button>Edit Item</button>
	{!! Form::close() !!}										
@stop
				