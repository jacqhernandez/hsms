<head>
	<title>Invoice {{ $sales_invoice['si_no'] }}</title>
	<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	
	<style type="text/css">
	</style>
</head>

	<h2>Invoice {{ $sales_invoice['si_no'] }}</h2>
	<table class="table">
		<tbody>
			<tr>
				<td>Date: </td>
				<td>{{ $sales_invoice['date'] }}</td>
			</tr>

			<tr>
				<td>Sold to: </td>
				<td>{{ $sales_invoice->Client->name }}</td>
			</tr>
				
			<tr>
				<td>TIN/SC-TIN: </td>
				<td>{{ $sales_invoice->Client->tin }}</td>
			
			<tr>
				<td>OSCA/PWD ID No: </td>
				<td></td>
			</tr>

			<tr>
				<td>PO Number: </td>
				<td>{{ $sales_invoice['po_number'] }}</td>
			</tr>


			<tr>
				<td>Payment Terms: </td>
				<td>{{ $sales_invoice->Client->payment_terms }}</td>
			</tr>

			<tr>
				<td>SI Number: </td>
				<td>SI # {{ $sales_invoice['si_no'] }}</td>
			</tr>
		
			<tr>
				<td>DR Number: </td>
				<td>DR # {{ $sales_invoice['dr_number'] }}</td>
			</tr>

			<tr>
				<td>Vatables Sales: </td>
				<td>ATTN: {{ $sales_invoice->Client->contact_person }}</td>
			</tr>
			
			<tr>
				<td>Add VAT: </td>
				<td>{{ $sales_invoice['vat'] }}</td>
			</tr>
			
			<tr>
				<td>Withholding Tax: </td>
				<td>{{ $sales_invoice['wtax'] }}</td>
			</tr>

			<tr>
				<td>Total Amount Due:</td>
				<td>{{ $sales_invoice['total_amount'] }}</td>
			</tr>

		</tbody>
	</table>

	<div>
	INVOICE ITEMS HERE
	</div>

<body>

</body>