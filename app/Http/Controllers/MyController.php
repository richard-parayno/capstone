<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MyController extends Controller
{
    public function usertypes()
    {
        $userTypes = DB::table('usertypes_ref')->select('userTypeID', 'userTypeName')->get();
        return view('user-add', compact('userTypes'));
    }
}
