<div>
	<table> 
		<tbody>
			<tr>
				<td class="span3 right"> {!! Form::label('name', 'Name: ') !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7']) !!} </td>
			</tr>
			<tr>
				<td class="span3 right"> {!! Form::label('description', 'Description: ') !!}</td>
				<td> {!! Form::text('description', old('description'), ['class' => 'span7']) !!} </td>
			</tr>	
		</tbody> 
	</table>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-warning']) !!}
	</div>
</div>