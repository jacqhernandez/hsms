@extends('layouts.app')
@section('content')
<br>
<h1> {{ $client->name }} </h1>
<h2>Sales Invoices: {{$delivered}} Delivered, {{$overdue}} Overdue, {{$check}} Check on Hand</h2>
<hr>
@include('flash::message')
<table>
	<td>
	{!! Form::open(['route' => ['collectibles.generate_pdf', $client->id], 'method' => 'get', 'target'=>'_blank']) !!}
	<button class="btn btn-success">Generate SOA</button>
	{!! Form::close() !!}
	</td>		
	<td> &nbsp; &nbsp; &nbsp;
	</td>
	<td>
	{!! Form::open(['route' => ['collectibles.email_pdf', $client->id], 'method' => 'get' ]) !!}
	<button class="btn btn-warning">Email SOA</button>
	{!! Form::close() !!}
	</td>
</table>
@if ($delivered !=0)
<h3>Delivered Sales Invoices</h3>
<table class="table table-hover sortable">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Total Amount</th>
		</tr>
	</thead>
	<tbody>
			@foreach ($delivereds as $d)
			<tr>
				<td>{{ $d->si_no }}</td>
				<td>{{ $d->total_amount}}</td>
				<td>
					<button type="button" id="confirmCollection" class="btn btn-primary" data-toggle="modal" data-target=".modal-hello">Confirm Collection</button>
						<div id="modalPopper" class="modal fade modal-hello1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<script>
								$("#confirmCollection").attr('data-target', '.modal-hello'+<?php echo $d->id ?>);
								$("#confirmCollection").attr('id', 'confirmCollection'+<?php echo $d->id ?>);
								$("#modalPopper").attr('class', 'modal fade modal-hello'+<?php echo $d->id ?>);
								$("#modalPopper").attr('id', 'modalPopper'+<?php echo $d->id ?>);
							</script>
						  <div class="modal-dialog modal-sm">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Confirm Collection</h4>
						      </div>
						      <div class="modal-body">
						      		<p><b>Sales Invoice No: </b><?php echo $d->si_no ?></p>
						      		<p><b>Total Amount: </b>Php <?php echo number_format($d->total_amount, 2, '.', ',') ?></p>
						      		{!! Form::open(['route' => ['invoices.collectedFromLog'], 'method' => 'post' ]) !!}
						      		{!! Form::hidden('id', $d->id) !!}
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
				</td>
				<td>
					{!! Form::open(['route' => ['invoices.show', $d->id], 'method' => 'get' ]) !!}
					<button class="btn btn-primary">View Details</button>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
@endif
@if ($overdue !=0)
<h3>Overdue Sales Invoices</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Total Amount</th>
		</tr>
	</thead>

	<tbody>
		
			@foreach ($overdues as $o)
			<tr>
				<td>{{ $o->si_no }}</td>
				<td>{{ $o->total_amount}}</td>
				<td>
					<button type="button" id="confirmCollection" class="btn btn-primary" data-toggle="modal" data-target=".modal-hello">Confirm Collection</button>
						<div id="modalPopper" class="modal fade modal-hello1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<script>
								$("#confirmCollection").attr('data-target', '.modal-hello'+<?php echo $o->id ?>);
								$("#confirmCollection").attr('id', 'confirmCollection'+<?php echo $o->id ?>);
								$("#modalPopper").attr('class', 'modal fade modal-hello'+<?php echo $o->id ?>);
								$("#modalPopper").attr('id', 'modalPopper'+<?php echo $o->id ?>);
							</script>
						  <div class="modal-dialog modal-sm">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Confirm Collection</h4>
						      </div>
						      <div class="modal-body">
						      		<p><b>Sales Invoice No: </b><?php echo $o->si_no ?></p>
						      		<p><b>Total Amount: </b>Php <?php echo number_format($o->total_amount, 2, '.', ',') ?></p>
						      		{!! Form::open(['route' => ['invoices.collectedFromLog'], 'method' => 'post' ]) !!}
						      		{!! Form::hidden('id', $o->id) !!}
						      		<p><b>OR Number: </b>{!! Form::input('number', 'or_number', old('or_number'), array('class'=>'itemPrice', 'required'=>'required')) !!}</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						        <button type="submit" class="btn btn-primary">Confirm</button>
						        {!! Form::close() !!}
						      </div>
						    </div>
						  </div>
					</div>
				</td>
				<td>
					{!! Form::open(['route' => ['invoices.show', $o->id], 'method' => 'get' ]) !!}
					<button class="btn btn-primary">View Details</button>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
