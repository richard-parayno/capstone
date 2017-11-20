<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getLogin() {
        Auth::logout();
        return view('auth.login');
    }

}
