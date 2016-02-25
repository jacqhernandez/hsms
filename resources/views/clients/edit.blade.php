@extends('layouts.app')
@section('content')

<h2>Edit Client</h2>
	{!! Form::model($client, ['method' => 'PATCH', 'action' => ['ClientsController@update', $client->id], 'id' => 'form']) !!}
	@include('clients._form')
	{!! Form::close() !!}

@stop
