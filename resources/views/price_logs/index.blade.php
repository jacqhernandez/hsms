@extends('layouts.app')
@section('content')
<br>
<h2>Price Logs</h2>
<hr>

{!!  Form::open(['route' => ['price_logs.search'], 'method' => 'get', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
<div class="form-group">
{!!  Form::text('query', null, ['placeholder' => 'Supplier or Item', 'class' => 'form-control'])  !!} 
</div>
{!!  Form::submit('Search', ['class' => 'btn btn-success'])  !!}
{!!  Form::close() !!}

<br><br>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Supplier</th>
			<th>Item</th>
			<th>Price</th>
			<th>Stock Available?</th>
			<th>Last Updated Date</th>
			<th class="sorttable_nosort"></th>
			<th class="sorttable_nosort"></th>
		</tr>
	</thead>
	<tbody>
		@foreach ($price_logs as $log)
		<tr>
			<td>{{ $log->Supplier->name }}</td>
			<td>{{ $log->Item->name}} </td>
			<td>{{ number_format($log->price,2) }}</td>
			@if ($log->stock_availability == 1)
			<td>Yes</td>
			@else
			<td>No</td>
			@endif
			<td>{{ $log->date }}</td>
			<td>
				{!! Form::open(['route' => ['price_logs.destroy', $log->id], 'method' => 'delete', 'id'=>'delete' ]) !!}
					<?php echo"
					<button id='btndelete".$log->id."' class='btn btn-danger' type='button' data-toggle='modal' data-target='#confirmDelete".$log->id."'>
							Delete
	    			</button>" ?>
					<?php echo'
					<div class="modal fade" id="confirmDelete'.$log->id.'" role="dialog" aria-hidden="true">' ?>
	  				@include('includes.delete_confirm')
					<?php echo '</div>' ?>
				{!! Form::close() !!}
			</td>
			<td>
				{!! Form::open(['route' => ['price_logs.edit', $log->id], 'method' => 'get' ]) !!}
				{!! Form::button('Edit', ['type' => 'submit', 'class' => 'btn btn-warning']) !!}
				{!! Form::close() !!}
			</td>
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $price_logs->render(); ?>
@if (Auth::user()['role'] == 'General Manager')
	<br><a href="{{ url('/price_logs/create') }}" class="btn btn-primary">Create New Price Log</a><br><br>
@endif
@stop