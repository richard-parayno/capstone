<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VehiclesMv;
use Validator;

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

          return redirect('/dashboard/vehicle-add')->with('success', true)->with('message', 'Vehicle successfully added!');
        }
    }

    public function edit(Request $request) {
      $data = $request->all();

      $currentPlate = $data['vehicle-current'];
      $campus = $data['vehicle-campus'];
      $brand = $data['vehicle-brand'];
      $type = $data['vehicle-types'];
      $fuel = $data['vehicle-fuel'];
      $model = $data['vehicle-model'];
      $year = $data['vehicle-year'];
      $plate = $data['vehicle-plate'];
      
      $cardata = VehiclesMv::find($currentPlate)

      $cardata->institutionID = $campus;
      $cardata->carBrandID = $brand;
      $cardata->carTypeID = $type;
      $cardata->fuelTypeID = $fuel;
      $cardata->modelName = $model;
      //year
      $cardata->plateNumber = $plate;
      $cardata->save();

      return redirect()->route('vehicle-view');
      
    }
}
