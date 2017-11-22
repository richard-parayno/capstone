<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AddController extends Controller
{
    public function loadToCampus() {
        $schoolTypes = DB::table('schooltype_ref')->get();
        
        return view('campus-add', compact('schoolTypes'));        
    }

    public function loadToVehicle() {
        $brands = DB::table('carbrand_ref')->get();
        $institutions = DB::table('institutions')->get(); 
        $fuelTypes = DB::table('fueltype_ref')->get();
        $carTypes = DB::table('cartype_ref')->get();

        return view('vehicle-add', compact('brands', 'institutions', 'fuelTypes', 'carTypes'));
    }
}
