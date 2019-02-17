<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
						$table->increments('id');
						$table->integer('idPatient')->unsigned();
						$table->text('symptoms');
						$table->text('diagnosis');
						$table->text('exploration');
						$table->text('treatment');
						
            $table->timestamps();
        });
		}
		/**
		 * id paciente
		 * fechas
		 * symptoms
		 * diagnosis
		 * exploration
		 * treatment
		 * heartrate
		 * blood pressure
		 * temp
		 * bool follow up
		 */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
