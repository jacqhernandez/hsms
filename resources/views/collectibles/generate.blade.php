<head>
	<title>SOA_{{ $client['name'] }}_<?php echo date("m/d/Y")?></title>
	<!-- <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet"> -->
	<!-- <link href="{{ URL::asset('/bower_components/bootstrap/dist/css/bootstrap.css')}}" rel="stylesheet"> -->
	
	<style type="text/css">
		#yeurico-logo {
			font-family: cambria;
			float: left;
			display: inline;
		}

		#yeurico-logo #soa-y{
			font-size: 30;
			color: red;
		}

		#yeurico-logo #soa-E{
			font-size: 50;
			font-style: italic;
			color: red;
		}

		#yeurico-logo #company-name{
			font-size: 18;
			color: #244062;
			margin-left: 2%;
		}

		#soa-soa{
			float: right;
			display: block;
			text-align: right;
			font-size: 20;
			font-family: "Arial";
			margin-top: -30;
			color: #244062;
		}

		#soa-header2{
			margin-top: 30px;
			display: table;
			width: 100%;
		}

		.soa-row{
			display:table-row;
			width: 100%;
			color: #244062;
		}

		#soa-to{
			display: table-cell;
			width: 48%;
			padding: 8px;
			border-width: 1px;
			border-style: solid;
			border-color: black;
		}

		#soa-details1 {
			display:table-cell;
			text-align: right;
			width: 35%;
			border-style: solid;
			border-width: 0px 1px 0px 0px;
			padding-right: 10px;
			border-color: #244062;
		}

		#soa-details2{
			display:table-cell;
			text-align: right;
		}

		#dues-table{
			width: 100%;
			margin-top: 10%;
		}

		table {
			border-collapse: collapse;
			background-color: #e3e3e3;
			color: #244062;
		}

		thead {
			text-align: center;
		}

		table, th, td {
    		border: 1px solid #1f497d;
    		height: 20px;
		}

		#th-date, #th-duedate{
			width: 13%;
		}

		.td-date, .td-duedate, .td-PO, .td-invoice{
			text-align: center;
			font-size: 14px;
		}

		.td-bal{
			text-align: right;
			padding-right: 8%;
			font-size: 14px;
		}

		.white-td{
			background-color: white;
			border: none;
		}

		#bal-forward{
			text-align: right;
			padding-right: 8%;
		}

		#bal-total{
			text-align: right;
		}

		#bottom-table-message{
			text-align: right;
			padding-right: 10%;
			color: #244062;
		}

		#soa-From{
			display: table-cell;
			width: 48%;
			padding: 8px;
			border-width: 1px;
			border-style: solid;
			border-color: black;
			font-size: 12px;
		}

		#soaFooter-details1 {
			display:table-cell;
			text-align: right;
			width: 35%;
			border-style: solid;
			border-width: 0px 1px 0px 0px;
			padding-right: 10px;
			border-color: #244062;
			padding-top: 20px;
			font-size: 14px;
		}

		#soaFooter-details2{
			display:table-cell;
			text-align: right;
			border-style: solid;
			border-width: 0px 0px 1px 0px;
			padding-top: 20px;
		}

		#soa-footer{
			display:table;
			width: 100%;
			margin-top: 3%;
		}


		.soa-table{
			display:table;
			width: 720px;
		}

		.soa-cell{
			display:table-cell;
			width: 50%;
		}

		.additionalText{
			font-size: 11px;
		}

		#soaRow-Text{
			margin-top: 20px;
		}

		#additionalText{
			padding-left: 20px;
		}
		
		#approvedBy{
			padding-left: 120px;
		}

	</style>
