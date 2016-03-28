<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\SalesInvoice;
use Activity;
use Mail;
use DB;
use Flash;
use Request;
use Auth;

class CollectiblesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('not_for_sales');
    }
    public function index()
    {
        if(Auth::user()['role'] == 'Accounting' OR Auth::user()['role'] =='General Manager')
        {
            $overdue = new SalesInvoice;
            $delivered = new SalesInvoice;
            $check = new SalesInvoice;
            $salesinvoice = new SalesInvoice;
            $salesinvoice2 = new SalesInvoice;
            $salesinvoice3 = new SalesInvoice;
            $salesinvoiceTotal;
            foreach($clients as $client)
            {
                 $overdue[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Overdue')->count();
                 $delivered[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Delivered')->count();
                 $check[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Check on Hand')->count();
                 // $salesinvoice[$client->id] = DB::SELECT("SELECT sum(total_amount) as total FROM sales_invoices 
                 //                        WHERE (status = 'Overdue' or  status = 'Delivered') and client_id = '$client->id'");
                 $salesinvoice = SalesInvoice::where('status', '=', 'Overdue')->where('client_id','=', $client->id)->sum('total_amount');
                 $salesinvoice2 = SalesInvoice::where('status', 'Delivered')->where('client_id', $client->id)->sum('total_amount');
                 $salesinvoice3 = SalesInvoice::where('status', 'Check on Hand')->where('client_id', $client->id)->sum('total_amount');
                 $salesinvoiceTotal[$client->id] = $salesinvoice + $salesinvoice2 + $salesinvoice3;
                 //$salesinvoice[$client->id] = SalesInvoice::where('status = Overdue or status = Delivered and client_id = '.$client->id.'')->sum('total_amount');
            }

            // for ($x = 1; $x < count($clients)+1; $x++)
            // {
            //    $overdue[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Overdue')->count();
            //    $delivered[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Delivered')->count();
            //    $pending[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Pending')->count();
            // }
            return view('collectibles.index', compact('clients', 'overdue', 'delivered', 'check', 'salesinvoiceTotal'));
        }
    }

    public function search()
    {
        $input = Request::all();
        $query = $input['query'];
        $clients = Client::where('name','LIKE',"%$query%")->paginate(10);
        $overdue = new SalesInvoice;
        $delivered = new SalesInvoice;
        $check = new SalesInvoice;
        $salesinvoice = new SalesInvoice;
        $salesinvoice2 = new SalesInvoice;
        $salesinvoice3 = new SalesInvoice;
        $salesinvoiceTotal;
        foreach($clients as $client)
        {
           $overdue[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Overdue')->count();
           $delivered[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Delivered')->count();
           $check[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Check on Hand')->count();
           // $salesinvoice[$client->id] = DB::SELECT("SELECT sum(total_amount) as total FROM sales_invoices 
           //                        WHERE (status = 'Overdue' or  status = 'Delivered') and client_id = '$client->id'");
           $salesinvoice = SalesInvoice::where('status', '=', 'Overdue')->where('client_id','=', $client->id)->sum('total_amount');
           $salesinvoice2 = SalesInvoice::where('status', 'Delivered')->where('client_id', $client->id)->sum('total_amount');
           $salesinvoice3 = SalesInvoice::where('status', 'Check on Hand')->where('client_id', $client->id)->sum('total_amount');
           $salesinvoiceTotal[$client->id] = $salesinvoice + $salesinvoice2 + $salesinvoice3;
        }
        if ($clients == "[]")
        {
            //flash()->error('There are no clients that match your query.');
            return redirect()->action('CollectiblesController@index');
        }
        $clients->appends(Request::only('query'));
        return view('collectibles.index',compact('clients', 'overdue', 'delivered', 'check', 'salesinvoiceTotal'));
    }

    public function filter()
    {
        $input = Request::all();
        $filter = $input['filter'];
        if ($filter == 'All')
        {
            return redirect()->action('CollectiblesController@index');
        }
        $clients = Client::where('status',$filter)->paginate(10);
        $overdue = new SalesInvoice;
        $delivered = new SalesInvoice;
        $check = new SalesInvoice;
        $salesinvoice = new SalesInvoice;
        $salesinvoice2 = new SalesInvoice;
        $salesinvoice3 = new SalesInvoice;
        $salesinvoiceTotal;
        foreach($clients as $client)
        {
           $overdue[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Overdue')->count();
           $delivered[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Delivered')->count();
           $check[$client->id] = SalesInvoice::where('client_id', $client->id)->where('status', 'Check on Hand')->count();
           // $salesinvoice[$client->id] = DB::SELECT("SELECT sum(total_amount) as total FROM sales_invoices 
           //                        WHERE (status = 'Overdue' or  status = 'Delivered') and client_id = '$client->id'");
           $salesinvoice = SalesInvoice::where('status', '=', 'Overdue')->where('client_id','=', $client->id)->sum('total_amount');
           $salesinvoice2 = SalesInvoice::where('status', 'Delivered')->where('client_id', $client->id)->sum('total_amount');
           $salesinvoice3 = SalesInvoice::where('status', 'Check on Hand')->where('client_id', $client->id)->sum('total_amount');
           $salesinvoiceTotal[$client->id] = $salesinvoice + $salesinvoice2 + $salesinvoice3;
        }
        // for ($x = $clients[0]; $x < count($clients)+1; $x++)
        // {
        //    $overdue[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Overdue')->count();
        //    $delivered[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Delivered')->count();
        //    $pending[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Pending')->count();
        // }
        if ($clients == "[]")
        {
            return redirect()->action('CollectiblesController@index');
        }
        $clients->appends(Request::only('filter'));
        return view('collectibles.index',compact('clients', 'overdue', 'delivered', 'check', 'salesinvoiceTotal'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function generatePdf($id)
    {
        ini_set("max_execution_time", 0);
        // $sales_invoice = SalesInvoice::find($id);
        $client = Client::find($id);

        $currentCollectibles = DB::SELECT("SELECT DATE_FORMAT(date, '%m/%d/%Y') as date, DATE_FORMAT(due_date, '%m/%d/%Y') as due_date, po_number, si_no, total_amount FROM sales_invoices si
                                            WHERE si.client_id = '$id' AND si.status='delivered' OR si.status='overdue'");

        $totalDue = DB::SELECT("SELECT SUM(total_amount) as sumTotal FROM sales_invoices si WHERE si.client_id = '$id' AND si.status='delivered' OR si.status='overdue'");

        $pdf = \PDF::loadView('collectibles.generate', compact('client', 'currentCollectibles', 'totalDue'));
        Activity::log('SOA for '. $client['name'] .' was generated');
        return $pdf->stream();

        // $data = []; // Empty array

        // Mail::send('collectibles.email', $data, function($message) use($pdf)
        //     {
        //         $message->from('dummyboi24@gmail.com', 'Tester');

        //         $message->to('jcy_424@yahoo.com')->subject('Statement of Account');

        //         $message->attachData($pdf->output(), "soa.pdf");
        //     });
    }

    public function emailPDF($id)
    {
        ini_set("max_execution_time", 0);
        // $sales_invoice = SalesInvoice::find($id);
        $client = Client::find($id);

        $currentCollectibles = DB::SELECT("SELECT DATE_FORMAT(date, '%m/%d/%Y') as date, DATE_FORMAT(due_date, '%m/%d/%Y') as due_date, po_number, si_no, total_amount FROM sales_invoices si
                                            WHERE si.client_id = '$id' AND si.status='delivered' OR si.status='overdue'");

        $totalDue = DB::SELECT("SELECT SUM(total_amount) as sumTotal FROM sales_invoices si WHERE si.client_id = '$id' AND si.status='delivered' OR si.status='overdue'");

        $pdf = \PDF::loadView('collectibles.generate', compact('client', 'currentCollectibles', 'totalDue'));
        Activity::log('SOA for '. $client['name'] .' was generated');
        // return $pdf->stream();

        $data = []; // Empty array

        $clientEmail = $client->accounting_email;

        try{

        Mail::send('collectibles.email', $data, function($message) use($pdf, $clientEmail)
            {
                $message->from('dummyboi24@gmail.com', 'Tester');

                $message->to($clientEmail)->subject('Statement of Account');

                $message->attachData($pdf->output(), "SoA_". date('m/d/Y') . ".pdf");
            });

        Flash::success('Email sent successfully');
        return redirect()->action('CollectionLogsController@index', [$client->id]);

        }

        catch(\Exception $e){
        Flash::error('Failed to send email! Please check if the Client\'s accounting email is correct');
        return redirect()->action('CollectionLogsController@index', [$client->id]);

        }

    }
}
