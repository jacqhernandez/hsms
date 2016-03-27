@extends('layouts.app')
@section('content')

<?php
  //namespace App\Http\Controllers;
  use App\Supplier;
  use App\InvoiceItem;
  use App\SalesInvoice;
  use App\Item;
  use App\PriceLog;
?>

<h2 class="sub-header">New Sales Invoice</h2><hr>
<h3 class="sub-header">Add Quotation</h3><hr><br>

{!! Form::open(['route' => ['invoiceitems.store'], 'method' => 'post' ]) !!}

{!! Form::hidden('item_count', 1, ['class' => 'itemCount']) !!}

@if (Session::get('message') == null)
@else
  <?php 
    echo "<div class='alert alert-danger'>";
    echo Session::get('message'); 
    echo '</div>';
  ?>
@endif



<table style="float:left;">
      <tr>
        <th>Client:</th>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td>
            <?php $clientOptions[""] = "- Select Client -"; ?>
            {!! Form::select('client_id', $clientOptions, Input::old('client_id'), array('class' => 'clientChange', 'selected' => '', 'id' => 'form_control')) !!}
        </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>
      <tr>
</table>

<div class="table-responsive">
  <table class="table table-striped" style="float:right;">
    <tbody>
      <tr>
        <th>Client Status</th>
        <td><p id="clientStatus"></p>
      </tr>
      <tr>
        <th>Contact Person</th>
        <td><p id="contactPerson"></p>
      </tr>
      <tr>
        <th>TIN</th>
        <td><p id="tin"></p>
      </tr>
      <tr>
        <th>Payment Terms</th>
        <td><p id="paymentTerms"></p>
      </tr>
      <tr>
        <th>Credit Limit</th>
        <td><p id="creditLimit"></p>
      </tr>
      <tr>
        <th>Current Credit</th>
        <td><p id="currentCredit"></p>
      </tr>
    </tbody>
  </table>
</div>

<br><br>
<div class="table-responsive">
<table class="table table-striped">
  <thead>
    <tr>
      <th>Item</th>
      <th>Unit</th>
      <th>Supplier</th>
      <th>Terms</th>
      <th>Contact No.</th>
      <th>Price <br>(input 0 if no update)</th>
      <th>Available?</th>
      <th>Last Updated</th>
    </tr>
  </thead>
  <tbody id="itemBody">
    <tr class="superRow">
      <?php $itemOptions[''] = "- Select Item -"; ?>
      <td>{!! Form::select('item_id', $itemOptions, Input::old('item_id'), array('class' => 'itemChange', 'id' => 'form_control')) !!}</td>
      <td><p class="itemUnit"></p></td>
      <?php $supplierOptions[''] = "- Select Supplier -"; ?>
      <?php $supplierOptions1[''] = "- Select Supplier -"; ?>

      <td>{!! Form::select('supplier_id1', $supplierOptions1, Input::old('supplier_id'), array('class' => 'supplierChange', 'id' => 'form_control')) !!}</td>


      <td><p class="supplierTerms"></p></td>
      <td><p class="contact"></p></td>
      <td>{!! Form::input('number', 'item_price', old('item_price'), array('class'=>'itemPrice', 'step'=>'0.01', 'id' => 'form_control',  'onkeypress' => 'return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46')) !!}</td>
      <td>{!! Form::select('availA', array(true=>'Yes', false=>'No'), old(''), array('class'=>'yesNo', 'id' => 'form_control')) !!}</td>
      <td><p class="lastUpdated"></p></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>{!! Form::select('supplier_idB1', $supplierOptions, Input::old('supplier_id'), ['class' => 'supplierChangeB', 'id' => 'form_control']) !!}</td>
      <td><p class="supplierBTerms"></p></td>
      <td><p class="contactB"></p></td>
      <td>{!! Form::input('number', 'item_priceB', old('supplier_id_2'), array('class'=>'itemPriceB', 'step'=>'0.01', 'id' => 'form_control',  'onkeypress' => 'return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46')) !!}</td>
      <td>{!! Form::select('availB', array(true=>'Yes', false=>'No'), old(''), array('class'=>'yesNoB', 'id' => 'form_control')) !!}</td>
      <td><p class="lastUpdatedB"></p></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>{!! Form::select('supplier_idC1', $supplierOptions, Input::old('supplier_id'), ['class' => 'supplierChangeC', 'id' => 'form_control']) !!}</td>
      <td><p class="supplierCTerms"></p></td>
      <td><p class="contactC"></p></td>
      <td>{!! Form::input('number', 'item_priceC', old('supplier_id_3'), array('class'=>'itemPriceC', 'step'=>'0.01', 'id' => 'form_control',  'onkeypress' => 'return (event.charCode >= 48 && event.charCode <= 57) || event.charCode == 46')) !!}</td>
      <td>{!! Form::select('availC', array(true=>'Yes', false=>'No'), old(''), array('class'=>'yesNoC', 'id' => 'form_control')) !!}</td>
      <td><p class="lastUpdatedC"></p></td>
    </tr>
  </tbody>
