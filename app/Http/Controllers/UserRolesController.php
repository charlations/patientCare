<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('user.index');
    }

    /**
     * Return to the last page, with the inputs if required
     *
     * @return \Illuminate\Http\Response
     */ 
    public function create()
    {
			return redirect($request->header("referer"))->withInput(
				$request->except(['_token'])
			);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Request $request)
    {
			//dd(count($request->except(['_token', 'idUser', 'idRole', 'notes'])));
			UserRoles::create($request->validate([
				'idUser' => ['required', 'exists:mysql.users,id'],
				'idRole' => ['required', 'exists:mysql.roles,id'],
				'notes' => 'nullable'
			]));
			return redirect($request->header("referer"))->withInput(
				$request->except(['_token'])
			);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function show(UserRoles $userRoles)
    {
			return redirect($request->header("referer"))->withInput(
				$request->except(['_token'])
			);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRoles $userRoles)
    {
			return redirect($request->header("referer"))->withInput(
				$request->except(['_token'])
			);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRoles $userRoles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function destroy($userId, $userRolesId)
    {
			$userRoles = UserRoles::findOrFail($userRolesId);
			//dd($userId, $userRoles);
			if($userRoles->idUser == $userId) {
				$userRoles->delete();
			}
			return redirect()->route('user.edit', ['user' => $userId]);
    }
}
