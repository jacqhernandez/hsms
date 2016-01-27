@extends ('layouts.app')
@section('content')
	@include('includes.required_errors')
		<h2>{{ $client->name }}</h2>
		<h3>Sales Invoices</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Sales Invoice Number</th>
					<th>Status</th>
					<th>Total Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($salesinvoices as $salesinvoice)
				<tr>
					<td>{{ $salesinvoice->SalesInvoice->si_no }}</td>
					<td>{{ $salesinvoice->SalesInvoice->status }}</td>
					<td>{{ $salesinvoice->SalesInvoice->total_amount }}</td>
				</tr>
				@endforeach		
			</tbody>
		</table>
		<h3>Collection Log Details</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Date</th>
					<th>Action</th>
					<th>Follow-Up Date</th>
					<th>Notes</th>
					<th>Reason</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<?php 
					$date = Carbon\Carbon::parse($cLog->date)->toFormattedDateString();
					$follow_up_date = Carbon\Carbon::parse($cLog->follow_up_date)->toFormattedDateString();
					?>
					<td>{{ $date }}</td>
					<td>{{ $cLog->action }}</td>
					<td>{{ $follow_up_date }}</td>
					<td>{{ $cLog->note }}</td>
					<td>{{ $cLog->Reason->reason }}</td>
				</tr>
			</tbody>
		</table>
	<table>
	<tr>
	@if (Auth::user()['role'] == 'General Manager')
	@endif
	<td>
	<a href="{{ URL::previous() }}"><button type="button" class="btn btn-info">Back</button></a>	
	</td>
	</tr>
	</table>
						
@stop