<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\Trip;
use App\Models\Monthlyemissionsperschool;
use DateTime;

class ExcelController extends Controller
{
    public function show() {

        return view('upload-files');
    }

    public function process() {
        $excelFile = Input::file('excelFile');

        $data = array();
        
        $load = Excel::load($excelFile, function($reader) {
            $reader->formatDates(true, 'm/d/Y');
        })->get()->toArray();

        if($load){
            $ctr = 0;
            $totalEmission = 0;
            foreach ($load as $key => $row) {

                $convertd1 = (string)$row['date'];
                $currentMonth = date("m", strtotime($convertd1));
                
                $data[$ctr]['date'] = $row['date'];
                $data[$ctr]['requesting_department'] = $row['requesting_department'];
                $data[$ctr]['plate_number'] = $row['plate_number'];
                $data[$ctr]['kilometer_reading'] = $row['kilometer_reading'];
                $data[$ctr]['destinations'] = $row['destinations'];
                $data[$ctr]['roundtripyn'] = $row['roundtripyn'];
                
                $currentPlateNumber = $row['plate_number'];
                $currentKMReading = $row['kilometer_reading'];
                $destinations = $row['destinations'];
                $currentDepartment = $row['requesting_department'];
                $currentInstitution = DB::table('deptsperinstitution')->where('deptName', $currentDepartment)->value('institutionID');
                
                $convertd2 = (string)$row['date'];
                $currentMonthInExcel = date("m", strtotime($convertd2));
                
                $currentDeptID = DB::table('deptsperinstitution')->where('deptName', $row['requesting_department'])->value('deptID');
                
                
                
                
                if (DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->first()) {
                    $selected = DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->first();
                    $carType = DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->value('carTypeID');
                    $fuelType = DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->value('fuelTypeID');
                    $selectedFuelType = DB::table('fueltype_ref')->where('fuelTypeID', $fuelType)->value('fuelTypeID');
                    $selectedCarTypeMPG = DB::table('cartype_ref')->where('carTypeID', $carType)->value('mpg');
                    
                    
                    switch ($selectedFuelType) {
                        case 1:
                        $dieselEmissionInTonnes = (($currentKMReading * 0.621371) * 19.36) / 2204.6;
                        $totalEmission = $totalEmission + $dieselEmissionInTonnes;
                        
                        $trips = new Trip;
                        $trips->deptID = $currentDeptID;
                        $trips->remarks = $destinations;
                        $trips->plateNumber = $currentPlateNumber;
                        $trips->kilometerReading = $currentKMReading;
                        $trips->emissions = $dieselEmissionInTonnes;
                        $trips->save();
                        
                        if (!isset($firstrun)) {
                            $currentMonth = $currentMonthInExcel;
                            $monthlyEmission = new Monthlyemissionsperschool;
                            $monthlyEmission->institutionID = $currentInstitution;
                            $monthlyEmission->emission = $totalEmission;
                            $monthlyEmission->monthYear = $currentMonthInExcel;
                            $monthlyEmission->save();
                            $firstrun = true;
                        }
                        
                        break;
                        case 2:
                        $gasEmissionInTonnes = ((6760 / $selectedCarTypeMPG) * $currentKMReading) * 100000000000000000000;
                        $totalEmission = $totalEmission + $gasEmissionInTonnes;
                        
                        $trips = new Trip;
                        $trips->deptID = $currentDeptID;   
                        $trips->remarks = $destinations;                         
                        $trips->plateNumber = $currentPlateNumber;
                        $trips->kilometerReading = $currentKMReading;
                        $trips->emissions = $gasEmissionInTonnes;
                        $trips->save();   
                        
                        if (!isset($firstrun)) {
                            $currentMonth = $currentMonthInExcel;
                            $monthlyEmission = new Monthlyemissionsperschool;
                            $monthlyEmission->institutionID = $currentInstitution;
                            $monthlyEmission->emission = $totalEmission;
                            $monthlyEmission->monthYear = $currentMonthInExcel;
                            $monthlyEmission->save();
                            $firstrun = true;
                        }
                        
                        break;
                    }
                }
                
                if ($currentMonth != $currentMonthInExcel && isset($firstrun)) {
                    $currentMonth = $currentMonthInExcel;
                    $monthlyEmission = new Monthlyemissionsperschool;
                    $monthlyEmission->institutionID = $currentInstitution;
                    $monthlyEmission->emission = $totalEmission;
                    $monthlyEmission->monthYear = $currentMonthInExcel;
                    $monthlyEmission->save();
                }
                
                $ctr++;
                /**
                 * if gasoline emission in tonnes -- ((6760 / MPG) * kilometer reading) * 100000000000000000000)
                 * if diesel emission in tonnes -- (((kilometer reading * 0.621371) / mpg) * 19.36) / 2204.6 
                 * 
                 * after each computation (per row), add it to the total (acts as counter) emission variable
                 */
            }

        }
        return view('display-table', compact('data'));

    }
}
