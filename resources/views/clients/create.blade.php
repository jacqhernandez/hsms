@extends('layouts.app')
@section('content')

<h2>Create Client</h2>
<hr>

	{!! Form::open(['route' => ['clients.store'], 'method' => 'post' ]) !!}
	@include('clients._form')
	{!! Form::close() !!}
	
@stop
