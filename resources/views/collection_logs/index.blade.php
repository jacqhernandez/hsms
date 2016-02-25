@extends('layouts.app')
@section('content')
<br>
<h1> {{ $client->name }} </h1>
<h2>Sales Invoices: {{$pending}} Pending, {{$overdue}} Overdue, {{$delivered}} Delivered</h2>
<hr>
@include('flash::message')
<table>
	<td>
	{!! Form::open(['route' => ['collectibles.generate_pdf', $client->id], 'method' => 'get', 'target'=>'_blank']) !!}
	<button class="btn btn-success">Generate SOA</button>
	{!! Form::close() !!}
	</td>		
	<td> &nbsp; &nbsp; &nbsp;
	</td>
	<td>
	{!! Form::open(['route' => ['collectibles.email_pdf', $client->id], 'method' => 'get' ]) !!}
	<button class="btn btn-warning">Email SOA</button>
	{!! Form::close() !!}
	</td>
</table>
@if ($pending !=0)
<h3>Pending Sales Invoices</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Total Amount</th>
		</tr>
	</thead>

	<tbody>
		
			@foreach ($pendings as $p)
			<tr>
				<td>{{ $p->si_no }}</td>
				<td>{{ $p->total_amount}}</td>
				<td>
					{!! Form::open(['route' => ['invoices.show', $p->id], 'method' => 'get' ]) !!}
					<button class="btn btn-danger">View Details</button>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
@endif
@if ($overdue !=0)
<h3>Overdue Sales Invoices</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Total Amount</th>
		</tr>
	</thead>

	<tbody>
		
			@foreach ($overdues as $o)
			<tr>
				<td>{{ $o->si_no }}</td>
				<td>{{ $o->total_amount}}</td>
				<td>
					{!! Form::open(['route' => ['invoices.show', $o->id], 'method' => 'get' ]) !!}
					<button class="btn btn-danger">View Details</button>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
@endif
@if ($delivered !=0)
<h3>Delivered Sales Invoices</h3>
<table class="table table-hover sortable">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
			@foreach ($delivereds as $d)
			<tr>
				<td>{{ $d->si_no }}</td>
				<td>{{ $d->total_amount}}</td>
				<td>
					{!! Form::open(['route' => ['invoices.show', $d->id], 'method' => 'get' ]) !!}
					<button class="btn btn-primary">View Details</button>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
@endif
<script>
function confirmDelete()
{
	var x = confirm("Are you sure you want to delete this log?");
	if (x)
	return true;
	else
	return false;
}
</script>
<h1>Collection Logs for {{ $client->name }}</h1>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Date</th>
			<th>Action</th>
			<th>Follow-Up Date</th>
			<th>Notes</th>
			<th>Reason</th>
			<th>Sales Invoices</th>
			
		</tr>
	</thead>
	
	<tbody>
		@foreach ($collection_logs as $cLog)
		<tr>
			<?php 
			$date = Carbon\Carbon::parse($cLog->date)->toFormattedDateString();
			$follow_up_date = Carbon\Carbon::parse($cLog->follow_up_date)->toFormattedDateString();

			$salesinvoices = App\SalesInvoiceCollectionLog::join('clients', 'sales_invoice_collection_logs.client_id', '=', 'clients.id')
                   ->join('sales_invoices', 'sales_invoice_collection_logs.sales_invoice_id', '=', 'sales_invoices.id')
                   ->join('collection_logs', 'sales_invoice_collection_logs.collection_log_id', '=', 'collection_logs.id')
                   ->where('sales_invoice_collection_logs.client_id', $cLog->client_id)
                   ->where('sales_invoice_collection_logs.collection_log_id', $cLog->id)
                   ->where('sales_invoices.status', '!=', 'Collected')
                   ->select('*')
                   ->get();
			?>

			<td>{{ $date }}</td>
			<td>{{ $cLog->action }}</td>
			<td>{{ $follow_up_date }}</td>
			<td>{{ $cLog->note }}</td>
			<td>{{ $cLog->Reason->reason }}</td>
			<td>
				@foreach($salesinvoices as $salesinvoice)
				<a href="{{ action ('SalesInvoicesController@show', [$salesinvoice->SalesInvoice->id])}}">{{$salesinvoice->SalesInvoice->si_no}}</a>
				<br>
				@endforeach
			</td>
			<td>
				{!! Form::open(['route' => ['collectibles.collection_logs.edit', $client->id, $cLog->id], 'method' => 'get' ]) !!}
				{!! Form::button('Edit', ['type' => 'submit', 'class' => 'btn']) !!}
				{!! Form::close() !!}
			</td>
			<td>
				{!! Form::open(['route' => ['collectibles.collection_logs.destroy', $cLog->id, $client->id], 'onsubmit' => 'return confirmDelete()', 'method' => 'delete' ]) !!}
				<button class="btn btn-danger">Delete</button>
				{!! Form::close() !!}
			</td>	
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $collection_logs->render(); ?>
<a href="{{ action ('CollectionLogsController@create', [$client->id] ) }}"><button type="button" class="btn btn-primary">New Log</button></a>
<a href="{{ action ('CollectiblesController@index') }}"><button type="button" class="btn btn-info">Back to Collectibles</button></a>
@stop