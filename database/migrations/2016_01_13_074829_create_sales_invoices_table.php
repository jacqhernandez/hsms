<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('si_no');
            $table->string('po_number');
            $table->string('dr_number');
            $table->date('date');
            $table->date('due_date');
            $table->double('total_amount', 12, 2)->unsigned();
            $table->string('status');
            $table->date('date_delivered');
            $table->date('date_collected');
            $table->string('or_number');

            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')
                  ->references('id')->on('clients')
                  ->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->nullable();

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
        //
    }
}
