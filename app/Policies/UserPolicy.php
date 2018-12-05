<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
		use HandlesAuthorization;
		private $permissions;

		/**
		 * Enlists user permissions when $permissions = null
		 * @param  \App\User  $user
		 * @return array[]
		 */
		private function checkPermission(User $user)
		{
			if($this->permissions == null) {
				$this->permissions = DB::table('permissions')
					->join('permissionsRole', 'permissions.id', '=', 'permissionsRole.idPermission')
					->join('usersRole', 'usersRole.idRole', '=', 'permissionsRole.idRole')
					->select('permissions.description')
					->where('usersRole.idUser', $user->id)
					->get();
			}
		}

		/**
		 * Determines whether user can view the users index
		 * @param  \App\User $user
		 * @return boolean
		 */
		public function index($user)
		{
				$this->checkPermission($user);
				$toCheck = "user_index";
				//dd($user, $toCheck, $this->permissions->pluck('description')->all(), in_array($toCheck, $this->permissions->pluck('description')->all()));
				return in_array( $toCheck, $this->permissions->pluck('description')->all() );
		}

		/**
		 * Determines whether user can delete users
		 * @param  \App\User $user
		 * @return boolean
		 */
		public function delete($user)
		{
				$this->checkPermission($user);
				$toCheck = "user_delete";
				//dd($user, in_array($toCheck, $this->permissions->pluck('description')->all()));
				return in_array( $toCheck, $this->permissions->pluck('description')->all() );
		}

		/**
		 * Determines whether user can view a user or their own user
		 * @param  \App\User $user
		 * @return boolean
		 */
		public function view(User $authuser, User $modeluser)
		{
				$this->checkPermission($authuser);
				$toCheck = "user_update";
				//dd($authuser, $modeluser, $this->permissions->pluck('description')->all(), in_array($toCheck, $this->permissions->pluck('description')->all()));
				return in_array( $toCheck, $this->permissions->pluck('description')->all() );
		}

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return false;
    }
}
