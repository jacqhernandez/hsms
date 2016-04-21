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
						//$price_logs = PriceLog::where('item_id', $invoice_item->Item->id)->orderBy('created_at', 'desc')->take(3)->orderBy('price','asc')->get();
						$price_logs = DB::table('price_logs AS t1')->select('t1.*')->leftJoin('price_logs AS t2', function( $join ){
    					$join->on( 't1.supplier_id', '=', 't2.supplier_id' );
    					$join->on( 't1.created_at', '<', 't2.created_at' );
    				})->whereNull('t2.created_at')->where('t1.item_id','=',$invoice_item->Item->id)->get();
					?>

					@foreach($price_logs as $price_log)
					<tr>
						<td>{{ $price_log->created_at }}</td>
						<?php $supplier = App\Supplier::find($price_log->supplier_id) ?>
						<td>{{ $supplier->name }}</td>
						<td>{{ $supplier->payment_terms }}</td>
						<td>{{ $supplier->telephone_number }}</td>
						<td>{{ $supplier->email }}</td>
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