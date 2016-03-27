@extends('layouts.app')
@section('content')
<h2>Perform Action</h2>

	{!! Form::model($cLog, ['method' => 'patch', 'action' => ['CollectionLogsController@update', $cLog->client_id, $cLog->id]]) !!}

	<div>
	@include('includes.required_errors')
	<table id="form-blades"> 
		<tbody>
			<tr>
				<td class="poguide-strong">Date: </td>

				<td>{{$date}}</td> 
			</tr>

			<tr>
				<td class="poguide-strong">Action: </td>
				<td> {{$cLog->action }} </td>
			</tr>

			<tr>
				<td>{!! Form::label('reasonslbl', 'Reason:') !!}</td>
				<td> {!! Form::select('reason_id', $reasonOptions, Input::old('reason'), ['class' => 'span7, form-control']) !!}</td>
				<td>
					<a class="btn btn-primary" href="{{ url('/reasons/create') }}">Add Reason</a>
				</td>
			</tr>	

			<tr>
				<td>{!! Form::label('noteslbl', 'Notes:') !!}</td>
				<td>{!! Form::textarea('note', old('note'), ['class' => 'span7, form-control']) !!}</td>
			</tr>
		</tbody> 
	</table>
	<br><br>
	<table class="table table-hover sortable">
		<thead>
			<tr>
				<th>Sales Invoice</th>
				<th>Status</th>
				<th>Amount</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($salesinvoices as $salesinvoice)
			<tr>
				
				<td> {{ $salesinvoice->si_no }} </td>
				<td> {{ $salesinvoice->status }} </td>
				<td> {{ $salesinvoice->total_amount }} </td>
				<?php $date = Carbon\Carbon::parse($salesinvoice->date)->toFormattedDateString(); ?>
				<td> {{ $date }} </td>
			</tr>
			@endforeach
		</tbody>
	</table>	
	<br>
	{!! Form::hidden('client_id', $id) !!}
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
		<a href="{{ action ('CollectionLogsController@index', $id ) }}"><button type="button" class="btn btn-info">Back to Collection Logs</button></a>
	</div>
</div>

	{!! Form::close() !!}
	
@stop
