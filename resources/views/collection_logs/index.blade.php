@extends('layouts.app')
@section('content')
<br>
@foreach ($client as $clients)
<h2>Collection Logs for {{ $clients->name }}</h2>
@endforeach
<hr>
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
				{!! Form::open(['route' => ['clients.collection_logs.destroy', $cLog->id, $cLog->client_id], 'onsubmit' => 'return confirmDelete()', 'method' => 'delete' ]) !!}
				<button class="btn btn-danger">Delete</button>
				{!! Form::close() !!}
			</td>	
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $collection_logs->render(); ?>
@foreach ($client as $clients)
<a href="{{ action ('CollectionLogsController@create', [$clients->id] ) }}">New Log</a>
@endforeach 
@stop
