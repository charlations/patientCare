<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedHistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medHistory', function (Blueprint $table) {
						$table->increments('id');
            $table->integer('idPatient')->unsigned();
						$table->integer('idMedHistList')->unsigned();
						$table->text('histRecord')->nullable()->default(null);
						$table->timestamps();
						$table->foreign('idPatient')
							->references('id')->on('patients')
							->onDelete('cascade');
						$table->foreign('idMedHistList')
								->references('id')->on('medHistList')
								->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medHistory');
    }
}
