<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->string('telephone_number');
            $table->string('address');
            $table->string('email');
            $table->string('tin');
			// $table->string('tin')->unique();
            $table->string('contact_person');
            $table->string('accounting_contact_person');
            $table->string('accounting_email');
            $table->double('credit_limit', 12, 2)->unsigned();
			$table->string('status');
            $table->string('payment_terms');
            $table->string('vat_exempt');
            $table->string('customer_id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
