<div>
	<table>
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ') !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('telephone_number', 'Telephone Number: ') !!} </td>
				<td> {!! Form::input('number', 'telephone_number', old('telephone_number')) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('tin', 'TIN: ') !!} </td>
				<td> {!! Form::input('number', 'tin', old('tin')) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('address', 'Address: ') !!} </td>
				<td> {!! Form::text('address', old('address')) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('email', 'E-mail: ') !!} </td>
				<td> {!! Form::email('email', old('email')) !!}</td>
			</tr>
			
		</tbody> 
	</table>
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('SuppliersController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
	</div>
</div>