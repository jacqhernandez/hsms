@extends('layouts.app')
@section('content')

<h2>Add New Log</h2>

	{!! Form::open(['action' => ['CollectionLogsController@store', $id], 'method' => 'POST']) !!}
	@include('collection_logs._form')
	{!! Form::close() !!}
	
@stop
