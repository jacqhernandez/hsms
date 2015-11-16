@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS THE CREATE CLIENTS PAGE</p>
	</div>
	{!! Form::open(['route' => ['clients.store'], 'method' => 'post' ]) !!}
	@include('clients._form')
	{!! Form::close() !!}
</div>
@stop
