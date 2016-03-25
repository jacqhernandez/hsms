@extends('layouts.app')
@section('content')

<h2>Suppliers</h2>
<hr/>

{!!  Form::open(['route' => ['suppliers.search'], 'method' => 'get', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
<div class="form-group">
{!!  Form::text('query', null, ['placeholder' => 'Supplier Name', 'class' => 'form-control'])  !!} 
</div>
{!!  Form::submit('Search', ['class' => 'btn btn-default'])  !!}
{!!  Form::close() !!}

<br><br>
<table class="table table-hover sortable">
<thead>
	<tr>
		<th>Name</th>
		<th>Telephone Number</th>
		<th>Contact Person</th>
		<th>Terms</th>
		<th>E-mail</th>
	</tr>
</thead>
<tbody>
	@foreach($suppliers as $supplier)
	<tr>
		<td>{{ $supplier->name }}</td>
		<td>{{ $supplier->telephone_number }}</td>
		<td>{{ $supplier->contact_person }}</td>
		<td>{{ $supplier->payment_terms }}</td>
		<td>{{ $supplier->email }}</td>
		<td><a href="{{ action ('SuppliersController@show', [$supplier->id]) }}">View</a></td>
	</tr>
	@endforeach
	</tbody>
</table>
<?php echo $suppliers->render(); ?>
<br>
@if (Auth::user()['role'] == 'General Manager' OR Auth::user()['role'] == 'Accounting')
<a href="{{ url('/suppliers/create') }}" class="btn btn-primary">Create New Supplier</a>
@endif

@stop