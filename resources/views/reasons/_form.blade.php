<div>
	@if ($errors->any())
		<ul class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	@endif
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('reason', 'Reason: ') !!}</td>
				<td> {!! Form::text('reason', old('reason'), ['class' => 'span7']) !!} </td>
			</tr>	
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('ReasonsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
	</div>
</div>
