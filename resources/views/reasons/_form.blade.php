<div>
	@include('includes.required_errors')
	<table id="form-blades"> 
		<tbody>
			<tr>
				<td> {!! Form::label('reason', 'Reason:', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::text('reason', old('reason'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		@if(\Request::route()->getName() == 'reasons.edit')
			@include('includes.update_confirm')
		@else
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		@endif
		@if(Auth::user()['role'] == 'General Manager')
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Back to Reasons</button>
			 <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cancel Add/Edit Reason</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to Cancel?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <a href="{{ action ('ReasonsController@index') }}">
                                <button type="button" class="btn btn-danger">Yes</button>
                            </a>
                </div>
                
              </div>
            </div>
          </div>

		@else
			<button type="button" class="btn btn-info"  data-toggle="modal" data-target="#myModal">Back to Collectibles</button>
			 <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Cancel Add/Edit Reason</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to Cancel?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            <a href="{{ action ('CollectiblesController@index') }}">
                                <button type="button" class="btn btn-danger">Yes</button>
                            </a>
                </div>
                
              </div>
            </div>
          </div>
		@endif
		</div>
</div>
