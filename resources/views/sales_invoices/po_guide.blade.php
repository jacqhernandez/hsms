@extends ('layouts.app')
@section('content')

<?php
	use App\PriceLog;
?>
		<h2>Purchase Order Guide</h2>
		<table class="table">
			<tbody>
				<tr>
					<td class="poguide-strong">Invoice: </td>
					<td>{{ $sales_invoice['si_no'] }}</td>
				</tr>

				<tr>
					<td class="poguide-strong">Client: </td>
					<td>{{ $sales_invoice->Client->name }}</td>
				</tr>
				
				<tr>
					<td class="poguide-strong">Payment Terms: </td>
					<td>{{ $sales_invoice->Client->payment_terms }}</td>
				</tr>
			</tbody>
		</table>

		@foreach($sales_invoice->InvoiceItems as $invoice_item)
		<br>
		<h3>{{ $invoice_item->Item->name }}</h3><hr>
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
			@if (Auth::user()['role'] == 'General Manager' || Auth::user()['role'] == 'Sales')
			<td>
				{!! Form::open(['route' => ['invoices.generate_pdf', $sales_invoice->id], 'method' => 'get', 'target'=>'_blank']) !!}
					<button class="btn btn-success">Print Invoice</button>
				{!! Form::close() !!}
			</td>
			@endif
			<td>
					<a id="positiveBtn" href="{{ action('SalesInvoicesController@show',[$sales_invoice->id]) }}">&nbsp;<button type="button" class="btn btn-info">Back to Invoice</button>
			</td>
		</tr>
						
@stop