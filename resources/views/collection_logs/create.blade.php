@extends('layouts.app')
@section('content')

<h2>Create Client</h2>

	{!! Form::open(['route' => ['clients.store'], 'method' => 'post' ]) !!}
	@include('clients._form')
	{!! Form::close() !!}
	
@stop
