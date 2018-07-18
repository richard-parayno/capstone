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

/** Campus/Institution Management APIs */
Route::get('/institution', 'InstitutionController@index');
Route::get('/institution/{institution}', 'InstitutionController@show');
Route::post('/institution/{institution}', 'InstitutionController@store');
Route::put('/institution/{institution}', 'InstitutionController@update');
Route::delete('/institution/{institution}', 'InstitutionController@delete');

/** User Management APIs */
Route::get('/users', 'UserController@index');
Route::get('/users/{user}', 'UserController@show');
Route::post('/users/{user}', 'UserController@store');


/** Department Management APIs */
Route::get('/department', 'DepartmentController@index');
Route::get('/department/{department}', 'DepartmentController@show');


/** Vehicle Management APIs */
Route::get('/vehicle', 'VehicleController@index');
Route::get('/vehicle/active', 'VehicleController@showActive');
Route::get('/vehicle/{vehicle}', 'VehicleController@show');

/** Upload Excel File APIs */
Route::get('/trip', 'UploadedTripController@index');
Route::get('/trip/{trip}', 'UploadedTripController@show');