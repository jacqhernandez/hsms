@extends ('layouts.app')
@section('content')
		<h2>Invoice {{ $sales_invoice['si_no'] }}</h2>
		<table class="table">
			<tbody>
				<tr>
					<td>PO Number: </td>
					<td>{{ $sales_invoice['po_number'] }}</td>
				</tr>
				
				<tr>
					<td>DR Number: </td>
					<td>{{ $sales_invoice['dr_number'] }}</td>
				
				<tr>
					<td>Date Created: </td>
					<td>{{ $sales_invoice['date'] }}</td>
				</tr>

				<tr>
					<td>Sales Employee: </td>
					<td>{{ $sales_invoice->User->username }}</td>
				</tr>

				<tr>
					<td>Payment Terms: </td>
					<td>{{ $sales_invoice->Client->payment_terms }}</td>
				</tr>
			
				<tr>
					<td>Due Date: </td>
					<td>{{ $sales_invoice['due_date'] }}</td>
				</tr>

				<tr>
					<td>Total Amount: </td>
					<td>{{ $sales_invoice['total_amount'] }}</td>
				</tr>
				
				<tr>
					<td>VAT: </td>
					<td>{{ $sales_invoice['vat'] }}</td>
				</tr>
				
				<tr>
					<td>Withholding Tax: </td>
					<td>{{ $sales_invoice['wtax'] }}</td>
				</tr>

				<tr>
					<td>Status:</td>
					<td>{{ $sales_invoice['status'] }}</td>
				</tr>

				<tr>
					<td>Date Delivered:</td>
					<td>{{ $sales_invoice['date_delivered'] }}</td>
				</tr>

				<tr>
					<td>Date Collected:</td>
					<td>{{ $sales_invoice['date_collected'] }}</td>
				</tr>

			</tbody>
		</table>

		INVOICE ITEMS HERE

	<table>
	<tr>

	<td>
		{!! Form::open(['route' => ['invoices.generate_pdf', $sales_invoice->id], 'method' => 'get' ]) !!}
			<button class="btn btn-success">Print Invoice</button>
		{!! Form::close() !!}	
	</td>
	<td>
		{!! Form::open(['route' => ['invoices.edit', $sales_invoice->id], 'method' => 'get' ]) !!}
			<button class="btn btn-warning">Edit</button>
		{!! Form::close() !!}		
	</td>
	<td>
		{!! Form::open(['route' => ['invoices.destroy', $sales_invoice->id], 'method' => 'delete' ]) !!}
			<button class="btn btn-danger">Delete</button>
		{!! Form::close() !!}
	</td>

	<td>
	<a href="{{ action ('SalesInvoicesController@index') }}"><button type="button" class="btn btn-info">Back</button></a>	
	</td>
	</table>
						
@stop