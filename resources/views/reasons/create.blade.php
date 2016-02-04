@extends('layouts.app')
@section('content')

<h2>Create Reason</h2>
	{!! Form::open(['route' => ['reasons.store'], 'method' => 'POST' ]) !!}
	@include('reasons._form')
	{!! Form::close() !!}

@stop
