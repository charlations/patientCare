<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
		/**
		 * Require user be logged in
		 */
		public function __construct()
		{
				$this->middleware('auth');
		}
		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
				$this->authorize('index', $user);
				$users = DB::table('users')->where('active', '=', '1')->get();
				return view('user.index', ['users' => $users]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
			$tempUser = $user;
			//$user = User::findOrFail($id);
			//dd($user);
			$this->authorize('view', $tempUser);
			return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
				return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
			$user->update($request->validate([
				'name' => ['required', 'min:2'],
				'lastNames' => 'nullable',
				'email' => ['nullable', 'email']
			]));
			return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
				$this->authorize('delete', auth()->user());
				$user->update(['active' => 0]);
				return redirect('/user');
    }
}
