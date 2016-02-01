<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\Item;
use App\SalesInvoice;
use Excel;
use Request;
use DB;


class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('general_manager');     
    }

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

        //$yearOptions = [];
        //$counter = 0;
        //$years = DB::select("SELECT YEAR(date) AS 'year' FROM sales_invoices")->get();

        $years = DB::table('sales_invoices')->select(db::raw('YEAR(date) as yearDate'))->lists('yearDate', 'yearDate');
        //$years = Salesinvoice::lists('date');
        return view('reports.index', compact('reportOptions', 'clients', 'items', 'years'));
        //return $years;
    }

    public function generate()
    {
        $input = Request::all();
        $counter = 1;
        $reportType = $input['report_type'];
        $salesCounter = 0;
        $counterClientBreakdown = 0;
        $counterClientLabel = 0;
        $counterClientData = 0;

        if ($reportType == "sales")
        {
            $monthStart = $input['select_monthFrom'];
            $monthEnd = $input['select_monthTo'];
            $year = $input['year'];

            $monthStartName = date("F", mktime(0, 0, 0, $monthStart, 10));
            $monthEndName = date("F", mktime(0, 0, 0, $monthEnd, 10));


            $results = DB::select("SELECT SUM(total_amount) as 'total' FROM sales_invoices si
                                    WHERE MONTH(si.date) >= '$monthStart' AND MONTH(si.date) <= '$monthEnd'
                                    AND YEAR(si.date) = '$year'");

            $resultsClient = DB::select("SELECT name, SUM(total_amount) as 'total'  FROM clients c
                                        JOIN sales_invoices si ON si.client_id = c.id
                                        WHERE MONTH(si.date) >= '$monthStart' AND MONTH(si.date) <= '$monthEnd'
                                        AND YEAR(si.date) = '$year' GROUP BY c.id");

            $resultsSales = DB::select("SELECT username, SUM(total_amount) as 'total'  FROM users u
                                        JOIN clients c ON c.user_id = u.id
                                        JOIN sales_invoices si ON si.client_id = c.id 
                                        WHERE MONTH(si.date) >= '$monthStart' AND MONTH(si.date) <= '$monthEnd'
                                        AND YEAR(si.date) = '$year' GROUP BY u.id");

            Excel::create('Sales Report ' . \Carbon\Carbon::today()->format('m-d-y'), function($excel) use($results, $resultsClient, $resultsSales,
                $counter, $monthStartName, $monthEndName, $salesCounter, $counterClientBreakdown, $counterClientLabel, $counterClientData,
                $year) {
            $excel->sheet('Data', function($sheet) use($results, $resultsClient, $resultsSales, $counter, $monthEndName, $monthStartName,
                $salesCounter, $counterClientBreakdown, $counterClientLabel, $counterClientData, $year) {

                $sheet->row($counter, array('Sales Report'));
                $counter++;
                $sheet->row($counter, array('For ' . $monthStartName . ' To ' . $monthEndName . ', Year ' . $year));
                $counter++;
                $sheet->row($counter, array('Total Sales: ', 'P' . $results[0]->total));

                $counter++;
                $counter++;
                $sheet->row($counter, array('Sale Employee Breakdown:'));

                //styling for 'Sales Employee Breakdown'
                $sheet->cells('A5', function($cells) {
                    $cells->setFontSize(14);
                    $cells->setFontWeight('bold');
                });

                $counter++;

                $sheet->row($counter, array('Username', 'Total Amount'));
                $counter++;

                foreach ($resultsSales as $sales)
                {
                    $sheet->row($counter, array($sales->username, $sales->total));
                    $counter++;
                }

                $salesCounter = $counter - 1;

                $counter += 10;
                $sheet->row($counter, array('Client Breakdown: '));
                $counterClientBreakdown = $counter;
                $counter++;

                $sheet->row($counter, array('Client Name', 'Total Amount'));

                $counterClientLabel = $counter;
                //$counter++;
                $counterClientData = $counter + 1;

                foreach($resultsClient as $client)
                {
                    $counter++;
                    $sheet->row($counter, array($client->name, $client->total));
                    //$counter++;
                }

                //styling 'Sales Report' -> bold
                $sheet->mergeCells('A1:B1');
                $sheet->cells('A1', function($cells) {
                    $cells->setFontSize(16);
                    $cells->setFontWeight('bold');
                });

                //styling for total sales
                $sheet->cells('A3:B3', function($cells) {
                    $cells->setFontSize(14);
                    $cells->setFontWeight('bold');
                });

                //styling for 'Client Breakdown'
                $sheet->cells('A' . $counterClientBreakdown, function($cells) {
                    $cells->setFontSize(14);
                    $cells->setFontWeight('bold');
                });



                //create Sales Employee chart
                if(Count($resultsSales) > 0)
                {
                    //Data Series Label
                    $dsl=array(
                    // new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$3', NULL, 1),
                    new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$B$6', NULL, 1), 
                    );


                    $xal=array(
                    new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$7:$A$' . $salesCounter, NULL, count($resultsSales)),
                    );

                    $dsv=array(
                    new \PHPExcel_Chart_DataSeriesValues('Number', 'Data!$B$7:$B$' . $salesCounter, NULL, count($resultsSales)),
                    );

                    $ds=new \PHPExcel_Chart_DataSeries(
                        \PHPExcel_Chart_DataSeries::TYPE_BARCHART,
                        \PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
                        range(0, count($dsv)-1),
                        $dsl,
                        $xal,
                        $dsv
                        );

                    $pa=new \PHPExcel_Chart_PlotArea(NULL, array($ds));
                    $legend=new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
                    $title=new \PHPExcel_Chart_Title('Sales by Employee');

                    $chart= new \PHPExcel_Chart(
                        'chart1',
                        $title,
                        $legend,
                        $pa,
                        true,
                        0,
                        NULL, 
                        NULL
                        );

                    $chart->setTopLeftPosition('E5');
                    $chart->setBottomRightPosition('L16');
                    $sheet->addChart($chart);
                }

                //create Client Breakdown chart
                if (Count($resultsClient) > 0)
                {
                    //Data Series Label
                    $dsl2=array(
                    // new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$3', NULL, 1),
                    new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$B$' . $counterClientLabel, NULL, 1), 
                    );


                    $xal2=array(
                    new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$' . $counterClientData . ':$A$' . $counter , NULL, count($resultsClient)),
                    );

                    $dsv2=array(
                    new \PHPExcel_Chart_DataSeriesValues('Number', 'Data!$B$' . $counterClientData . ':$B$' . $counter, NULL, count($resultsClient)),
                    );

                    $ds2=new \PHPExcel_Chart_DataSeries(
                        \PHPExcel_Chart_DataSeries::TYPE_BARCHART,
                        \PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
                        range(0, count($dsv2)-1),
                        $dsl2,
                        $xal2,
                        $dsv2
                        );

                    $pa2=new \PHPExcel_Chart_PlotArea(NULL, array($ds2));
                    $legend2=new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
                    $title2=new \PHPExcel_Chart_Title('Sales by Client');

                    $chart= new \PHPExcel_Chart(
                        'chart2',
                        $title2,
                        $legend2,
                        $pa2,
                        true,
                        0,
                        NULL, 
                        NULL
                        );

                    $chart->setTopLeftPosition('E19');
                    $chart->setBottomRightPosition('L30');
                    $sheet->addChart($chart);
                }
            });            
            })->export('xlsx');

        }

        else if ($reportType == "collection")
        {
            $monthStart = $input['select_monthFrom'];
            $monthEnd = $input['select_monthTo'];
            $year = $input['year'];

            $monthStartName = date("F", mktime(0, 0, 0, $monthStart, 10));
            $monthEndName = date("F", mktime(0, 0, 0, $monthEnd, 10));

            $counter = 1;

            $results = DB::select("SELECT sum(total_amount) as 'total', count(*) as 'numCount' FROM sales_invoices si
                                    WHERE (si.status = 'delivered' OR si.status = 'overdue')
                                    AND MONTH(si.due_date) >= '$monthStart' AND MONTH(si.due_date) <= '$monthEnd'
                                    AND YEAR(si.due_date) = '$year'");

            $resultsCollected = DB::select("SELECT sum(total_amount) as 'total', count(*) as 'numCount' FROM sales_invoices si
                                                WHERE si.status = 'collected'
                                                AND MONTH(si.due_date) >= '$monthStart' AND MONTH(si.due_date) <= '$monthEnd'
                                                AND YEAR(si.due_date) = '$year'");

            $resultsInvoices = DB::select("SELECT name, si_no, date, due_date, total_amount, si.status FROM sales_invoices si
                                            JOIN clients c ON si.client_id = c.id
                                            WHERE MONTH(si.due_date) >= '$monthStart' AND MONTH(si.due_date) <= '$monthEnd'
                                            AND YEAR(si.due_date) = '$year' ORDER BY name, si.status");

            Excel::create('Collection Report ' . \Carbon\Carbon::today()->format('m-d-y'), function($excel) use($results, $counter, $monthStartName, $monthEndName, $year,
                $resultsCollected, $resultsInvoices) {
            $excel->sheet('Data', function($sheet) use($results, $counter, $monthStartName, $monthEndName, $year, $resultsCollected, $resultsInvoices) {

                    $sheet->row($counter, array('Collection Report'));
                    $counter++;
                    $sheet->row($counter, array('For ' . $monthStartName . ' To ' . $monthEndName . ', Year ' . $year));
                    $counter++;
                    $sheet->row($counter, array('Total Amount Collected: ', $resultsCollected[0]->total));
                    $counter++;
                    $sheet->row($counter, array('Total Collectibles: ', $results[0]->total));
                    $counter+= 2;
                    $sheet->row($counter, array('List of Collectibles: '));
                    $counter++;
                    $sheet->row($counter, array('Client Name', 'Sales Invoice Number', 'Date', 'Due Date', 'Total Amount', 'Status'));
                    $counter++;

                    foreach ($resultsInvoices as $result)
                    {
                        $sheet->row($counter, array($result->name, $result->si_no, $result->date, $result->due_date, $result->total_amount, $result->status));
                        $counter++;
                    }

                    // foreach($results as $result)
                    // {
                    //     $sheet->row($counter, array('Total Collectibles: ', $result->total));
                    // }

                    //style
                    //style for item name
                    $sheet->mergeCells('A1:B1');
                    $sheet->cells('A1', function($cells) {
                        $cells->setFontSize(14);
                        $cells->setFontWeight('bold');
                    });

                    //style for total amount  collected
                    $sheet->cells('A3:B3', function($cells) {
                        $cells->setFontSize(12);
                        $cells->setFontWeight('bold');
                    });

                    //style for total collectibles
                    $sheet->cells('A4:B4', function($cells) {
                        $cells->setFontSize(12);
                        $cells->setFontWeight('bold');
                    });


                });            
            })->export('xlsx');
        }

        else if ($reportType == "item")
        {

            $itemID = $input['item'];
            $item = Item::find($itemID);
            $itemName = $item->name;

            $monthStart = $input['select_monthFrom'];
            $monthEnd = $input['select_monthTo'];
            $year = $input['year'];

            $monthStartName = date("F", mktime(0, 0, 0, $monthStart, 10));
            $monthEndName = date("F", mktime(0, 0, 0, $monthEnd, 10));

            $counterLabel = 0;
            $counterData = 0;

            $results = DB::select("SELECT name, supplier_id FROM price_logs pl
                JOIN suppliers s ON pl.supplier_id = s.id 
                WHERE item_id = '$itemID' AND MONTH(pl.date) >= '$monthStart' 
                AND MONTH(pl.date) <= '$monthEnd' AND YEAR(pl.date) = '$year' 
                GROUP BY pl.supplier_id");

            $itemResults = DB::select("SELECT name, sum(quantity) as 'totalSold', sum(total_price) as 'totalAmount' FROM invoice_items ii
                                        JOIN items i ON ii.item_id = i.id
                                        WHERE ii.item_id = '$itemID'");


            Excel::create('Item Report-'. $itemName . ' '. \Carbon\Carbon::today()->format('m-d-y'), function($excel) use($results, $counter, $itemID,
                $monthStart, $monthStartName, $monthEnd, $monthEndName, $year, $itemResults, $itemName, $counterLabel, $counterData) {
            $excel->sheet('Data', function($sheet) use($results, $counter, $itemID, $monthStart, $monthStartName, $monthEnd, $monthEndName, $year,
                $itemResults, $itemName, $counterLabel, $counterData) {

                    $sheet->row($counter, array('Item Report'));

                    //style for Item Report Title
                    $sheet->cells('A1', function($cells) {
                        $cells->setFontSize(16);
                        $cells->setFontWeight('bold');
                    });

                    $counter++;
                    $sheet->row($counter, array('For ' . $monthStartName . ' To ' . $monthEndName . ', Year ' . $year));
                    $counter++;
                    $sheet->row($counter, array('Item Name: ' . $itemName));

                    //style for item name
                    $sheet->mergeCells('A1:B1');
                    $sheet->cells('A'.$counter, function($cells) {
                        $cells->setFontSize(14);
                        $cells->setFontWeight('bold');
                    });

                    $counter++;
                    $sheet->row($counter, array('Total Quantity Sold: ', 'P' . $itemResults[0]->totalSold));

                    //style for quantity sold
                    $sheet->cells('A'.$counter.':B'.$counter, function($cells) {
                        $cells->setFontSize(12);
                        $cells->setFontWeight('bold');
                    });

                    $counter++;
                    $sheet->row($counter, array('Total Revenue Generated: ', 'P' . $itemResults[0]->totalAmount));

                    //style for revenue generated
                    $sheet->cells('A'.$counter .':B'.$counter, function($cells) {
                        $cells->setFontSize(12);
                        $cells->setFontWeight('bold');
                    });

                    $counter+= 2;

                    foreach($results as $result)
                    {
                        $sheet->row($counter, array($result->name));
                        //style for quantity sold
                        $sheet->cells('A'.$counter, function($cells) {
                            $cells->setFontWeight('bold');
                        });

                        $counter++;

                        $sheet->row($counter, array('Date', 'Unit Price'));
                        $counterLabel = $counter;
                        $counterData = $counter + 1;

                        $logs = DB::select("SELECT date, price FROM price_logs pl 
                                            WHERE item_id = '$itemID' AND supplier_id = '$result->supplier_id'
                                            AND MONTH(pl.date) >= '$monthStart' 
                                            AND MONTH(pl.date) <= '$monthEnd' AND YEAR(pl.date) = '$year'");

                        foreach($logs as $log)
                        {
                            $counter++;
                            $sheet->row($counter, array($log->date, $log->price));
                        }

                        //Create chart
                        if (count($logs) > 0)
                        {
                            //Data Series Label
                            $dsl=array(
                            // new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$3', NULL, 1),
                            new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$B$' . $counterLabel, NULL, 1), 
                            );


                            $xal=array(
                            new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$' . $counterData . ':$A$' . $counter, NULL, count($logs)),
                            );

                            $dsv=array(
                            new \PHPExcel_Chart_DataSeriesValues('Number', 'Data!$B$' . $counterData . ':$B$' . $counter, NULL, count($logs)),
                            );

                            $ds=new \PHPExcel_Chart_DataSeries(
                                \PHPExcel_Chart_DataSeries::TYPE_LINECHART,
                                \PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
                                range(0, count($dsv)-1),
                                $dsl,
                                $xal,
                                $dsv
                                );

                            $pa=new \PHPExcel_Chart_PlotArea(NULL, array($ds));
                            $legend=new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
                            $title=new \PHPExcel_Chart_Title('Price History');

                            $chart= new \PHPExcel_Chart(
                                'chart1',
                                $title,
                                $legend,
                                $pa,
                                true,
                                0,
                                NULL, 
                                NULL
                                );

                            $counter += 5;

                            $chart->setTopLeftPosition('E' . $counterLabel);
                            $chart->setBottomRightPosition('K' . $counter);
                            $sheet->addChart($chart);
                        }

                        $counter += 2;

                    }


                });            
            })->export('xlsx');
        }

        else if ($reportType == "client")
        {
            //$client = Client::all();
            $clientid = $input['client'];
            $clientName = Client::find($clientid)->name;
            $results = DB::select("SELECT c.name AS 'clientName', i.name, SUM(quantity) AS 'total' FROM invoice_items ii
                                    JOIN items i on ii.item_id = i.id 
                                    JOIN sales_invoices si ON ii.sales_invoice_id = si.id
                                    JOIN clients c ON si.client_id = c.id
                                    WHERE c.id = '$clientid'
                                    GROUP BY item_id ORDER BY sum(quantity) DESC LIMIT 3");
            //$client = DB::table('clients')->get();

            Excel::create('Client Report ' . \Carbon\Carbon::today()->format('m-d-y'), function($excel) use($results, $counter, $clientName) {
            $excel->sheet('Data', function($sheet) use($results, $counter, $clientName) {


                $sheet->row($counter, array('Client Report'));
                $counter++;
                //$sheet->row($counter, array('Client Name', $results[0]->clientName));

                $sheet->row($counter, array('Client Name', $clientName));


                $counter++;
                $counter++; //add space
                $sheet->row($counter, array('Most Bought Items:'));
                $counter++;
                $sheet->row($counter, array('Item Name', 'Total Quantity'));
                $counter++;

                foreach ($results as $result)
                {
                    $sheet->row($counter, array($result->name, $result->total));
                    $counter++;
                }

                //Add the styling
                $sheet->mergeCells('A1:B1');
                $sheet->cells('A1', function($cells) {
                    $cells->setFontSize(16);
                    $cells->setFontWeight('bold');
                });

                $sheet->cells('A2:B2', function($cells) {
                    $cells->setFontSize(16);
                });

                $sheet->cells('A4', function($cells) {
                    $cells->setFontWeight('bold');
                });

                //Create chart
                if (count($results) > 0)
                {
                    //Data Series Label
                    $dsl=array(
                    // new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$3', NULL, 1),
                    new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$B$5', NULL, 1), 
                    );


                    $xal=array(
                    new \PHPExcel_Chart_DataSeriesValues('String', 'Data!$A$6:$A$' . $counter, NULL, 3),
                    );

                    $dsv=array(
                    new \PHPExcel_Chart_DataSeriesValues('Number', 'Data!$B$6:$B$' . $counter, NULL, 3),
                    );

                    $ds=new \PHPExcel_Chart_DataSeries(
                        \PHPExcel_Chart_DataSeries::TYPE_BARCHART,
                        \PHPExcel_Chart_DataSeries::GROUPING_STANDARD,
                        range(0, count($dsv)-1),
                        $dsl,
                        $xal,
                        $dsv
                        );

                    $pa=new \PHPExcel_Chart_PlotArea(NULL, array($ds));
                    $legend=new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_RIGHT, NULL, false);
                    $title=new \PHPExcel_Chart_Title('Most Bought');

                    $chart= new \PHPExcel_Chart(
                        'chart1',
                        $title,
                        $legend,
                        $pa,
                        true,
                        0,
                        NULL, 
                        NULL
                        );

                    $chart->setTopLeftPosition('A10');
                    $chart->setBottomRightPosition('C25');
                    $sheet->addChart($chart);
                }
            });            
            })->export('xlsx');
        }
    }
}
