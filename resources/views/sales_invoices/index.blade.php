@extends('layouts.app')
@section('content')
<br>
<h2>List of Sales Invoice</h2>
<hr>

{!!  Form::open(['route' => ['invoices.search'], 'method' => 'get', 'class' => 'navbar-form navbar-right', 'role' => 'search'])  !!}
<div class="form-group">
{!!  Form::text('query', null, ['placeholder' => 'SI Number or Client Name', 'class' => 'form-control'])  !!} 
</div>
{!!  Form::submit('Search', ['class' => 'btn btn-default'])  !!}
{!!  Form::close() !!}

{!!  Form::open(['route' => ['invoices.filter'], 'method' => 'get', 'class' => 'navbar-form navbar-right'])  !!}
<div class="form-group">
{!! Form::select('filter_status', [
						'' => 'Filter by Status',
						'Draft' => 'Draft',
						'Pending' => 'Pending',
						'Delivered' => 'Delivered',
						'Collected' => 'Collected',
						'Overdue' => 'Overdue'], 
					 	old('filter_status'), ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
</div>
{!!  Form::close() !!}

{!!  Form::open(['route' => ['invoices.filter'], 'method' => 'get', 'class' => 'navbar-form navbar-right'])  !!}
<div class="form-group">
<?php $dates[''] = "Filter by Due Date"; ?>
{!! Form::select('filter_date', $dates,
					 	old('filter_date'), ['class' => 'form-control', 'onchange' => 'this.form.submit()']) !!}
</div>
{!!  Form::close() !!}

<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Invoice No.</th>
			<th>Client</th>
			<th>Due Date</th>
			<th>Total Amount</th>
			<th>Payment Terms</th>
			<th>Status</th>
		</tr>
	</thead>
	
	<tbody>
		@foreach ($sales_invoices as $sales_invoice)
		@if (!(Auth::user()['role'] == 'Accounting' && ($sales_invoice->status == "Draft" || $sales_invoice->status == "Pending")))
		<tr>
			<td>@if ($sales_invoice->si_no == 0) ----- @else {{ $sales_invoice->si_no }} @endif</td>
			<td>{{ $sales_invoice->Client->name }}</td>
			<?php
				$due_date = Carbon\Carbon::parse($sales_invoice->due_date)->toFormattedDateString();
			?>
			<td>@if ($sales_invoice->status == "Draft" || $sales_invoice->status == "Pending" || $sales_invoice->Client->payment_terms == "PDC") ----- @else {{ $due_date }} @endif</td>
			<td>{{ number_format($sales_invoice->total_amount, 2, '.', ',') }}</td>
			<td>{{ $sales_invoice->Client->payment_terms }}</td>
			<td>{{ $sales_invoice->status }}</td>
			<td>@if ($sales_invoice->status === "Draft") <a href="{{ action ('SalesInvoicesController@make', [$sales_invoice->id]) }}">Finish</a>
				@else <a href="{{ action ('SalesInvoicesController@show', [$sales_invoice->id]) }}">View</a> @endif </td>
			<td>@if ($sales_invoice->status !== "Draft" && Auth::user()['role'] != 'Accounting') <a href="{{ action ('SalesInvoicesController@poGuide', [$sales_invoice->id]) }}">PO Guide</a>@endif</td>
			<td>@if (Auth::user()['role'] == 'Sales')
					@if ($sales_invoice->status === "Pending" )
							<button type="button" id="confirmDelivery" class="btn btn-primary" data-toggle="modal" data-target=".modal-hello">@if ($sales_invoice->Client->payment_terms == 'PDC') PDC Acquired @else Confirm Delivery @endif</button>
								<div id="modalPopper" class="modal fade modal-hello1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
									<script>
										$("#confirmDelivery").attr('data-target', '.modal-hello'+<?php echo $sales_invoice->id ?>);
										$("#confirmDelivery").attr('id', 'confirmDelivery'+<?php echo $sales_invoice->id ?>);
										$("#modalPopper").attr('class', 'modal fade modal-hello'+<?php echo $sales_invoice->id ?>);
										$("#modalPopper").attr('id', 'modalPopper'+<?php echo $sales_invoice->id ?>);
									</script>
								  <div class="modal-dialog modal-sm">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title" id="myModalLabel">@if ($sales_invoice->Client->payment_terms == 'PDC') PDC Acquired @else Confirm Delivery @endif</h4>
								      </div>
								      <div class="modal-body">
								      	@if ($sales_invoice->Client->payment_terms == 'PDC') This confirms that Sales Invoice #<?php echo $sales_invoice->si_no ?> has been delivered to <?php echo $sales_invoice->Client->name ?> today, and the post-dated check has been received as well.
								      	@else
								        This confirms that Sales Invoice #<?php echo $sales_invoice->si_no ?> has been delivered to <?php echo $sales_invoice->Client->name ?> today.
								      	@endif
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								        <a href="{{ action ('SalesInvoicesController@delivered', [$sales_invoice->id]) }}">
								        <button type="submit" class="btn btn-primary">Confirm</button></a>
								      </div>
								    </div>
								  </div>
							</div>
					@endif
				@elseif (Auth::user()['role'] == 'General Manager')
					 	<a href="{{ action ('SalesInvoicesController@editStatus', [$sales_invoice->id]) }}">Update Status</a>
				@else 
					@if ($sales_invoice->status == "Delivered" || $sales_invoice->status == "Check on Hand" )
							<button type="button" id="confirmCollection" class="btn btn-primary" data-toggle="modal" data-target=".modal-hello">Confirm Collection</button>
								<div id="modalPopper" class="modal fade modal-hello1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
									<script>
										$("#confirmCollection").attr('data-target', '.modal-hello'+<?php echo $sales_invoice->id ?>);
										$("#confirmCollection").attr('id', 'confirmCollection'+<?php echo $sales_invoice->id ?>);
										$("#modalPopper").attr('class', 'modal fade modal-hello'+<?php echo $sales_invoice->id ?>);
										$("#modalPopper").attr('id', 'modalPopper'+<?php echo $sales_invoice->id ?>);
									</script>
								  <div class="modal-dialog modal-sm">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title" id="myModalLabel">Confirm Collection</h4>
								      </div>
								      <div class="modal-body">
								      		<p><b>Sales Invoice No: </b><?php echo $sales_invoice->si_no ?></p>
								      		<p><b>Total Amount: </b>Php <?php echo $sales_invoice->total_amount ?></p>
								      		{!! Form::open(['route' => ['invoices.collected'], 'method' => 'post' ]) !!}
								      		{!! Form::hidden('id', $sales_invoice->id) !!}
								      		<p><b>OR Number: </b>{!! Form::text('or_number', old('or_number'), array('class'=>'itemPrice', 'required'=>'required')) !!}</p>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								        <button type="submit" class="btn btn-primary">Confirm</button>
								        {!! Form::close() !!}
								      </div>
								    </div>
								  </div>
							</div>
					@endif
				@endif
			</td>
		</tr>
		@endif
		@endforeach
	</tbody> 
</table>
<!-- Button trigger modal -->

<?php echo $sales_invoices->render(); ?>
@if (Auth::user()['role'] == 'General Manager' || Auth::user()['role'] == 'Sales')
	<a href="{{ url('/invoices/quotation') }}">New Sales Invoice</a>
@endif
<button type="button" class="btn btn-info" onclick="history.go(-1);">Back </button>
@stop
