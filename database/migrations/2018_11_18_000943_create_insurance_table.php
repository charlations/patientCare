<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->increments('id');
						$table->string('insuranceName');
						$table->text('notes');
				});
				
				// Agregar la foreign key a los pacientes
				// Schema::table('patients', function(Blueprint $table) {
				//	$table->foreign('idInsurance')->references('id')->on('insurances')->onDelete('cascade');
				// });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurances');
    }
}
