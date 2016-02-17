<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\SalesInvoice;
use Activity;
use Mail;
use DB;

class CollectiblesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(10);
        $overdue = new SalesInvoice;
        $delivered = new SalesInvoice;
        for ($x = 1; $x < count($clients)+1; $x++)
        {
           $overdue[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Overdue')->count();
           $delivered[$x] = SalesInvoice::where('client_id', $x)->where('status', 'Delivered')->count();
        }
        return view('collectibles.index', compact('clients', 'overdue', 'delivered'));
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

        Mail::send('collectibles.email', $data, function($message) use($pdf)
            {
                $message->from('dummyboi24@gmail.com', 'Tester');

                $message->to('jcy_424@yahoo.com')->subject('Statement of Account');

                $message->attachData($pdf->output(), "soa.pdf");
            });
    }
}
