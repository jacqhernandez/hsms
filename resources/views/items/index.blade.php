@extends('layouts.app')
@section('content')
<br>
<h2>Items</h2>
<hr>

{!!  Form::open(['route' => ['items.search'], 'method' => 'get', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
<div class="form-group">
{!!  Form::text('query', null, ['placeholder' => 'Item Name or Description', 'class' => 'form-control'])  !!} 
</div>
{!!  Form::submit('Search', ['class' => 'btn btn-default'])  !!}
{!!  Form::close() !!}

<br><br>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Name</th>
			<th>Unit</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($items as $item)
		<tr>
			<td>{{ $item->name }}</td>
			<td>{{ $item->unit}} </td>
			<td>{{ $item->description }}</td>
			@if (Auth::user()['role'] == 'General Manager')
				<td>
					{!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete', 'id'=>'delete' ]) !!}
						<?php echo"
						<button id='btndelete".$item->id."' class='btn btn-danger' type='button' data-toggle='modal' data-target='#confirmDelete".$item->id."'>
								Delete
	    			</button>" ?>
					<?php echo'
						<div class="modal fade" id="confirmDelete'.$item->id.'" role="dialog" aria-hidden="true">' ?>
	  				@include('includes.delete_confirm')
					<?php echo '</div>' ?>
					{!! Form::close() !!}
				</td>
			@endif
			@if (Auth::user()['role'] == 'General Manager' || Auth::user()['role'] == 'Accounting') 
				<td>
					{!! Form::open(['route' => ['items.edit', $item->id], 'method' => 'get' ]) !!}
					{!! Form::button('Edit', ['type' => 'submit', 'class' => 'btn']) !!}
					{!! Form::close() !!}
				</td>
			@endif
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $items->render(); ?>
@if (Auth::user()['role'] == 'General Manager' || Auth::user()['role'] == 'Accounting') 
	<a href="{{ url('/items/create') }}" class="btn btn-primary">New Item</a>
@endif
@stop