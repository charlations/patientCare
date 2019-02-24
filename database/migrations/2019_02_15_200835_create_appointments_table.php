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
						$table->text('symptoms')->nullable();
						$table->text('exploration')->nullable();
						$table->integer('heartrate')->nullable();
						$table->string('bloodpressure', 9)->nullable();
						$table->decimal('temp', 6, 2)->nullable();
						$table->string('weight', 9)->nullable();
						$table->string('height', 9)->nullable();
						$table->text('prevStudies')->nullable();
						$table->string('diagnosis', 255)->nullable();
						$table->text('treatment')->nullable();
            $table->timestamps();
						$table->foreign('idPatient')
							->references('id')->on('patients')
							->onDelete('cascade');
        });
		}
		/**
		 * id paciente
		 * fechas
		 * symptoms
		 * exploration
		 * heartrate
		 * blood pressure (tensión arterial)
		 * temp
		 * weight
		 * height (talla)
		 * índice de masa corporal
		 * prev studies
		 * diagnosis
		 * treatment
		 * 
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
