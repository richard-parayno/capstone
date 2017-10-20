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

/* Login Route */
Route::get('/', function () {
    return view('login');
});

/* Dashboard Route */
Route::get('/dashboard', function () {
    return view('dashboard');
});

/* Submit Form Route */
Route::get('/submit', function () {
    return view('submit');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
