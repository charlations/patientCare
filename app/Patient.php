<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'name', 'lastNames', 'gender', 'birthdate', 'idInsurance', 'email',
		];
}
