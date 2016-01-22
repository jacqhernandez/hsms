<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\Item;
use Excel;
use Request;
use DB;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $reportOptions = [];
        $reportOptions['sales'] = 'Sales';
        $reportOptions['collection'] = 'Collection';
        $reportOptions['item'] = 'Item';
        $reportOptions['client'] = 'Client';

        $clients = Client::lists('name', 'id');
        $items = Item::lists('name', 'id');
        
        return view('reports.index', compact('reportOptions', 'clients', 'items'));
    }

    public function generate()
    {
        $input = Request::all();
        $counter = 1;
        $reportType = $input['report_type'];

        if ($reportType == "sales")
        {
            
        }

        else if ($reportType == "collection")
        {

        }

        else if ($reportType == "item")
        {

        }

        else if ($reportType == "client")
        {
            //$client = Client::all();
            $clients = DB::select('SELECT * FROM clients');
            //$client = DB::table('clients')->get();

            Excel::create('test', function($excel) use($clients) {
            $excel->sheet('Home', function($sheet) use($clients) {

                foreach ($clients as $client)
                {
                    //$sheet->row($counter, array($client->name, $client->id));
                    $counter++;
                }
                //$sheet->fromModel($client);
            });

            })->export('xlsx');
        }

       //$client = Client::all();


        // Excel::create('test', function($excel) use($client) {
        //     $excel->sheet('Home', function($sheet) use($client) {

        //         $sheet->fromModel($client);
        //     });

        //     })->export('xlsx');
    }
}
