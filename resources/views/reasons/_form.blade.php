<div>
	<table> 
		<tbody>
			<tr>
				<td class="span3 right"> {!! Form::label('reason', 'Reason: ') !!}</td>
				<td> {!! Form::text('reason', old('reason'), ['class' => 'span7']) !!} </td>
			</tr>	
		</tbody> 
	</table>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-warning']) !!}
	</div>
</div>