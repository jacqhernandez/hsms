<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SalesInvoicesController;
use App\InvoiceItem;
use App\SalesInvoice;
use App\Client;
use App\User;
use App\Item;
use App\PriceLog;
use Request;
use Auth;
use Carbon\Carbon;
use Activity;

class InvoiceItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('general_manager',['except' => ['index','show','search', 'store']]);
        $this->middleware('not_for_accounting',['only' => ['store']]);
    }

    public function store()
    {
        $input = Request::all();
        //print_r(array_values($input))
        //print_r("pasok");
        //$invoiceItem = new InvoiceItem;
        $salesInvoice = new SalesInvoice;
        //print_r($salesInvoice);
        $salesInvoice->status = "Draft";
        $salesInvoice->client_id = $input['client_id'];
        $client = Client::find($input['client_id']);
        $salesInvoice->user_id = $client->user_id;
        $salesInvoice->save();

        $no_items = $input['item_count'];
        //print_r($no_items);

        $sameItem = false;
        $sameSupplier = false;

        $itemList = [];
        for ($i = 1; $i <= $no_items; $i++) {
          $finder = 'item_id' . strval($i);

          try {
            array_push($itemList, $input[$finder]);
          } catch(Exception $e) {

          }

          $supplierList = [];

          $supplierer = $input['supplier_id' . strval($i)];
          $supplierer2 = $input['supplier_idB' . strval($i)];
          $supplierer3 = $input['supplier_idC' . strval($i)];
          if (($supplierer3) == "none"){
            $supplierer3 = "hello";
          }
          
          if ($supplierer == $supplierer2 || $supplierer2 == $supplierer3 || $supplierer == $supplierer3){
            $sameSupplier = true;
          }
        }

        if (count($itemList) !== count(array_unique($itemList))){
          $sameItem = true;
        }

        if ($sameItem == true){
            return redirect()->back()->withInput()->with('message','You cannot have the same item in the sales invoice.');
        }

        if ($sameSupplier == true){
            return redirect()->back()->withInput()->with('message','You cannot have the same supplier for a single item.');
        }

        for ($i = 1; $i <= $no_items; $i++) {
            $invoiceItem = new InvoiceItem;
            $finder = 'item_id' . strval($i);
            $invoiceItem->item_id = $input[$finder];
            $invoiceItem->sales_invoice_id = $salesInvoice->id;
            $invoiceItem->save();

            $priceLog = new PriceLog;
            $pricer = 'item_price' . strval($i);
            $availer = 'availA' . strval($i);
            $supplierer = 'supplier_id' . strval($i);
            if ($input[$pricer] == 0 || $input[$supplierer] == "none") {
              //do nothing
            } else {
              $priceLog->date = Carbon::now();
              $priceLog->price = $input[$pricer];
              $priceLog->stock_availability = $input[$availer];
              $priceLog->item_id = $input[$finder];
              $priceLog->supplier_id = $input[$supplierer];
              $priceLog->save();
            }
            
            $priceLog2 = new PriceLog;
            $pricer2 = 'item_priceB' . strval($i);
            $availer2 = 'availB' . strval($i);
            $supplierer2 = 'supplier_idB' . strval($i);
            if ($input[$pricer2] == 0 || $input[$supplierer2] == "none") {
              //do nothing
            } else {
              $priceLog2->date = Carbon::now();
              $priceLog2->price = $input[$pricer2];
              $priceLog2->stock_availability = $input[$availer2];
              $priceLog2->item_id = $input[$finder];
              $priceLog2->supplier_id = $input[$supplierer2];
              $priceLog2->save();
            }

            $priceLog3 = new PriceLog;
            $pricer3 = 'item_priceC' . strval($i);
            $availer3 = 'availC' . strval($i);
            $supplierer3 = 'supplier_idC' . strval($i);
            if ($input[$pricer3] == 0 || $input[$supplierer3] == "none") {
              //do nothing
            } else {
              $priceLog3->date = Carbon::now();
              $priceLog3->price = $input[$pricer3];
              $priceLog3->stock_availability = $input[$availer3];
              $priceLog3->item_id = $input[$finder];
              $priceLog3->supplier_id = $input[$supplierer3];
              $priceLog3->save();
            }
            //if (Auth::user()['role'] !== 'Sales') 
        }

        // $invoiceItem->sales_invoice_id = $salesInvoice->id;
        // $invoiceItem->item_id = $input['item_id'];
        //print_r(array_values($invoiceItem));
        //print_r($invoiceItem);
		// $invoiceItem->item_id = $input['item_id'];
  //       $priceLog->stock_availability = $input['stock_availability'];
  //       $priceLog->supplier_id = $input['supplier_id'];
  //       $priceLog->item_id = $input['item_id'];
		// $priceLog->save();
        Activity::log('Quotation for invoice '. $salesInvoice['si_no'] .' was added');
        return redirect()->action('SalesInvoicesController@make',[$salesInvoice->id]);
        //return redirect()->action('ClientsController@index');
    }

    public function addItem($salesId)
    {
        $itemOptions = Item::all()->lists('name', 'id');

        return view('invoice_items.create', compact('itemOptions', 'salesId'));
    }

    public function newItem(Requests\CreateInvoiceItemRequest $request)
    {
      $input = Request::all();
      $salesId = $input['salesId'];
      $saleItem = new InvoiceItem;
      $saleItem->quantity = $input['quantity'];
      $saleItem->unit_price = $input['unit_price'];
      $saleItem->item_id = $input['item_id'];
      $saleItem->sales_invoice_id = $salesId;
      $saleItem->total_price = $input['quantity'] * $input['unit_price'];
      $saleItem->save();

      $items = InvoiceItem::where('sales_invoice_id', $salesId)->get();
      $total_amount = 0;
      foreach ($items as $item) {
          $invoiceItem = InvoiceItem::find($item->id);

          $total_amount += $invoiceItem->total_price;
      }

      $salesInvoice = $saleItem->salesInvoice;
      $salesInvoice->update([
          'total_amount' => $total_amount
      ]);

      return redirect()->action('SalesInvoicesController@edit',[$salesInvoice->id]);
    }

    public function edit($id)
    {
        $saleItem = InvoiceItem::find($id);

        $itemOptions = Item::all()->lists('name', 'id');

        return view('invoice_items.edit', compact('saleItem', 'itemOptions'));
    }

    public function update(Requests\CreateInvoiceItemRequest $request, $id)
    {
        $saleItem = InvoiceItem::find($id);
        $input = Request::all();
        $saleItem->update([
            'item_id' => $input['item_id'],
            'quantity' => $input['quantity'],
            'unit_price' => $input['unit_price'],
            'total_price' => $input['quantity'] * $input['unit_price']
        ]);
        $salesInvoice = $saleItem->salesInvoice;

        $items = InvoiceItem::where('sales_invoice_id', $salesInvoice->id)->get();
        $total_amount = 0;
        foreach ($items as $item) {
            $invoiceItem = InvoiceItem::find($item->id);

            $total_amount += $invoiceItem->total_price;
        }

        $salesInvoice->update([
            'total_amount' => $total_amount
        ]);

        return redirect()->action('SalesInvoicesController@edit',[$salesInvoice->id]);
    }

    public function destroy($id)
    {   
        $invoiceItem = InvoiceItem::find($id);
        $salesId = $invoiceItem->salesInvoice->id;
        $invoice = SalesInvoice::find($salesId);
        $invoice->update([
            'total_amount' => $invoice->total_amount - $invoiceItem->total_price
        ]);
        $invoiceItem->delete();
        return redirect()->action('SalesInvoicesController@edit', [$salesId]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
