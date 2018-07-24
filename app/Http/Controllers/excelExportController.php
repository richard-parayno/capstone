<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class excelExportController extends Controller
{
    public function index() {
        $trips = DB::table('trips')->get();
        return view('reports')->with('trips', $trips);
    }
}
