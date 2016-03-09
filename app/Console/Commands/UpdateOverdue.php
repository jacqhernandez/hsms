<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SalesInvoice;
use App\Client;
use App\SalesInvoiceCollectionLog;
use App\CollectionLog;
use DB;
use App\Reason;
use Carbon\Carbon;

class UpdateOverdue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'overdue:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will update invoice status to Overdue if due date has passed and client has not yet paid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //\DB::table('sales_invoices')->whereRaw('(week(now()) - week(due_date) >= 1) and (status != "Collected")')->update(['status' => "Overdue"]);
        // $invoices = DB::table('sales_invoices')->whereRaw('(week(now()) - week(due_date) >= 1) and (status != "Collected")');
        // $invoices = DB::SELECT("SELECT * FROM sales_invoices WHERE (week(now()) - week(due_Date) >= 1) and (status != 'Collected')");
        $invoices = SalesInvoice::whereRaw('(week(now()) - week(due_date) >= 1) and (status != "Collected")');
        $invoicesForClient = SalesInvoice::whereRaw('(week(now()) - week(due_date) >= 1) and (status != "Collected")')->get();

        $invoices->update(['status' => "Overdue"]);

        foreach ($invoicesForClient as $invoice)
        {
            $client = Client::find($invoice->client_id);
            $client->update(['status' => "Blacklisted"]);
        }



        

        // $overdues = \DB::table('sales_invoices')->whereRaw('status = "Overdue"');

        $overdues = DB::SELECT("SELECT * FROM sales_invoices where status = 'Overdue'");
        $today = Carbon::today();
        $mondayOf = Carbon::now()->startOfWeek();

        if($today == $mondayOf)
        {
            foreach ($overdues as $overdue)
            {
                $cLog = new CollectionLog;
                $cLog->date = $mondayOf;
                $cLog->action = 'Call and Send SOA Overdue';
                $cLog->client_id = $overdue->client_id;
                $cLog->status = 'To Do';
                $cLog->save();

                $sicl = new SalesInvoiceCollectionLog;
                $sicl->sales_invoice_id = $overdue->id;
                $sicl->client_id = $cLog->client_id;
                $sicl->collection_log_id = $cLog->id;
                $sicl->save();
            }
        }

        // $reason = new Reason;
        // $reason->reason = 'WEW';
        // $reason->save();
        
        //problem is if saturday, it will be 6-7 so it will subtract
        //\DB::table('sales_invoices')->whereRaw('((date_add(due_date,interval 6-dayofweek(due_date) day)) < (date_add(date(now()),interval 6-dayofweek(date(now())) day))) and (status != "Collected")')->update(['status'=>"Overdue"]);
    }
}


