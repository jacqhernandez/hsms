<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td>{!! Form::label('item_id', 'Item: ') !!}</td>
				<td>{!! Form::select('item_id', $itemOptions, Input::old('item_id'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			<tr>
				<td> {!! Form::label('quantity', 'Quantity: ') !!}</td>
				<td> {!! Form::input('number', 'quantity', old('quantity'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('unit_price', 'Price Per Unit: ') !!}</td>
				<td> {!! Form::input('number', 'unit_price', old('unit_price'), array('step' => '0.01', 'class' => 'span7')) !!} </td>
			</tr>
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		@if(\Request::route()->getName() == 'invoiceitems.edit')
			@include('includes.update_confirm')
		@else
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		@endif
		<button type="button" class="btn btn-info" onclick="history.go(-1);">Back </button>
	</div>
</div>
