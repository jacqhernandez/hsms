@extends('layouts.app')
@section('content')
<br>
<h2>Reasons</h2>
<hr>
<table class="table table-hover"> 
	<thead>
		<tr>
			<th>Reason</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($reasons as $reason)
		<tr>
			<td>{{ $reason->reason }}</td>
			
			<td><a href="{{ action ('ReasonController@show', [$reason->id]) }}"><button type="button" class="btn btn-info"> View</button></a></td>
		</tr>
		@endforeach
	</tbody> 
</table>

<a href="{{ url('/reasons/create') }}"><button type="button" class="btn btn-info">New Reason</button></a>
@stop
