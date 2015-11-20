@extends ('layouts.app')
@section('content')
	@include('includes.required_errors')
	<div>
		<p>THIS IS THE SHOW REASONS PAGE</p>
		<table width="100%">
			<tbody>
				<tr>
					<td>Reason: {{ $reason['reason']}}</td>
				</tr>
			</tbody>
		</table>
	</div>
	{!! Form::open(['route' => ['reasons.destroy', $reason->id], 'method' => 'delete' ]) !!}
		<button>Delete Reason</button>
	{!! Form::close() !!}
	{!! Form::open(['route' => ['reasons.edit', $reason->id], 'method' => 'get' ]) !!}
		<button>Edit Reason</button>
	{!! Form::close() !!}										
@stop
				