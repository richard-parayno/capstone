<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Input;
use DB;
use App\Models\Trip;
use App\Models\Monthlyemissionsperschool;
use DateTime;
use Debugbar;

class ExcelController extends Controller
{
    public function show() {

        return view('upload-files');
    }

    public function process() {
        // initialize the excelfile that we will be loading
        $excelFile = Input::file('excelFile');

        $data = array();
        
        //load the content of the excel file into an array called $load. we also format the dates into m/d/Y before we pass all of the data to the array.
        $load = Excel::load($excelFile, function($reader) {
            $reader->formatDates(true, 'm/d/Y');
        })->get()->toArray();
        // run the conditional if $load has stuff in it
        if($load){
            // initialize the counters
            $ctr = 0;
            $totalEmission = 0;
            foreach ($load as $key => $row) {
                // in the current row....... 
                //convert the date
                $convertd1 = (string)$row['date'];
                Debugbar::info("convertd1 ".$convertd1);                
                Debugbar::info("convertd1 strtotime".strtotime($convertd1));                
                $currentMonth = date("Y-m-d", strtotime($convertd1));
                Debugbar::info("currentMonth ".$currentMonth);
                

                // place the current row's data into variables you can manipulate easier
                $currentPlateNumber = $row['plate_number'];
                $currentKMReading = $row['kilometer_reading'];
                $destinations = $row['destinations'];
                $currentDepartment = $row['requesting_department'];
                $currentInstitution = DB::table('deptsperinstitution')->where('deptName', $currentDepartment)->value('institutionID');

                //do the same date conversion but declare it as the currrent month in excel.
                $convertd2 = (string)$row['date'];
                Debugbar::info("convertd2 ".$convertd2);                
                Debugbar::info("convertd2 strtotime".strtotime($convertd2));  
                $currentMonthInExcel = date("Y-m-d", strtotime($convertd2));
                Debugbar::info("currentMonthInExcel ".$currentMonthInExcel);
                
                
                //get the current dept id from the deptsperinstitution table
                $currentDeptID = DB::table('deptsperinstitution')->where('deptName', $row['requesting_department'])->value('deptID');
                
                //check the vehicles_mv table if theres a match for the currentplatenumber
                if (DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->first()) {
                    //get the values if there's a match
                    $selected = DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->first();
                    $carType = DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->value('carTypeID');
                    $fuelType = DB::table('vehicles_mv')->where('plateNumber', $currentPlateNumber)->value('fuelTypeID');
                    $selectedFuelType = DB::table('fueltype_ref')->where('fuelTypeID', $fuelType)->value('fuelTypeID');
                    $selectedCarTypeMPG = DB::table('cartype_ref')->where('carTypeID', $carType)->value('mpg');
                    
                    //check the fuel type
                    switch ($selectedFuelType) {
                        //if it's diesel
                        case 1:
                        $dieselEmissionInTonnes = (($currentKMReading * 0.621371) * 19.36) / 2204.6;
                        $totalEmission += $dieselEmissionInTonnes;
                        
                        //create a new trip object (to be placed in the db)
                        $trips = new Trip;
                        $trips->deptID = $currentDeptID;
                        $trips->remarks = $destinations;
                        $trips->plateNumber = $currentPlateNumber;
                        $trips->kilometerReading = $currentKMReading;
                        $trips->emissions = $dieselEmissionInTonnes;
                        $trips->save();
                        
                        //if the first run of the code hasn't started yet
                        if (!isset($firstrun)) {
                            $currentMonth = $currentMonthInExcel;
                            Debugbar::info("currentmonth ".$currentMonth);
                            Debugbar::info("currentmonthinexcel ".$currentMonthInExcel);
                            
                            
                            // create a new monthly emission object (to be placed in the db)
                            $monthlyEmission = new Monthlyemissionsperschool;
                            $monthlyEmission->institutionID = $currentInstitution;
                            $monthlyEmission->emission = $totalEmission;
                            $monthlyEmission->monthYear = $currentMonthInExcel;
                            $monthlyEmission->save();
                            $firstrun = true;
                        }
                        
                        break;
                        //if it's gas
                        case 2:
                        $gasEmissionInTonnes = ((6760 / $selectedCarTypeMPG) * $currentKMReading) * 100000000000000000000;
                        $totalEmission += $gasEmissionInTonnes;
                        
                        //create a new trip object (to be placed in the db)                        
                        $trips = new Trip;
                        $trips->deptID = $currentDeptID;   
                        $trips->remarks = $destinations;                         
                        $trips->plateNumber = $currentPlateNumber;
                        $trips->kilometerReading = $currentKMReading;
                        $trips->emissions = $gasEmissionInTonnes;
                        $trips->save();   
                        
                        //if the first run of the code hasn't started yet
                        /** 
                        * 
                        *if (!isset($firstrun)) {
                        *   $currentMonth = $currentMonthInExcel;
                        *    // create a new monthly emission object (to be placed in the db)
                        *    $monthlyEmission = new Monthlyemissionsperschool;
                        *    $monthlyEmission->institutionID = $currentInstitution;
                        *    $monthlyEmission->emission = $totalEmission;
                        *    $monthlyEmission->monthYear = $currentMonthInExcel;
                        *    $monthlyEmission->save();
                        *    $firstrun = true;
                        *}
                        **/
                        //if the current month isn't equal to the one in the excel and the first run is done already
                        if ($currentMonth != $currentMonthInExcel) {
                            $currentMonth = $currentMonthInExcel;
                            // create a new monthly emission object (to be placed in the db)
                            $monthlyEmission = new Monthlyemissionsperschool;
                            $monthlyEmission->institutionID = $currentInstitution;
                            $monthlyEmission->emission = $totalEmission;
                            $monthlyEmission->monthYear = $currentMonthInExcel;
                            $monthlyEmission->save();
                        } else {
                            // create a new monthly emission object (to be placed in the db)
                            $monthlyEmission = new Monthlyemissionsperschool;
                            $monthlyEmission->institutionID = $currentInstitution;
                            $monthlyEmission->emission = $totalEmission;
                            $monthlyEmission->monthYear = $currentMonth;
                            $monthlyEmission->save();
                        }
                        
                        break;
                    }
                }

                // place current row into the array that we'll pass to the next page
                $data[$ctr]['date'] = $row['date'];
                $data[$ctr]['requesting_department'] = $row['requesting_department'];
                $data[$ctr]['plate_number'] = $row['plate_number'];
                $data[$ctr]['kilometer_reading'] = $row['kilometer_reading'];
                $data[$ctr]['destinations'] = $row['destinations'];
                
                //iterate the ctr to go to the next row
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
