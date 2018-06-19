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


//Route::get('/analytics-test', 'DashboardController@main')->name('analytics-test')->middleware('auth');

Route::resource('institution', 'InstitutionController');

/* Dashboard Route 
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');
/*filtering analytics*/
Route::get('/dashboard', 'AddController@filterDashboard')->name('dashboard')->middleware('auth');
Route::post('/dashboard-process', 'FilterController@filter')->name('dashboard-process')->middleware('auth');

/* Excel Upload Route */
Route::get('/dashboard/upload-files', 'ExcelController@show')->name('upload-files')->middleware('auth');
Route::get('/dashboard/upload-view', 'ExcelController@showUploaded')->name('upload-view')->middleware('auth');
Route::post('/dashboard/pre-process-files', 'ExcelController@process')->name('pre-process-files')->middleware('auth');
Route::post('/dashboard/process-file', 'ExcelController@saveToDb')->name('process-file')->middleware('auth');
Route::get('/dashboard/tree-plant', 'AddController@loadToBatchPlant')->name('tree-plant')->middleware('auth');
Route::get('/dashboard/tree-view', 'AddController@viewPlanted')->name('tree-view')->middleware('auth');
Route::post('/dashboard/process-trees', 'InstitutionBatchPlantController@add')->name('process-trees')->middleware('auth');
Route::get('/dashboard/manual-upload', 'ExcelController@showManual')->name('manual-upload')->middleware('auth');
Route::post('/dashboard/manual-upload-process', 'ExcelController@showManualProcess')->name('manual-upload-process')->middleware('auth');
/* Download Excel Template */
Route::get('/dashboard/download-template', 'ExcelController@downloadTemplate')->name('download-template')->middleware('auth');

/* User Account Management Routes */
/* View Users */
Route::get('/dashboard/user-view', 'ViewUserController@viewUsers')->name('user-view')->middleware('auth');
/* Create New User Account */
Route::get('/dashboard/user-add', 'MyController@usertypes')->name('user-add');
/* Edit User Account Information */
Route::get('/dashboard/user-editinfo', 'MyController@users')->name('user-editinfo')->middleware('auth');
Route::get('/dashboard/user-editinfo-process', 'MyController@editinfo')->name('user-editinfo-process')->middleware('auth');
/* Edit User Account Credentials */
Route::get('/dashboard/user-editcreds', 'MyController@usercreds')->name('user-editcreds')->middleware('auth');
Route::get('/dashboard/user-editcreds-process', 'MyController@editcreds')->name('user-editcreds-process')->middleware('auth');

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
Route::get('/dashboard/campus-editinfo-process', 'InstitutionController@edit')->name('campus-editinfo-process')->middleware('auth');

/* View Departments/Offices */
Route::get('/dashboard/department-view', 'ViewUserController@viewDepartments')->name('department-view')->middleware('auth');
Route::get('/dashboard/department-view-search', 'ViewUserController@viewDepartmentsSearch')->name('department-view-search')->middleware('auth');
Route::get('/department-search','ViewUserController@viewDepartmentsProcess')->name('department-search')->middleware('auth');




/* Add New Department/Offices */
Route::get('/dashboard/department-add', 'AddController@loadToDepartment')->name('department-add')->middleware('auth');
Route::post('/dashboard/department-add-process', 'DepartmentController@create')->name('department-add-process')->middleware('auth');
/* Edit Department/Offices */
Route::get('/dashboard/department-editinfo',function() {
    return view('department-editinfo');
})->name('department-editinfo')->middleware('auth');
Route::get('/dashboard/department-editinfo-process', 'DepartmentController@edit')->name('department-editinfo-process')->middleware('auth');

/* View Vehicles */
Route::get('/dashboard/vehicle-view', 'ViewUserController@viewVehicles')->name('vehicle-view')->middleware('auth');
/* Add New Vehicle */
Route::get('/dashboard/vehicle-add', 'AddController@loadtoVehicle')->name('vehicle-add')->middleware('auth');
Route::post('/dashboard/vehicle-add-process', 'VehicleController@create')->name('vehicle-add-process')->middleware('auth');
/* Edit Vehicle */
Route::get('/dashboard/vehicle-editinfo', function() {
    return view('vehicle-editinfo');
})->name('vehicle-editinfo')->middleware('auth');
Route::get('/dashboard/vehicle-editinfo-process', 'VehicleController@edit')->name('vehicle-editinfo-process')->middleware('auth');
/* Decommission Vehicle */
Route::get('/dashboard/vehicle-decommission', function() {
    return view('vehicle-decommission');
})->name('vehicle-decommission')->middleware('auth');
Route::get('/dashboard/vehicle-decommission-process', 'VehicleController@decommission')->name('vehicle-decommission-process')->middleware('auth');

/* Report Maker */
Route::get('/dashboard/report-maker', function() {
    return view('report-maker');
})->name('report-maker')->middleware('auth');
/*Route::get('/dashboard/vehicle-decommission-process', 'VehicleController@decommission')->name('vehicle-decommission-process')->middleware('auth');*/

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');

/*Live Search*/
Route::get('/search','SearchController@index')->name('search');

Route::get('/search-process','SearchController@search')->name('search-process');

/*Decision Support*/
Route::get('/tree-decision-support', 'DecisionSupportController@index')->name('tree-decision-support')->middleware('auth');

