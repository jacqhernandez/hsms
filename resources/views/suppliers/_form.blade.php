<div>
	@include('includes.required_errors')
	<table>
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7 form-control']) !!} </td>
			</tr>

			<tr>
				<td> {!! Form::label('description', 'Description: ') !!}</td>
				<td> {!! Form::text('description', old('description'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('telephone_number', 'Telephone Number: ', ['class' => 'required-field']) !!} </td>
				<td> {!! Form::input('number', 'telephone_number', old('telephone_number'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('tin', 'TIN: ', ['class' => 'required-field']) !!} </td>
				<td> {!! Form::input('number', 'tin', old('tin'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('address', 'Address: ', ['class' => 'required-field']) !!} </td>
				<td> {!! Form::textarea('address', old('address'), ['class' => 'span7 form-control', 'rows' => '2']) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('email', 'E-mail: ', ['class' => 'required-field']) !!} </td>
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
		@if(\Request::route()->getName() == 'suppliers.edit')
			@include('includes.update_confirm')
		@else
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		@endif
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Back to Suppliers</button>
		<div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cancel Add/Edit Supplier</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to Cancel?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <a href="{{ action ('SuppliersController@index') }}">
                                <button type="button" class="btn btn-danger">Yes</button>
                            </a>
                </div>
                
              </div>
            </div>
          </div>
	</div>
</div>