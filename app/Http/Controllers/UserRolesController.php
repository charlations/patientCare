<?php

namespace App\Http\Controllers;

use App\UserRoles;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
			dd(count($request->except(['_token', 'idUser', 'idRole', 'notes'])));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserRoles  $userRoles
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRoles $userRoles)
    {
        //
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
    public function destroy(UserRoles $userRoles)
    {
        //
    }
}
