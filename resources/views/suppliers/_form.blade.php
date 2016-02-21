<div>
	@include('includes.required_errors')
	<table>
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ') !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7 form-control']) !!} </td>
			</tr>

			<tr>
				<td> {!! Form::label('description', 'Description: ') !!}</td>
				<td> {!! Form::text('description', old('description'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('telephone_number', 'Telephone Number: ') !!} </td>
				<td> {!! Form::input('number', 'telephone_number', old('telephone_number'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('tin', 'TIN: ') !!} </td>
				<td> {!! Form::input('number', 'tin', old('tin'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('address', 'Address: ') !!} </td>
				<td> {!! Form::textarea('address', old('address'), ['class' => 'span7 form-control', 'rows' => '2']) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('email', 'E-mail: ') !!} </td>
				<td> {!! Form::email('email', old('email'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('contact_person', 'Contact Person: ') !!}</td>
				<td>{!! Form::text('contact_person', old('contact_person'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			<tr>
				<td>{!! Form::label('payment_terms', 'Payment Terms: ') !!}</td>
				<td>{!! Form::select('payment_terms', $paymentOptions, Input::old('payment_terms'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

		</tbody> 
	</table>
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('SuppliersController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
	</div>
</div>