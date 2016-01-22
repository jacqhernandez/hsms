<div>
	<table> 
		<thead>
			<tr>
				<th>Date</th>
				<th>Action</th>
				<th>Follow-Up Date</th>
				<th>Notes</th>
				<th>Reason</th>
			</tr>
		</thead>

		<tbody>
			<tr>
				
				<td> {!! Form::input('date', 'date', old('date'), 
					['class' => 'form-control', 'placeholder' => 'Date']) !!} </td>
				<td> {!! Form::select('action', $actionOptions, 
					Input::old('action')) !!} </td>
				<td> {!! Form::input('date', 'follow_up_date', old('follow_up_date'), 
					['class' => 'form-control', 'placeholder' => 'Date', 'visible' => 'false']) !!}</td>
				<td>{!! Form::text('note', old('note'), ['class' => 'span7']) !!}</td>
				<td> {!! Form::select('reason_id', $reasonOptions, Input::old('reason')) !!}</td>

			</tr>	
			<tr>
				<td> {!! Form::hidden('client_id', $id) !!}</td>
			</tr>		
		</tbody> 
	</table>
	
	<br>
	{!! Form::hidden('invisble', $id) !!}
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('CollectionLogsController@index', $id ) }}"><button type="button" class="btn btn-info">Back</button></a>
	</div>

	@if ($errors->any())
		<ul class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	@endif
</div>
