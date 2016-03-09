<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td>{!! Form::label('date', 'Date:') !!}</td>
				<td> {!! Form::date('date', old('date'), ['class' => 'span7']) !!} </td>
			</tr>

			<tr>
				<td>{!! Form::label('actionlbl', 'Action:') !!}</td>
				<td> {!! Form::select('action', $actionOptions, 
					Input::old('action'), ['class' => 'span7, form-control']) !!} </td>
			</tr>

			<!-- <tr>
				<td>{!! Form::label('flwuplbl', 'Follow-Up Date:') !!}</td>
				<td> {!! Form::input('date', 'follow_up_date', old('follow_up_date'), 
					['class' => 'span7, form-control', 'placeholder' => 'Date', 'visible' => 'false']) !!}</td>
			</tr> -->

			<tr id="note">
				<td>{!! Form::label('noteslbl', 'Notes:') !!}</td>
				<td>{!! Form::textarea('note', old('note'), ['class' => 'span7, form-control']) !!}</td>
			</tr>
			<tr id="reason">
				<td>{!! Form::label('reasonslbl', 'Reason:') !!}</td>
				<td> {!! Form::select('reason_id', $reasonOptions, Input::old('reason'), ['class' => 'span7, form-control']) !!}</td>
				<td>
					<a href="{{ url('/reasons/create') }}">Add Reason</a>
				</td>
			</tr>	
			<tr>
				<td>{!! Form::label('status', 'Status: ') !!}</td>
				<td>{!! Form::select('status', $statusOptions, Input::old('status'), ['class'=> 'span7, form-control', 'id'=>'status_select']) !!}</td>
			</tr>
		</tbody> 
	</table>
	<table class="table table-hover sortable">
		<thead>
			<tr>
				<th></th>
				<th>Sales Invoice</th>
				<th>Status</th>
				<th>Amount</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($salesinvoices as $salesinvoice)
			<tr>
				<?php
				if ($method == 'post')
				{
					$salescount = 0;
				}
				else
				{
					$salescount = App\SalesInvoiceCollectionLog::where('client_id', '=', $salesinvoice->client_id)
									->where('sales_invoice_id', '=', $salesinvoice->id)
									->where('collection_log_id', '=', $cLog->id)
									->count();
				}		
				?>
				@if ($salescount != 0)
				<td> {!! Form::checkbox('check_list['.$salesinvoice->id.']', $salesinvoice->id, 'true') !!} </td>
				@else
				<td> {!! Form::checkbox('check_list['.$salesinvoice->id.']', $salesinvoice->id) !!} </td>
				@endif
				<td> {{ $salesinvoice->si_no }} </td>
				<td> {{ $salesinvoice->status }} </td>
				<td> {{ $salesinvoice->total_amount }} </td>
				<?php $date = Carbon\Carbon::parse($salesinvoice->date)->toFormattedDateString(); ?>
				<td> {{ $date }} </td>
			</tr>
			@endforeach
		</tbody>
	</table>	
	<br>
	{!! Form::hidden('client_id', $id) !!}
	<div class = "submit">
		{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
		<a href="{{ action ('CollectionLogsController@index', $id ) }}"><button type="button" class="btn btn-info">Back to Collection Logs</button></a>
	</div>
</div>

<script>

$('#reason').hide();


$( document ).ready(function() {
    if($('#status_select').val() == 'To Do')
    {
		$('#reason').hide();
    }

    else
    {
		$('#reason').show();
    }
});


$('#status_select').change(function() {
	if($(this).val() == 'To Do')
	{
		$('#reason').hide();
	}

	else
	{
		$('#reason').show();
	}
});
</script>