@endif
@if ($check !=0)
<h3>Check on Hand Sales Invoices</h3>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Sales Invoice Number</th>
			<th>Total Amount</th>
		</tr>
	</thead>

	<tbody>
		
			@foreach ($checks as $c)
			<tr>
				<td>{{ $c->si_no }}</td>
				<td>{{ $c->total_amount}}</td>
				<td>
					<button type="button" id="confirmCollection" class="btn btn-primary" data-toggle="modal" data-target=".modal-hello">Confirm Collection</button>
						<div id="modalPopper" class="modal fade modal-hello1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							<script>
								$("#confirmCollection").attr('data-target', '.modal-hello'+<?php echo $c->id ?>);
								$("#confirmCollection").attr('id', 'confirmCollection'+<?php echo $c->id ?>);
								$("#modalPopper").attr('class', 'modal fade modal-hello'+<?php echo $c->id ?>);
								$("#modalPopper").attr('id', 'modalPopper'+<?php echo $c->id ?>);
							</script>
						  <div class="modal-dialog modal-sm">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Confirm Collection</h4>
						      </div>
						      <div class="modal-body">
						      		<p><b>Sales Invoice No: </b><?php echo $c->si_no ?></p>
						      		<p><b>Total Amount: </b>Php <?php echo number_format($c->total_amount, 2, '.', ',') ?></p>
						      		{!! Form::open(['route' => ['invoices.collectedFromLog'], 'method' => 'post' ]) !!}
						      		{!! Form::hidden('id', $c->id) !!}
						      		<p><b>OR Number: </b>{!! Form::input('number', 'or_number', old('or_number'), array('class'=>'itemPrice', 'required'=>'required')) !!}</p>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
						        <button type="submit" class="btn btn-primary">Confirm</button>
						        {!! Form::close() !!}
						      </div>
						    </div>
						  </div>
					</div>
				</td>
				<td>
					{!! Form::open(['route' => ['invoices.show', $c->id], 'method' => 'get' ]) !!}
					<button class="btn btn-primary">View Details</button>
					{!! Form::close() !!}
				</td>
			</tr>
			@endforeach
	</tbody>
</table>
@endif
<script>
function confirmDelete()
{
	var x = confirm("Are you sure you want to delete this log?");
	if (x)
	return true;
	else
	return false;
}
</script>
<h1>Collection Logs for {{ $client->name }}</h1>
<table class="table table-hover sortable"> 
	<thead>
		<tr>
			<th>Date</th>
			<th>Action</th>
			<!-- <th>Follow-Up Date</th> -->
			<th>Notes</th>
			<th>Reason</th>
			<th>Sales Invoices</th>
			<th>Status</th>
			
		</tr>
	</thead>
	
	<tbody>
		@foreach ($collection_logs as $cLog)
		<tr>
			<?php 
			$date = Carbon\Carbon::parse($cLog->date)->toFormattedDateString();

			$salesinvoices = App\SalesInvoiceCollectionLog::join('clients', 'sales_invoice_collection_logs.client_id', '=', 'clients.id')
                   ->join('sales_invoices', 'sales_invoice_collection_logs.sales_invoice_id', '=', 'sales_invoices.id')
                   ->join('collection_logs', 'sales_invoice_collection_logs.collection_log_id', '=', 'collection_logs.id')
                   ->where('sales_invoice_collection_logs.client_id', $cLog->client_id)
                   ->where('sales_invoice_collection_logs.collection_log_id', $cLog->id)
                   ->select('*')
                   ->get();
			?>

			<td>{{ $date }}</td>
			<td>{{ $cLog->action }}</td>
			
			<td>{{ $cLog->note }}</td>
			@if ($cLog->Reason == null)
			<td>---------</td>
			@else
			<td>{{ $cLog->Reason->reason }}</td>
			@endif
			<td>
				@foreach($salesinvoices as $salesinvoice)
				<a href="{{ action ('SalesInvoicesController@show', [$salesinvoice->SalesInvoice->id])}}">{{$salesinvoice->SalesInvoice->si_no}}</a>
				<br>
				@endforeach
			</td>
			<td>{{ $cLog->status}}</td>
			@if ($cLog->status == 'To Do')
			<td>
				{!! Form::open(['route' => ['collectibles.collection_logs.edit', $client->id, $cLog->id], 'method' => 'get' ]) !!}
				{!! Form::button('Perform Action', ['type' => 'submit', 'class' => 'btn']) !!}
				{!! Form::close() !!}
			</td>
			@else
			<td>&nbsp;</td>
			@endif
			<td>
				{!! Form::open(['route' => ['collectibles.collection_logs.destroy', $cLog->id, $client->id], 'onsubmit' => 'return confirmDelete()', 'method' => 'delete' ]) !!}
				<button class="btn btn-danger">Delete</button>
				{!! Form::close() !!}
			</td>	
		</tr>
		@endforeach
	</tbody> 
</table>
<?php echo $collection_logs->render(); ?>
<br>
<a href="{{ action ('CollectionLogsController@create', [$client->id] ) }}"><button type="button" class="btn btn-primary">Create Collection Action</button></a>
<a href="{{ action ('CollectiblesController@index') }}"><button type="button" class="btn btn-info">Back to Collectibles</button></a>
@stop