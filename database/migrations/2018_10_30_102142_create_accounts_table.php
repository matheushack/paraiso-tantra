<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['I', 'B'])->default('I');
            $table->integer('bank_id')->nullable()->unsigned();
            $table->enum('account_type', ['C', 'P'])->nullable();
            $table->string('agency_number')->nullable();
            $table->string('account_number')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bank_id')
                ->references('id')
                ->on('banks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
