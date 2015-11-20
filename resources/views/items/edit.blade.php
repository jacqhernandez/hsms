@extends('layouts.app')
@section('content')
<div>
	<div>
		<p>THIS IS THE EDIT ITEMS PAGE</p>
	</div>
	{!! Form::model($item, ['method' => 'PATCH', 'action' => ['ItemsController@update', $item->id]]) !!}
	@include('items._form')
	{!! Form::close() !!}
</div>
@stop
