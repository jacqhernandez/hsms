<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->double('price',12,2);
            $table->boolean('stock_availability');
            $table->integer('supplier_id')->unsigned();
            $table->integer('item_id')->unsigned();

            $table->foreign('supplier_id')
                  ->references('id')->on('suppliers');

            $table->foreign('item_id')
                  ->references('id')->on('items');
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
        Schema::drop('price_logs');
    }
}
