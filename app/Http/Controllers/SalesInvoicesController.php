<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\SalesInvoice;
use Request;
use Auth;
use App\Item;
use DB;
use Activity;
use App\Supplier;
use App\PriceLog;
use App\InvoiceItem;
use App\User;
use Carbon\Carbon;

class SalesInvoicesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('general_manager',['only' => ['edit','update','destroy','editStatus']]);
        $this->middleware('not_for_accounting',['only' => ['create','store','quotation','make','creation','generatePdf','delivered']]);
        $this->middleware('not_for_sales',['only'=> ['collected']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()['role'] == 'Sales') {
            $sales_invoices = SalesInvoice::where('user_id', Auth::user()['id'])->paginate(10);
            //IMPORTANT: this displays ALL invoices instead of until last month
        } 
        elseif (Auth::user()['role'] == 'Accounting'){
            $sales_invoices = SalesInvoice::where('status','!=','Draft')->where('status','!=',"Pending")->paginate(10);
        }
        else {
            $sales_invoices = SalesInvoice::paginate(10);
        }
        $dates = $sales_invoices->lists('due_date','due_date');
        return view('sales_invoices.index', compact('sales_invoices','dates'));
    }

    public function search()
    {
        $input = Request::all();
        $query = $input['query'];
        $clients = Client::where('name','LIKE',"%$query%")->lists('id');
        $sales_invoices = SalesInvoice::whereIn('client_id',$clients)->orWhere('si_no','LIKE',"%$query%")->paginate(10);
        
        if ($sales_invoices == "[]")
        {
            //flash()->error('There are no suppliers that match your query.');
            return redirect()->action('SalesInvoicesController@index');
        }
        $sales_invoices->appends(Request::only('query'));
        $dates = SalesInvoice::all()->lists('due_date','due_date');
        return view('sales_invoices.index',compact('sales_invoices','dates'));
    }


    public function filter()
    {
        $input = Request::all();
        if (isset($input['filter_status']))
        {
            $filter_status = $input['filter_status'];
            $sales_invoices = SalesInvoice::where('status',$filter_status)->paginate(10);
            $sales_invoices->appends(Request::only('filter_status'));
        }
        else
        {
            $filter_date = $input['filter_date'];
            $sales_invoices = SalesInvoice::where('due_date',$filter_date)->paginate(10); //and where status !== collected
            $sales_invoices->appends(Request::only('filter_date'));
        }
        if ($sales_invoices == "[]")
        {
            return redirect()->action('SalesInvoicesController@index');
        }
        $dates = SalesInvoice::all()->lists('due_date','due_date');
        return view('sales_invoices.index',compact('sales_invoices','dates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientOptions = Client::where('user_id', Auth::user()['id'])->lists('name','id');

        return view('sales_invoices.create', compact('clientOptions'));
    }


    public function show($id)
    {
        $sales_invoice = SalesInvoice::find($id);
        $items = SalesInvoice::find($id)->InvoiceItems;
        if ((Auth::user()['role'] == 'Sales') && ($sales_invoice['user_id'] !== Auth::user()['id'])) 
        {
            return redirect()->action('SalesInvoicesController@index');
        }
        elseif ((Auth::user()['role'] == 'Accounting') && (($sales_invoice['status'] == "Draft") || ($sales_invoice['status'] == "Pending")) )
        {    
            return redirect()->action('SalesInvoicesController@index');
        }
        else
        {
            return view('sales_invoices.show', compact('sales_invoice', 'items'));
        }
        return view('sales_invoices.show', compact('sales_invoice', 'items'));
    }

    public function poGuide($id)
    {
        $sales_invoice = SalesInvoice::find($id);
        if ((Auth::user()['role'] == 'Sales') && ($sales_invoice['user_id'] != Auth::user()['id'])) 
        {
            return redirect()->action('SalesInvoicesController@index');
        }
        elseif ((Auth::user()['role'] == 'Accounting') && (($sales_invoice['status'] == "Draft") || ($sales_invoice['status'] == "Pending")) )
        {    
            return redirect()->action('SalesInvoicesController@index');
        }
        else
        {
            return view('sales_invoices.po_guide', compact('sales_invoice'));
        }
        return view('sales_invoices.po_guide', compact('sales_invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales_invoice = SalesInvoice::find($id);
        $items = SalesInvoice::find($id)->InvoiceItems;
        $userOptions = User::where('role', 'Sales')->lists('username','id');
        $statusOptions = [];
            $statusOptions['Pending'] = "Pending";
            $statusOptions['Delivered'] = "Delivered";
            $statusOptions['Check on Hand'] = "Check on Hand";
            $statusOptions['Collected'] = "Collected";
        $clientOptions = Client::all()->lists('name', 'id');
        $items = SalesInvoice::find($id)->InvoiceItems;
        $salesId = $id;
        return view('sales_invoices.edit', compact('sales_invoice', 'userOptions', 'statusOptions', 'clientOptions', 'items', 'salesId'));
    }

    public function editStatus($id)
    {
        $sales_invoice = SalesInvoice::find($id);
        if ($sales_invoice->status === "Overdue"){
            return redirect()->action('SalesInvoicesController@index');
        }
        return view('sales_invoices.edit_status',compact('sales_invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateSalesInvoiceRequest $request, $id)
    {
        //UNFINISHED
        $sales_invoice = SalesInvoice::find($id);
        $input = Request::all();
        $sales_invoice->update([
            'si_no' => $input['si_no'],
      		'po_number' => $input['po_number'],
      		'dr_number' => $input['dr_number'],
            'due_date' => $input['due_date'],
            'status' => $input['status'],
            'date_delivered' => $input['date_delivered'],
            'date_collected' => $input['date_collected'],
            'client_id' => $input['client_id'],
            'or_number' => $input['or_number']
        ]);
        $client = Client::find($input['client_id']);
        $sales_invoice->update([
            'user_id' => $client->user_id
        ]);
        //return redirect()->action('SalesInvoicesController@show',[$id]);
        return redirect()->action('SalesInvoicesController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales_invoice = SalesInvoice::find($id);
        $sales_invoice->delete('set null');
        return redirect()->action('SalesInvoicesController@index');
    }

    public function quotation() {

        //$clientOptions = Client::where('user_id', Auth::user()['id'])->lists('name','id');
        $clientOptions = Client::all()->lists('name','id');
        $supplierOptions = Supplier::all()->lists('name','id');
        $itemOptions = Item::all()->lists('name','id');

        return view('sales_invoices.quotation', compact('supplierOptions','itemOptions', 'clientOptions'));
    }

    public function edit_quotation() {

    }

    public function returnSupplierTerms($id){
        $payment_terms = Supplier::find($id)->lists('payment_terms');

        return $payment_terms;
    }

    public function make($id){
        //$items = InvoiceItem::where('sales_invoice_id', $id)->get();
        $items = SalesInvoice::find($id)->InvoiceItems;
        $invoice_id = $id;
        return view('sales_invoices.make', compact('items', 'invoice_id'));
    }

    public function creation(Requests\CreateSalesInvoiceRequest $request){
        $input = Request::all();
        $salesInvoice = SalesInvoice::find($input['invoice_no']);

        $salesInvoice->update([
            'si_no' => $input['si_no'],
            'po_number' => $input['po_number'],
            'dr_number' => $input['dr_number'],
            'date' => Carbon::now()
        ]);

        $total_amount = 0;
        $items = InvoiceItem::where('sales_invoice_id', $salesInvoice->id)->get();
        //$items = $input(['items']);

        foreach ($items as $item) {
            $invoiceItem = InvoiceItem::find($item->id);
            $invoiceItem->update([
                'quantity' => $input['quantity' . $item->id],
                'unit_price' => $input['unit_price' . $item->id],
                'total_price' => $input['quantity' . $item->id] * $input['unit_price' . $item->id]
            ]);

            $total_amount += $invoiceItem->total_price;
        }

        $salesInvoice->update([
            'total_amount' => $total_amount,
            'status' => "Pending"
        ]);
        Activity::log('Sales Invoice '. $salesInvoice['si_no'] .' was completed');
        return redirect()->action('SalesInvoicesController@show',[$salesInvoice->id]);
        
    }

    public function viewCollected()
    {
        $sales_invoices = SalesInvoice::whereRaw("week(due_date) = week(now()) AND sales_invoices.status='collected'")->paginate(10);
        return view('sales_invoices.index', compact('sales_invoices'));
    }

    public function viewCollectibles()
    {
        $sales_invoices = SalesInvoice::whereRaw("week(due_date) = week(now()) AND sales_invoices.status='delivered'")->paginate(10);
        return view('sales_invoices.index', compact('sales_invoices'));
    }

    public function viewUpcoming()
    {
        $sales_invoices = SalesInvoice::whereRaw("week(due_date) - week(now()) = 1 AND sales_invoices.status='delivered'")->paginate(10);
        return view('sales_invoices.index', compact('sales_invoices'));
    }

    public function viewOverdue()
    {
        $sales_invoices = SalesInvoice::whereRaw("week(now()) - week(due_date) >= 1 AND sales_invoices.status='overdue'")->paginate(10);
        return view('sales_invoices.index', compact('sales_invoices'));
    }

    public function generatePdf($id)
    {
        ini_set("max_execution_time", 0);
        $sales_invoice = SalesInvoice::find($id);
        $items = DB::select("SELECT * FROM invoice_items i 
                                JOIN sales_invoices si ON i.sales_invoice_id = si.id 
                                JOIN items ON i.item_id = items.id WHERE si.id = '$id' ");

        $pdf = \PDF::loadView('sales_invoices.generate', compact('sales_invoice', 'items'));
        Activity::log('Sales Invoice '. $sales_invoice['si_no'] .' was generated');
        return $pdf->stream();
    }

    //WIP
    public function getTopSuppliers() {
        $item = $_GET['item'];

        // $terms = Item::where('item_id', $item)->payment_terms;
        //$price_logs = PriceLog::where('item_id', $invoice_item->Item->id)->orderBy('created_at', 'desc')->take(3)->get();
        //$terms = DB::select("SELECT * FROM items WHERE id = '$item'");
        $terms = DB::select("SELECT DISTINCT supplier_id, date, price, stock_availability FROM price_logs WHERE item_id = '$item' ORDER BY created_at desc LIMIT 3");

        return $terms;
    }

    public function getClientDetails() {
        $id = $_GET['id'];

        $init = DB::select("SELECT * FROM clients WHERE id = '$id'");
        $credit = DB::select("SELECT SUM(total_amount) AS credit FROM sales_invoices WHERE client_id='$id' AND (status='Delivered' OR status='Check on Hand' OR status='Pending' or status='Overdue')");

        $client = array($init, $credit);

        return $client;
    }

    public function delivered($id) {

        $salesInvoice = SalesInvoice::find($id);
        if ($salesInvoice->Client->payment_terms == "PDC") {
            $salesInvoice->update([
                'status' => "Check on Hand",
                'date_delivered' => Carbon::now()
            ]);
        } else {
            $salesInvoice->update([
                'status' => "Delivered",
                'date_delivered' => Carbon::now() 
            ]);
            if ($salesInvoice->Client->payment_terms == "Cash") {
                $salesInvoice->update([
                    'due_date' => Carbon::now()
                ]);
            } else if ($salesInvoice->Client->payment_terms == "30 Days"){
                $salesInvoice->update([
                    'due_date' => Carbon::now()->addDays(30)
                ]);
            }  else if ($salesInvoice->Client->payment_terms == "60 Days"){
                $salesInvoice->update([
                    'due_date' => Carbon::now()->addDays(60)
                ]);
            }
        }
        return redirect()->action('SalesInvoicesController@index');
    }

    public function collected() {
        $input = Request::all();
        $salesInvoice = SalesInvoice::find($input['id']);
        $salesInvoice->update([
                'status' => "Collected",
                'date_collected' => Carbon::now(),
                'or_number' => $input['or_number'] 
        ]);
        return redirect()->action('SalesInvoicesController@index');
    }
}
