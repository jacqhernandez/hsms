@extends('layouts.app')
@section('content')
<br>
<h2>List of Sales Invoice</h2>
<hr>

{!!  Form::open(['route' => ['invoices.search'], 'method' => 'get', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
<div class="form-group">
{!!  Form::text('query', null, ['placeholder' => 'SI Number or Client Name', 'class' => 'form-control'])  !!} 
</div>
{!!  Form::submit('Search', ['class' => 'btn btn-default'])  !!}
{!!  Form::close() !!}

{!!  Form::open(['route' => ['invoices.filter'], 'method' => 'get', 'class' => 'navbar-form navbar-right'])  !!}
<div class="form-group">
{!! Form::select('filter_status', [
						'' => 'Filter by Status',
						'Pending' => 'Pending',
						'Delivered' => 'Delivered',
						'Collected' => 'Collected',
						'Overdue' => 'Overdue'], 
					 	old('filter_status'), ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
</div>
{!!  Form::close() !!}

{!!  Form::open(['route' => ['invoices.filter'], 'method' => 'get', 'class' => 'navbar-form navbar-right'])  !!}
<div class="form-group">
<?php $dates[''] = "Filter by Due Date"; ?>
{!! Form::select('filter_date', $dates,
					 	old('filter_date'), ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
</div>
{!!  Form::close() !!}

<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Invoice Number</th>
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
			<td>{{ $sales_invoice->si_no }}</td>
			<td>{{ $sales_invoice->Client->name }}</td>
			<?php
				$due_date = Carbon\Carbon::parse($sales_invoice->due_date)->toFormattedDateString();
			?>
			<td>{{ $due_date }}</td>
			<td>{{ $sales_invoice->total_amount }}</td>
			<td>{{ $sales_invoice->Client->payment_terms }}</td>
			<td>{{ $sales_invoice->status }}</td>
			<td><a href="{{ action ('SalesInvoicesController@show', [$sales_invoice->id]) }}">View</a></td>
			@if ($sales_invoice->status !== "Overdue")
			<td><a href="{{ action ('SalesInvoicesController@editStatus', [$sales_invoice->id]) }}">Update Status</a></td>
			@endif
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $sales_invoices->render(); ?>
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/invoices/create') }}">New Sales Invoice</a>
@endif
<button type="button" class="btn btn-info" onclick="history.go(-1);">Back </button>
@stop
