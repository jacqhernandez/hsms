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
use Carbon\Carbon;

class SalesInvoicesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');   
        // $this->middleware('auth');  
        // $this->middleware('general_manager',['except' => ['index','show']]);
        // $this->middleware('sales',['except' => ['index','show']]);       
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
        } else {
            $sales_invoices = SalesInvoice::paginate(10);
        }
        $dates = SalesInvoice::all()->lists('due_date','due_date');
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
		//return 'wtf';
		//$statusOptions = ['good', 'blacklisted'];
		// $statusOptions = [];
		// $statusOptions['Good'] = 'Good';
		// $statusOptions['Blacklisted'] = 'Blacklisted';

  //       $paymentOptions = [];
  //       $paymentOptions['Cash'] = 'Cash';
  //       $paymentOptions['15 Days'] = '15 Days';
  //       $paymentOptions['30 Days'] = '30 Days';
  //       $paymentOptions['60 Days'] = '60 Days';
        $clientOptions = Client::where('user_id', Auth::user()['id'])->lists('name','id');

        return view('sales_invoices.create', compact('clientOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateSalesInvoiceRequest $request)
    {
        $input = Request::all();
        $sales_invoice = new SalesInvoice;
        $sales_invoice->si_no = $input['si_no'];
    		$sales_invoice->po_number = $input['po_number'];
    		$sales_invoice->dr_number = $input['dr_number'];
        $sales_invoice->date = Carbon\Carbon::now();
		    $sales_invoice->due_date = $input['due_date'];
        //$salesInvoice->total_amount = $input['total_amount'];
        $sales_invoice->vat = $input['vat'];
		    $sales_invoice->wtax = $input['wtax'];
        $sales_invoice->status = "Pending";
        //$salesInvoice->date_delivered = $input['date_delivered'];
        //$salesInvoice->date_collected = $input['date_collected'];
        $sales_invoice->client_id = $input['client_id'];
        $sales_invoice->user_id = $input['user_id'];
        $sales_invoice->save();
        return redirect()->action('SalesInvoicesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sales_invoice = SalesInvoice::find($id);
        return view('sales_invoices.show', compact('sales_invoice'));
    }

    public function poGuide($id)
    {
        $sales_invoice = SalesInvoice::find($id);
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
        return view('sales_invoices.edit', compact('sales_invoice'));
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
            'date' => $input['date'],
            'due_date' => $input['due_date'],
            'vat' => $input['vat'],
            'credit_limit' => $input['credit_limit'],
            'wtax' => $input['wtax'],
            'status' => $input['status'],
            'date_delivered' => $input['date_delivered'],
            'date_collected' => $input['date_collected'],
            'client_id' => $input['client_id'],
            'user_id' => $input['user_id']
        ]);
        return redirect()->action('SalesInvoicesController@show',[$id]);
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

    public function creation(){
        $input = Request::all();
        $salesInvoice = SalesInvoice::find($input['invoice_no']);

        $salesInvoice->update([
            'si_no' => $input['si_no'],
            'po_number' => $input['po_number'],
            'dr_number' => $input['dr_number'],
            'vat' => $input['vat'],
            'wtax' => $input['wtax'],
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
            'status' => "pending"
        ]);

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
        $pdf = \PDF::loadView('sales_invoices.generate', compact('sales_invoice'));
        Activity::log('Sales Invoice '. $sales_invoice['si_no'] .' was generated');
        return $pdf->stream();

    }

    //WIP
    public function getTopThreeSuppliers(Illuminate\Http\Request $request) {

        return response()->json(['response' => 'This is get method']);
    }
}
