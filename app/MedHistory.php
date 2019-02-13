<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedHistory extends Model
{
		/* Define table name */
		protected $table = 'medHistory';

		/* Define no primary key, since we are using a composite primary key 
		protected $primaryKey = null;
    public $incrementing = false; /* */

		/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'idPatient', 'idMedHistList', 'histRecord',
		];
}