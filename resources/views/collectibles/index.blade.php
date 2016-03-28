@extends('layouts.app')
@section('content')
<br>
<h2>Collectibles</h2>
<hr>
{!!  Form::open(['route' => ['collectibles.search'], 'method' => 'get', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
<div class="form-group">
{!!  Form::text('query', null, ['placeholder' => 'Client Name', 'class' => 'form-control'])  !!} 
</div>
{!!  Form::submit('Search', ['class' => 'btn btn-success'])  !!}
{!!  Form::close() !!}

{!!  Form::open(['route' => ['collectibles.filter'], 'method' => 'get', 'class' => 'navbar-form navbar-right'])  !!}
<div class="form-group">
{!! Form::select('filter', [
						'' => 'Filter by Status',
						'All' => 'Show All',
						'Good' => 'Good',
						'Blacklisted' => 'Blacklisted'], 
					 	old('filter'), ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
</div>
{!!  Form::close() !!}
<br><br>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Name</th>
			<th>Credit Limit</th>
			<th>Status</th>
			<th>Overdue</th>
			<th>Delivered</th>
			<th>Check on Hand</th>
			<th>Total Amount Due </th>
			<th class="sorttable_nosort"></th>
		</tr>
	</thead>
	
	<tbody>
		@foreach ($clients as $client)
		@if ($overdue[$client->id] != 0 OR $delivered[$client->id] != 0 OR $check[$client->id] != 0)
		<tr>
			<td><a href="{{ action ('ClientsController@show', [$client->id]) }}">{{ $client->name }}</a></td>
			<td>{{ $client->credit_limit }}</td>
			<td>{{ $client->status }}</td>
			<td>{{ $overdue[$client->id] }}</td>
			<td>{{ $delivered[$client->id] }}</td>
			<td>{{ $check[$client->id] }}</td>
			<td>{{ $salesinvoiceTotal[$client->id] }}</td>
			<td><a class="btn btn-info" href="{{ action ('CollectionLogsController@index', [$client->id]) }}">View</a></td>
		</tr>
		@endif
		@endforeach
	</tbody> 
</table>

@stop
