@extends('layouts.app')
@section('content')

<h2>Add to Item List</h2>
<hr>

	{!! Form::open(['route' => ['invoices.newItem'], 'method' => 'post' ]) !!}
	@include('invoice_items._form')
	{!! Form::hidden('salesId', $salesId) !!}
	{!! Form::close() !!}
	
@stop
