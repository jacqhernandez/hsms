@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS THE EDIT CLIENTS PAGE</p>
	</div>
	{!! Form::model($client, ['method' => 'PATCH', 'action' => ['ClientsController@update', $client->id]]) !!}
	@include('clients._form')
	{!! Form::close() !!}
</div>
@stop
