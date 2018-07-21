<?php

namespace App\Http\Controllers;

use App\Models\Institutionbatchplant;
use Illuminate\Http\Request;
use DB;
class TreeController extends Controller
{
    public function index() {
        $treePlant = Institutionbatchplant::all();
        $treePlant->toArray();
        
        foreach ($treePlant as $x) {
          $institution = DB::table('institutions')->where('institutionID', $x->institutionID)->first();
          if ($institution != null) {
            $x['institutionName'] = $institution->institutionName;
          } else {
            $x['institutionName'] = "NO INSTITUTION RECORDED";
          }
        }
  
        return response()->json($treePlant);
    }

    public function show(Institutionbatchplant $tree) {
        $institution = DB::table('institutions')->where('institutionID', $tree->institutionID)->first();
        $tree = $tree->toArray();
        
        if ($institution != null) {
          $user['institutionName'] = $institution->institutionName;
        } else {
          $user['institutionName'] = "NO INSTITUTION RECORDED";
        }

        return response()->json($tree);

    }

    public function store(Request $request) {

    }

    public function update(Request $request) {

    }

    public function delete(User $user) {

    }
}
