<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    /* Define table name */
		protected $table = 'usersRole';

		/**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
			'idUser', 'idRole', 'notes',
		];
}
