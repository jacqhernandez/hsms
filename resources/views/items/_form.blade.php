<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td> {!! Form::label('unit', 'Unit: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::text('unit', old('unit'), ['class' => 'span7 form-control']) !!} </td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td> {!! Form::label('description', 'Description: ') !!}</td>
				<td> {!! Form::text('description', old('description'), ['class' => 'span7 form-control']) !!} </td>
			</tr>
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('ItemsController@index') }}"><button type="button" class="btn btn-info">Back to Items</button></a>
	</div>
</div>
