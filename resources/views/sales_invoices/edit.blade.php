@extends('layouts.app')
@section('content')

<?php
	use App\Item;
	use App\PriceLog;
	use App\Supplier;
?>

<h2>Edit Sales Invoice</h2><hr>
{!! Form::open(array('method' => 'PATCH', 'action' => ['SalesInvoicesController@update', $sales_invoice->id])) !!}
	<!-- {!! Form::model($sales_invoice, ['method' => 'PATCH', 'action' => ['SalesInvoicesController@update', $sales_invoice->id]]) !!}
	 --><table id="form-blades"> 
		@include('includes.required_errors')
		<tbody>
			<tr>
				<td> {!! Form::label('si_no', 'Invoice Number: ') !!}</td>
				<td> {!! Form::text('si_no', old('si_no'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	

			<tr>
				<td>{!! Form::label('client_id', 'Client: ') !!}</td>
				<td>{!! Form::select('client_id', $clientOptions, Input::old('client_id'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
			
			<tr>
				<td> {!! Form::label('po_number', 'PO Number: ') !!}</td>
				<td> {!! Form::text('po_number', old('po_number'), ['class' => 'span7 form-control']) !!} </td>
			</tr>	
			
			<tr>
				<td> {!! Form::label('dr_number', 'DR Number: ') !!} </td>
				<td> {!! Form::text('dr_number', old('dr_number'), ['class' => 'span7 form-control']) !!}</td>
			</tr>
						
			<tr>
				<td> {!! Form::label('due_date', 'Due Date: ') !!} </td>
				<td> {!! Form::date('due_date', old('due_date'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td>{!! Form::label('status', 'Status: ') !!}</td>
				<td>{!! Form::select('status', $statusOptions, Input::old('status'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td> {!! Form::label('date_delivered', 'Date Delivered: ') !!} </td>
				<td> {!! Form::date('date_delivered', old('date_delivered'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td> {!! Form::label('date_collected', 'Date Collected: ') !!} </td>
				<td> {!! Form::date('date_collected', old('date_collected'), ['class' => 'span7 form-control']) !!}</td>
			</tr>

			<tr>
				<td> {!! Form::label('or_number', 'OR Number: ') !!}</td>
				<td> {!! Form::text('or_number', old('or_number'), ['class' => 'span7 form-control']) !!} </td>
			</tr>
			<tr>
				<th>Total Amount: </th>
				<td>Php {{ number_format($sales_invoice->total_amount, 2, '.', ',') }}</td>
			</tr>		

			<tr>
				<td colspan=2><div class="submit" style="float:right;">@include('includes.update_confirm')</div></td>
			</tr>

		</tbody> 
	</table>

	{!! Form::close() !!}

	<hr>
	<br>
	<h3>Item List</h3><hr>
		<div class="table-responsive">
			<table class="table table-striped">
			<thead>
				<tr>
					<th>Item</th>
					<th>Units</th>
					<th>Quantity</th>
					<th>Selling Price per Unit</th>
					<th>Subtotal</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $item)
				<tr>
					<td><?php echo Item::find($item->item_id)->name; ?></td>
					<td><?php echo Item::find($item->item_id)->unit; ?></td>
					<td>{{ $item->quantity }}</td>
					<td>Php {{ number_format($item->unit_price, 2, '.', ',') }}</td>
					<td>Php {{ number_format($item->total_price, 2, '.', ',') }}</td>
					<td><a href="{{ action ('InvoiceItemsController@edit', [$item->id]) }}">
						 <button type="button" class="btn btn-warning">Edit Entry</button></a>
					@if (count($items) > 1)
						{!! Form::open(['route' => ['invoiceitems.destroy', $item->id], 'method' => 'delete']) !!}
								<button type="submit" class="btn btn-danger">Delete Entry</button>
						{!! Form::close() !!}
						<button type="button" id="viewPO" class="btn btn-info" data-toggle="modal" data-target="#myModal">View P.O.</button>

					<div id="myModal" class="modal fade" role="dialog">
				      <div class="modal-dialog modal-sm">

				        <!-- Modal content-->
				        <div class="modal-content">
				          <div class="modal-header">
				            <button type="button" class="close" data-dismiss="modal">&times;</button>
				            <h4 class="modal-title">Latest Price Logs for <?php echo Item::find($item->item_id)->name; ?></h4>
				          </div>
				          <div class="modal-body">
				            <?php $price_logs = PriceLog::where('item_id', $item->item_id)->orderBy('created_at', 'desc')->take(3)->get(); ?>
				            @foreach ($price_logs as $price_log)
				              <p><?php echo Supplier::withTrashed()->find($price_log->supplier_id)->name ?>: Php {{ number_format($price_log->price, 2, '.', ',') }}</p>
				            @endforeach            
				          <div class="modal-footer">
				            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				          </div>
				        </div>
				      </div>
				    </div>

				    <script>
				      $("#viewPO").attr('data-target', '.myModal'+<?php echo $item->id ?>);
				      $("#viewPO").attr('id', 'viewPO'+<?php echo $item->id ?>);
				      $("#myModal").attr('class', 'modal fade myModal'+<?php echo $item->id ?>);
				      $("#myModal").attr('id', 'myModal'+<?php echo $item->id ?>);
				    </script>
					 
					 @endif
					</td>
				</tr>
				@endforeach
			</tbody> 
			</table>

			<a href="{{ action ('InvoiceItemsController@addItem', [$sales_invoice->id]) }}">
				<button type="button" class="btn btn-primary">New Entry for Item List</button>
			</a>
		</div>
	
	<br>
	
	<a href="{{action ('SalesInvoicesController@show', [$sales_invoice->id])}}"><button type="button" class="btn btn-info">Back to View Sales Invoice </button></a>
@stop