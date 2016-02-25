@extends('layouts.app')
@section('content')

<h2>Edit Item</h2>

	{!! Form::model($price_log, ['method' => 'PATCH', 'action' => ['PriceLogsController@update', $price_log->id]]) !!}
	@include('price_logs._form')
	{!! Form::close() !!}

@stop
