@extends('layouts.app')
@section('content')

@if(!isset($type))
	<h2>Choose Report Type</h2>

	<div>
	{!! Form::open(['route' => ['reports.generate'], 'method' => 'get'])  !!}

	<div>
	    <select onchange="this.form.submit()" class="form-control" name="type" value="{{ old('type') }}">
	        <option value="Sales">Sales</option>
	        <option value="Collections">Collections</option>
	        <option value="Clients">Clients</option>
	        <option value="Items">Items</option>
	    </select>
	</div>
	{!! Form::close() !!}
	</div>
@else

	<h2>Generate {{ $type }} Report</h2>
	{!! Form::open(['route' => ['reports.result'], 'method' => 'get'])  !!}
		@if ($type == 'Items')
			{!! Form::label('item', 'Item: ') !!}
			{!! Form::select('item', $items) !!}
		@elseif ($type == 'Collections')

		@elseif ($type == 'Sales')

		@else
			{!! Form::label('client', 'Client: ') !!}
			{!! Form::select('client', $clients) !!}
		@endif
	{!! Form::submit('Submit', ['class' => 'btn'])  !!}
	{!! Form::close() !!}
@endif

@stop