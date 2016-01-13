@extends('layouts.app')
@section('content')

<h2>Suppliers</h2>
<hr/>

<div>
{!!  Form::open(['route' => ['suppliers.search'], 'method' => 'get'])  !!}
{!!  Form::text('query', null, ['placeholder' => 'Supplier Name'])  !!} 
{!!  Form::submit('Search', ['class' => 'btn', 'position:relative;'])  !!}
{!!  Form::close() !!}
</div>
<br><br>
<table class="table table-hover sortable">
<thead>
	<tr>
		<th>Name</th>
		<th>Telephone Number</th>
		<th>TIN</th>
		<th>Address</th>
	</tr>
</thead>
<tbody>
	@foreach($suppliers as $supplier)
	<tr>
		<td>{{ $supplier->name }}</td>
		<td>{{ $supplier->telephone_number }}</td>
		<td>{{ $supplier->tin }}</td>
		<td>{{ $supplier->address }}</td>
		<td>{{ $supplier->email }}</td>
		<td><a href="{{ action ('SuppliersController@show', [$supplier->id]) }}">View</a></td>
	</tr>
	@endforeach
	</tbody>
</table>
<br>
@if (Auth::user()['role'] == 'General Manager')
<a href="{{ url('/suppliers/create') }}">Create New Supplier</a>
@endif

@stop