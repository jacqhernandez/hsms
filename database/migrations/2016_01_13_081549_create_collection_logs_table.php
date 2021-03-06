<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('action');
            // $table->date('follow_up_date');
            $table->string('note');
            $table->string('status');
            $table->integer('reason_id')->unsigned()->nullable();
            $table->foreign('reason_id')
                  ->references('id')->on('reasons')
                  ->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->nullable();
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')
                  ->references('id')->on('clients');
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
        Schema::drop('collection_logs');
    }
}
