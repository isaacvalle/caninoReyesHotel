<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
	Route::get('dogs', 'DogController@index');
	Route::get('dogs/{id}', 'DogController@show');
	Route::post('dogs', 'DogController@store');
	Route::put('dogs/{id}', 'DogController@update');
	Route::delete('dogs/{id}', 'DogController@destroy');
	Route::post('reservations', 'ReservationController@store');
	Route::post('roles', 'RoleController@store');
	Route::post('permissions', 'PermissionController@store');
});
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');