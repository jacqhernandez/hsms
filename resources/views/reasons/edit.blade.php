@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS THE EDIT REASONS PAGE</p>
	</div>
	{!! Form::model($reason, ['method' => 'PATCH', 'action' => ['ReasonController@update', $reason->id]]) !!}
	@include('reasons._form')
	{!! Form::close() !!}
</div>
@stop
