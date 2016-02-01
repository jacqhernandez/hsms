@extends('layouts.app')
@section('content')

<h2>Add New Log</h2>

	{!! Form::open(['route' => ['collectibles.collection_logs.store'], 'method' => 'post' ]) !!}
	@include('collection_logs._form')
	{!! Form::close() !!}
	
@stop
