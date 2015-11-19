@extends('layouts.app')
@section('content')
<h2>Edit Supplier</h2>

	{!! Form::model($supplier, ['method' => 'PATCH', 'action' => ['SuppliersController@update', $supplier->id]]) !!}
	@include('suppliers._form')
	{!! Form::close() !!}

@stop