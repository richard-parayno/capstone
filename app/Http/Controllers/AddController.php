<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Institution, App\Models\Institutionbatchplant;

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

    public function loadToDepartment() {
        $institutions = DB::table('institutions')->get();  
        $departments = DB::table('deptsperinstitution')->get();     

        return view('department-add', compact('institutions', 'departments'));
        
    }

    public function loadToBatchPlant() {
        $institutions = DB::table('institutions')->get();         

        return view('tree-plant', compact('institutions'));
    }

    public function viewPlanted() {
        $institutions = Institution::all();
        $treesPlanted = Institutionbatchplant::all();

        return view('tree-view', compact('institutions', 'treesPlanted'));
    }
    
    public function filterDashboard() {
        $institutions = Institution::all();
        $departments = DB::table('deptsperinstitution')->get();   
        $fuelTypes = DB::table('fueltype_ref')->get();
        $carTypes = DB::table('cartype_ref')->get();

        return view('analytics-test', compact('institutions', 'departments','fuelTypes', 'carTypes'));
    }
}
