@extends('layouts.app')
@section('content')

<h2>Create Item</h2>
<hr>
	{!! Form::open(['route' => ['items.store'], 'method' => 'post' ]) !!}
	@include('items._form')
	{!! Form::close() !!}
	
@stop
