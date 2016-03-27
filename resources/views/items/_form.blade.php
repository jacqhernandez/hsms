<div>
	@include('includes.required_errors')
	<table id="form-blades"> 
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
		
			<tr>
				<td> {!! Form::label('unit', 'Unit: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::text('unit', old('unit'), ['class' => 'span7 form-control']) !!} </td>
			</tr>
		
			<tr>
				<td> {!! Form::label('description', 'Description: ') !!}</td>
				<td> {!! Form::text('description', old('description'), ['class' => 'span7 form-control']) !!} </td>
			</tr>
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		@if(\Request::route()->getName() == 'items.edit')
			@include('includes.update_confirm')
		@else
			{!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
		@endif
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Back to Items</button>
		<div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cancel Add/Edit Item</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to Cancel?</p>
                            </div>
                            <div class="modal-footer">
                            <a href="{{ action ('ItemsController@index') }}" id="positiveBtn">
                                <button type="button" class="btn btn-danger">Yes</button>
                            </a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
                
              </div>
            </div>
          </div>

	</div>
</div>