</head>
	<div id="soa-header1">
		<div class =".col-md-8" id="yeurico-logo"><span id="soa-y">Y</span><span id="soa-E">E</span>
			<span id="company-name">YEURICO ENTERPRISES</span></div>
		<div class=".col-md-4" id="soa-soa">STATEMENT OF
			<br>ACCOUNT</div>
	</div>

	<div id="soa-header2">
		<div class="soa-row">
		<div id="soa-to">To: {{$client->name}}<br> Attn: {{$client->accounting_contact_person}}<br> Address: {{$client->address}} </div>
		<div id="soa-details1">
			<p>Statement Date</p>
			<p>Amount Due</p>
		</div>
		<div id="soa-details2">
			<p><?php echo date("F d, Y")?></p>
			<p><b>PHP <?php echo number_format($totalDue[0]->sumTotal, 2) ?></b></p>
		</div>
	</div>
	</div>

<?php $x = 0 ?>
	<div id="soa-body">
		<table id="dues-table">
			<thead>
				<tr>
				<td id="th-date">Date</td>
				<td id="th-duedate">Due Date</td>
				<td id="th-PO">Purchase Order No.</td>
				<td id="th-invoice">Invoice No.</td>
				<td id="th-bal">Balance</td>
			</tr>
			</thead>
			<tbody>
				@foreach ($currentCollectibles as $collectible)
				<tr>
					<td class="td-date">{{$collectible->date}}</td>

					@if ($collectible->due_date < date("m/d/y"))
					<td class="td-duedate"><b>Immediately</b></td>
					@else
					<td class="td-duedate">{{$collectible->due_date}}</td>
					@endif

					<td class="td-PO">{{$collectible->po_number}}</td>
					<td class="td-invoice">{{$collectible->si_no}}</td>
					<td class="td-bal">{{number_format($collectible->total_amount, 2)}}</td>
				</tr>
				<?php $x += 1?>
				@endforeach

				@for ($z = $x; $z < 11; $z++)
					<tr>
						<td class="td-date"></td>
						<td class="td-duedate"></td>	
						<td class="td-PO"></td>
						<td class="td-invoice"></td>
						<td class="td-bal"></td>
					</tr>
				@endfor

					<tr>
						<td class="white-td"></td>
						<td class="white-td"></td>
						<td colspan="2" id="bal-forward"><b>BALANCE FORWARD:</b></td>
						<td class="white-td" id="bal-total"><b>PHP <?php echo number_format($totalDue[0]->sumTotal, 2) ?></b></td>
					</tr>
			</tbody>
		</table>
		<div id="bottom-table-message"><b>Please pay last amount in Balance Column</b></div>
	</div>

	<div id="soa-footer">
		<div class="soa-row">
			<div id="soa-From">From:
				<br>#8325 San Fernando St. San Antonio Valley 8 Parañaque City
				<br>TEL NO: (02) 846-7650 (02) 846-9653 FAX: (02) 825-2306
				<br>Email Address: yeurico@yahoo.com.ph
			</div>

			<div id="soaFooter-details1">
				<p><b>Amount Due</b></p>
			</div>

			<div id="soaFooter-details2">
				<p>PHP <?php echo number_format($totalDue[0]->sumTotal, 2) ?></p>
			</div>
		</div>
	</div>

<br>
	<div class="soa-table">
		<div class="soa-row" id="soaRow-Text">
			<div class="soa-cell">
				<b class="additionalText">MAKE ALL CHECKS PAYABLE TO: Yeurico Enterprises</b>
			</div>
			<div class="soa-cell" id="addressText">
				<b class="additionalText">ADDRESS QUESTIONS TO: Charo Co, Accounting Clerk</b>
			</div>
		</div>
	</div>

<br>
<br>
	<div class="soa-table">
		<div class="soa-row">
			<div class="soa-cell">
				Prepared by:
				<br><br> ____________________
				<br><i>Charo Co
				<br> Accounting Clerk</i>
			</div>
			<div class="soa-cell" id="approvedBy">
				Approved by:
				<br><br> ____________________
				<br><i>Simonette A. Crisologo
				<br>Accounting Manager</i>
			</div>
		</div>
	</div>
<br>
<br>
	<div style="text-align:center; width: 100%; color:#244062">
		<b>THANKYOU FOR YOUR BUSINESS!</b>
</div>
