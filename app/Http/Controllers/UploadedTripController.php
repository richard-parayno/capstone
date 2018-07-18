<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deptsperinstitution;
use App\Models\Trip;
use DB;

class UploadedTripController extends Controller
{
    public function index() {
        $trips = Trip::all();
        $trips->toArray();
        
        foreach ($trips as $x) {
          $departments = DB::table('deptsperinstitution')->where('deptID', $x->deptID)->first();
          $institution = DB::table('institutions')->where('institutionID', $x->institutionID)->first();
          
          if ($departments != null) {
              $x['departmentName'] = $departments->deptName;
          } else {
              $x['departmentName'] = "N/A";
          }
          if ($institution != null) {
              $x['institutionName'] = $institution->institutionName;
          } else {
              $x['institutionName'] = "N/A";
          }
          
        }
  
        return response()->json($trips);
    }

    public function show(Trip $trip) {
        $departments = DB::table('deptsperinstitution')->where('deptID', $trip->deptID)->first();
        $institution = DB::table('institutions')->where('institutionID', $trip->institutionID)->first();
        $trip = $trip->toArray();
        
        if ($departments != null) {
            $trip['departmentName'] = $departments->deptName;
        } else {
            $trip['departmentName'] = "N/A";
        }
        if ($institution != null) {
            $trip['institutionName'] = $institution->institutionName;
        } else {
            $trip['institutionName'] = "N/A";
        }

        return response()->json($trip);

    }

    public function store(Request $request) {

    }

    public function update(Request $request) {

    }

    public function delete(User $user) {

    }
}
