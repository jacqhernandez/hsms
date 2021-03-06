@extends ('layouts.app')
@section('content')
		<h2>{{ $client['name'] }}</h2>
		<table class="table">
			<tbody>
				<tr>
					<td>Telephone Number: </td>
					<td>{{ $client['telephone_number'] }}</td>
				</tr>
				
				<tr>
					<td>Address: </td>
					<td>{{ $client['address'] }}</td>
				
				<tr>
					<td>Email: </td>
					<td>{{ $client['email'] }}</td>
				</tr>
			
				<tr>
					<td>TIN: </td>
					<td>{{ $client['tin'] }}</td>
				</tr>

				<tr>
					<td>Contact Person: </td>
					<td>{{ $client['contact_person'] }}</td>
				</tr>

				<tr>
					<td>Accounting Contact Person: </td>
					<td>{{ $client['accounting_contact_person'] }}</td>
				</tr>

				<tr>
					<td>Accounting Email: </td>
					<td>{{ $client['accounting_email'] }}</td>
				</tr>
				
				<tr>
					<td>Credit Limit: </td>
					<td>{{ number_format($client['credit_limit'], 2) }}</td>
				</tr>
				
				<tr>
					<td>Payment Terms: </td>
					<td>{{ $client['payment_terms'] }}</td>
				</tr>

				<tr>
					<td>Status:</td>
					<td>{{ $client['status'] }}</td>
				</tr>

				<tr>
					<td>VAT</td>
					<td>{{ ($client['vat_exempt']) }}</td>
				</tr>

				<tr>
					<td>Sales Employee: </td>
					<td>{{ $client->User->username }}</td>
				</tr>
			</tbody>
		</table>

	<br>

	<h2>List of Sales Invoices</h2>
	<table class="table">
		<thead>
			<tr>
				<th>Invoice No.</th>
				<th>Client</th>
				<th>Date</th>
				<th>Due Date</th>
				<th>Total Amount</th>
				<th>Payment Terms</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($sales_invoices as $sales_invoice)
				<tr>
					<td>@if ($sales_invoice->si_no == 0) ----- @else {{ $sales_invoice->si_no }} @endif</td>
					<td>{{ $sales_invoice->Client->name }}</td>

					<?php $date = Carbon\Carbon::parse($sales_invoice->date)->toFormattedDateString(); ?>
					<td>{{ $date }}</td>

					<?php $duedate = Carbon\Carbon::parse($sales_invoice->due_date)->toFormattedDateString(); ?>
					<td>@if ($sales_invoice->status == "Draft" || $sales_invoice->status == "Pending" || $sales_invoice->Client->payment_terms == "PDC") ----- @else {{ $duedate }} @endif</td>
					<td>{{ number_format($sales_invoice->total_amount, 2) }}</td>
					<td>{{ $sales_invoice->Client->payment_terms}}</td>
					<td>{{ $sales_invoice->status }}</td>
				</tr>
			@endforeach
		</tbody>
	</table>		

	<?php echo $sales_invoices->render(); ?>

	<table id="form-blades">
	<tr>

	@if (Auth::user()['role'] == 'General Manager' OR Auth::user()['role'] == 'Accounting')
	<td>
		{!! Form::open(['route' => ['clients.edit', $client->id], 'method' => 'get' ]) !!}
			<button class="btn btn-warning">Edit Client</button>
		{!! Form::close() !!}		
	</td>
	<td>
		{!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete', 'id'=>'delete' ]) !!}
				<?php echo"
						<button id='btndelete' class='btn btn-danger' type='button' data-toggle='modal' data-target='#confirmDelete'>
								Delete Client
	    			</button>" ?>
					<?php echo'
						<div class="modal fade" id="confirmDelete" role="dialog" aria-hidden="true">' ?>
	  				@include('includes.delete_confirm')
					<?php echo '</div>' ?>
		{!! Form::close() !!}
	</td>
	@endif
	</table>

	<hr>
	<a href="{{ action ('ClientsController@index') }}"><button type="button" class="btn btn-info">Back to Clients</button></a>	
	
@stop