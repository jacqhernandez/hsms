@extends('layouts.app')
@section('content')
<br>
<h2>Reasons</h2>
<hr>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Reason</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($reasons as $reason)
		<tr>
			<td>{{ $reason->reason }}</td>
		</tr>
		@endforeach
	</tbody> 
</table>
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/reasons/create') }}">New Reason</a>
@endif

@stop
