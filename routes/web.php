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
})->name('dashboard');

/* Submit Form Route */
Route::get('/submit', function () {
    return view('submit');
});

/* User Account Management Routes */
/* View Users */
Route::get('/dashboard/user-view', function() {
    return view('user-view');
})->name('user-view');
/* Create New User Account */
Route::get('/dashboard/user-add', 'MyController@usertypes')->name('user-add');
/* Edit User Account Information */
Route::get('/dashboard/user-editinfo', function() {
    return view('user-editinfo');
})->name('user-editinfo');
/* Edit User Account Credentials */
Route::get('/dashboard/user-editcreds', function() {
    return view('user-editcreds');
})->name('user-editcreds');

/* Campus Information Management Routes */
/* View Campus */
Route::get('/dashboard/campus-view', function() {
    return view('campus-view');
})->name('campus-view');
/* Add New Campus/Institute */
Route::get('/dashboard/campus-add', function() {
    return view('campus-add');
})->name('campus-add');
/* Edit Campus/Institute */
Route::get('/dashboard/campus-editinfo', function() {
    return view('campus-editinfo');
})->name('campus-editinfo');

/* View Departments/Offices */
Route::get('/dashboard/department-view', function() {
    return view('department-view');
})->name('department-view');
/* Add New Department/Offices */
Route::get('/dashboard/department-add', function() {
    return view('department-add');
})->name('department-add');
/* Edit Department/Offices */
Route::get('/dashboard/department-editinfo', function() {
    return view('department-editinfo');
})->name('department-editinfo');

/* View Vehicles */
Route::get('/dashboard/vehicle-view', function() {
    return view('vehicle-view');
})->name('vehicle-view');
/* Add New Vehicle */
Route::get('/dashboard/vehicle-add', function() {
    return view('vehicle-add');
})->name('vehicle-add');
/* Edit Vehicle */
Route::get('/dashboard/vehicle-editinfo', function() {
    return view('vehicle-editinfo');
})->name('vehicle-editinfo');
/* Decommission Vehicle */
Route::get('/dashboard/vehicle-decommission', function() {
    return view('vehicle-decommission');
})->name('vehicle-decommission');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
