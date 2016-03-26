@extends ('layouts.app')
@section('content')

<?php
	use App\Item;
?>
		<h2>Invoice #{{ $sales_invoice['si_no'] }} - {{ $sales_invoice->Client->name }}</h2>
		<table class="table table-striped">
			<tbody>
				<tr>
					<th>PO Number</th>
					<td>{{ $sales_invoice['po_number'] }}</td>
				</tr>
				
				<tr>
					<th>DR Number</th>
					<td>{{ $sales_invoice['dr_number'] }}</td>
				
				<tr>
					<th>Date Created</th>
					<td><?php echo Carbon\Carbon::parse($sales_invoice->date)->toFormattedDateString();	?></td>
				</tr>

				<tr>
					<th>Sales Employee</th>
					<td>{{ $sales_invoice->User->username }}</td>
				</tr>

				<tr>
					<th>Payment Terms</th>
					<td>{{ $sales_invoice->Client->payment_terms }}</td>
				</tr>

				<tr>
					<th>Date Delivered</th>
					<td>@if ($sales_invoice->date_delivered == 00-00-0000) ----- @else <?php echo Carbon\Carbon::parse($sales_invoice->date_delivered)->toFormattedDateString(); ?> @endif</td>
				</tr>
			
				<tr>
					<th>Due Date</th>
					<td>@if ($sales_invoice->due_date == 00-00-0000) ----- @else <?php echo Carbon\Carbon::parse($sales_invoice->due_date)->toFormattedDateString(); ?> @endif</td>
				</tr>

				<tr>
					<th>Total Amount</th>
					<td>Php {{ number_format($sales_invoice->total_amount, 2, '.', ',') }}</td>
				</tr>

				<tr>
					<th>Status</th>
					<td>{{ $sales_invoice['status'] }}</td>
				</tr>

				@if ($sales_invoice->status == "Delivered" || $sales_invoice->status == "Collected" || $sales_invoice->status == "Check on Hand")
				<tr>
					<th>Date Delivered</th>
					<td><?php echo Carbon\Carbon::parse($sales_invoice->date_delivered)->toFormattedDateString(); ?></td>
				</tr>
				@endif

				@if ($sales_invoice->status == "Collected")
				<tr>
					<th>Date Collected</th>
					<td><?php echo Carbon\Carbon::parse($sales_invoice->date_collected)->toFormattedDateString(); ?></td>
				</tr>
				

				<tr>
					<th>OR Number</th>
					<td>{{ $sales_invoice['or_number'] }}</td>
				</tr>
				@endif

			</tbody>
		</table>
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
				</tr>
			</thead>
			<tbody>
				@foreach ($items as $item)
				<tr>
					<td><?php echo Item::withTrashed()->find($item->item_id)->name; ?></td>
					<td><?php echo Item::withTrashed()->find($item->item_id)->unit; ?></td>
					<td>{{ $item->quantity }}</td>
					<td>Php {{ number_format($item->unit_price, 2, '.', ',') }}</td>
					<td>Php {{ number_format($item->total_price, 2, '.', ',') }}</td>
				</tr>
				@endforeach
			</tbody> 
			</table>
		</div>
	<table class="button-tables">
	<tr>

	@if (Auth::user()['role'] == 'General Manager' || Auth::user()['role'] == 'Sales')
	<td>
		{!! Form::open(['route' => ['invoices.generate_pdf', $sales_invoice->id], 'method' => 'get', 'target' => '_blank' ]) !!}
			<button class="btn btn-success">Print Invoice</button>
		{!! Form::close() !!}	
	</td>

	<td>
		{!! Form::open(['route' => ['invoices.generate_dr', $sales_invoice->id], 'method' => 'get', 'target' => '_blank' ]) !!}
			<button class="btn btn-success">Print Delivery Receipt</button>
		{!! Form::close() !!}	
	</td>
	@endif
	<td>
		<a href="{{ action ('SalesInvoicesController@poGuide', [$sales_invoice->id]) }}"><button class="btn btn-primary">PO Guide</button></a>
	</td>
	@if (Auth::user()['role'] == 'General Manager')
	<td>
		{!! Form::open(['route' => ['invoices.edit', $sales_invoice->id], 'method' => 'get' ]) !!}
			<button class="btn btn-warning">Edit</button>
		{!! Form::close() !!}		
	</td>
	<td>
		{!! Form::open(['route' => ['invoices.destroy', $sales_invoice->id], 'method' => 'delete', 'id' => 'delete' ]) !!}
			<?php echo"
						<button id='btndelete' class='btn btn-danger' type='button' data-toggle='modal' data-target='#confirmDelete'>
								Delete
	    			</button>" ?>
					<?php echo'
						<div class="modal fade" id="confirmDelete" role="dialog" aria-hidden="true">' ?>
	  				@include('includes.delete_confirm')
					<?php echo '</div>' ?>
		{!! Form::close() !!}
	</td>
	@endif

	<td>
	<a href="{{ action ('SalesInvoicesController@index') }}"><button type="button" class="btn btn-info">Back to Invoices</button></a>	
	</td>
	@if (Auth::user()['role'] != 'Sales')
	{
		<td>
		<a href="{{ action ('CollectionLogsController@index', $sales_invoice->client_id) }}"><button type="button" class="btn btn-info">Back to Collection Log</button></a>	
		</td>
	}
	@endif
	</table>
		
@stop