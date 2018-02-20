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

    public function users()
    {
        $users = DB::table('users')->select('id', 'userName', 'accountName')->get();
        return view('user-editinfo', compact('users'));
    }

    public function usercreds()
    {
        $usercreds = DB::table('users')->select('id', 'userName', 'accountName', 'email')->get();
        return view('user-editcreds', compact('usercreds'));
    }
}
