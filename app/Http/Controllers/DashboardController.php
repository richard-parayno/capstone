<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function generate(Request $request){
        $data = $request->all();
        return view('reports', compact('data'));
    }    
}

?>