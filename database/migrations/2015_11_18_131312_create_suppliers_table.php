<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
            $table->string('description');
			$table->string('telephone_number');
            $table->string('tin');
			// $table->string('tin')->unique();
			$table->string('address');
			$table->string('email');
            $table->string('payment_terms');
            $table->string('contact_person');
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
        Schema::drop('suppliers');
    }
}
