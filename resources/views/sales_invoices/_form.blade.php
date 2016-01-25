<div>
	@include('includes.required_errors')
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
				<td>{!! Form::label('contact_person', 'Contact Person: ') !!}</td>
				<td>{!! Form::text('contact_person', old('contact_person')) !!}</td>
			</tr>
			
			<tr>
				<td> {!!Form::label('credit_limit', 'Credit Limit: ') !!}</td>
				<td> {!! Form::input('number','credit_limit', old('credit_limit'), ['class' => 'span3', 'step' => '1']) !!} </td>
			</tr>
			
			<tr>
				<td> {!! Form::label('status', 'Status: ') !!} </td>
				<td> {!! Form::select('status', $statusOptions, Input::old('status')) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('payment_terms', 'Payment Terms: ') !!}</td>
				<td>{!! Form::select('payment_terms', $paymentOptions, Input::old('payment_terms')) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('user_id', 'Sales Person: ') !!}</td>
				<td>{!! Form::select('user_id', $userOptions, Input::old('user_id')) !!}</td>
			</tr>
			
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('ClientsController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
	</div>
</div>
