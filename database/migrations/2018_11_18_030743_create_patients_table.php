<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
						$table->increments('id');
						$table->string('name');
						$table->string('lastNames');
						$table->enum('gender', ['Hombre', 'Mujer', 'Otro']);
						$table->date('birthdate');
						$table->integer('idInsurance')->unsigned();
            $table->string('email')->unique();
						$table->timestamps();
						$table->foreign('idInsurance')->references('id')->on('insurances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
