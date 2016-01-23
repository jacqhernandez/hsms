@extends('layouts.app')
@section('content')

<h2 class="sub-header">New Sales Invoice</h2><hr>
<p><b>Date Today:</b> <?php echo date("m/d/Y")?></p>
<p><b>Time:</b> <?php date_default_timezone_set("Singapore"); echo date("h:i a")?></p>
<h3 class="sub-header">Add Quotation</h3>

<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th>SKU</th>
      <th>Payment Terms</th>
      <th>Due Date</th>
      <th>Total Amount</th>
      <th>Current Status</th>
      <th>View</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td></td>
    </tr>   
  </tbody>
</table>
</div>


<button type="button" class="btn btn-primary" onclick="location.href=''">Create New Sales Invoice</button>

@stop