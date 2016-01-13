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
		@if (Auth::user()['role'] == 'General Manager')
			<td>
				{!! Form::open(['route' => ['reasons.destroy', $reason->id], 'method' => 'delete' ]) !!}
					<button class="btn btn-warning">Delete</button>
				{!! Form::close() !!}
			</td>
			<td>
				{!! Form::open(['route' => ['reasons.edit', $reason->id], 'method' => 'get' ]) !!}
				{!! Form::button('Edit', ['type' => 'submit', 'class' => 'btn']) !!}
				{!! Form::close() !!}
			</td>
		@endif
		</tr>
		@endforeach
	</tbody> 
</table>
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/reasons/create') }}">New Reason</a>
@endif

@stop
