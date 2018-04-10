<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DecisionSupportController extends Controller
{
    public function index() {
        return view('tree-decision-support');
    }
}
