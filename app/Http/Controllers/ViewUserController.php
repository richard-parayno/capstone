<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ViewUserController extends Controller
{
    public function viewUsers() {
        $users = DB::table('users')->get();
        $userTypes = DB::table('usertypes_ref')->get();
        
        return view('user-view', compact('users', 'userTypes'));        
    }

    public function viewCampus() {
        $institutions = DB::table('institutions')->get();
        $schools = DB::table('schooltype_ref')->get();

        return view('campus-view', compact('institutions', 'schools'));
    }

    public function viewDepartments() {
        $departments = DB::table('deptsperinstitution')->get();
        $institutions = DB::table('institutions')->get();

        return view('department-view', compact('departments', 'institutions'));
    }

    public function viewVehicles() {
        $vehicles = DB::table('vehicles_mv')->where('active', 1)->get();
        $inactive = DB::table('vehicles_mv')->where('active', 0)->get();
        $brands = DB::table('carbrand_ref')->get();
        $institutions = DB::table('institutions')->get(); 
        $fueltype = DB::table('fueltype_ref')->get();
        $cartypes = DB::table('cartype_ref')->get();

        return view('vehicle-view', compact('vehicles', 'inactive', 'brands', 'institutions', 'fueltype', 'cartypes'));
    }


}
