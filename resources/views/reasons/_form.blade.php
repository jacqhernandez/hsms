<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('reason', 'Reason: ') !!}</td>
				<td> {!! Form::text('reason', old('reason'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('ReasonsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
	</div>
</div>
