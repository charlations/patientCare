<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'idPatient', 'symptoms', 'exploration', 'heartrate', 'bloodpressure', 'temp', 'weight', 'height', 'prevStudies', 'diagnosis', 'treatment',
		];
		protected $dates = ['created_at', 'updated_at',];
}

/**
 * $table->increments('id');
 * $table->integer('idPatient')->unsigned();
 * $table->text('symptoms')->nullable();
 * $table->text('exploration')->nullable();
 * $table->integer('heartrate')->nullable();
 * $table->string('bloodpressure', 9)->nullable();
 * $table->double('temp', 6, 2)->nullable();
 * $table->double('weight', 6, 2)->nullable();
 * $table->double('height', 6, 2)->nullable();
 * $table->text('prevStudies')->nullable();
 * $table->lineString('diagnosis')->nullable();
 * $table->text('treatment')->nullable();
 * $table->timestamps();
 */