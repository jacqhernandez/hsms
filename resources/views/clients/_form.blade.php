<div>
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ') !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('telephone_number', 'Telephone Number: ') !!}</td>
				<td> {!! Form::text('telephone_number', old('telephone_number'), ['class' => 'span7']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('address', 'Address: ') !!} </td>
				<td> {!! Form::text('address', old('address')) !!}</td>
			</tr>
			
			<tr>
				<td>{!! Form::label('email', 'Email: ') !!}</td>
				<td>{!! Form::email('email', old('email'), ['class' => 'span7']) !!}</td>
			</tr>
			
			
			<tr>
				<td> {!! Form::label('tin', 'TIN: ') !!} </td>
				<td> {!! Form::input('number', 'tin', old('tin')) !!}</td>
			</tr>
			
			<tr>
				<td> {!!Form::label('credit_limit', 'Credit Limit: ') !!}</td>
				<td> {!! Form::input('number','credit_limit', old('credit_limit'), ['class' => 'span3', 'step' => '1']) !!} </td>
			</tr>
			
			<tr>
				<td> {!! Form::label('status', 'Status: ') !!} </td>
				<td> {!! Form::select('status', $statusOptions, null) !!}</td>
			</tr>
			
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('ClientsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
	</div>
</div>
