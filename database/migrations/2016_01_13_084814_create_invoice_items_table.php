<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->double('unit_price',12,2);
            $table->double('total_price',12,2);
            $table->integer('sales_invoice_id')->unsigned();
            $table->integer('item_id')->unsigned();

            $table->foreign('sales_invoice_id')
                  ->references('id')
                  ->on('sales_invoices')
                  ->onDelete('cascade');

            $table->foreign('item_id')
                  ->references('id')
                  ->on('items');

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
        Schema::drop('invoice_items');
    }
}
