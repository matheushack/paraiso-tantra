<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cpf', 11);
            $table->enum('gender', ['F', 'M'])->default('M');
            $table->date('birth_date');
            $table->string('phone', 13);
            $table->string('cell_phone', 14);
            $table->string('email');
            $table->string('color');
            $table->text('observation');
            $table->decimal('commission');
            $table->tinyInteger('is_access_system')->default(0);

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
        Schema::dropIfExists('employees');
    }
}
