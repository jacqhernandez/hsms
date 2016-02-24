@extends('layouts.app')
@section('content')

<?php
  //namespace App\Http\Controllers;
  use App\Item;
  use App\SalesInvoice;
  use App\PriceLog;
  use App\Supplier;
?>

<h2 class="sub-header">New Sales Invoice</h2><hr>
<p><b>Date Today:</b> <?php echo date("m/d/Y")?></p>
<p><b>Time:</b> <?php date_default_timezone_set("Singapore"); echo date("h:i a")?></p>
<h3 class="sub-header"><?php echo SalesInvoice::find($invoice_id)->Client->name; ?> Sales Invoice</h3>

{!! Form::open(['route' => ['invoices.creation'], 'method' => 'post' ]) !!}

{!! Form::hidden('invoice_no', $invoice_id) !!}

<!-- {!! Form::hidden('item_count', 1, ['class' => 'itemCount']) !!}
 -->

<div class="table-responsive">
  @include('includes.required_errors')
<table class="table">
<!--   <thead>
    <tr>
      <th>Item</th>
      <th>Unit</th>
      <th>Supplier</th>
      <th>Terms</th>
      <th>Price</th>
      <th>Available?</th>
      <th>Update</th>
    </tr>
  </thead> -->
  <tbody>
    <tr>
      <td>Sales Invoice ID: </td>
      <td>{!! Form::text('si_no', old('si_no')) !!}</td>
    </tr>
    <tr>
      <td>PO Number: </td>
      <td>{!! Form::text('po_number', old('po_number')) !!}</td>
    </tr>
    <tr>
      <td>Delivery Number: </td>
      <td>{!! Form::text('dr_number', old('dr_number')) !!}</td>
    </tr>
  </tbody>
</table>
</div>
<div class="table-responsive">
	<table class="table table-striped">
	<thead>
		<tr>
			<th>Item</th>
			<th>Units</th>
			<th>Quantity</th>
			<th>Selling Price per Unit</th>
      <th>Price Logs</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($items as $item)
		<tr>
			<td><?php echo Item::find($item->item_id)->name; ?></td>
			<td><?php echo Item::find($item->item_id)->unit; ?></td>
			<td>{!! Form::input('number', 'quantity' . $item->id, old('quantity')) !!}</td>
			<td>{!! Form::input('number', 'unit_price' . $item->id, old('unit_price'), array('step' => '0.01')) !!}</td>
      <td><button type="button" id="viewPO" class="btn btn-info" data-toggle="modal" data-target="#myModal">View</button><td>
		</tr>
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
              <p><?php echo Supplier::find($price_log->supplier_id)->name ?>: Php {{ number_format($price_log->price, 2, '.', ',') }}</p>
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

		@endforeach
	</tbody> 
	</table>
</div>
<br>

<a href="{{ action ('SalesInvoicesController@index')}}">
  <button type="button" class="btn btn-primary">Exit</button>
</a>
{!! Form::submit('Finish and View Invoice', array('class' => 'btn btn-primary', 'id' => 'generateInvoice', 'disabled' => 'disabled')) !!}
<!-- <button type="button" class="btn btn-primary" id="generateInvoice">Generate Sale Inovoice</button>
 -->{!! Form::close() !!}

<script>
  
function checkButton() {

      $('form input').keyup(function() {
          var empty = false;

          $('form input').each(function() {
              if ($(this).val() == '') {
                  empty = true;
              }
          });

          if (empty) {
              $('#generateInvoice').attr('disabled', 'disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          } else {
              $('#generateInvoice').removeAttr('disabled'); // updated according to http://stackoverflow.com/questions/7637790/how-to-remove-disabled-attribute-with-jquery-ie
          }
      });
  }

  checkButton();

</script>

@stop