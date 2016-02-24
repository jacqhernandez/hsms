@extends ('layouts.app')
@section('content')

<?php
	use App\PriceLog;
?>
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
					<td>Payment Terms: </td>
					<td>{{ $sales_invoice->Client->payment_terms }}</td>
				</tr>
			</tbody>
		</table>

		@foreach($sales_invoice->InvoiceItems as $invoice_item)
		<h3>{{ $invoice_item->Item->name }}</h3>
		<table class="table table-hover sortable"> 
			<thead>
				<tr>
					<th>Supplier</th>
					<th>Terms</th>
					<th>Contact No.</th>
					<th>E-mail</th>
					<th>Price</th>
					<th>Available?</th>
				</tr>
			</thead>
			
			<tbody>
					<?php
						$price_logs = PriceLog::where('item_id', $invoice_item->Item->id)->orderBy('created_at', 'desc')->take(3)->orderBy('price','asc')->get();
					?>
					@foreach($price_logs as $price_log)
					<tr>
					<td>{{ $price_log->Supplier->name }}</td>
					<td>{{ $price_log->Supplier->payment_terms }}</td>
					<td>{{ $price_log->Supplier->telephone_number }}</td>
					<td>{{ $price_log->Supplier->email }}</td>
					<td>Php {{ number_format($price_log->price, 2, '.', ',') }}</td>
					<td>@if ($price_log->stock_availability === 1) Yes @else No @endif</td>
				</tr>
					@endforeach
			</tbody> 
		</table>
		@endforeach

	<table>
		<tr>
			<td>
				{!! Form::open(['route' => ['invoices.generate_pdf', $sales_invoice->id], 'method' => 'get' ]) !!}
					<button class="btn btn-success">Print Invoice</button>
				{!! Form::close() !!}
			</td>
			<td>
					<button type="button" class="btn btn-info" onclick="history.go(-1);">Back </button>
			</td>
		</tr>
						
@stop