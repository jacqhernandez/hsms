<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('name', 'Name: ') !!}</td>
				<td> {!! Form::text('name', old('name'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('unit', 'Unit: ') !!}</td>
				<td> {!! Form::text('unit', old('unit'), ['class' => 'span7']) !!} </td>
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
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		@endif
		<a href="{{ action ('ItemsController@index') }}"><button type="button" class="btn btn-info">Back to Items</button></a>
	</div>
</div>
