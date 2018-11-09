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
            $table->integer('payment_id')->unsigned()->nullable();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->enum('status', ['A', 'P'])->default('A');
            $table->decimal('amount');
            $table->decimal('discount');
            $table->decimal('aliquot')->default(0);
            $table->decimal('total');
            $table->enum('type_discount', ['C', 'B', 'T'])->nullable();
            $table->tinyInteger('first_call')->default(0);
            $table->text('description')->nullable();
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
