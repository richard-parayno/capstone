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
Route::get('/', function() {
    Auth::logout();
    return redirect()->action('Auth\LoginController@showLoginForm');
});


Route::get('/test', function () {
    return view('test');
});

Route::resource('institution', 'InstitutionController');

/* Dashboard Route */
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');
/* Excel Upload Route */
Route::get('/dashboard/upload-files', 'ExcelController@show')->name('upload-files')->middleware('auth');
Route::post('/dashboard/process-file', 'ExcelController@process')->name('process-file')->middleware('auth');
Route::get('/dashboard/tree-plant', 'AddController@loadToBatchPlant')->name('tree-plant')->middleware('auth');
Route::post('/dashboard/process-trees', 'InstitutionBatchPlantController@add')->name('process-trees')->middleware('auth');




/* User Account Management Routes */
/* View Users */
Route::get('/dashboard/user-view', 'ViewUserController@viewUsers')->name('user-view')->middleware('auth');
/* Create New User Account */
Route::get('/dashboard/user-add', 'MyController@usertypes')->name('user-add');
/* Edit User Account Information */
Route::get('/dashboard/user-editinfo', function() {
    return view('user-editinfo');
})->name('user-editinfo')->middleware('auth');
/* Edit User Account Credentials */
Route::get('/dashboard/user-editcreds', function() {
    return view('user-editcreds');
})->name('user-editcreds')->middleware('auth');

/* Campus Information Management Routes */
/* View Campus */
Route::get('/dashboard/campus-view', 'ViewUserController@viewCampus')->name('campus-view')->middleware('auth');
/* Add New Campus/Institute */
Route::get('/dashboard/campus-add', 'AddController@loadToCampus')->name('campus-add')->middleware('auth');
Route::post('/dashboard/campus-add-process', 'InstitutionController@create')->name('campus-add-process')->middleware('auth');

/* Edit Campus/Institute */
Route::get('/dashboard/campus-editinfo', function() {
    return view('campus-editinfo');
})->name('campus-editinfo')->middleware('auth');

/* View Departments/Offices */
Route::get('/dashboard/department-view', 'ViewUserController@viewDepartments')->name('department-view')->middleware('auth');
/* Add New Department/Offices */
Route::get('/dashboard/department-add', 'AddController@loadToDepartment')->name('department-add')->middleware('auth');
Route::post('/dashboard/department-add-process', 'DepartmentController@create')->name('department-add-process')->middleware('auth');
/* Edit Department/Offices */
Route::get('/dashboard/department-editinfo', function() {
    return view('department-editinfo');
})->name('department-editinfo')->middleware('auth');

/* View Vehicles */
Route::get('/dashboard/vehicle-view', 'ViewUserController@viewVehicles')->name('vehicle-view')->middleware('auth');
/* Add New Vehicle */
Route::get('/dashboard/vehicle-add', 'AddController@loadtoVehicle')->name('vehicle-add')->middleware('auth');
Route::post('/dashboard/vehicle-add-process', 'VehicleController@create')->name('vehicle-add-process')->middleware('auth');
/* Edit Vehicle */
Route::get('/dashboard/vehicle-editinfo', function() {
    return view('vehicle-editinfo');
})->name('vehicle-editinfo')->middleware('auth');
/* Decommission Vehicle */
Route::get('/dashboard/vehicle-decommission', function() {
    return view('vehicle-decommission');
})->name('vehicle-decommission')->middleware('auth');

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');


