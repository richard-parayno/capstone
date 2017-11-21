<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\institution;

class InstitutionController extends Controller
{
    public function show($id){
      $institution = Institution::find($id);
      return view('institution.show', array('institution' => $institution));
    }
}
