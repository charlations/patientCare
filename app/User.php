<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastNames', 'email', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
		];

    /**
     * Returns if user has permission
     * @param string $permission
     * @return boolean
     */
    public function hasPermission($permission) {
			$permissions = DB::table('permissions')
				->join('permissionsRole', 'permissions.id', '=', 'permissionsRole.idPermission')
				->join('usersRole', 'usersRole.idRole', '=', 'permissionsRole.idRole')
				->select('permissions.description')
				->where('usersRole.idUser', Auth::user()->id)
				->get();
			//dd($permissions, in_array( $permission, $permissions->pluck('description')->all() ));
			//return false;
			return in_array( $permission, $permissions->pluck('description')->all() );
    }
}
