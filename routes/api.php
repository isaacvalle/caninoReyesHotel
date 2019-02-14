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
})->middleware('verified');

Route::group(['middleware' => 'auth:api'], function() {
	Route::get('dogs', 'DogController@index')->middleware('verified');	
	Route::post('dogs', 'DogController@store');
	Route::get('dogs/{id}', 'DogController@show');
	Route::put('dogs/{id}', 'DogController@update');
	Route::post('reservations', 'ReservationController@store');
	Route::get('reservations/{id}', 'ReservationController@show');
    Route::put('reservations/{id}', 'ReservationController@update');
	Route::get('reservations', 'ReservationController@index');

});

Route::group(['middleware' => ['auth:api', 'role:admin']], function () {
    Route::delete('reservations/{id}', 'ReservationController@destroy');
	Route::delete('dogs/{id}', 'DogController@destroy');
	Route::post('roles', 'RoleController@store');
	Route::post('permissions', 'PermissionController@store');
});

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
