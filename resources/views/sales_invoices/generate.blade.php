<?php
	require app_path().'\Carbon\Carbon.php';
	use Carbon\Carbon;
?>
<head>
	<title>Print - Sales Invoice {{ $sales_invoice['si_no'] }}</title>
	<!-- Favicon -->
    <link rel="icon" type="image/png" href="http://localhost/hsms/public/img/Logo.png">
    <link rel="icon" type="image/ico" href="http://localhost/hsms/public/img/Logo.ico">
    <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">

	<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">

	<!-- Custom CSS for Printing-->	
	<style type="text/css">
		@page{
			margin-top:0px;
			margin-left:18px;
			margin-right:18px;
			margin-bottom:0px;
			size:a4 portrait;
			color:#000000;
			background-image:none;
		}

		body{
			background: transparent;
			/*background-image: url('http://localhost/hsms/public/img/Sales%20Invoice%20-%20A4.jpg');*/
			background-repeat: no-repeat;
			margin-top: 0px;
			background-position: -10px 3px;
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


		.table3{
			border: none;
			border-collapse: collapse;
			width:100%;
			position:absolute;
			left:0px;
			top:528.5px;
		}

		.table4{
			border: none;
			border-collapse: collapse;
			width:100%;
			position:absolute;
			left:40px;
			top:650px;

		}
		
		/* 
		.table{
			border: 1px solid #000;
			width:100%;
		}

		.table2{
			border: 1px solid #000;
			width:100%;
			font-size: 10pt;
		}

		.table3{
			border: 1px solid #000;
			width:100%;
			position:absolute;
			left:0px;
			top:528.5px;
			text-overflow: ellipsis; 
			overflow: hidden; 
			white-space:nowrap;
		}

		.table4{
			border: 1px solid #000;
			width:100%;
			position:absolute;
			left:40px;
			top:650px;
			text-overflow: ellipsis; 
			overflow: hidden; 
			white-space:nowrap;
		}
		*/

		.filler{
			background: none;
		}

		td{
			border: none;  
		}
	</style>
</head>

<body>

	<div class="filler" style="height:120px; visibility: hidden;">Invoice {{ $sales_invoice['si_no'] }}</div>
	<div class="filler" style="height:32px;"></div>

	<!-- Date -->
	<table class="table2" style="width:100%;">
		<tr>
			<td style="width:530px;">&nbsp;</td>
			<td style="width:87px; visibility:hidden;">Date: </td>
			<!--<td style="font-size:11pt; width:auto;">{{ $sales_invoice['date'] }}</td>-->
			<td style="font-size:11pt; width:auto;">
			<?php
				$c = new Carbon($sales_invoice['date']);
				echo $c->format('M. j, Y');
			?>
			</td>
		</tr>
	</table>
	<div class="filler" style="height:16px;"></div>
	<!-- Sold to -->
	<table class="table2">
			<tr>
				<td style="width:75px;  visibility:hidden;">Sold to: </td>
				<td style="font-size:11pt; text-indent:25px;">{{ $sales_invoice->Client->name }}</td>

			</tr>
	</table>

	<div class="filler" style="height:2px;"></div>
	<!-- TIN/SC-TIN: -->
	<table class="table2">
			<tr>
				<td style="width:77px;  visibility:hidden;">TIN/SC-TIN: </td>
				<td style="font-size:11pt; text-indent:25px; width:300px">{{ $sales_invoice->Client->tin }}</td>
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

	<div class="filler" style="height:6px;"></div>
	<!-- Address -->
	<table class="table2">
			<tr>
				<td style="width:57px;  visibility:hidden;">Address: </td>
				<td style="text-indent:25px;">{{ $sales_invoice->Client->address }}</td>
			</tr>
	</table>

	<div class="filler" style="height:17px;"></div>
	<!-- Customer ID | PO Number | Payment Terms -->
	<table class="table" style="text-align:center;">
			<tr style="font-size: 11pt;  visibility:hidden;">
				<td style="width:208px;">Customer ID</td>
				<td style="width:auto; ">PO Number</td>
				<td style="width:208px;">Payment Terms</td>
			</tr>
			<tr>
				<td>{{ $sales_invoice->Client->customer_id }}</td>
				<td>PO# {{ $sales_invoice['po_number'] }}</td>
				<td>{{ $sales_invoice->Client->payment_terms }}</td>
			</tr>
	</table>

	<div class="filler" style="height:35px;"></div>
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
			<tr style="font-size:10pt;">
				<td style="text-align: center;">{{$item->quantity}}</td>
				<td style="text-align: center; text-indent: 10px;">{{$item->unit}}</td>
				<td style="text-align: left; text-indent: 20px;">{{$item->name}}</td>
				<td>&nbsp;</td>
				<td style="text-align: left; text-indent: 10px;">{{ number_format($item->unit_price,2) }}</td>
				<td style="text-align: left; text-indent: 10px;">{{ number_format($item->total_price,2) }}</td>
			</tr>
			@endforeach
	</table>

	<div>
		<table class="table4" style="text-align:center;">
				<tr>
					<td style="width:70px;">&nbsp;</td>
					<td style="width:65px;">&nbsp;</td>
					<td style="width:auto;">** NOTHING FOLLOWS **</td>
					<td style="width:94px;">&nbsp;</td>
					<td style="width:92px;">&nbsp;</td>
					<td style="width:97px;">&nbsp;</td>
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
		</table>
	</div>

	<div>
	<table class="table3" style="text-align:center;">
				<tr>
					<td style="width:70px;">&nbsp;</td>
					<td style="width:65px;">&nbsp;</td>
					<td style="width:auto;">&nbsp;</td>
					<td style="width:94px;">&nbsp;</td>
					<td style="width:92px;">&nbsp;</td>
					<td style="width:97px;">&nbsp;</td>
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
					<!-- For VAT Computation -->
					<?php 
						$vat_rate = 0.12; 
						$divisor = 1.12;
					?>
					@if (($sales_invoice->Client->vat_exempt == 'VAT Exclusive') || ($sales_invoice->Client->vat_exempt == 'VAT Inclusive'))
						<td style="font-size:11pt; text-align: left; text-indent: 5px;"><div style="margin-top:-12px;">{{ number_format(( ($sales_invoice['total_amount'] / $divisor) * $vat_rate), 2) }}</div></td>
					@else
						<td>&nbsp;</td>
					@endif
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=2 style="font-size:9pt; text-align: right; font-weight: bold; visibility: hidden;">TOTAL AMOUNT DUE&nbsp;</td>
					<td style="font-size:11pt; text-align: left; text-indent: 5px;">{{ number_format($sales_invoice['total_amount'], 2) }}</td>
				</tr>
		</table>
	</div>
	<div class="filler" style="height:150px;"></div>

</body>