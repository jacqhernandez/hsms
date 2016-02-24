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
				{!! Form::open(['route' => ['reasons.destroy', $reason->id], 'method' => 'delete', 'id'=>'delete' ]) !!}
					<?php echo"
						<button id='btndelete".$reason->id."' class='btn btn-danger' type='button' data-toggle='modal' data-target='#confirmDelete".$reason->id."'>
								Delete
	    			</button>" ?>
					<?php echo'
						<div class="modal fade" id="confirmDelete'.$reason->id.'" role="dialog" aria-hidden="true">' ?>
	  				@include('includes.delete_confirm')
					<?php echo '</div>' ?>
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
<?php echo $reasons->render(); ?>
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/reasons/create') }}">New Reason</a>
@endif
@stop
