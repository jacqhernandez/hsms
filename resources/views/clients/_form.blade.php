<div>
	<table> 
		<tbody>
			<tr>
				<td class="span3 right"> {!! Form::label('name', 'Name: ') !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7']) !!} </td>
			</tr>	
			<tr>
				<td class="span3 right">{!! Form::label('email', 'Email: ') !!}</td>
				<td>{!! Form::email('email', old('email'), ['class' => 'span7']) !!}</td>
			</tr>
			<tr>
				<td class="span3 right">{!! Form::label('credit_limit', 'Credit Limit: ') !!}</td>
				<td> {!! Form::input('number','credit_limit', old('credit_limit'), ['class' => 'span3', 'step' => '1']) !!} </td>
			</tr>
		</tbody> 
	</table>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-warning']) !!}
	</div>
</div>