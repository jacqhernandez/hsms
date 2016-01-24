<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        \DB::table('sales_invoices')->whereRaw('due_date < now() and status != "Collected"')->update(['status' => "Overdue"]);
    }
}
