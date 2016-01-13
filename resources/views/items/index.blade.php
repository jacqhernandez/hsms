@extends('layouts.app')
@section('content')
<br>
<h2>Items</h2>
<hr>
<table class="table table-hover sortable"> 
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
			<td><a href="{{ action ('ItemsController@show', [$item->id]) }}">View</a></td>
		</tr>
		@endforeach
	</tbody> 
</table>
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/items/create') }}">New Item</a>
@endif
@stop