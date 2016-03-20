<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ') !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('telephone_number', 'Telephone Number: ') !!}</td>
				<td> {!! Form::text('telephone_number', old('telephone_number'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('address', 'Address: ') !!} </td>
				<td> {!! Form::textarea('address', old('address'), ['class' => 'span7 form-control', 'rows' => '2']) !!}</td>
			</tr>
			
			<tr>
				<td>{!! Form::label('email', 'Email: ') !!}</td>
				<td>{!! Form::email('email', old('email'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			
			<tr>
				<td> {!! Form::label('tin', 'TIN: ') !!} </td>
				<td> {!! Form::input('number', 'tin', old('tin'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('contact_person', 'Contact Person: ') !!}</td>
				<td>{!! Form::text('contact_person', old('contact_person'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('accounting_contact_person', 'Accounting Contact Person: ') !!}</td>
				<td>{!! Form::text('accounting_contact_person', old('accounting_contact_person'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('accounting_email', 'Accounting Email: ') !!}</td>
				<td>{!! Form::text('accounting_email', old('accounting_email'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			<tr>
				<td> {!!Form::label('credit_limit', 'Credit Limit: ') !!}</td>
				<td> {!! Form::input('number','credit_limit', old('credit_limit'), ['class' => 'span3 form-control', 'step' => '1', 'min'=>0]) !!} </td>
			</tr>
			
			<tr>
				<td> {!! Form::label('status', 'Status: ') !!} </td>
				<td> {!! Form::select('status', $statusOptions, Input::old('status'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('payment_terms', 'Payment Terms: ') !!}</td>
				<td>{!! Form::select('payment_terms', $paymentOptions, Input::old('payment_terms'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('vat_exempt', 'VAT Exempted? ') !!}</td>
				<td>{!! Form::select('vat_exempt', ['0' => "No", '1' => "Yes"], Input::old('vat_exempt'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('user_id', 'Sales Person: ') !!}</td>
				<td>{!! Form::select('user_id', $userOptions, Input::old('user_id'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
		</tbody> 
	</table>
	
	<br>
	
		@if(\Request::route()->getName() == 'clients.edit')
			@include('includes.update_confirm')
		@else
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		@endif
		
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Back to Clients</button>
		 <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cancel Add/Edit Client</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to Cancel?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <a href="{{ action ('ClientsController@index') }}">
                                <button type="button" class="btn btn-danger">Yes</button>
                            </a>
                </div>
                
              </div>
            </div>
          </div>

</div>
