@extends('layouts.app')
@section('content')

<h2>Create Reason</h2>
	{!! Form::open(['route' => ['reasons.store'], 'method' => 'post' ]) !!}
	@include('reasons._form')
	{!! Form::close() !!}

@stop
