<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'idPatient', 'idAntecedente', 'histRecord',
		];
}