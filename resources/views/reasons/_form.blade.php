<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td> {!! Form::label('reason', 'Reason: ') !!}</td>
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
			<a href="{{ action ('ReasonsController@index') }}"><button type="button" class="btn btn-info">Back to Reasons</button></a>
		@else
			<a href="{{ action ('CollectiblesController@index') }}"><button type="button" class="btn btn-info">Back to Collectibles</button></a>
		@endif
		</div>
</div>
