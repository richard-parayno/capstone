<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class reportExport extends Controller
{
    public function transfer(Request $request){
        $data = $request->all();
        return view('reportexport', compact('data'));
    }
}
