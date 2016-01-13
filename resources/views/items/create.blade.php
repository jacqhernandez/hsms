@extends('layouts.app')
@section('content')

<h2>Create Item</h2>

	{!! Form::open(['route' => ['items.store'], 'method' => 'post' ]) !!}
	@include('items._form')
	{!! Form::close() !!}
	
@stop
