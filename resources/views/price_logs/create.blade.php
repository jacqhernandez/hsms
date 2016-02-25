@extends('layouts.app')
@section('content')

<h2>Create Price Log</h2>

	{!! Form::open(['route' => ['price_logs.store2'], 'method' => 'post' ]) !!}
	@include('price_logs._form')
	{!! Form::close() !!}
	
@stop
