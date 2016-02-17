<head>
	<title>Print - Sales Invoice {{ $sales_invoice['si_no'] }}</title>
	<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
	
	<style type="text/css">
		@page{
			margin-top:0px;
			margin-left:18px;
			margin-right:18px;
			margin-bottom:0px;
			size:a4 portrait;
			color:#0000ff;
		}

		.table{
			border: none;
			border-collapse: collapse;
			width:100%;
		}

		.table2{
			border: none;
			border-collapse: collapse;
			width:100%;
			font-size: 10pt;
		}

		td{
			border: none;
		}
	</style>
</head>

<body>

	<div style="height:240px; background:white; visibility: hidden;">Invoice {{ $sales_invoice['si_no'] }}</div>
	<div style="height:32px; background:white;"></div>

	<!-- Date -->
	<table class="table2" style="width:100%;">
		<tr>
			<td style="width:530px;">&nbsp;</td>
			<td style="width:87px; visibility:hidden;">Date: </td>
			<td style="width:auto;">{{ $sales_invoice['date'] }}</td>
		</tr>
	</table>
	<div style="height:19px; background:white;"></div>
	<!-- Sold to -->
	<table class="table2">
			<tr>
				<td style="width:75px;  visibility:hidden;">Sold to: </td>
				<td style="text-indent:25px;">{{ $sales_invoice->Client->name }}</td>

			</tr>
	</table>

	<div style="height:2px; background:white;"></div>
	<!-- TIN/SC-TIN: -->
	<table class="table2">
			<tr>
				<td style="width:77px;  visibility:hidden;">TIN/SC-TIN: </td>
				<td style="text-indent:25px; width:300px">{{ $sales_invoice->Client->tin }}</td>
				<td style="width:113px;  visibility:hidden;">Bus, Name/style: </td>
				<td style="width:auto;"> </td>
			</tr>
	</table>

	<!-- OSCA/PWD ID No -->
	<table class="table2">
			<tr>
				<td style="width:115px; visibility:hidden;">OSCA/PWD ID No: </td>
				<td></td>
			</tr>
	</table>

	<div style="height:6px; background:white;"></div>
	<!-- Address -->
	<table class="table2">
			<tr>
				<td style="width:57px;  visibility:hidden;">Address: </td>
				<td style="text-indent:25px;">{{ $sales_invoice->Client->address }}</td>
			</tr>
	</table>

	<div style="height:13px; background:white;"></div>
	<!-- Customer ID | PO Number | Payment Terms -->
	<table class="table" style="text-align:center;">
			<tr style="font-size: 11pt;  visibility:hidden;">
				<td style="width:208px;">Customer ID</td>
				<td style="width:auto; ">PO Number</td>
				<td style="width:208px;">Payment Terms</td>
			</tr>
			<tr>
				<td>{{ $sales_invoice->Client->id }}</td>
				<td>{{ $sales_invoice['po_number'] }}</td>
				<td>{{ $sales_invoice->Client->payment_terms }}</td>
			</tr>
	</table>

	<div style="height:35px; background:white;"></div>
	<!-- Quantity | Unit/M | Description | Item Code | Unit Price | Amount -->
	<table class="table" style="text-align:center;">
			<tr style="font-size: 10pt;  visibility:hidden;">
				<td style="width:70px;">Quantity</td>
				<td style="width:65px">Unit/M</td>
				<td style="width:auto">Description</td>
				<td style="width:94px;">Item Code</td>
				<td style="width:92px;">Unit Price</td>
				<td style="width:97px;">Amount</td>
			</tr>
			@foreach ($items as $item)
			<tr>
				<td style="text-align: center;">{{$item->quantity}}</td>
				<td style="text-align: center;">{{$item->unit}}</td>
				<td style="text-align: left; text-indent: 10px;">{{$item->description}}</td>
				<td>&nbsp;</td>
				<td style="text-align: left; text-indent: 10px;">{{$item->unit_price}}</td>
				<td style="text-align: left; text-indent: 10px;">{{$item->total_price}}</td>
			</tr>
			@endforeach

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>** NOTHING FOLLOWS **</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>SI# {{ $sales_invoice['si_no'] }}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>DR# {{ $sales_invoice['dr_number'] }}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>ATTN: {{ $sales_invoice->Client->contact_person }}</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr style="visibility: hidden;">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2 style="font-size:9pt; text-align: right;">Total Sales (VAT Inclusive)&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr style="visibility: hidden;">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="font-size:9pt; text-indent: 5px; text-align: left;">VATable Sales</td>
				<td colspan=2 style="font-size:9pt; text-align: right;">Less: VAT&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr style="visibility: hidden;">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="font-size:9pt; text-indent: 5px; text-align: left;">VAT-Exempt Sales</td>
				<td colspan=2 style="font-size:9pt; text-align: right;">Amount: Net of VAT&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr style="visibility: hidden;">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="font-size:9pt; text-indent: 5px; text-align: left;">Zero Rated Sales</td>
				<td colspan=2 style="font-size:9pt; text-align: right;">Less: SC/PWD Discount&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr style="visibility: hidden;">
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td style="font-size:9pt; text-indent: 5px; text-align: left;">VAT Amount</td>
				<td colspan=2 style="font-size:9pt; text-align: right;">Amount Due&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2 style="font-size:9pt; text-align: right; visibility: hidden;">Add: VAT&nbsp;</td>
				<td style="font-size:10pt; text-align: left; text-indent: 5px;">{{ $sales_invoice['vat'] }}</td>
			</tr>

			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2 style="font-size:9pt; text-align: right; font-weight: bold; visibility: hidden;">TOTAL AMOUNT DUE&nbsp;</td>
				<td style="font-size:10pt; text-align: left; text-indent: 5px;">{{ $sales_invoice['total_amount'] }}</td>
			</tr>
	</table>
	<div style="background:white; height:150px;"></div>

</body>