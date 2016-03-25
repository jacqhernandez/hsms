<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('date', 'Date: ') !!}</td>
				<td> {!! Form::label('datelbl', $date, Input::old('date'), ['class' => 'span7']) !!} </td>
				{!! Form::hidden('date', $date ) !!}
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td> {!! Form::label('supplier', 'Supplier: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::select('supplier_id', $supplierOptions, Input::old('supplier_id'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td> {!! Form::label('item', 'Item: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::select('item_id', $itemOptions, Input::old('item_id'), ['class' => 'span7 form-control']) !!} </td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td> {!! Form::label('price', 'Price: ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::input('number', 'price', old('price'), ['class' => 'span7 form-control', 'step' => '0.01']) !!} </td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td> {!! Form::label('stock_availability', 'Stock Available? ', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::select('stock_availability', $availability, Input::old('stock_availability'), ['class' => 'span7 form-control']) !!} </td>
			</tr>
		</tbody> 
	</table>
	
	<br>
	<div class = "submit">
		@if(\Request::route()->getName() == 'price_logs.edit')
			@include('includes.update_confirm')
		@else
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		@endif
		<a href="{{ action ('PriceLogsController@index') }}"><button type="button" class="btn btn-info">Back to Price Logs</button></a>
	</div>
</div>
