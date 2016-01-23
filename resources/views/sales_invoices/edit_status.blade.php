@extends('layouts.app')
@section('content')

<h2>Edit Sales Invoice</h2>

	{!! Form::model($sales_invoice, ['method' => 'PATCH', 'action' => ['SalesInvoicesController@update', $sales_invoice->id]]) !!}

	<div>
		@include('includes.required_errors')
		<table> 
			<tbody>
				<tr>
					<td>{!! Form::label('status', 'Status: ') !!}</td>
					<td>{!! Form::select('status', ['Pending' => "Pending", 'Delivered' => "Delivered", 'Overdue' => "Overdue", 'Collected' => "Collected"], Input::old('status'), ['class' => 'span7 form-control']) !!}</td>
				</tr>
				<tr id="collected">
					<td>{!! Form::label('date_collected', 'Date Collected: ') !!}</td>
					<td>{!! Form::date('date_collected', old('date_collected'), ['class' => 'span7 form-control']) !!} </td>
				</tr>
				<tr id="delivered">
					<td>{!! Form::label('date_delivered', 'Date Delivered: ') !!}</td>
					<td>{!! Form::date('date_delivered', old('date_delivered'), ['class' => 'span7 form-control']) !!} </td>
				</tr>
				
				{!! Form::hidden('si_no', old('si_no')) !!}
				{!! Form::hidden('po_number', old('po_number')) !!}
				{!! Form::hidden('dr_number', old('dr_number')) !!}
				{!! Form::hidden('date', old('date')) !!}
				{!! Form::hidden('due_date', old('due_date')) !!}
				{!! Form::hidden('vat', old('vat')) !!}
				{!! Form::hidden('credit_limit', old('credit_limit')) !!}
				{!! Form::hidden('wtax', old('wtax')) !!}
				{!! Form::hidden('client_id', old('client_id')) !!}
				{!! Form::hidden('user_id', old('user_id')) !!}

			</tbody> 
		</table>
		
		<br>
		<div class = "submit">
			{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
			<a href="{{ action ('SalesInvoicesController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
		</div>
	</div>

	{!! Form::close() !!}

	<script type="text/javascript">
		$('#collected').hide();
		$('#delivered').hide();

		if($('#status').val() === 'Collected') {
			$('#collected').show();
		}
		if($('#status').val() === 'Delivered') {
			$('#delivered').show();
		}

		$('#status').change(function() {
		    if($(this).val() === 'Collected') {
		        $('#delivered').hide();
		        $('#collected').show();
		    }

		    if ($(this).val() === 'Delivered'){
		    	$('#collected').hide();
		    	$('#delivered').show();
		    }

		    if($(this).val() === 'Pending') {
		        $('#delivered').hide();
		        $('#collected').hide();
		    }

		    if ($(this).val() === 'Overdue'){
		    	$('#collected').hide();
		    	$('#delivered').hide();
		    }
		});
	</script>

@stop
