@extends ('layouts.app')
@section('content')
	@include('includes.required_errors')
	<script type="text/javascript">
	
	function ConfirmDelete()
	{
		var x = confirm("Are you sure you want to delete?");
		if(x)
			return true;
		else
			return false;
	}
	
	</script>
		<h2>{{ $reason['reason'] }}</h2>
		<table class="table">
			<tbody>
				<tr>
					<td>Reason </td>
					<td>{{ $reason['reason']}}</td>
				</tr>
			
				
			</tbody>
		</table>

	<table>	
	<tr>
	<td>
	{!! Form::open(['route' => ['reasons.edit', $reason->id], 'method' => 'get']) !!}
		<button class="btn btn-warning">Edit</button>
	{!! Form::close() !!}		
	</td>
	<td>
	{!! Form::open(['route' => ['reasons.destroy', $reason->id], 'method' => 'delete', 'onsubmit' => 'return ConfirmDelete()' ]) !!}
		<button class="btn btn-danger">Delete</button>
	{!! Form::close() !!}
	</td>
	<td>
	<a href="{{ action ('ReasonController@index') }}"><button type="button" class="btn btn-info">Back</button></a>	
	</td>
	</table>	

@stop
				