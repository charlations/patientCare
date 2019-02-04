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
						$table->string('lastNames')->nullable()->default(null);
						$table->enum('gender', ['genderM', 'genderF', 'genderO']);
						$table->date('birthdate');
						$table->integer('idInsurance')->unsigned()->nullable();
            $table->string('email')->unique()->nullable();
						$table->timestamps();
						$table->softDeletes();
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
