@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS THE CREATE REASONS PAGE</p>
	</div>
	{!! Form::open(['route' => ['reasons.store'], 'method' => 'post' ]) !!}
	@include('reasons._form')
	{!! Form::close() !!}
</div>
@stop
