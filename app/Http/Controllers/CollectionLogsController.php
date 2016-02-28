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
use Carbon\Carbon;
use Request;
use DB;
use Activity;

class CollectionLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');  
    
    }
   public function index($id)
    {
        if(Auth::user()['role'] == 'Accounting' OR Auth::user()['role'] =='General Manager')
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
            $pending = SalesInvoice::where('client_id', $id)->where('status', 'Pending')->count();
            if ($pending != 0)
            {
                $pendings = SalesInvoice::where('client_id', $id)->where('status', 'Pending')->get();
            }
            $collection_logs= CollectionLog::where('client_id', $id)->orderBy('date', 'asc')
                                                                    ->orderBy('status', 'desc')
                                                                    ->paginate(10);
            // $collection_logs= CollectionLog::where('client_id', $id)->orderBy('status', 'desc', 'date', 'asc')->paginate(10);

            // $collection_logs = DB::SELECT("SELECT * FROM collection_logs WHERE client_id = '$id' ORDER BY date desc, status desc");
            $salesinvoices = new SalesInvoiceCollectionLog;
            return view('collection_logs.index', compact('collection_logs', 'client', 'overdue', 'delivered', 'pending', 'overdues', 'delivereds', 'pendings'));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, Request $request)
    {
        $salesinvoices = SalesInvoice::where('client_id', $id)
                    ->where('status', '!=', 'Collected')
                    ->where('status', '!=', 'Draft')
                    ->orderBy('status', 'asc')
                    ->get();
        $actionOptions = [];
        $actionOptions['Text'] = 'Text';
        $actionOptions['Call'] = 'Call';
        $actionOptions['Fax'] = 'Fax';
        $actionOptions['Send SOA'] = 'Send SOA';
        $actionOptions['Email'] = 'Email';
        $actionOptions['Visit'] = 'Visit';
        $actionOptions['Call and Send SOA'] = 'Call and Send SOA';
        $reasonOptions = Reason::lists('reason', 'id');
        $statusOptions = [];
        $statusOptions['To Do'] = 'To Do';
        $statusOptions['Done'] = 'Done';
        $method = 'post';

        return view('collection_logs.create', compact('id', 'method', 'actionOptions', 'statusOptions', 'reasonOptions', 'id', 'salesinvoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Requests\CreateCollectionLogRequest $request)
    {
        $salesinvoice = Request::get('check_list');

        $input = Request::all();
        $cLog = new CollectionLog;
        $cLog->date = $input['date'];
        $cLog->action = $input['action'];
        // $cLog->follow_up_date = $input['follow_up_date'];
        $cLog->note = $input['note'];
        $cLog->reason_id = $input['reason_id'];
        $cLog->user_id = Auth::user()['id'];
        $cLog->client_id = $input['client_id'];
        $cLog->status = $input['status'];
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
    public function edit(Request $request, $id, $cLog_id)
    {
        $cLog = CollectionLog::find($cLog_id);
        $actionOptions = [];
        $actionOptions['Text'] = 'Text';
        $actionOptions['Call'] = 'Call';
        $actionOptions['Fax'] = 'Fax';
        $actionOptions['Send SOA'] = 'Send SOA';
        $actionOptions['Email'] = 'Email';
        $actionOptions['Visit'] = 'Visit';
        $reasonOptions = Reason::lists('reason', 'id');
        $statusOptions = [];
        $statusOptions['To Do'] = 'To Do';
        $statusOptions['Done'] = 'Done';
        // $salesinvoices = SalesInvoice::where('client_id', $id)
        //             ->where('status', '!=', 'Collected')
        //             ->where('status', '!=', 'Draft')
        //             ->orderBy('status', 'asc')
        //             ->get();
        $salesinvoices = DB::SELECT("SELECT si.si_no, si.status, si.total_amount, si.date FROM sales_invoice_collection_logs sicl
                                    JOIN sales_invoices si ON sicl.sales_invoice_id = si.id
                                    JOIN collection_logs cl ON sicl.collection_log_id = cl.id
                                    WHERE cl.id = '$cLog_id'");
        $date = Carbon::parse($cLog->date)->toFormattedDateString();
        $method = 'patch';
        return view('collection_logs.edit', compact('method', 'cLog', 'date', 'actionOptions', 'statusOptions', 'reasonOptions', 'id', 'salesinvoices'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($client_id, $cLog_id)
    {
        $salesinvoice = Request::get('check_list');
        $cLog = CollectionLog::find($cLog_id);
        $input = Request::all();
        $client = Client::find($client_id);
        $cLog->update([
            'note' => $input['note'],   
            'reason_id' => $input['reason_id'],
            'user_id' => Auth::user()['id'],
            'status' => 'Done'
        ]);
        // $sicls = SalesInvoiceCollectionLog::where('sales_invoice_collection_logs.client_id', $input['client_id'])
        //                     ->where('sales_invoice_collection_logs.collection_log_id', $cLog_id)
        //                     ->delete();
        // foreach ($salesinvoice as $key)
        // {
        //     $sicl = new SalesInvoiceCollectionLog;
        //     $sicl->sales_invoice_id = $key;
        //     $sicl->client_id = $cLog->client_id;
        //     $sicl->collection_log_id = $cLog->id;
        //     $sicl->save();
        // }
        $id = $cLog->client_id;
        Activity::log($cLog->action . ' to' . $client['name'] .' was performed');
         return redirect()->action('CollectionLogsController@index', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client_id)
    {
        $sicls = SalesInvoiceCollectionLog::where('sales_invoice_collection_logs.collection_log_id', $id)
                            ->delete();
        $cLog = CollectionLog::find($id);
        $cLog->delete();
        return redirect()->action('CollectionLogsController@index', [$client_id]);
    }
}
