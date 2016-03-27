@extends('layouts.app')
@section('content')
<h2>Create Supplier</h2>
<hr>

	{!! Form::open(['route' => ['suppliers.store'], 'method' => 'post' ]) !!}
	@include('suppliers._form')
	{!! Form::close() !!}
	
@stop