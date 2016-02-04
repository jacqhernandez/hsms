<?php

namespace App\Http\Controllers;



use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CollectionLog;
use App\Reason;
use App\User;
use App\Client;
use App\SalesInvoice;
use App\SalesInvoiceCollectionLog;
use Auth;
use Request;





class CollectionLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index($id)
    {
        
        $client = Client::find($id);
        
        $overdue = SalesInvoice::where('client_id', $id)->where('status', 'Overdue')->count();
        if ($overdue != 0)
        {
            $overdues = SalesInvoice::where('client_id', $id)->where('status', 'Overdue')->get();
        }
        $delivered = SalesInvoice::where('client_id', $id)->where('status', 'Delivered')->count();
        if ($delivered != 0)
        {
            $delivereds = SalesInvoice::where('client_id', $id)->where('status', 'Delivered')->get();
        }
        $collection_logs= CollectionLog::where('client_id', $id)->orderBy('date', 'desc')->paginate(10);
        $salesinvoices = new SalesInvoiceCollectionLog;
        return view('collection_logs.index', compact('collection_logs', 'client', 'overdue', 'delivered', 'overdues', 'delivereds'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $salesinvoices = SalesInvoice::where('client_id', $id)->get();
        $actionOptions = [];
        $actionOptions['Text'] = 'Text';
        $actionOptions['Call'] = 'Call';
        $actionOptions['Fax'] = 'Fax';
        $actionOptions['Send SOA'] = 'Send SOA';
        $actionOptions['Email'] = 'Email';
        $actionOptions['Visit'] = 'Visit';
        $reasonOptions = Reason::lists('reason', 'id');
        return view('collection_logs.create', compact('actionOptions', 'reasonOptions', 'id', 'salesinvoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $salesinvoice = Request::get('check_list');

        $input = Request::all();
        $cLog = new CollectionLog;
        $cLog->date = $input['date'];
        $cLog->action = $input['action'];
        $cLog->follow_up_date = $input['follow_up_date'];
        $cLog->note = $input['note'];
        $cLog->reason_id = $input['reason_id'];
        $cLog->user_id = Auth::user()['id'];
        $cLog->client_id = $input['client_id'];
        $cLog->save();
        foreach ($salesinvoice as $key)
        {
            $sicl = new SalesInvoiceCollectionLog;
            $sicl->sales_invoice_id = $key;
            $sicl->client_id = $cLog->client_id;
            $sicl->collection_log_id = $cLog->id;
            $sicl->save();
        }
        $id = $cLog->client_id;

        return redirect()->action('CollectionLogsController@index', [$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($client_id, $id)
    {
        $cLog = CollectionLog::find($id);
        //$sicl = SalesInvoiceCollectionLog::where('client_id', $client_id)->get();
        //$salesinvoices = SalesInvoice::where('client_id', $client_id)->where('status', '!=', 'Collected')->get();
        $client = Client::find($client_id);
        $salesinvoices = SalesInvoiceCollectionLog::join('clients', 'sales_invoice_collection_logs.client_id', '=', 'clients.id')
                       ->join('sales_invoices', 'sales_invoice_collection_logs.sales_invoice_id', '=', 'sales_invoices.id')
                       ->join('collection_logs', 'sales_invoice_collection_logs.collection_log_id', '=', 'collection_logs.id')
                       ->where('sales_invoice_collection_logs.client_id', $client_id)
                       ->where('sales_invoice_collection_logs.collection_log_id', $id)
                       ->where('sales_invoices.status', '!=', 'Collected')
                       ->select('*')
                       ->get();
        return view('collection_logs.show', compact('cLog', 'client', 'salesinvoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cLog = CollectionLog::find($id);
        return view('collection_logs.edit', compact('cLog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests $request, $id)
    {
        $cLog = CollectionLog::find($id);
        $input = Request::all();
        $cLog->update([
            'date' => $input['date'],
            'action' => $input['action'],
            'follow_up_date' => $input['follow_up_date'],
            'note' => $input['note'],
            'reason_id' => $input['reason_id'],
            'user_id' => $input['user_id']
        ]);
        return redirect()->action('CollectionLogsController@show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client_id)
    {
        $cLog = CollectionLog::find($id);
        $cLog->delete();
        return redirect()->action('CollectionLogsController@index', [$client_id]);
    }
}
