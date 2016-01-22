@extends('layouts.app')
@section('content')
<br>
<h2>List of Sales Invoice</h2>
<hr>


<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Client</th>
			<th>Due Date</th>
			<th>Total Amount</th>
			<th>Payment Terms</th>
			<th>Status</th>
		</tr>
	</thead>
	
	<tbody>
		@foreach ($sales_invoices as $sales_invoice)
		<tr>
			<td>{{ $sales_invoice->Client->name }}</td>
			<td>{{ $sales_invoice->due_date }}</td>
			<td>{{ $sales_invoice->total_amount }}</td>
			<td>{{ $sales_invoice->Client->payment_terms }}</td>
			<td>{{ $sales_invoice->status }}</td>
			<td><a href="{{ action ('SalesInvoicesController@show', [$sales_invoice->id]) }}">View invoice</a></td>
		</tr>
		@endforeach
	</tbody> 
</table>
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/invoices/create') }}">New Sales Invoice</a>
@endif

@stop
