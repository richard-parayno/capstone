<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VehiclesMv;
use Validator;
use DB;

class VehicleController extends Controller
{
    public function create(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
          'plateNumber' => 'required|string|max:8|unique:vehicles_mv',
          'modelName' => 'required|string|max:45',
          'institutionID' => 'required|int|max:100',
          'carTypeID' => 'required|int|max:100',
          'carBrandID' => 'required|int|max:100',
          'fuelTypeID' => 'required|int|max:100',
        ]);

        if ($validator->fails()) {
          return redirect('/dashboard/vehicle-add')->withErrors($validator)->withInput();
        }

        else if ($validator->passes()) {
          $vehicle = new VehiclesMv;
          $vehicle->plateNumber = $data['plateNumber'];
          $vehicle->modelName = $data['modelName'];
          $vehicle->institutionID = $data['institutionID'];
          $vehicle->carTypeID = $data['carTypeID'];
          $vehicle->carBrandID = $data['carBrandID'];
          $vehicle->fuelTypeID = $data['fuelTypeID'];
          $vehicle->active = 1;
          $vehicle->save();

          return redirect('/dashboard/vehicle-add')->with('success', true)->with('message', $data['modelName'].'-'.$data['plateNumber'].' added!');
        }
    }

    public function edit(Request $request) {
      $data = $request->all();

      $currentPlate = $data['vehicle-current'];
      $campus = $data['vehicle-campus'];
      $brand = $data['vehicle-brand'];
      $type = $data['vehicle-type'];
      $fuel = $data['vehicle-fuel'];
      $model = $data['vehicle-model'];
      $year = $data['vehicle-year'];
      $plate = $data['vehicle-plate'];
      
      $cardata = VehiclesMv::find($currentPlate);

      $cardata->institutionID = $campus;
      $cardata->carBrandID = $brand;
      $cardata->carTypeID = $type;
      $cardata->fuelTypeID = $fuel;
      $cardata->modelName = $model;
      //year
      $cardata->plateNumber = $plate;
      $cardata->save();

      return redirect()->route('vehicle-view')->with('success', true)->with('message', $cardata->modelName.'-'.$currentPlate.' successfully edited to '.$model.'-'.$plate.'!');
      
    }

    public function decommission(Request $request) {
      $data = $request->all();
      $currentPlate = $data['vehicle-current'];
      $choice = $data['choice'];

      if (VehiclesMv::find($currentPlate)->active == 1) {
        if ($choice == 'yes') {
          $cardata = VehiclesMv::find($currentPlate);
          $cardata->active = 0; 
          $cardata->save();
  
          return redirect()->route('vehicle-view')->with('success', true)->with('message', $cardata->modelName.'-'.$currentPlate.' successfully decommissioned!');
        } else {
          $cardata = VehiclesMv::find($currentPlate);
          $cardata->active = 1; 
          $cardata->save();
  
          return redirect()->route('vehicle-view')->with('success', true)->with('message', $cardata->modelName.'-'.$currentPlate.' successfully activated!');
        }
      } else {
        if ($choice == 'yes') {
          $cardata = VehiclesMv::find($currentPlate);
          $cardata->active = 1; 
          $cardata->save();
  
          return redirect()->route('vehicle-view')->with('success', true)->with('message', $cardata->modelName.'-'.$currentPlate.' successfully activated!');
        } else {
          $cardata = VehiclesMv::find($currentPlate);
          $cardata->active = 0; 
          $cardata->save();
  
          return redirect()->route('vehicle-view')->with('success', true)->with('message', $cardata->modelName.'-'.$currentPlate.' successfully decommissioned!');
        }
      }

      
    }

    public function index() {
      $vehicle = VehiclesMv::all();
      $vehicle->toArray();
      
      foreach ($vehicle as $x) {
        $cartypes = DB::table('cartype_ref')->where('carTypeID', $x->carTypeID)->first();
        $carbrands = DB::table('carbrand_ref')->where('carBrandID', $x->carBrandID)->first();
        $fueltypes = DB::table('fueltype_ref')->where('fuelTypeID', $x->fuelTypeID)->first();
        $institution = DB::table('institutions')->where('institutionID', $x->institutionID)->first();
        
        if ($cartypes != null){
          $x['carTypeName'] = $cartypes->carTypeName; 
        } else {
          $x['carTypeName'] = "N/A";
        }
        if ($carbrands != null) {
          $x['carBrandName'] = $carbrands->carBrandName;
        } else {
          $x['carBrandName'] = "N/A";
        }
        if ($fueltypes != null) {
          $x['fuelTypeName'] = $fueltypes->fuelTypeName;
        } else {
          $x['fuelTypeName'] = "N/A";
        }
        if ($institution != null) {
          $x['institutionName'] = $institution->institutionName;
        } else {
          $x['institutionName'] = "N/A";
        }
        if ($x->active = 1) {
          $x['status'] = 'Active';
        } else {
          $x['status'] = 'Inactive';
        }
      }

      return response()->json($vehicle);
  }

  public function show(VehiclesMv $vehicle) {
      $cartypes = DB::table('cartype_ref')->where('carTypeID', $vehicle->carTypeID)->first();
      $carbrands = DB::table('carbrand_ref')->where('carBrandID', $vehicle->carBrandID)->first();
      $fueltypes = DB::table('fueltype_ref')->where('fuelTypeID', $vehicle->fuelTypeID)->first();
      $institution = DB::table('institutions')->where('institutionID', $vehicle->institutionID)->first();
      $vehicle->toArray();
      if ($cartypes != null){
        $vehicle['carTypeName'] = $cartypes->carTypeName;
      } else {
        $vehicle['carTypeName'] = "N/A";
      }
      if ($carbrands != null) {
        $vehicle['carBrandName'] = $carbrands->carBrandName;
      } else {
        $vehicle['carBrandName'] = "N/A";
      }
      if ($fueltypes != null) {
        $vehicle['fuelTypeName'] = $fueltypes->fuelTypeName;
      } else {
        $vehicle['fuelTypeName'] = "N/A";
      }
      if ($institution != null) {
        $vehicle['institutionName'] = $institution->institutionName;
      } else {
        $vehicle['institutionName'] = "N/A";
      }
      if ($vehicle->active = 1) {
        $vehicle['status'] = 'Active';
      } else {
        $vehicle['status'] = 'Inactive';
      }

      return response()->json($vehicle);

  }

  public function store(Request $request) {

  }

  public function update(Request $request) {

  }

  public function delete(User $user) {

  }
}
