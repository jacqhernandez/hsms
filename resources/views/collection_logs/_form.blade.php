<div>
	@include('includes.required_errors')
	<table> 
		<tbody>
			<tr>
				<td>{!! Form::label('date', 'Date:', ['class' => 'required-field']) !!}</td>
				<td> {!! Form::date('date', old('date'), ['class' => 'span7']) !!} </td>
			</tr>

			<tr>
				<td>{!! Form::label('actionlbl', 'Action:', ['class' => 'required-field']) !!}</td>
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
				<td>{!! Form::label('reasonslbl', 'Reason:', ['class' => 'required-field']) !!}</td>
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
	<h3 class='required-field'>Sales Invoices Involved</h3>
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
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Back to Collection Logs</button>
		<div class="modal fade" id="myModal" role="dialog">
    		<div class="modal-dialog modal-sm">
     			<div class="modal-content">
       				<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Cancel Create Collection Action</h4>
        			</div>
        			<div class="modal-body">
          				<p>Are you sure you want to Cancel?</p>
        			</div>
        			<div class="modal-footer">
          				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          			<a href="{{ action ('CollectionLogsController@index', $id ) }}">
            			<button type="button" class="btn btn-danger">Yes</button>
          			</a>
        </div>
        
      </div>
    </div>
  </div>


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