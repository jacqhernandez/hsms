@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS ALL THE ITEMS PAGE</p>
	</div>
	<div>
		<table> 
			<thead>
				<tr>
					<th>Name</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $item)
				<tr>
					<td>{{ $item->name }}</td>
					<td>{{ $item->description }}</td>
					<td>{!! Form::open(['route' => ['items.show', $item->id], 'method' => 'get' ]) !!}
						<button>View Item</button>
						{!! Form::close() !!}</td>
				</tr>
				@endforeach
			</tbody> 
		</table>
	</div>
	<a href="{{ url('/items/create') }}">New Item</a>
</div>
@stop
