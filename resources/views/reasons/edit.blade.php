@extends('layouts.app')
@section('content')

<h2>Edit Reason</h2>
	{!! Form::model($reason, ['method' => 'PATCH', 'action' => ['ReasonsController@update', $reason->id]]) !!}
	@include('reasons._form')
	{!! Form::close() !!}
</div>
@stop
