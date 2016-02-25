@extends('layouts.app')
@section('content')
<h2>Edit Log</h2>

	{!! Form::model($cLog, ['method' => 'patch', 'action' => ['CollectionLogsController@update', $cLog->client_id, $cLog->id]]) !!}
	@include('collection_logs._form')
	{!! Form::close() !!}
	
@stop
