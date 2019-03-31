<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
//For switchLocale
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
		/**
		 * Require user be logged in
		 * Check permissions via middleware for all necesary functions
		 */
		public function __construct()
		{
				$this->middleware('auth');
				$this->middleware('permission:user_index')->only('index');
				$this->middleware('permission:user_view')->only('show');
				$this->middleware('permission:user_edit')->only('edit');
				$this->middleware('permission:user_edit')->only('update');
				$this->middleware('permission:user_delete')->only('destroy');
		}
		
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
				//$this->authorize('index', $user);
				$users = DB::table('users')->where('active', '=', '1')->get();
				return view('user.index', ['users' => $users]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
			$roles = Role::all();
			return view('user.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
			if (($user = User::where('email', $request['email'])->first()) == null) {
				$data = $request->validate([
					'name' => ['required', 'string', 'max:255'],
					'last_name' => ['string', 'max:255'],
					'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
					'idRole' => 'exists:roles,id',
					'password' => ['required', 'string', 'min:6', 'confirmed'],
				]);
				$user = User::create([
					'name' => $data['name'],
					'lastNames' => $data['last_name'],
					'email' => $data['email'],
					'password' => Hash::make($data['password']),
				]);
			} else {
				$data = $request->validate([
					'name' => ['required', 'string', 'max:255'],
					'last_name' => ['string', 'max:255'],
					'email' => ['required', 'string', 'email', 'max:255'],
					'idRole' => 'exists:roles,id',
					'password' => ['required', 'string', 'min:6', 'confirmed'],
				]);
				$user->update([
					'name' => $data['name'],
					'lastNames' => $data['last_name'],
					'password' => Hash::make($data['password']),
					'active' => 1,
				]);
			}
			UserRoles::create([
				'idUser' => $user->id,
				'idRole' => $data['idRole'],
				'notes' => 'First Role',
			]);
			return redirect()->route('user.index');
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
			//$this->authorize('view', $tempUser);
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
			$roles = Role::all();
			$userRoles = UserRoles::where('idUser', $user->id)
			//$userRoles = DB::table('usersRole')->where('idUser', $user->id)
				//->select('idRole')
				->orderBy('idRole', 'asc')
				->get();
			$idUsRoles = [];
			foreach($userRoles as &$uRol) {
				array_push($idUsRoles, $uRol->idRole);
			}
			//dd(compact('user', 'roles', 'userRoles', 'idUsRoles'), $idUsRoles);
			return view('user.edit', compact('user', 'roles', 'userRoles', 'idUsRoles'));
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
			// dd($request->except(['_token', '_method', 'name', 'lastNames', 'email']), $user->id);
			$user->update($request->validate([
				'name' => ['required', 'min:2'],
				'lastNames' => 'nullable',
				'email' => ['nullable', 'email']
			]));
			// Update roles
			foreach( $request->except(['_token', '_method', 'name', 'lastNames', 'email']) as $urId => $urValue ) {
				$userRole = UserRoles::find($urId);
				if ($userRole->idUser == $user->id) {
					$userRole->idRole = $urValue;
					$userRole->save();
				}
			}
			// Update roles END
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
				//$this->authorize('delete', auth()->user());
				$user->update(['active' => 0]);
				$userRoles = UserRoles::where('idUser', $user->id)->get();
				foreach ($userRoles as $uRole) {
					$uRole->delete();
				}
				return redirect('/user');
		}
		
		/**
		 * Change localization setting (language). Reference: https://stackoverflow.com/questions/45433877/laravel-5-4-proper-way-to-store-locale-setlocale.
		 * 
		 * @param Request $request
		 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
		 */
		public function switchLocale(Request $request)
    {
			if (!empty($request->userLocale)) {
				$locale = $request->userLocale;
				if (!in_array($locale, ['en', 'es'])) {
					$locale = 'en';
				}
				app()->setLocale($locale);
				Session::put('locale', $locale);
			}
			return redirect($request->header("referer"));
    }
}
