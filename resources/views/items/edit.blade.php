@extends('layouts.app')
@section('content')

<h2>Edit Item</h2>

	{!! Form::model($item, ['method' => 'PATCH', 'action' => ['ItemsController@update', $item->id]]) !!}
	@include('items._form')
	{!! Form::close() !!}

@stop
