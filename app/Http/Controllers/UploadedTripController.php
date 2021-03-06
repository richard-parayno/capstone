<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Monthlyemissionsperschool;
use App\Models\Deptsperinstitution;
use App\Models\Institution;
use DateTime;
use Debugbar;

use Illuminate\Support\Facades\Input;


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

    public function showSpecificCampus(Request $request) {
        $data = $request->all();
        $institutionID = $data['institutionID'];

        //$matchedDepartments = DB::table('deptsperinstitution')->where('institutionID', $institutionID)->get();

        $matchedTrips = DB::table('trips')->where('institutionID', $institutionID)->get();

        
        foreach ($matchedTrips as $x) {
          $departments = DB::table('deptsperinstitution')->where('deptID', $x->deptID)->first();
          $institution = DB::table('institutions')->where('institutionID', $x->institutionID)->first();
          
          if ($departments != null) {
              $x->departmentName = $departments->deptName;
          } else {
              $x->departmentName = "N/A";
          }
          if ($institution != null) {
              $x->institutionName = $institution->institutionName;
          } else {
              $x->institutionName = "N/A";
          }
          
        }
  
        return response()->json($matchedTrips);
    }

    public function showSpecificDate(Request $request) {
        $data = $request->all();
        $institutionID = $data['institutionID'];
        $uploadedAt = $data['uploadedAt'];

        //$matchedDepartments = DB::table('deptsperinstitution')->where('institutionID', $institutionID)->get();

        $matchedTrips = DB::table('trips')->where('institutionID', $institutionID)->where('uploaded_at', $uploadedAt)->get();

        
        foreach ($matchedTrips as $x) {
          $departments = DB::table('deptsperinstitution')->where('deptID', $x->deptID)->first();
          $institution = DB::table('institutions')->where('institutionID', $x->institutionID)->first();
          
          if ($departments != null) {
              $x->departmentName = $departments->deptName;
          } else {
              $x->departmentName = "N/A";
          }
          if ($institution != null) {
              $x->institutionName = $institution->institutionName;
          } else {
              $x->institutionName = "N/A";
          }
          
        }
  
        return response()->json($matchedTrips);
    }

    public function getDates() {
        $trips = DB::table('trips')->orderBy('uploaded_at', 'desc')->get();
        $trips->toArray();

        $dates = array();

        foreach ($trips as $x) {
            $convertedDate = new Carbon($x->uploaded_at);
            if (!in_array(array('uploadedAt' => $convertedDate->toDateString()), $dates)) {
                $dates[] = array(
                    'uploadedAt' => $convertedDate->toDateString(),
                );
            }
            

        }

        return response()->json($dates);
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

    // return all trips in excel
    public function preProcess(Request $request) {
        $toProcess = $request->all();

        //transform the dates
        for ($x = 0; $x < count($toProcess); $x++) {
            $carbonDate = new Carbon($toProcess[$x]['Date']);
            $toProcess[$x]['Date'] = $carbonDate->toDateString();
        }

        return response()->json($toProcess);
    }

    // returns the unmatched trips (department and platenumber NOT existing in system)
    public function preProcessErrors(Request $request) {
        $cleanThis = $request->all();
        $y = count($cleanThis);
        $holdCount = 0;

        

        
        $throw = array();
        for ($x = 0; $x < $y; $x++) {
            $plateNumber = str_replace(' ', '', $cleanThis[$x]['Plate Number']);
            $checkerPlate = DB::table('vehicles_mv')->where('plateNumber', $plateNumber)->first();
            $checkerDept = DB::table('deptsperinstitution')->where('deptName', $cleanThis[$x]['Requesting Department'])->first();

            if ($checkerPlate == null || $checkerDept == null) {
                if ($checkerPlate == null) {
                    $plateNull = true;
                } else {
                    $plateNull = false;
                }
                if ($checkerDept == null) {
                    $deptNull = true;
                } else {
                    $deptNull = false;
                }
                $throw[] = array(
                    'Date' => $cleanThis[$x]['Date'], 
                    'Departure Time' => $cleanThis[$x]['Departure Time'], 
                    'Destinations' => $cleanThis[$x]['Destinations'], 
                    'Kilometer Reading' => $cleanThis[$x]['Kilometer Reading'], 
                    'Plate Number' => $plateNumber, 
                    'Requesting Department' => $cleanThis[$x]['Requesting Department'], 
                    'plateNull' => $plateNull, 
                    'deptNull' => $deptNull
                );
            } else {
                $clean[$holdCount]['Date'] = $cleanThis[$x]['Date'];
                $clean[$holdCount]['Departure Time'] = $cleanThis[$x]['Departure Time'];
                $clean[$holdCount]['Destinations'] = $cleanThis[$x]['Destinations'];
                $clean[$holdCount]['Kilometer Reading'] = $cleanThis[$x]['Kilometer Reading'];
                $clean[$holdCount]['Plate Number'] = $plateNumber;
                $clean[$holdCount]['Requesting Department'] = $cleanThis[$x]['Requesting Department'];
            }
        }

        return response()->json($throw);
    }

    // returns the matched trips (department and platenumber EXISTING in system)
    public function preProcessClean(Request $request) {
        $cleanThis = $request->all();
        $y = count($cleanThis);
        $holdCount = 0;

        $clean = array();
        for ($x = 0; $x < $y; $x++) {
            $plateNumber = str_replace(' ', '', $cleanThis[$x]['Plate Number']);
            $checkerPlate = DB::table('vehicles_mv')->where('plateNumber', $plateNumber)->first();
            $checkerDept = DB::table('deptsperinstitution')->where('deptName', $cleanThis[$x]['Requesting Department'])->first();
            

            if ($checkerPlate == null || $checkerDept == null) {
                $throw[$holdCount]['Date'] = $cleanThis[$x]['Date'];
                $throw[$holdCount]['Departure Time'] = $cleanThis[$x]['Departure Time'];
                $throw[$holdCount]['Destinations'] = $cleanThis[$x]['Destinations'];
                $throw[$holdCount]['Kilometer Reading'] = $cleanThis[$x]['Kilometer Reading'];
                $throw[$holdCount]['Plate Number'] = $plateNumber;
                $throw[$holdCount]['Requesting Department'] = $cleanThis[$x]['Requesting Department'];
            } else {
                $checkerInstitution = Institution::where('institutionID', $checkerDept->institutionID)->first();
                if ($checkerPlate == null) {
                    $plateNull = true;
                } else {
                    $plateNull = false;
                }
                if ($checkerDept == null) {
                    $deptNull = true;
                } else {
                    $deptNull = false;
                }
                $clean[] = array(
                    'Date' => $cleanThis[$x]['Date'], 
                    'Departure Time' => $cleanThis[$x]['Departure Time'], 
                    'Destinations' => $cleanThis[$x]['Destinations'], 
                    'Kilometer Reading' => $cleanThis[$x]['Kilometer Reading'], 
                    'Plate Number' => $plateNumber, 
                    'Requesting Department' => $cleanThis[$x]['Requesting Department'],
                    'plateNull' => $plateNull, 
                    'deptNull' => $deptNull,
                    'deptID' => $checkerDept->deptID,
                    'institutionID' => $checkerInstitution->institutionID
                );
            }
        }
        
        return response()->json($clean);
    }

    public function prepareForExport(Request $request) {
        $cleanThis = $request->all();
        $y = count($cleanThis);
        $clean = array();

        for ($x = 0; $x< $y; $x++) {
            $clean[] = array(
                'Date' => $cleanThis[$x]['Date'], 
                'Departure Time' => $cleanThis[$x]['Departure Time'], 
                'Destinations' => $cleanThis[$x]['Destinations'], 
                'Kilometer Reading' => $cleanThis[$x]['Kilometer Reading'], 
                'Plate Number' => $cleanThis[$x]['Plate Number'], 
                'Requesting Department' => $cleanThis[$x]['Requesting Department']
            );
        }

        return response()->json($clean);
    }

    public function uploadToDb(Request $request) {
        $request = $request->all();

        $y = count($request);

        $institutionSave = null;

        for ($x = 0; $x < $y ; $x++) {
            //compute emissions
            $plateNumber = str_replace(' ', '', $request[$x]['Plate Number']);            
            $vehicle = DB::table('vehicles_mv')->where('plateNumber', $plateNumber)->first();
            $selectedFuelType = DB::table('fueltype_ref')->where('fuelTypeID', $vehicle->fuelTypeID)->value('fuelTypeID');
            $selectedCarTypeMPG = DB::table('cartype_ref')->where('carTypeID', $vehicle->carTypeID)->value('mpg');

            //checker the current fuel type and apply emission calculation
            switch ($selectedFuelType) {
                //if the fuel type is diesel
                case 1:
                    $dieselEmissionInTonnes = ((($request[$x]['Kilometer Reading'] * 0.621371) * 19.36) / $selectedCarTypeMPG) / 2204.6;
                    break;
                //if the fuel type is gas
                case 2:
                    $gasEmissionInTonnes = ((6760 / $selectedCarTypeMPG) * $request[$x]['Kilometer Reading']) * 0.000001;
                    break;
            }

            //create a new trip object and save it
            $trip = new Trip;
            $trip->institutionID = $request[$x]['institutionID'];
            $trip->deptID = $request[$x]['deptID'];
            $trip->tripDate = $request[$x]['Date'];
            $trip->tripTime = $request[$x]['Departure Time'];
            $trip->kilometerReading = $request[$x]['Kilometer Reading'];
            $trip->remarks = $request[$x]['Destinations'];
            $trip->plateNumber = $plateNumber;
            $trip->batch = 1;
            if (isset($dieselEmissionInTonnes)){
                $trip->emissions = $dieselEmissionInTonnes;
            }
            if (isset($gasEmissionInTonnes)) {
                $trip->emissions = $gasEmissionInTonnes;
            }
            $currentAuditDate = Carbon::now();
            $formattedCurrentAuditDate = $currentAuditDate->toDateString();
            $trip->uploadedAt = $formattedCurrentAuditDate;
            $trip->save();

            $institutionSave = $request[$x]['institutionID'];
        }

        $allTrips = Trip::all();
        $now = Carbon::now();

        $counter = DB::table('notifications')->orderBy('notifID', 'desc')->first();
        $ctr = $counter->notifID;

        $sendNotification = DB::table('notifications')
            ->insert([
                'actionID' => 2,
                'toUserID' => 2, 
                'fromUserID' => $institutionSave, 
                'read' => 0, 
                'remarks' => 'New trips were added on '.$now->toDateString(),
                'insertedOn' => $now->toDateTimeString()
            ]);

        return response()->json($allTrips);
    }

 
    public function store(Request $request) {

    }

    public function update(Request $request) {

    }

    public function delete(User $user) {

    }
}
