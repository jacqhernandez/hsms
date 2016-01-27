@extends('layouts.app')
@section('content')
<br>
<h1> {{ $client->name }} </h1>
<h2>Sales Invoices: {{$overdue}} Overdue, {{$pending}} Pending</h2>
<hr>
@if ($overdue !=0)
<h3>Overdue Sales Invoices</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Status</th>
			<th>Total Amount</th>
		</tr>
	</thead>

	<tbody>
		
			@foreach ($overdues as $o)
			<tr>
				<td>{{ $o->si_no }}</td>
				<td>{{ $o->status}}</td>
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
@if ($pending !=0)
<h3>Pending Sales Invoices</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Status</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
			@foreach ($pendings as $p)
			<tr>
				<td>{{ $p->si_no }}</td>
				<td>{{ $p->status}}</td>
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
<table class="table table-hover"> 
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
		@foreach ($collection_logs as $cLog)
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
			<td>
				{!! Form::open(['route' => ['clients.collection_logs.show', $cLog->client_id, $cLog->id], 'method' => 'get' ]) !!}
				<button class="btn btn-danger">View Details</button>
				{!! Form::close() !!}
			</td>	
			<td>
				{!! Form::open(['route' => ['clients.collection_logs.destroy', $cLog->id, $cLog->client_id], 'onsubmit' => 'return confirmDelete()', 'method' => 'delete' ]) !!}
				<button class="btn btn-danger">Delete</button>
				{!! Form::close() !!}
			</td>	
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $collection_logs->render(); ?>
<a href="{{ action ('CollectionLogsController@create', [$client->id] ) }}">New Log</a>
<a href="{{ action ('ClientsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
@stop