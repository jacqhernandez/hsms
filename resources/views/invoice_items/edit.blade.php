@extends('layouts.app')
@section('content')

<h2>Edit Item Entry</h2>

	{!! Form::model($saleItem, ['method' => 'PATCH', 'action' => ['InvoiceItemsController@update', $saleItem->id]]) !!}
	@include('invoice_items._form')
	{!! Form::close() !!}

@stop
