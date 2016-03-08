<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SalesInvoice;
use App\Client;
use App\SalesInvoiceCollectionLog;
use App\CollectionLog;

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
        $invoices = \DB::table('sales_invoices')->whereRaw('(week(now()) - week(due_date) >= 1) and (status != "Collected")');
        $invoices->update(['status' => "Overdue"]);

        //create collection To Do
        $DueDate_Components = DB::SELECT("SELECT YEAR(due_date) as Year, MONTH(due_date) as Month, DAYOFMONTH(due_date) as Day FROM sales_invoices
                                            WHERE sales_invoices.id = '$id'");

        foreach ($invoices as $invoice)
        {
            $client = Client::find($invoice->client_id);
            $client->update(['status'=>"Blacklisted"]);

            $clientId = $invoices->client_id;
            $mondayOf = Carbon::create($DueDate_Components[0]->Year, $DueDate_Components[0]->Month, $DueDate_Components[0]->Day)->startOfWeek()->subweek();

            $cLog = new CollectionLog;
            $cLog->date = $mondayOf;
            $cLog->action = 'Call and Send SOA';
            $cLog->client_id = $salesInvoice->client_id;
            $cLog->status = 'To Do';
            $cLog->save();

            $sicl = new SalesInvoiceCollectionLog;
            $sicl->sales_invoice_id = $id;
            $sicl->client_id = $cLog->client_id;
            $sicl->collection_log_id = $cLog->id;
            $sicl->save();
        }

        //problem is if saturday, it will be 6-7 so it will subtract
        //\DB::table('sales_invoices')->whereRaw('((date_add(due_date,interval 6-dayofweek(due_date) day)) < (date_add(date(now()),interval 6-dayofweek(date(now())) day))) and (status != "Collected")')->update(['status'=>"Overdue"]);
    }
}


