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
					<td>{!! Form::select('status', ['Pending' => "Pending", 'Delivered' => "Delivered", 'Collected' => "Collected", "Check on Hand" => "Check on Hand", "Overdue" => "Overdue", "Cancelled" => "Cancelled"], Input::old('status'), ['class' => 'span7 form-control']) !!}</td>
				</tr>
				<tr id="collected">
					<td>{!! Form::label('date_collected', 'Date Collected: ') !!}</td>
					<td>{!! Form::date('date_collected', old('date_collected'), ['class' => 'span7 form-control']) !!} </td>
				</tr>
				<tr id="due">
					<td>{!! Form::label('due_date', 'Due Date: ') !!}</td>
					<td>{!! Form::date('due_date', old('due_date'), ['class' => 'span7 form-control']) !!} </td>
				</tr>
				<tr id="delivered">
					<td>{!! Form::label('date_delivered', 'Date Delivered: ') !!}</td>
					<td>{!! Form::date('date_delivered', old('date_delivered'), ['class' => 'span7 form-control']) !!} </td>
				</tr>

				<tr id="or_number">
					<td>{!! Form::label('or_number', 'OR Number: ') !!}</td>
					<td>{!! Form::text('or_number', old('or_number')) !!}</td>
				</tr>
				
				{!! Form::hidden('si_no', old('si_no')) !!}
				{!! Form::hidden('po_number', old('po_number')) !!}
				{!! Form::hidden('dr_number', old('dr_number')) !!}
				{!! Form::hidden('date', old('date')) !!}
				<!-- {!! Form::hidden('due_date', old('due_date')) !!} -->
				{!! Form::hidden('vat', old('vat')) !!}
				{!! Form::hidden('credit_limit', old('credit_limit')) !!}
				{!! Form::hidden('wtax', old('wtax')) !!}
				{!! Form::hidden('client_id', old('client_id')) !!}
				{!! Form::hidden('user_id', old('user_id')) !!}
			</tbody> 
		</table>
		
		<br>
		<div class = "submit">
			@include('includes.update_confirm')
			<a href="{{ action ('SalesInvoicesController@index') }}"><button type="button" class="btn btn-info">Back</button></a>
		</div>

	</div>

	{!! Form::close() !!}

	<script type="text/javascript">
		$('#collected').hide();
		$('#delivered').hide();
		$('#due').hide();
		$('#or_number').hide();

		if($('#status').val() == 'Collected') {
			$('#collected').show();
			$('#or_number').show();
		}

		if($('#status').val() == 'Delivered') {
			$('#delivered').show();
	    	$('#due').show();
		}

		if($('#status').val() == 'Cash on Hand') {
			$('#delivered').show();
	    	$('#due').show();
		}


		$('#status').change(function() {
		    if($(this).val() == 'Collected') {
		        $('#delivered').hide();
		        $('#due').hide();
		        $('#collected').show();
		        $('#or_number').show();
		    }

		    if ($(this).val() == 'Delivered'){
		    	$('#collected').hide();
		    	$('#or_number').hide();
		    	$('#due').show();
		    	$('#delivered').show();
		    }

		    if($(this).val() == 'Pending') {
		        $('#collected').hide();
				$('#delivered').hide();
				$('#due').hide();
				$('#or_number').hide();
		    }

		    if($(this).val() == 'Check on Hand') {
		        $('#collected').hide();
		    	$('#or_number').hide();
		    	$('#due').show();
		    	$('#delivered').show();
		    }
		});
	</script>

@stop
