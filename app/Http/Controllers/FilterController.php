<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institution;
use DB;

class FilterController extends Controller
{
    public function filter(Request $request){
        $data = $request->all();
        $institutions = Institution::all();
        $departments = DB::table('deptsperinstitution')->get();   
        $fuelTypes = DB::table('fueltype_ref')->get();
        $carTypes = DB::table('cartype_ref')->get();
        return view('/dashboard', compact('data', 'institutions', 'departments', 'fuelTypes', 'carTypes'));
    }
}