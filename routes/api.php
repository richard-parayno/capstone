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

Route::get('/institution', 'InstitutionController@index');

Route::get('/institution/{institution}', 'InstitutionController@show');

Route::post('/institution/{institution}', 'InstitutionController@store');

Route::put('/institution/{institution}', 'InstitutionController@update');

Route::delete('/institution/{institution}', 'InstitutionController@delete');
