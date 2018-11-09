<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj')->unique();
            $table->string('name');
            $table->string('social_name');
            $table->string('cep');
            $table->string('address');
            $table->integer('number');
            $table->string('complement');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state', 2);
            $table->string('email');
            $table->string('phone', 13);
            $table->string('cell_phone', 14);
            $table->json('operating_hours')->nullable();
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
        Schema::dropIfExists('units');
    }
}
