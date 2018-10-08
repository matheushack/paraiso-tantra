<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unity_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->decimal('amount');
            $table->decimal('discount');
            $table->decimal('total');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('unity_id')
                ->references('id')
                ->on('units');
            $table->foreign('service_id')
                ->references('id')
                ->on('services');
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms');
            $table->foreign('customer_id')
                ->references('id')
                ->on('customers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calls');
    }
}
