<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCallsPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('call_id')->unsigned();
            $table->integer('payment_id')->unsigned();
            $table->decimal('amount');
            $table->decimal('aliquot')->default(0);
            $table->date('date_in_account')->nullable();

            $table->foreign('call_id')
                ->references('id')
                ->on('calls');
            $table->foreign('payment_id')
                ->references('id')
                ->on('payment_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_payments');
    }
}
