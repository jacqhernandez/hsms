@extends('layouts.app')
@section('content')

<?php
	use App\Item;
?>

<h2>Edit Sales Invoice</h2>
	{!! Form::model($sales_invoice, ['method' => 'PATCH', 'action' => ['SalesInvoicesController@update', $sales_invoice->id]]) !!}
	<table> 
		@include('includes.required_errors')
		<tbody>
			<tr>
				<td> {!! Form::label('si_no', 'Invoice Number: ') !!}</td>
				<td> {!! Form::text('si_no', old('si_no'), ['class' => 'span7']) !!} </td>
			</tr>	

			<tr>
				<td>{!! Form::label('client_id', 'Client: ') !!}</td>
				<td>{!! Form::select('client_id', $clientOptions, Input::old('client_id')) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('po_number', 'PO Number: ') !!}</td>
				<td> {!! Form::text('po_number', old('po_number'), ['class' => 'span7']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('dr_number', 'DR Number: ') !!} </td>
				<td> {!! Form::text('dr_number', old('dr_number')) !!}</td>
			</tr>
			
			<tr>
				<td>{!! Form::label('user_id', 'Sales Employee: ') !!}</td>
				<td>{!! Form::select('user_id', $userOptions, Input::old('user_id')) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('due_date', 'Due Date: ') !!} </td>
				<td> {!! Form::date('due_date', old('due_date')) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('status', 'Status: ') !!}</td>
				<td>{!! Form::select('status', $statusOptions, Input::old('status')) !!}</td>
			</tr>

			<tr>
				<td> {!! Form::label('date_delivered', 'Date Delivered: ') !!} </td>
				<td> {!! Form::date('date_delivered', old('date_delivered')) !!}</td>
			</tr>

			<tr>
				<td> {!! Form::label('date_collected', 'Date Collected: ') !!} </td>
				<td> {!! Form::date('date_collected', old('date_collected')) !!}</td>
			</tr>

			<tr>
				<td> {!! Form::label('or_number', 'OR Number: ') !!}</td>
				<td> {!! Form::text('or_number', old('or_number'), ['class' => 'span7']) !!} </td>
			</tr>
			<tr>
				<th>Total Amount: </th>
				<td>Php {{ number_format($sales_invoice->total_amount, 2, '.', ',') }}</td>
			</tr>		

		</tbody> 
	</table>

	<h3>Item List</h3>
		<div class="table-responsive">
			<table class="table table-striped">
			<thead>
				<tr>
					<th>Item</th>
					<th>Units</th>
					<th>Quantity</th>
					<th>Selling Price per Unit</th>
					<th>Subtotal</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $item)
				<tr>
					<td><?php echo Item::find($item->item_id)->name; ?></td>
					<td><?php echo Item::find($item->item_id)->unit; ?></td>
					<td>{{ $item->quantity }}</td>
					<td>Php {{ number_format($item->unit_price, 2, '.', ',') }}</td>
					<td>Php {{ number_format($item->total_price, 2, '.', ',') }}</td>
					<td><a href="{{ action ('InvoiceItemsController@edit', [$item->id]) }}">
						 <button type="button" class="btn btn-primary">Edit Entry</button></a>
					@if (count($items) > 1)
						<a href="{{ action ('InvoiceItemsController@destroy', [$item->id]) }}">
						 <button type="button" class="btn btn-danger">Delete Entry</button></a>
					@endif
					</td>
				</tr>
				@endforeach
			</tbody> 
			<a href="{{ action ('InvoiceItemsController@addItem', [$sales_invoice->id]) }}">
				<button type="button" class="btn btn-primary">New Entry</button></a>
			</table>
		</div>
	
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
	</div>
	<button type="button" class="btn btn-info" onclick="history.go(-1);">Back </button>
@stop