<div>
	<table> 
		<tbody>
			<tr>
				<td>Date</td>
				<td> {!! Form::input('date', 'date', old('date'), 
					['class' => 'span7, form-control', 'placeholder' => 'Date']) !!} </td>
			</tr>

			<tr>
				<td>Action</td>
				<td> {!! Form::select('action', $actionOptions, 
					Input::old('action'), ['class' => 'span7, form-control']) !!} </td>
			</tr>

			<tr>
				<td>Follow-Up Date</td>
				<td> {!! Form::input('date', 'follow_up_date', old('follow_up_date'), 
					['class' => 'span7, form-control', 'placeholder' => 'Date', 'visible' => 'false']) !!}</td>
			</tr>

			<tr>
				<td>Notes</td>
				<td>{!! Form::text('note', old('note'), ['class' => 'span7, form-control']) !!}</td>
			</tr>
			<tr>
				<td>Reason</td>
				<td> {!! Form::select('reason_id', $reasonOptions, Input::old('reason'), ['class' => 'span7, form-control']) !!}</td>
				<td>
					<a href="{{ url('/reasons/create') }}">Add Reason</a>
				</td>
			</tr>	
		</tbody> 
	</table>
	<table>
		<thead>
			<tr>
				<th></th>
				<th>Sales Invoice Number Involved</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($salesinvoices as $salesinvoice)
			<tr>
				<td> {!! Form::checkbox('check_list['.$salesinvoice->id.']', $salesinvoice->id) !!}</td>
				<td> {{ $salesinvoice->si_no }} </td>
			</tr>
			@endforeach
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