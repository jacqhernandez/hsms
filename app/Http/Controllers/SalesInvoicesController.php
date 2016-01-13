<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use Request;

class SalesInvoicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('general_manager',['except' => ['index','show']]);     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()['role'] == 'Sales') {
            $sales_invoices = SalesInvoice::where('user_id', Auth::user()['id']);
            //IMPORTANT: this displays ALL invoices instead of until last month
        } else {
            $sales_invoices = SalesInvoice::all();
        }

        return view('sales_invoices.index', compact('sales_invoices'));
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
        $saleInvoice = new SalesInvoice;
        $saleInvoice->si_no = $input['si_no'];
		$saleInvoice->po_number = $input['po_number'];
		$saleInvoice->dr_number = $input['dr_number'];
        $saleInvoice->date = $input['date'];
		$saleInvoice->due_date = $input['due_date'];
        //$saleInvoice->total_amount = $input['total_amount'];
        $saleInvoice->vat = $input['vat'];
		$saleInvoice->wtax = $input['wtax'];
        //$saleInvoice->status = $input['status'];
        //$saleInvoice->date_delivered = $input['date_delivered'];
        //$saleInvoice->date_collected = $input['date_collected'];
        $saleInvoice->client_id = $input['client_id'];
        $saleInvoice->user_id = $input['user_id'];
        $saleInvoice->save();
    
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
        $salesInvoice = SalesInvoice::find($id);
        return view('sales_invoices.show', compact('salesInvoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salesInvoice = SalesInvoice::find($id);
		// $statusOptions = [];
		// $statusOptions['Good'] = 'Good';
		// $statusOptions['Blacklisted'] = 'Blacklisted';

  //       $paymentOptions = [];
  //       $paymentOptions['Cash'] = 'Cash';
  //       $paymentOptions['15 Days'] = '15 Days';
  //       $paymentOptions['30 Days'] = '30 Days';
  //       $paymentOptions['60 Days'] = '60 Days';

        return view('sales_invoices.edit', compact('salesInvoice'));
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
        $client = Client::find($id);
        $input = Request::all();
        $client->update([
            'name' => $input['name'],
			'telephone_number' => $input['telephone_number'],
			'address' => $input['address'],
            'email' => $input['email'],
			'tin' => $input['tin'],
            'contact_person' => $input['contact_person'],
            'credit_limit' => $input['credit_limit'],
			'status' => $input['status'],
            'payment_terms' => $input['payment_terms'],
            'user_id' => $input['username']
        ]);
        return redirect()->action('ClientsController@show',[$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salesInvoice = SalesInvoice::find($id);
        $salesInvoice->delete();
        return redirect()->action('SalesInvoicesController@index');
    }
}
