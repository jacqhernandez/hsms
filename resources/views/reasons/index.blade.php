@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS ALL THE REASONS PAGE</p>
	</div>
	<div>
		<table> 
			<thead>
				<tr>
					<th>Reason</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($reasons as $reason)
				<tr>
					<td>{{ $reason->reason }}</td>
					
					<td>{!! Form::open(['route' => ['reasons.show', $reason->id], 'method' => 'get' ]) !!}
						<button>View Reason</button>
						{!! Form::close() !!}</td>
				</tr>
				@endforeach
			</tbody> 
		</table>
	</div>
	<a href="{{ url('/reasons/create') }}">New Reason</a>
</div>
@stop