</table>
</div>

<button type="button" id="addItem" class="btn btn-primary">Add Item</button><br><br>
  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Exit</button>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancel Sales Invoice</h4>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to exit the invoice process? This will discard all changes made.</p>
        </div>
        <div class="modal-footer">
          <a href="{{ action ('SalesInvoicesController@index') }}" id="positiveBtn">
            <button class="btn btn-danger">Yes</button>
          </a>
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
        
      </div>
    </div>
  </div>

<button type="submit" class="btn btn-success" id="generateInvoice" disabled="disabled">Generate Sales Invoice</button>
{!! Form::close() !!}

<script>
jQuery.noConflict();

jQuery( document ).ready(function( $ ) {

  $("select option[value='']").attr("style", "display:none");
  $("select option[value='']").attr("disabled", "disabled");
  $("select option[value='']").attr("selected", "selected");

  var rowCounter = 2;
  var row = $(".superRow").parent().html();

  $(".superRow").attr("class", "superRow1");
  $(".itemChange").attr("class", "itemChange1");
  $(".itemChange1").attr("name", "item_id1");
  $(".clientChange").attr("class", "required clientChange1");
  $(".supplierChange").attr("class", "supplierChange1");
  $(".supplierChangeB").attr("class", "supplierChangeB1");
  $(".supplierChangeC").attr("class", "supplierChangeC1")
  $(".supplierTerms").attr("class", "supplierTerms1");
  $(".supplierBTerms").attr("class", "supplierBTerms1");
  $(".supplierCTerms").attr("class", "supplierCTerms1");
  $(".supplierTerms1").attr("name", "supplier_id1");
  $(".supplierBTerms2").attr("name", "supplier_idB1");
  $(".supplierCTerms3").attr("name", "supplier_idC1");
  $(".itemUnit").attr("class", "itemUnit1");
  $(".itemPrice").attr("class", "itemPrice1");
  $(".itemPriceB").attr("class", "itemPriceB1");
  $(".itemPriceC").attr("class", "itemPriceC1");
  $(".itemPrice1").attr("name", "item_price1");
  $(".itemPriceB1").attr("name", "item_priceB1");
  $(".itemPriceC1").attr("name", "item_priceC1");
  $(".yesNo").attr("class", "yesNo1");
  $(".yesNoB").attr("class", "yesNoB1");
  $(".yesNoC").attr("class", "yesNoC1");
  $(".yesNo1").attr("name", "availA1");
  $(".yesNoB1").attr("name", "availB1");
  $(".yesNoC1").attr("name", "availC1");
  $(".lastUpdated").attr("class", "lastUpdated1");
  $(".lastUpdatedB").attr("class", "lastUpdatedB1");
  $(".lastUpdatedC").attr("class", "lastUpdatedC1");
  $(".contact").attr("class", "contact1");
  $(".contactB").attr("class", "contactB1");
  $(".contactC").attr("class", "contactC1");

  $("#addItem").click(function(){
    //row.find(".superRow").css("background-color", "red");
    $("#itemBody").append(row);

    var newName = "superRow" + rowCounter;
    var newName2 = "supplierTerms" + rowCounter;
    var newName3 = "clientChange" + rowCounter;
    var newName4 = "item_id" + rowCounter;
    var newName5 = "itemChange" + rowCounter;
    var newName6 = "itemUnit" + rowCounter;
    var newName7 = "supplierBTerms" + rowCounter;
    var newName8 = "supplierCTerms" + rowCounter;
    var newName9 = "supplierChange" + rowCounter;
    var newName10 = "supplierChangeB" + rowCounter;
    var newName11 = "supplierChangeC" + rowCounter;
    var newName12 = "itemPrice" + rowCounter;
    var newName13 = "itemPriceB" + rowCounter;
    var newName14 = "itemPriceC" + rowCounter;
    var newName15 = "item_price" + rowCounter;
    var newName16 = "item_priceB" + rowCounter;
    var newName17 = "item_priceC" + rowCounter;
    var newName18 = "yesNo" + rowCounter;
    var newName19 = "yesNoB" + rowCounter;
    var newName20 = "yesNoC" + rowCounter;
    var newName21 = "availA" + rowCounter;
    var newName22 = "availB" + rowCounter;
    var newName23 = "availC" + rowCounter;
    var newName24 = "supplier_id" + rowCounter;
    var newName25 = "supplier_idB" + rowCounter;
    var newName26 = "supplier_idC" + rowCounter;
    var newName27 = "lastUpdated" + rowCounter;
    var newName28 = "lastUpdatedB" + rowCounter;
    var newName29 = "lastUpdatedC" + rowCounter;
    var newName30 = "contact" + rowCounter;
    var newName31 = "contactB" + rowCounter;
    var newName32 = "contactC" + rowCounter;

    $(".superRow").attr("class", newName);
    $(".supplierTerms").attr("class", newName2);
    $(".clientChange").attr("class", newName3);
    $(".itemChange").attr("name", newName4);
    $(".itemChange").attr("class", newName5);
    $(".itemUnit").attr("class", newName6);

    $(".supplierChange").attr("name", newName24);
    $(".supplierChangeB").attr("name", newName25);
    $(".supplierChangeC").attr("name", newName26);

    $(".supplierBTerms").attr("class", newName7);
    $(".supplierCTerms").attr("class", newName8);
    $(".supplierChange").attr("class", newName9);
    $(".supplierChangeB").attr("class", newName10);
    $(".supplierChangeC").attr("class", newName11);

    $(".itemPrice").attr("name", newName15);
    $(".itemPriceB").attr("name", newName16);
    $(".itemPriceC").attr("name", newName17);
    $(".yesNo").attr("name", newName21);
    $(".yesNoB").attr("name", newName22);
    $(".yesNoC").attr("name", newName23);

    $(".itemPrice").attr("class", newName12);
    $(".itemPriceB").attr("class", newName13);
    $(".itemPriceC").attr("class", newName14);
    $(".yesNo").attr("class", newName18);
    $(".yesNoB").attr("class", newName19);
    $(".yesNoC").attr("class", newName20);

    $(".lastUpdated").attr("class", newName27);
    $(".lastUpdatedB").attr("class", newName28);
    $(".lastUpdatedC").attr("class", newName29);
    $(".contact").attr("class", newName30);
    $(".contactB").attr("class", newName31);
    $(".contactC").attr("class", newName32);

    //SUPPLIER
    var caster = "." + newName9;
    $(caster).change(function(a){
      var searcher = a.currentTarget.value;
      var supplierChange = "." + newName2;
      var suppliers = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
      $(supplierChange).text(suppliers[searcher]);
      var supplierChange2 = "." + newName30;
      var suppliers2 = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;
      $(supplierChange2).text(suppliers2[searcher]);
    });

    //ITEM
    var caster2 = "." + newName5;
    $(caster2).select2({
      placeholder: "- Select Item -"
    });


    $(caster2).change(function(a){
      var searcher = a.currentTarget.value;
      var unitChange = "." + newName6;
      var items = <?php echo Item::all()->lists('unit', 'id') ?>;
      $(unitChange).text(items[searcher]);

      $.get('getTopSuppliers', {item: searcher}, function(data){
      
        var terms = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
        var contact = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;

        if (data[0]) {
          $("." + newName9).val(data[0].supplier_id);
          $("." + newName12).attr("placeholder", data[0].price);
          $("." + newName27).text(data[0].date);
          $("." + newName18).val(data[0].stock_availability);
          $("." + newName2).text(terms[data[0].supplier_id]);
          $("." + newName30).text(contact[data[0].supplier_id]);
        } else {
          $("." + newName12).attr("placeholder", "");
          $("." + newName27).text('');
          $("." + newName2).text('');
          $("." + newName30).text('');
        }
        if (data[1]) {
          $("." + newName10).val(data[1].supplier_id);
          $("." + newName13).attr("placeholder", data[1].price);
          $("." + newName28).text(data[1].date);
          $("." + newName19).val(data[1].stock_availability);
          $("." + newName7).text(terms[data[1].supplier_id]);
          $("." + newName31).text(contact[data[1].supplier_id]);
        } else {
          $("." + newName10).val("none");
          $("." + newName13).attr("placeholder", "");
          $("." + newName28).text('');
          $("." + newName7).text('');
          $("." + newName31).text('');
        }

        if (data[2]) {
          $("." + newName11).val(data[2].supplier_id);
          $("." + newName14).attr("placeholder", data[2].price);
          $("." + newName29).text(data[2].date);
          $("." + newName20).val(data[2].stock_availability);
          $("." + newName8).text(terms[data[2].supplier_id]);
          $("." + newName32).text(contact[data[2].supplier_id]);
        } else {
          $("." + newName11).val("none");
          $("." + newName14).attr("placeholder", "");
          $("." + newName29).text('');
          $("." + newName8).text('');
          $("." + newName32).text('');
        }

      }, 'json');

    });

    var caster3 = "." + newName10;
    $(caster3).change(function(a){
      var searcher = a.currentTarget.value;
      var supplierChange = "." + newName7;
      var suppliers = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
      $(supplierChange).text(suppliers[searcher]);
      var supplierChange2 = "." + newName31;
      var suppliers2 = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;
      $(supplierChange2).text(suppliers2[searcher]);
    });

    var caster4 = "." + newName11;
    $(caster4).change(function(a){
      var searcher = a.currentTarget.value;
      var supplierChange = "." + newName8;
      var suppliers = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
      $(supplierChange).text(suppliers[searcher]);
      var supplierChange2 = "." + newName32;
      var suppliers2 = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;
      $(supplierChange2).text(suppliers2[searcher]);
    });

    checkButton();
    $('#generateInvoice').attr('disabled', 'disabled');
    //NOTE TO SELF, HAVE TO UNBIND PREVIOUS EVENT

    //console.log($(".itemCount"));
    $(".itemCount")[0].value = rowCounter++;

  });

  $(".itemChange1").select2({
    placeholder: "- Select Item -"
  });

  $(".clientChange1").change(function(a){
    var searcher = a.currentTarget.value;
    $.get('getClientDetails', {id: searcher}, function(data){
      $("#clientStatus").text(data[0][0].status);
      $("#contactPerson").text(data[0][0].contact_person);
      $("#paymentTerms").text(data[0][0].payment_terms);
      $("#tin").text(data[0][0].tin);
      $("#creditLimit").text("Php " + data[0][0].credit_limit.toFixed(2));
      if (data[1][0].credit == null) {
        $("#currentCredit").text("None");
      } else {
        $("#currentCredit").text("Php " + data[1][0].credit.toFixed(2));
      }

    }, 'json');
  });

  $(".supplierChange1").change(function(a){
    var searcher = a.currentTarget.value;
    var supplierChange = ".supplierTerms1";
    var supplierChange2 = ".contact1";
    var suppliers = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
    $(supplierChange).text(suppliers[searcher]);
    var suppliers2 = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;
    $(supplierChange2).text(suppliers2[searcher]);
  });

  $(".supplierChangeB1").change(function(a){
    var searcher = a.currentTarget.value;
    var supplierChange = ".supplierBTerms1";
    var supplierChange2 = ".contactB1";
    var suppliers = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
    $(supplierChange).text(suppliers[searcher]);
    var suppliers2 = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;
    $(supplierChange2).text(suppliers2[searcher]);
  });

  $(".supplierChangeC1").change(function(a){
    var searcher = a.currentTarget.value;
    var supplierChange = ".supplierCTerms1";
    var supplierChange2 = ".contactC1";
    var suppliers = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
    $(supplierChange).text(suppliers[searcher]);
    var suppliers2 = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;
    $(supplierChange2).text(suppliers2[searcher]);
  });

  $(".itemChange1").change(function(a){
    var searcher = a.currentTarget.value;
    var unitChange = ".itemUnit1";
    // $.get('getItemTerms', {item: searcher}, function(data){
    //   console.log(data);
    // }, 'json');

    var items = <?php echo Item::all()->lists('unit', 'id') ?>;
    $(unitChange).text(items[searcher]);

    $.get('getTopSuppliers', {item: searcher}, function(data){

      var terms = <?php echo Supplier::all()->lists('payment_terms', 'id') ?>;
      var contact = <?php echo Supplier::all()->lists('telephone_number', 'id') ?>;

      if (data[0]) {
        $(".supplierChange1").val(data[0].supplier_id);
        $(".itemPrice1").attr("placeholder", data[0].price);
        $(".lastUpdated1").text(data[0].date);
        $(".yesNo1").val(data[0].stock_availability);
        $(".supplierTerms1").text(terms[data[0].supplier_id]);
        $(".contact1").text(contact[data[0].supplier_id]);
      } else {
        $(".itemPrice1").attr("placeholder", "");
        $(".lastUpdated1").text('');
        $(".supplierTerms1").text('');
        $(".contact1").text('');
      }
      if (data[1]) {
        $(".supplierChangeB1").val(data[1].supplier_id);
        $(".itemPriceB1").attr("placeholder", data[1].price);
        $(".lastUpdatedB1").text(data[1].date);
        $(".yesNoB1").val(data[1].stock_availability);
        $(".supplierBTerms1").text(terms[data[1].supplier_id]);
        $(".contactB1").text(contact[data[1].supplier_id]);
      } else {
        $(".supplierChangeB1").val("none");
        $(".itemPriceB1").attr("placeholder", "");
        $(".lastUpdatedB1").text('');
        $(".supplierBTerms1").text('');
        $(".contactB1").text('');
      }

      if (data[2]) {
        $(".supplierChangeC1").val(data[2].supplier_id);
        $(".itemPriceC1").attr("placeholder", data[2].price);
        $(".lastUpdatedC1").text(data[2].date);
        $(".yesNoC1").val(data[2].stock_availability);
        $(".supplierCTerms1").text(terms[data[2].supplier_id]);
        $(".contactC1").text(contact[data[2].supplier_id]);
      } else {
        $(".supplierChangeC1").val("none");
        $(".itemPriceC1").attr("placeholder", "");
        $(".lastUpdatedC1").text('');
        $(".supplierCTerms1").text('');
        $(".contactC1").text('');
      }

    }, 'json');

  });

    //to disable button while all fields are empty
  function checkButton() {
      $('form select').change(function() {
          var empty = false;
          $('form select').each(function() {
              if ($(this).val() == null) {
                  empty = true;
              }
          });

          $('form input').each(function() {
              if ($(this).val() == '') {
                  empty = true;
              } 
          });

          if (empty) {
              $('#generateInvoice').attr('disabled', 'disabled');
          } else {
              $('#generateInvoice').removeAttr('disabled');
          }
      });

      $('form input').keyup(function() {
          var empty = false;
          $('form select').each(function() {
              if ($(this).val() == null) {
                  empty = true;
              }
          });

          $('form input').each(function() {
              if ($(this).val() == '') {
                  empty = true;
              } 
          });

          if (empty) {
              $('#generateInvoice').attr('disabled', 'disabled');
          } else {
              $('#generateInvoice').removeAttr('disabled');
          }
      });
  }

  checkButton();

  $(document).ready(function() {
    $('form').on('submit', function(e){
      var valid = true;
      var errorMessage = "";
      var diff = 7;

      if ($("#clientStatus")[0].textContent == "Blacklisted") {
        valid = false;
        errorMessage += "Sorry, the client is Blacklisted and cannot participate in further sales. ";
      }
      
      for (var i = 1; i < rowCounter; i++) {
        if ($(".lastUpdated" + i).text() != null) {
          var a = new Date($(".lastUpdated" + i).text());
          if (getDateDiff(a) > diff) {
            if ($(".itemPrice" + i).val() == 0) {
              valid = false;
              errorMessage += " The 1st price log in Item Row number " + i + " needs to be updated.<br>";
            }
          }
        }
        if ($(".lastUpdatedB" + i).text() != null) {
          var a = new Date($(".lastUpdatedB" + i).text());
          if (getDateDiff(a) > diff) {
            if ($(".itemPriceB" + i).val() == 0) {
              valid = false;
              errorMessage += " The 2nd price log in Item Row number " + i + " needs to be updated.<br>";
            }
          }
        }

        if ($(".lastUpdatedC" + i).text() != null) {
          var a = new Date($(".lastUpdatedC" + i).text());
          if (getDateDiff(a) > diff) {
            if ($(".itemPriceC" + i).val() == 0) {
              valid = false;
              errorMessage += " The 3rd price log in Item Row number " + i + " needs to be updated.<br>";
            }
          }
        }
      }

      if(!valid) {
        e.preventDefault();
        //alert(errorMessage);
        document.getElementById("error").innerHTML = errorMessage;
        $("#error-dialog").modal("show");
      }
    });
  });

  function getDateDiff(oldDate){
    var a = oldDate;
    var b = new Date();
    var timeDiff = Math.abs(b.getTime() - a.getTime());
    var diffDays = Math.ceil(timeDiff/(1000*3600*24));
    return diffDays;
  }


  //$(".clientChange")[''].disabled="disable";

  // $("#generateInvoice").click(function(){
  //   var itemName;
  //   var itemNo = rowCounter - 1;
  //   <?php
  //       $salesInvoice = new SalesInvoice;
  //       $salesInvoice->status = "draft";
  //       $salesInvoice->client_id = 1;
  //       //$salesInvoice->save();
  //   ?>

  //   console.log(invoice_id);

  //   for (i = 1; i <= itemNo; i++) {
  //     itemName = ".itemChange" + i;
  //     <?php
  //       // $hello = new InvoiceItem;
  //       // $hello->item_id = 
  //     ?>
  //     console.log($(itemName));
  //     console.log($(itemName)[0].value);
  //   }
  // });
});
</script>

<!-- Modal -->
  <div class="modal fade" id="error-dialog" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header error">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">ERROR</h4>
        </div>
        <div class="modal-body">
          <p id="error"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

@stop