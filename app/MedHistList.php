<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedHistList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
			'abbreviation', 'name',
		];
}
