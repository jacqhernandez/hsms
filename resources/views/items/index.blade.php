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
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($items as $item)
		<tr>
			<td>{{ $item->name }}</td>
			<td>{{ $item->description }}</td>
			@if (Auth::user()['role'] == 'General Manager')
				<td>
					{!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete' ]) !!}
						<button class="btn btn-warning">Delete</button>
					{!! Form::close() !!}
				</td>
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
@if (Auth::user()['role'] == 'General Manager')
	<a href="{{ url('/items/create') }}">New Item</a>
@endif
@stop