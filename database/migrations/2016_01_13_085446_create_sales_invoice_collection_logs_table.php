<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesInvoiceCollectionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_invoice_collection_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_invoice_id')->unsigned();
            $table->foreign('sales_invoice_id')
                  ->references('id')
                  ->on('sales_invoices')
                  ->onDelete('cascade');
            $table->integer('collection_log_id')->unsigned();
            $table->integer('client_id')->unsigned();

            //$table->foreign('sales_invoice_id')->references('id')->on('sales_invoices');
            $table->foreign('collection_log_id')->references('id')->on('collection_logs')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sales_invoice_collection_logs');
    }
}
