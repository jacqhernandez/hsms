@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS THE CREATE ITEMS PAGE</p>
	</div>
	{!! Form::open(['route' => ['items.store'], 'method' => 'post' ]) !!}
	@include('items._form')
	{!! Form::close() !!}
</div>
@stop
