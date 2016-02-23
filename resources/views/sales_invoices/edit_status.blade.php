@extends('layouts.app')
@section('content')

<h2 class="sub-header">Update Status</h2><hr>
<h3 class="sub-header">Invoice #<?php echo $sales_invoice->si_no ?></h3>
<p><b>Client:</b> <?php echo $sales_invoice->Client->name ?></p>
<p><b>Date Created:</b> <?php echo $sales_invoice->date ?></p>
@if ($sales_invoice->status == "Delivered") <p><b>Due Date:</b> <?php echo $sales_invoice->due_date ?> @endif</p>
<p><b>Total Amount:</b> Php <?php echo $sales_invoice->total_amount ?></p>
<p><b>Payment Terms:</b> <?php echo $sales_invoice->Client->payment_terms ?></p>

	{!! Form::model($sales_invoice, ['method' => 'PATCH', 'action' => ['SalesInvoicesController@update', $sales_invoice->id]]) !!}

	<div>
		@include('includes.required_errors')
		<table> 
			<tbody>
				<tr>
					<td>{!! Form::label('status', 'Status: ') !!}</td>
					<td>{!! Form::select('status', ['Pending' => "Pending", 'Delivered' => "Delivered", 'Collected' => "Collected", "Check on Hand" => "Check on Hand"], Input::old('status'), ['class' => 'span7 form-control']) !!}</td>
				</tr>
				<tr id="collected">
					<td>{!! Form::label('date_collected', 'Date Collected: ') !!}</td>
					<td>{!! Form::date('date_collected', old('date_collected'), ['class' => 'span7 form-control']) !!} </td>
				</tr>
				<tr id="due">
					<td>{!! Form::label('date_collected', 'Due Date: ') !!}</td>
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
			<a href="{{ action ('SalesInvoicesController@index') }}"><button type="button" class="btn btn-info">Back to Invoices</button></a>
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
		});
	</script>

@stop
