@extends('layouts.app')
@section('content')

<?php
  //namespace App\Http\Controllers;
  use App\Item;
  use App\SalesInvoice;
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
      <td>{!! Form::text('si_no', old('si_no'), array('placeholder'=>'i.e. 3345')) !!}</td>
    </tr>
    <tr>
      <td>PO Number: </td>
      <td>{!! Form::text('po_number', old('po_number')) !!}</td>
    </tr>
    <tr>
      <td>Delivery Number: </td>
      <td>{!! Form::text('dr_number', old('dr_number')) !!}</td>
    </tr>
    <tr>
      <td>Value Added Tax (VAT): </td>
      <td>{!! Form::input('number', 'vat', old('vat')) !!}</td>
    </tr>
    <tr>
      <td>Witholding Tax: </td>
      <td>{!! Form::input('number', 'wtax', old('wtax')) !!}</td>
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
			<th>Total Price</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($items as $item)
		<tr>
			<td><?php echo Item::find($item->item_id)->name; ?></td>
			<td><?php echo Item::find($item->item_id)->unit; ?></td>
			<td>{!! Form::input('number', 'quantity' . $item->id, old('quantity')) !!}</td>
			<td>{!! Form::input('number', 'unit_price' . $item->id, old('unit_price')) !!}</td>
			<td></td>
		</tr>
		@endforeach
	</tbody> 
	</table>
</div>
<br>

<a href="{{ action ('DashboardController@index')}}">
  <button type="button" class="btn btn-primary">Exit</button>
</a>
{!! Form::submit('Save and View P.O. Guide', array('class' => 'btn btn-primary', 'id' => 'generateInvoice', 'disabled' => 'disabled')) !!}
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