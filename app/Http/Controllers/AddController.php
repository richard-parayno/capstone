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
}
