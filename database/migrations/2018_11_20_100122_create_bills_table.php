<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('call_id')->nullable();
            $table->unsignedInteger('payment_id');
            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('unity_id');
            $table->enum('type', ['R', 'D']);
            $table->enum('status', ['AP','AR','P','R']);
            $table->text('description');
            $table->date('expiration_date');
            $table->decimal('amount', 8, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('call_id')
                ->references('id')
                ->on('calls');

            $table->foreign('payment_id')
                ->references('id')
                ->on('payment_methods');

            $table->foreign('unity_id')
                ->references('id')
                ->on('units');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
