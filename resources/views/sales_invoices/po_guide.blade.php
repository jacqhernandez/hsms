@extends ('layouts.app')
@section('content')
		<h2>Purchase Order Guide</h2>
		<table class="table">
			<tbody>
				<tr>
					<td>Invoice: </td>
					<td>{{ $sales_invoice['si_no'] }}</td>
				</tr>

				<tr>
					<td>Client: </td>
					<td>{{ $sales_invoice->Client->name }}</td>
				</tr>
				
				<tr>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>

		@foreach($sales_invoice->InvoiceItems as $invoice_item)
		<h6>Item: {{ $invoice_item->Item->name }}</h6>
		<table class="table table-hover sortable"> 
			<thead>
				<tr>
					<th>Supplier</th>
					<th>Price</th>
					<th>Stock Availability</th>
				</tr>
			</thead>
			
			<tbody>
				<tr>
					<?php
						$price_logs = PriceLog::where('item_id', $invoice_item->Item->id)->orderBy('date','desc')->take(3)->get();
					?>
					@foreach($price_logs as $price_log)
					<td>{{ $price_log->Supplier->name }}</td>
					<td>{{ $price_log->price }}</td>
					<td>{{ $price_log->stock_availability }}</td>
					@endforeach
				</tr>
			</tbody> 
		</table>
		@endforeach

	<a href="{{ action ('SalesInvoicesController@index') }}"><button type="button" class="btn btn-info">Back</button></a>	
	
						
@stop