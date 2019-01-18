<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntecedentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedentes', function (Blueprint $table) {
						$table->increments('id');
						$table->string('abbreviation', 5);
						$table->string('name', 20);
        });
				
				// Agregar la foreign key a los pacientes
				Schema::table('medHistory', function(Blueprint $table) {
						$table->foreign('idAntecedente')->references('id')->on('antecedentes')->onDelete('cascade');
				});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
				Schema::dropIfExists('antecedentes');
    }
}
