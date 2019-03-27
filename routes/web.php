<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
 * GET 		/insurance 				(index)		Route::get()
 * GET		/insurance/i			(show) 		Route::get()
 * POST 	/insurance 				(store) 	Route::post()
 * GET		/insurance/1/edit (edit) 		Route::get()
 * PATCH 	/insurance/1 			(update) 	Route::patch()
 * DELETE /insurance/1 			(destroy) Route::delete()
 * --------------------------------------------------
 * Route::resource()
 * php artisan make:controller InsuranceController 
 * 		-r 								//Create with boilerplate functions
 * 		-m Insurance 			//Include Model and reference
 * php artisan route:list
*/

Auth::routes();
// Controllers
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/insurance', 'InsuranceController');
Route::resource('/user', 'UserController');
Route::resource('/patient', 'PatientController');
Route::resource('patient.appointment', 'AppointmentController');
//Route::resource('user.roles', 'UserRolesController');

// Partial Controllers
Route::post('user/{user}/roles', 'UserRolesController@store')->name('user.roles.store');
Route::match(['put', 'patch'], 'user/{user}/roles/{role}', 'UserRolesController@update')->name('user.roles.update');
Route::delete('user/{user}/roles/{role}', 'UserRolesController@destroy')->name('user.roles.destroy');

// Specific Controllers
Route::get('/appointment', 'AppointmentController@indexAll');
Route::post('switchLocale', 'UserController@switchLocale');

// Google Login Controller
Route::get('/redirect', 'SocialAuthGoogleController@redirect');
Route::get('/callback', 'SocialAuthGoogleController@callback');