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
}
