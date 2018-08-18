<?php
     //initialization
    {
    $filter = false;
    $filterPost = false;
    $emptySet = true;
    $dataSet = false;
    $rawDB = "";
    $fuelTypes = DB::table('fueltype_ref')->get();
    $carTypes = DB::table('cartype_ref')->get();
    $carBrands = DB::table('carbrand_ref')->get();
    $userType = Auth::user()->userTypeID;
    if($userType > 2){
        $institutionID = Auth::user()->institutionID;
        $filter = true;
    }

    if(isset($data)){
        if($data['isFiltered']=='true'){
            $filterPost = true;
        }
        if(isset($data['fromDate']) && isset($data['toDate'])){
            $from = strtotime($data['fromDate']);
            $to = strtotime($data['toDate']);
            $fromNew = date('d/m/Y', $from);
            $toNew = date('d/m/Y', $to);
            
            if($fromNew > $toNew){
                $temp = $data['toDate'];
                $data['toDate'] = $data['fromDate'];
                $data['fromDate'] = $temp;
            }
        }
    }
    else{
        $showChartDiv = false;
    }
    
    $institutions = DB::table('institutions')->get();
    $departments = DB::table('deptsperinstitution')->get();   
    $fuelTypes = DB::table('fueltype_ref')->get();
    $carTypes = DB::table('cartype_ref')->get();
    $carBrands = DB::table('carbrand_ref')->get();
    $tripYears = DB::table('trips')
    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')    
        ->select(DB::raw('EXTRACT(year_month from tripDate) as monthYear'))
        ->groupBy(DB::raw('1'))
        ->orderByRaw('1')
        ->get();
    }
    if(isset($data)){
        $showChartDiv = true;
        $filterMessage = "";
        $add = false;
        if($data['reportName']=="trip"){
            if($data['isFiltered']=="true" && ($data['institutionID']!= null || $data['fromDate'] != null || $data['toDate']!=null || $data['datePreset']!="? string: ?" || $data['carTypeID']!=null || $data['fuelTypeID']!=null || $data['carBrandID']!=null)){
            $rawDB = "";
            if($data['datePreset']==0){   
                if($data['fromDate'] != null && $data['toDate'] != null){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $add = true;
                    $rawDB .= "trips.tripDate BETWEEN '"  . $data['fromDate'] ."' AND '". $data['toDate'] . "'";
                    $filterMessage .= $data['toDate']. " to ". $data['fromDate'];
                }elseif(!isset($data['fromDate']) && $data['toDate'] != null){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $add = true;
                    $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "'";
                    $filterMessage .= "before ".$data['toDate'];
                }elseif($data['fromDate'] != null && !isset($data['toDate'])){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated  ";
                    }
                    $add = true;
                    $rawDB .= "trips.tripDate >= '" . $data['fromDate'] . "'";
                    $filterMessage .= "after ".$data['fromDate'];
                }
            }
            else{
                switch($data['datePreset']){
                    case "1": {
                            if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 2 WEEK";
                        $filterMessage .= "from 2 weeks ago";
                        break;
                    }
                    case "2": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 MONTH";
                        $filterMessage .= "from 1 month ago";
                        break;
                    } 
                    case "3": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 3 MONTH";
                        $filterMessage .= "from 3 month ago";
                        break;
                    }
                    case "4": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 6 MONTH";
                        $filterMessage .= "from 6 month ago";
                        break;
                    }
                    case "5": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 YEAR";
                        $filterMessage .= "from 1 year ago";
                        break;
                    }
                    default: $rawDB .= "";
                }
            }
            if($data['institutionID'] != null){
                    $institutionID = $data['institutionID'];
            }
            if($data['carTypeID']!=null){
                if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['carTypeID'];
                    }
                    $rawDB .= "cartype_ref.carTypeID = ".$data['carTypeID'];
                    $add = true;
            }
            if($data['fuelTypeID']!=null){
                if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['fuelTypeID'];
                    }
                    $rawDB .= "fueltype_ref.fuelTypeID = ".$data['fuelTypeID'];
                    $add = true;
            }
            if($data['carBrandID']!=null){
                if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['carBrandID'];
                    }
                    $rawDB .= "carbrand_ref.carBrandID = ".$data['carBrandID'];
                    $add = true;
            }
            if(isset($institutionID)){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " by " . $data['carTypeID'];
                }
                $rawDB .= "institutions.institutionID = ".$institutionID;
            }
                    $tripData=DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('trips.tripDate', 'trips.tripTime','institutions.institutionName', 'deptsperinstitution.deptName', 'trips.plateNumber', 'trips.kilometerReading', 'trips.remarks', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'carbrand_ref.carBrandName', 'vehicles_mv.modelName', 'vehicles_mv.active', DB::raw('round(trips.emissions,4) as emission'))
                    ->whereRaw($rawDB)
                    ->orderByRaw('1 ASC, 3 ASC')
                    ->get();
                $tripEmissionTotal = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('round(sum(emissions), 4) as totalEmissions'))
                    ->whereRaw($rawDB)
                    ->get();
                    
                $monthlyTrip = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('EXTRACT(YEAR_MONTH FROM tripDate) as tripDate, count(emissions) as emission'))
                    ->groupBy(DB::raw('1'))
                    ->whereRaw($rawDB)
                    ->get();
                }
            else{
                $tripData=DB::table('trips')
                    ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('trips.tripDate', 'trips.tripTime','institutions.institutionName', 'deptsperinstitution.deptName', 'trips.plateNumber', 'trips.kilometerReading', 'trips.remarks', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'carbrand_ref.carBrandName', 'vehicles_mv.modelName', 'vehicles_mv.active', DB::raw('round(trips.emissions,4) as emission'))
                    ->orderByRaw('1 ASC, 3 ASC')
                    ->get();
                $tripEmissionTotal = DB::table('trips')
                    ->select(DB::raw('round(sum(emissions),4) as totalEmissions'))
                    ->get();
                $monthlyTrip = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('EXTRACT(YEAR_MONTH FROM tripDate) as tripDate, count(emissions) as emission'))
                    ->groupBy(DB::raw('1'))
                    ->get();
            }
        }
        elseif($data['reportName']=="vehicleUsage"){
            if($data['isFiltered']=='true' && ($data['institutionID']!= null || $data['fromDate'] != null || $data['toDate']!=null || $data['datePreset']!="? string: ?" || $data['carTypeID']!=null || $data['fuelTypeID']!=null || $data['carBrandID']!=null)){
                if($data['datePreset']==0){   
                if($data['fromDate'] != null && $data['toDate'] != null){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $add = true;
                    $rawDB .= "trips.tripDate BETWEEN '"  . $data['fromDate'] ."' AND '". $data['toDate'] . "'";
                    $filterMessage .= $data['toDate']. " to ". $data['fromDate'];
                }elseif(!isset($data['fromDate']) && $data['toDate'] != null){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $add = true;
                    $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "'";
                    $filterMessage .= "before ".$data['toDate'];
                }elseif($data['fromDate'] != null && !isset($data['toDate'])){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated  ";
                    }
                    $add = true;
                    $rawDB .= "trips.tripDate >= '" . $data['fromDate'] . "'";
                    $filterMessage .= "after ".$data['fromDate'];
                }
            }
            else{
                switch($data['datePreset']){
                    case "1": {
                            if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 2 WEEK";
                        $filterMessage .= "from 2 weeks ago";
                        break;
                    }
                    case "2": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 MONTH";
                        $filterMessage .= "from 1 month ago";
                        break;
                    } 
                    case "3": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 3 MONTH";
                        $filterMessage .= "from 3 month ago";
                        break;
                    }
                    case "4": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 6 MONTH";
                        $filterMessage .= "from 6 month ago";
                        break;
                    }
                    case "5": {
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 YEAR";
                        $filterMessage .= "from 1 year ago";
                        break;
                    }
                    default: $rawDB .= "";
                }
            }
            if($data['institutionID'] != null){
                    $institutionID = $data['institutionID'];
            }
            if($data['carTypeID']!=null){
                if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['carTypeID'];
                    }
                    $rawDB .= "cartype_ref.carTypeID = ".$data['carTypeID'];
                    $add = true;
            }
            if($data['fuelTypeID']!=null){
                if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['fuelTypeID'];
                    }
                    $rawDB .= "fueltype_ref.fuelTypeID = ".$data['fuelTypeID'];
                    $add = true;
            }
            if($data['carBrandID']!=null){
                if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['carBrandID'];
                    }
                    $rawDB .= "carbrand_ref.carBrandID = ".$data['carBrandID'];
                    $add = true;
            }
            if(isset($institutionID)){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " by " . $data['carTypeID'];
                }
                $rawDB .= "institutions.institutionID = ".$institutionID;
            }
                 $vehicleData=DB::table('vehicles_mv')
                    ->join('trips', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('trips.plateNumber', 'institutions.institutionName','fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'carbrand_ref.carBrandName', 'vehicles_mv.modelName', DB::raw('COUNT(trips.tripID) as tripCount, SUM(trips.kilometerReading) as totalKM, round(SUM(trips.emissions), 4) as totalEmissions'))
                    ->whereRaw($rawDB)
                    ->groupBy('vehicles_mv.plateNumber')
                    ->orderByRaw('9 DESC')
                    ->get();
                
                $vehicleDataEmissionTotal=DB::table('vehicles_mv')
                    ->join('trips', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('round(sum(trips.emissions), 4) as totalEmissions'))
                    ->whereRaw($rawDB)
                    ->get();
                
                $vehicleDataKMTotal=DB::table('vehicles_mv')
                    ->join('trips', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('sum(trips.kilometerReading) as totalKM'))
                    ->whereRaw($rawDB)
                    ->get();
                
                $column = "round(SUM(trips.emissions),4) as emission";
                     
                $fuelContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('fuelType_ref.fuelTypeName', DB::raw($column))
                    ->whereRaw($rawDB)
                    ->groupBy('fuelType_ref.fuelTypeName')
                    ->orderByRaw('2 DESC')
                    ->limit(1)
                    ->get();

                //get most car type contributions (emission total)
                $carContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))
                    ->whereRaw($rawDB)
                    ->groupBy('vehicles_mv.modelName')
                    ->orderByRaw('2 DESC')
                    ->limit(1)
                    ->get();

                //get most car brand type contributions (emission total)
                $carBrandContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('carbrand_ref.carBrandName', DB::raw($column))
                    ->whereRaw($rawDB)
                    ->groupBy('carbrand_ref.carbrandName')
                    ->orderByRaw('2 DESC')
                    ->limit(1)
                    ->get();
            }
            else{
                
                $vehicleData=DB::table('vehicles_mv')
                    ->join('trips', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('trips.plateNumber', 'institutions.institutionName','fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'carbrand_ref.carBrandName', 'vehicles_mv.modelName', DB::raw('COUNT(trips.tripID) as tripCount, SUM(trips.kilometerReading) as totalKM, round(SUM(trips.emissions),4) as totalEmissions'))
                    ->groupBy('vehicles_mv.plateNumber')
                    ->orderByRaw('9 DESC')
                    ->get();
                
                $vehicleDataEmissionTotal=DB::table('trips')
                    ->select(DB::raw('round(sum(trips.emissions), 4) as totalEmissions'))
                    ->get();
                
                $vehicleDataKMTotal=DB::table('trips')
                    ->select(DB::raw('sum(trips.kilometerReading) as totalKM'))
                    ->get();
                
                $column = "round(SUM(trips.emissions),4) as emission";
                     
                $fuelContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('fuelType_ref.fuelTypeName', DB::raw($column))
                    ->groupBy('fuelType_ref.fuelTypeName')
                    ->orderByRaw('2 DESC')
                    ->limit(1)
                    ->get();

                //get most car type contributions (emission total)
                $carContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))
                    ->groupBy('vehicles_mv.modelName')
                    ->orderByRaw('2 DESC')
                    ->limit(1)
                    ->get();

                //get most car brand type contributions (emission total)
                $carBrandContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('carbrand_ref.carBrandName', DB::raw($column))
                    ->groupBy('carbrand_ref.carbrandName')
                    ->orderByRaw('2 DESC')
                    ->limit(1)
                    ->get();
            }
        }
        elseif($data['reportName']=="forecast"){
             $forecastData = DB::table('trips')
                 ->select(DB::raw('EXTRACT(year_month from tripDate) as monthYear, round(sum(trips.emissions), 4) as emission')) 
                 ->groupBy(DB::raw('1'))
                 ->orderBy(DB::raw('1'), 'asc')
                 ->get();

             $r = 0;
             $summationOfNumerator = 0;
             $xAve = 0;
             $yAve = 0;
             for($x = 1; $x <= count($forecastData); $x++) {
                 $xAve += $x;
             }
             for($x = 0; $x < count($forecastData); $x++) {
                 $yAve += $forecastData[$x]->emission;
             }
             $xAve = $xAve/count($forecastData);
             $yAve = $yAve/count($forecastData);
             for($x = 1; $x <= count($forecastData); $x++) {
                 $summationOfNumerator+=($x - $xAve)*($forecastData[$x - 1]->emission - $yAve);
             }
 
             //denominator 
             $denominator = 0;
             $summationTerm1 = 0;
             $summationTerm2 = 0;
             for($x = 1; $x <= count($forecastData); $x++) {
                 $summationTerm1+=($x - $xAve)*($x - $xAve);
                 $summationTerm2+=($forecastData[$x - 1]->emission - $yAve)*($forecastData[$x - 1]->emission - $yAve);
             }
 
             $denominator = sqrt($summationTerm1 * $summationTerm2);
             $r = $summationOfNumerator/$denominator;
 
             //standard deviation calculation
             $Sy = sqrt($summationTerm2/(count($forecastData)-1));
             $Sx = sqrt($summationTerm1/(count($forecastData)-1));
 
             //slope calculation
             $b = $r * ($Sy/$Sx);
 
             //y-intercept calculation
             $a;
             $a = $yAve - ($b * $xAve);
 
             $regressionLine = array($a, $b);
            $ctr = 0;
            foreach($forecastData as $point){
                $forecastData[$ctr]->forecastPoint = round($regressionLine[0]+($regressionLine[1]*($ctr+1)), 4);
                $ctr++;
            }
            $forecastPoint = round($regressionLine[0]+($regressionLine[1]*($ctr+1)), 4);
            $toPush = json_decode('{"monthYear":"Forecast","emission":'.$forecastPoint.',"forecastPoint":'.$forecastPoint.'}');
            $forecastData->push($toPush);
        }   
        elseif($data['reportName']=='treeSeq'){
            if($data['isFiltered']=="true" && ($data['institutionID']!= null || $data['fromDate'] != null || $data['toDate']!=null || $data['datePreset']!="? string: ?" || $data['carTypeID']!=null || $data['fuelTypeID']!=null || $data['carBrandID']!=null)){
                $filterMessage = "";
                $rawDB = "";
                $add = false;
                if($data['datePreset']==0){   
                    if($data['fromDate'] != null && $data['toDate'] != null){
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $add = true;
                        $rawDB .= "trips.tripDate BETWEEN '"  . $data['fromDate'] ."' AND '". $data['toDate'] . "'";
                        $filterMessage .= $data['toDate']. " to ". $data['fromDate'];
                    }elseif(!isset($data['fromDate']) && $data['toDate'] != null){
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $add = true;
                        $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "'";
                        $filterMessage .= "before ".$data['toDate'];
                    }elseif($data['fromDate'] != null && !isset($data['toDate'])){
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated  ";
                        }
                        $add = true;
                        $rawDB .= "trips.tripDate >= '" . $data['fromDate'] . "'";
                        $filterMessage .= "after ".$data['fromDate'];
                    }
                }
                else{
                    switch($data['datePreset']){
                        case "1": {
                                if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 2 WEEK";
                            $filterMessage .= "from 2 weeks ago";
                            break;
                        }
                        case "2": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 MONTH";
                            $filterMessage .= "from 1 month ago";
                            break;
                        } 
                        case "3": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 3 MONTH";
                            $filterMessage .= "from 3 month ago";
                            break;
                        }
                        case "4": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 6 MONTH";
                            $filterMessage .= "from 6 month ago";
                            break;
                        }
                        case "5": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 YEAR";
                            $filterMessage .= "from 1 year ago";
                            break;
                        }
                        default: $rawDB .= "";
                    }
                }
                if($data['institutionID'] != null){
                        $institutionID = $data['institutionID'];
                }
                if($data['carTypeID']!=null){
                    if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " by " . $data['carTypeID'];
                        }
                        $rawDB .= "cartype_ref.carTypeID = ".$data['carTypeID'];
                        $add = true;
                }
                if($data['fuelTypeID']!=null){
                    if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " by " . $data['fuelTypeID'];
                        }
                        $rawDB .= "fueltype_ref.fuelTypeID = ".$data['fuelTypeID'];
                        $add = true;
                }
                if($data['carBrandID']!=null){
                    if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " by " . $data['carBrandID'];
                        }
                        $rawDB .= "carbrand_ref.carBrandID = ".$data['carBrandID'];
                        $add = true;
                }            
                if(isset($institutionID)){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['carTypeID'];
                    }
                    $rawDB .= "institutions.institutionID = ".$institutionID;
                }
            
                $monthlyEmissions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                     ->select(DB::raw('EXTRACT(year_month from tripDate) as monthYear, round(sum(trips.emissions), 4) as emission')) 
                     ->whereRaw($rawDB)
                     ->groupBy(DB::raw('1'))
                     ->orderBy(DB::raw('1'), 'asc')
                     ->get();
                if(isset($institutionID)){
                    $treeRaw = "institutionID = ".$institutionID;
                    $monthlyTreeSeq = DB::Table('institutionbatchplant')
                        ->select(DB::raw('EXTRACT(year_month from datePlanted) as monthYear, sum(numOfPlantedTrees) as numOfTrees'))
                        ->whereRaw($treeRaw)
                        ->groupBy(DB::raw('1'))
                        ->orderBy(DB::raw('1'))
                        ->get();
                }
                else{
                    $monthlyTreeSeq = DB::Table('institutionbatchplant')
                        ->select(DB::raw('EXTRACT(year_month from datePlanted) as monthYear, sum(numOfPlantedTrees) as numOfTrees'))
                        ->groupBy(DB::raw('1'))
                        ->orderBy(DB::raw('1'))
                        ->get();
                }
            }
            else{
            $monthlyTreeSeq = DB::Table('institutionbatchplant')
                ->select(DB::raw('EXTRACT(year_month from datePlanted) as monthYear, sum(numOfPlantedTrees) as numOfTrees'))
                ->groupBy(DB::raw('1'))
                ->orderBy(DB::raw('1'))
                ->get();
            
            $monthlyEmissions = DB::table('trips')
                 ->select(DB::raw('EXTRACT(year_month from tripDate) as monthYear, round(sum(trips.emissions), 4) as emission')) 
                 ->groupBy(DB::raw('1'))
                 ->orderBy(DB::raw('1'), 'asc')
                 ->get();
            }
            $red = 0;
            $yellow = 0;
            $green = 0;
            for($x = 0; $x < count($monthlyEmissions); $x++){
                for($y = 0; $y < count($monthlyTreeSeq); $y++){
                    if($monthlyEmissions[$x]->monthYear==$monthlyTreeSeq[$y]->monthYear){
                        $monthlyEmissions[$x]->treeSeq = (($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001;
                        if(((($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001 / $monthlyEmissions[$x]->emission)*100 < 40){
                            $red++;
                        }elseif(((($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001 / $monthlyEmissions[$x]->emission)*100 >= 40 && ((($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001 / $monthlyEmissions[$x]->emission)*100 < 80){
                            $yellow++;
                        }else $green++;
                    }
                }
            }
            for($x = 0; $x < count($monthlyEmissions); $x++){
                if(!isset($monthlyEmissions[$x]->treeSeq)){
                    $monthlyEmissions[$x]->treeSeq = 0;
                    $red++;
                }
            }
        }
        elseif($data['reportName']=='treevsforecast'){
            if($data['isFiltered']=="true" && ($data['institutionID']!= null || $data['fromDate'] != null || $data['toDate']!=null || $data['datePreset']!="? string: ?" || $data['carTypeID']!=null || $data['fuelTypeID']!=null || $data['carBrandID']!=null)){
                $filterMessage = "";
                $rawDB = "";
                $add = false;
                if($data['datePreset']==0){   
                    if($data['fromDate'] != null && $data['toDate'] != null){
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $add = true;
                        $rawDB .= "trips.tripDate BETWEEN '"  . $data['fromDate'] ."' AND '". $data['toDate'] . "'";
                        $filterMessage .= $data['toDate']. " to ". $data['fromDate'];
                    }elseif(!isset($data['fromDate']) && $data['toDate'] != null){
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated ";
                        }
                        $add = true;
                        $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "'";
                        $filterMessage .= "before ".$data['toDate'];
                    }elseif($data['fromDate'] != null && !isset($data['toDate'])){
                        if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " dated  ";
                        }
                        $add = true;
                        $rawDB .= "trips.tripDate >= '" . $data['fromDate'] . "'";
                        $filterMessage .= "after ".$data['fromDate'];
                    }
                }
                else{
                    switch($data['datePreset']){
                        case "1": {
                                if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 2 WEEK";
                            $filterMessage .= "from 2 weeks ago";
                            break;
                        }
                        case "2": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 MONTH";
                            $filterMessage .= "from 1 month ago";
                            break;
                        } 
                        case "3": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 3 MONTH";
                            $filterMessage .= "from 3 month ago";
                            break;
                        }
                        case "4": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 6 MONTH";
                            $filterMessage .= "from 6 month ago";
                            break;
                        }
                        case "5": {
                            if($add){
                                $rawDB .= " AND ";
                                $filterMessage .= " dated ";
                            }
                            $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 YEAR";
                            $filterMessage .= "from 1 year ago";
                            break;
                        }
                        default: $rawDB .= "";
                    }
                }
                if($data['institutionID'] != null){
                        $institutionID = $data['institutionID'];
                }
                if($data['carTypeID']!=null){
                    if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " by " . $data['carTypeID'];
                        }
                        $rawDB .= "cartype_ref.carTypeID = ".$data['carTypeID'];
                        $add = true;
                }
                if($data['fuelTypeID']!=null){
                    if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " by " . $data['fuelTypeID'];
                        }
                        $rawDB .= "fueltype_ref.fuelTypeID = ".$data['fuelTypeID'];
                        $add = true;
                }
                if($data['carBrandID']!=null){
                    if($add){
                            $rawDB .= " AND ";
                            $filterMessage .= " by " . $data['carBrandID'];
                        }
                        $rawDB .= "carbrand_ref.carBrandID = ".$data['carBrandID'];
                        $add = true;
                }            
                if(isset($institutionID)){
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " by " . $data['carTypeID'];
                    }
                    $rawDB .= "institutions.institutionID = ".$institutionID;
                }
            
                $monthlyEmissions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                     ->select(DB::raw('EXTRACT(year_month from tripDate) as monthYear, round(sum(trips.emissions), 4) as emission')) 
                     ->whereRaw($rawDB)
                     ->groupBy(DB::raw('1'))
                     ->orderBy(DB::raw('1'), 'asc')
                     ->get();
                if(isset($institutionID)){
                    $treeRaw = "institutionID = ".$institutionID;
                    $monthlyTreeSeq = DB::Table('institutionbatchplant')
                        ->select(DB::raw('EXTRACT(year_month from datePlanted) as monthYear, sum(numOfPlantedTrees) as numOfTrees'))
                        ->whereRaw($treeRaw)
                        ->groupBy(DB::raw('1'))
                        ->orderBy(DB::raw('1'))
                        ->get();
                }
                else{
                    $monthlyTreeSeq = DB::Table('institutionbatchplant')
                        ->select(DB::raw('EXTRACT(year_month from datePlanted) as monthYear, sum(numOfPlantedTrees) as numOfTrees'))
                        ->groupBy(DB::raw('1'))
                        ->orderBy(DB::raw('1'))
                        ->get();
                }
            }
            else{
            $monthlyTreeSeq = DB::Table('institutionbatchplant')
                ->select(DB::raw('EXTRACT(year_month from datePlanted) as monthYear, sum(numOfPlantedTrees) as numOfTrees'))
                ->groupBy(DB::raw('1'))
                ->orderBy(DB::raw('1'))
                ->get();
            
            $monthlyEmissions = DB::table('trips')
                 ->select(DB::raw('EXTRACT(year_month from tripDate) as monthYear, round(sum(trips.emissions), 4) as emission')) 
                 ->groupBy(DB::raw('1'))
                 ->orderBy(DB::raw('1'), 'asc')
                 ->get();
            }
            $red = 0;
            $yellow = 0;
            $green = 0;
            for($x = 0; $x < count($monthlyEmissions); $x++){
                for($y = 0; $y < count($monthlyTreeSeq); $y++){
                    if($monthlyEmissions[$x]->monthYear==$monthlyTreeSeq[$y]->monthYear){
                        $monthlyEmissions[$x]->treeSeq = (($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001;
                        if(((($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001 / $monthlyEmissions[$x]->emission)*100 < 40){
                            $red++;
                        }elseif(((($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001 / $monthlyEmissions[$x]->emission)*100 >= 40 && ((($monthlyTreeSeq[$y]->numOfTrees)*22.6)/12*0.001 / $monthlyEmissions[$x]->emission)*100 < 80){
                            $yellow++;
                        }else $green++;
                    }
                }
            }
            for($x = 0; $x < count($monthlyEmissions); $x++){
                if(!isset($monthlyEmissions[$x]->treeSeq)){
                    $monthlyEmissions[$x]->treeSeq = 0;
                    $red++;
                }
            }
        }
    }
?>
    @extends('layouts.main') @section('styling')
    <style>
        /** TODO: Push margin more to the right. Make the box centered to the user. **/

        #box-form {
            margin-top: 20px;
            padding: 40px;
            border-radius: 10px;
        }

        #box-form h1 {
            text-align: center;
            color: white;
        }

        #box-form input {
            color: white;
        }
        
        /* Tooltip container */
        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black; /* If you want dots under the hoverable text */
        }

        /* Tooltip text */
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 250px;
            bottom: 100%;
            left: 50%; 
            margin-left: -60px;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;

            /* Position the tooltip text - see examples below! */
            position: absolute;
            z-index: 1;
        }
        
        .tooltip .tooltiptext::after {
            content: " ";
            position: absolute;
            top: 100%; /* At the bottom of the tooltip */
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: black transparent transparent transparent;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
    </style>
    <style>
        #chartdiv2 {
            width: 100%;
            height: 500px;
        }
    </style>
    @endsection @section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
    <div ng-app="myapp">
     <br>
    <form method="get" target="print_popup" action="{{ route('reportexport') }}" onsubmit="var opening = 'width='; window.open('about:blank','print_popup',opening.concat(screen.availWidth, ', height=', screen.availHeight));">
    {{ csrf_field() }}
        <div class="row"><div class="seven columns "><h5>&nbsp; Dashboard > Generate Reports</h5></div>
    <?php 
        if(isset($data)){
            echo '<input type="hidden" name="isFiltered" value="';
            if(isset($data['isFiltered'])){
                echo $data['isFiltered'];
            }else echo "";
                     echo '">';
            echo '<input type="hidden" name="institutionID" value="';
            if(isset($data['institutionID'])){
                echo $data['institutionID'];
            }else echo "";
                     echo '">';
            echo '<input type="hidden" name="fromDate" value="';
            if(isset($data['fromDate'])){
                echo $data['fromDate'];
            }else echo "";
            echo '">';
            echo '<input type="hidden" name="toDate" value="';
            if(isset($data['toDate'])){
                echo $data['toDate'];
            }else echo "";
            echo '">';
            echo '<input type="hidden" name="datePreset" value="';
            if(isset($data['datePreset'])){
                echo $data['datePreset'];
            }else echo "";
            echo '">';
            echo '<input type="hidden" name="carTypeID" value="';
               if(isset($data['carTypeID'])){
                   echo $data['carTypeID'];
               }else echo "";
            echo '">';
            echo '<input type="hidden" name="fuelTypeID" value="';
            if(isset($data['fuelTypeID'])){
                echo $data['fuelTypeID'];
            }else echo "";
            echo '">';
            echo '<input type="hidden" name="carBrandID" value="';
            if(isset($data['carBrandID'])){
                echo $data['carBrandID'];
            }else echo "";
            echo '">';
            switch($data['reportName']){
                case "vehicleUsage": {$reportName = "Vehicle Usage Report"; break;}
                case "trip": {$reportName = "Trip Report"; break;}
                case "comparison": {$reportName = "Comparison Report"; break;}
                case "treeSeq": {$reportName = "Tree Sequestration Report"; break;}
                case "forecast": {$reportName = "Forecast Report"; break;}
                case "emission": {$reportName = "Emission Report"; break;}
                default: $reportName = "";
            }
            echo '<input type="hidden" name="reportName" value="';
            if(isset($reportName)){
                echo $reportName.'">';
            }else echo "";
        }
        if(isset($data['reportName'])){
            echo '<div class="two columns"><input type="submit" class="button button-primary" value="Export Report"></form></div>';
            echo '<div class="two columns offset-by-one"><button class="button-primary" onclick="javascript:xport.toCSV(\''.$data['reportName']."report-".(new DateTime())->add(new DateInterval('PT8H'))->format('Y-m-d H:i:s').'\');">Export to CSV</button></div></div>';
            echo '<div class="row" style="text-align:center"><h5>'.$reportName.'</h5></div>';
        }
    ?>
    <form method="post" action="{{ route('reports-process') }}">
    {{ csrf_field() }}
    <?php
        if($showChartDiv){
                if(isset($regressionLine)){
                    $div = "twelve";
                }
                else $div = "eight";
                echo '<div class="row" id="content">
                    <div class="'.$div.' columns">
                        <div id="chartdiv2" style="background-color: #FFFFFF;" ></div></div>';
                if(!isset($regressionLine)){
                echo '<div class="four columns">
                        <div id="chartdiv" style="width: 100%; height: 400px; background-color: #FFFFFF;">';
                }else echo '<div><div>';
                if(isset($vehicleData)){
                    echo '<br><table>
                              <tr>
                                  <td width="40%">Top Vehicle</td>
                                  <td width="30%"><strong>'.$carContributions[0]->modelName.'</strong></td>
                                  <td width="30%">'.$carContributions[0]->emission.' MT C02</td>
                              </tr>
                                 <tr>
                                  <td>Top Fuel Type</td>
                                  <td><strong>'.$fuelContributions[0]->fuelTypeName.'</strong></td>
                                  <td>'.$fuelContributions[0]->emission.' MT C02</td>
                              </tr>
                                 <tr>
                                  <td>Top Car Brand</td>
                                  <td><strong>'.$carBrandContributions[0]->carBrandName.'</strong></td>
                                  <td>'.$carBrandContributions[0]->emission.' MT C02</td>
                              </tr>';
                            if($userType <= 2){
                                echo '
                              <tr><td colspan=3 style="text-align:center"><strong>Action Items</strong></td></tr>
                              <tr>
                              <td>Ask School to check on top vehicle</td>
                              <td>Discourage Schools to buy top Car Brand</td>
                              <td>Remind to Carpool</td>
                              </tr>
                              ';
                            }
                          echo '</table>';
                }
                elseif(isset($monthlyEmissions)){
                    echo '<br><br><table>
                              <tr>
                                  <td width="40%">Red Sequestration Months</td>
                                  <td width="30%"><strong>'.$red.'</strong></td>
                              </tr>
                                 <tr>
                                  <td>Yellow Sequestration Months</td>
                                  <td><strong>'.$yellow.'</strong></td>
                              </tr>
                                 <tr>
                                  <td>Green Sequestration Months</td>
                                  <td><strong>'.$green.'</strong></td>
                              </tr>
                          </table>';
                }
                echo '</div></div></div>
                    <div class="row">';
                if(isset($tripData)){
                   //table for excel print 
                    {
                    echo "<div ng-hide=\"true\">
                    <table id=\"".$data['reportName']."report-".(new DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."\" class='display'>
                      <thead>
                          <tr>
                              <th>
                                <td>Prepared By: ".$userType = Auth::user()->accountName."</td>
                                <td>Prepared On: ".(new \DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."</td>
                              </th>
                          </tr>
                      </thead>";
                        echo "<tr></tr>";
                        echo "<tr>
                            <td>Total Trips: </td><td>".count($tripData)."</td>";
                        echo "<td>Total Emissions: </td><td>".$tripEmissionTotal[0]->totalEmissions." MT CO2</td></tr><tr></tr>";
                        echo "<tr><td>Trip Date</td><td>Trip Time</td><td>Institution</td><td>Department</td><td>Plate Number</td><td>KM Reading</td><td>Fuel Type</td><td>Car Type</td><td>Vehicle Model Name</td><td>Remarks/Itenerary</td><td>Trip Emission in MT C02</td></tr>";
                         foreach($tripData as $trip){
                             echo "<tr>";
                                 echo "<td>".$trip->tripDate."</td>";
                                 echo "<td>".$trip->tripTime."</td>";
                                 echo "<td>".$trip->institutionName."</td>";
                                 echo "<td>".$trip->deptName."</td>";
                                 echo "<td>".$trip->plateNumber."</td>";
                                 echo "<td>".$trip->kilometerReading."</td>";
                                 echo "<td>".$trip->fuelTypeName."</td>";
                                 echo "<td>".$trip->carTypeName."</td>";
                                 echo "<td>".$trip->modelName."</td>";
                                 echo "<td>".$trip->remarks."</td>";
                                 echo "<td>".$trip->emission."</td>";
                             echo "</tr>";
                            }
                            echo "<tr><td></td>
                                <td>Showing ".count($tripData)." Rows</td>
                            </tr>
                    </table>
                </div>";
                }
                  //table for html print 
                    { 
                echo "<div class=\"row\" ng-hide=\"false\"><div class=\"twelve columns\">
                    <table id=\"table_id\" class='display'>
                      <thead>
                          <tr>
                            <th>Trip Date</td><td>Trip Time</td><td>Institution</td><td>Department</td><td>Plate Number</td><td>KM Reading</td><td>Fuel Type</td><th>Car Type</td><td>Remarks/Itenerary</td><td>Trip Emission in MT C02</td>
                          </tr>
                      </thead>
                      </tbody>";
                         foreach($tripData as $trip){
                             echo "<tr>";
                                 echo "<td>".$trip->tripDate."</td>";
                                 echo "<td>".$trip->tripTime."</td>";
                                 echo "<td>".$trip->institutionName."</td>";
                                 echo "<td>".$trip->deptName."</td>";
                                 echo "<td>".$trip->plateNumber."</td>";
                                 echo "<td>".$trip->kilometerReading."</td>";
                                 echo "<td>".$trip->fuelTypeName."</td>";
                                 echo "<td>".$trip->carTypeName."</td>";
                                 echo "<td>".$trip->remarks."</td>";
                                 echo "<td>".$trip->emission."</td>";
                             echo "</tr>";
                            }
                            echo "</tbody>
                    </table>
                </div></div>";
                }
                }
                elseif(isset($vehicleData)){
                    //table for excel print
                    {
                     echo "<div class=\"row\"><div class=\"eleven columns offset-by-one\"><div ng-hide=\"true\" id=\'report\'>
                <table id=\"".$data['reportName']."report-".(new DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."\" class='display'>
                  <thead>
                      <tr>
                          <th>
                            <td>Prepared By: ".$userType = Auth::user()->accountName."</td>
                            <td>Prepared On: ".(new \DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."</td>
                          </th>
                      </tr>
                  </thead>";
                    echo "<tr></tr>";
                    echo "<tr>";
                    echo "<td>Total Distance Traveled: </td><td>".$vehicleDataKMTotal[0]->totalKM." KM </td>";
                    echo "<td>Total Emissions: </td><td>".$vehicleDataEmissionTotal[0]->totalEmissions." MT</td></tr><tr></tr>";
                    echo "<tr><td>Institution Name</td><td>Car Type</td><td>Car Brand</td><td>Car Model</td><td>Plate Number</td><td>Fuel Type</td><td>Number of Trips</td><td>Distance Traveled</td><td>Total Emissions</td></tr>";
                     foreach($vehicleData as $car){
                         echo "<tr>";
                             echo "<td>".$car->institutionName."</td>";
                             echo "<td>".$car->carTypeName."</td>";
                             echo "<td>".$car->carBrandName."</td>";
                             echo "<td>".$car->modelName."</td>";
                             echo "<td>".$car->plateNumber."</td>";
                             echo "<td>".$car->fuelTypeName."</td>";
                             echo "<td>".$car->tripCount."</td>";
                             echo "<td>".$car->totalKM."</td>";
                             echo "<td>".$car->totalEmissions."</td>";
                         echo "</tr>";
                        }
                        echo "<tr><td></td>
                            <td>Showing ".count($vehicleData)." Rows</td>
                        </tr>
                        <tr></tr>
                        <tr>
                              <td width=\"40%\">Top Vehicle</td>
                              <td width=\"30%\"><strong>".$carContributions[0]->modelName."</strong></td>
                              <td width=\"30%\">".$carContributions[0]->emission." MT C02</td>
                              </tr><tr>
                              <td>Top Fuel Type</td>
                              <td><strong>".$fuelContributions[0]->fuelTypeName."</strong></td>
                              <td>".$fuelContributions[0]->emission." MT C02</td>
                              </tr><tr>
                              <td>Top Car Brand</td>
                              <td><strong>".$carBrandContributions[0]->carBrandName."</strong></td>
                              <td>".$carBrandContributions[0]->emission." MT C02</td>
                              </tr>
                </table>
            </div></div></div>";
                    }
                    //table for html print
                    {
                    echo "<div class=\"row\" ng-hide=\"false\"><div class=\"twelve columns\">
                    <table id=\"table_id\" class='display'>
                      <thead>
                          <tr>
                            <td>Institution Name</td><td>Car Type</td><td>Car Brand</td><td>Car Model</td><td>Plate Number</td><td>Fuel Type</td><td>Number of Trips</td><td>Distance Traveled</td><td>Total Emissions</td>
                          </tr>
                      </thead>
                      </tbody>";
                         foreach($vehicleData as $car){
                         echo "<tr>";
                             echo "<td>".$car->institutionName."</td>";
                             echo "<td>".$car->carTypeName."</td>";
                             echo "<td>".$car->carBrandName."</td>";
                             echo "<td>".$car->modelName."</td>";
                             echo "<td>".$car->plateNumber."</td>";
                             echo "<td>".$car->fuelTypeName."</td>";
                             echo "<td>".$car->tripCount."</td>";
                             echo "<td>".$car->totalKM."</td>";
                             echo "<td>".$car->totalEmissions." MT C02</td>";
                         echo "</tr>";
                        }
                            echo "</tbody>
                    </table>
                </div></div>";
                    }
                }
                elseif(isset($forecastData)){
                    //table for html print
                    {
                    echo '<div class="row" ng-hide="false"><div class="twelve columns">
                    <table id="table_id" class=\'display\'>
                              <thead>
                                  <tr>
                                      <th style="text-align: center">Month-Year</th>
                                      <th style="text-align: center">Emission</th>
                                      <th style="text-align: center">Forecasted Value</th>
                                  </tr>
                              </thead>
                              <tbody>';
                    foreach($forecastData as $point){
                        echo '<tr>';
                        echo '<td>'.$point->monthYear.'</td>
                            <td style="text-align: right">'.$point->emission.'</td>
                            <td style="text-align: right">'.$point->forecastPoint.'</td></tr>';
                    }
                    echo '</tbody>
                          </table></div></div></div>';
                    }
                    
                    //for excel print
                    {
                        echo "<div class=\"row\"><div class=\"eleven columns offset-by-one\"><div ng-hide=\"true\" id=\'report\'>
                <table id=\"".$data['reportName']."report-".(new DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."\" class='display'>
                  <thead>
                      <tr>
                          <th>
                            <td>Prepared By: ".$userType = Auth::user()->accountName."</td>
                            <td>Prepared On: ".(new \DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."</td>
                          </th>
                      </tr>
                  </thead>";
                    echo "<tr></tr>";
                    echo "<tr><td>Month-Year</td><td>Emission</td><td>Forecast Value</td></tr>";
                     foreach($forecastData as $point){
                        echo '<tr>';
                        echo '<td>'.$point->monthYear.'</td>
                            <td style="text-align: right">'.$point->emission.'</td>
                            <td style="text-align: right">'.$point->forecastPoint.'</td></tr>';
                    }
                        echo "<tr><td></td>
                            <td>Showing ".count($forecastData)." Rows</td>
                        </tr>
                </table>
            </div></div></div>";
                    }
                }
                elseif(isset($monthlyEmissions)){
                    //table for excel print
                    {
                     echo "<div class=\"row\"><div class=\"eleven columns offset-by-one\"><div ng-hide=\"true\" id=\'report\'>
                <table id=\"".$data['reportName']."report-".(new DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."\" class='display'>
                  <thead>
                      <tr>
                          <th>
                            <td>Prepared By: ".$userType = Auth::user()->accountName."</td>
                            <td>Prepared On: ".(new \DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."</td>
                          </th>
                      </tr>
                  </thead>";
                    echo "<tr></tr>";
                    echo "<tr>";
                    echo "<td>Red Sequestration Months: </td><td>".$red."</td>";
                    echo "<td>Yellow Sequestration Months: </td><td>".$yellow."</td>";
                    echo "<td>Green Sequestration Months: </td><td>".$green."</td></tr><tr></tr>";
                    echo "<tr><td>Month-Year</td><td>Emission</td><td>Tree Sequestration</td></tr>";
                     foreach($monthlyEmissions as $month){
                         echo "<tr>";
                             echo "<td style=\"text-align:center\">".$month->monthYear."</td>";
                             echo "<td style=\"text-align:center\">".$month->emission."</td>";
                             echo "<td style=\"text-align:center\">".$month->treeSeq."</td>";
                         echo "</tr>";
                        }
                        echo "<tr><td></td>
                            <td>Showing ".count($monthlyEmissions)." Rows</td>
                        </tr>
                        <tr></tr>
                </table>
            </div></div></div>";
                    }
                    //table for html print
                    {
                    echo "<div class=\"row\" ng-hide=\"false\"><div class=\"twelve columns\">
                    <table id=\"table_id\" class='display'>
                      <thead>
                          <tr>"; 
                            echo "<tr><td>Month-Year</td><td>Emission</td><td>Tree Sequestration</td></tr>";
                          echo "</tr>
                      </thead>
                      </tbody>";
                         foreach($monthlyEmissions as $month){
                         echo "<tr>";
                             echo "<td>".$month->monthYear."</td>";
                             echo "<td style=\"text-align:right\">".$month->emission."</td>";
                             echo "<td style=\"text-align:right\">".$month->treeSeq."</td>";
                         echo "</tr>";
                        }
                            echo "</tbody>
                    </table>
                </div></div>";
                    }
                }
            elseif(isset($carBrandContributions1)){
                //table for excel print
                    {
                     echo "<div class=\"row\"><div class=\"eleven columns offset-by-one\"><div ng-hide=\"true\" id=\'report\'>
                <table id=\"".$data['reportName']."report-".(new DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."\" class='display'>
                  <thead>
                      <tr>
                          <th>
                            <td>Prepared By: ".$userType = Auth::user()->accountName."</td>
                            <td>Prepared On: ".(new \DateTime())->add(new DateInterval("PT8H"))->format('Y-m-d H:i:s')."</td>
                          </th>
                      </tr>
                  </thead>";
                    echo "<tr></tr>";
                    echo "<tr>";
                    echo "<td>Most Used Car: </td><td>".$carContributions1[0]->modelName."</td>";
                    echo "<td>Most Used Car Brand: </td><td>".$carBrandContributions1[0]->carBrandName."</td>";
                    echo "<td>Carpooling More? </td><td></td></tr><tr></tr>";
                    echo "<tr><td>Month-Year</td><td>Emission</td><td>Tree Sequestration</td></tr>";
                        echo "<tr><td></td>
                        </tr>
                        <tr></tr>
                </table>
            </div></div></div>";
                    }
                    //table for html print
                    {
                    echo "<div class=\"row\" ng-hide=\"false\"><div class=\"twelve columns\">
                    <table id=\"table_id\" class='display'>
                      <thead>
                          <tr>"; 
                            echo "<th>Type</th><th>Item</th><th>Emission</th><th>Action</th>";
                          echo "</tr>
                      </thead><tbody>";
                      echo "<tr>";
                    echo "<td>Most Used Car</td>";
                    echo "<td>".$carContributions1[0]->modelName."</td>";
                    echo "<td>".$carContributions1[0]->emission."</td>";
                    echo "<td>Ask School to Investigate</td></tr>";
                    echo "<tr>";
                    echo "<td>Most Used Car Brand</td>";
                    echo "<td>".$carBrandContributions1[0]->carBrandName."</td>";
                    echo "<td>".$carBrandContributions1[0]->emission."</td><td>Discourage to buy</td></tr><tr></tr>
                      </tbody>
                    </table>
                </div></div>";
                    }
                }
            }
        echo "<br>";
        ?>
            </form>
        <div ng-controller="MyController">
                <form method="post" action="{{ route('reports-process') }}" ng-init="showSchoolFilter = <?php echo isset($institutionID); ?>"> {{ csrf_field() }}
                    <input type="hidden" name="isFiltered" value="<?php echo " {{showFilter}} "?>">
                    <input type="hidden" name="reportName" value='<?php echo "{{reportName}}"?>'>
                    <div class="row">
                      <div class="six columns">
                           <div class="six columns">
                                <a class="button" ng-click="toggleFilter();" style="width: 100%"><?php echo "{{plusMinus}}"; ?> Filters</a>
                            </div>
                           <div class="six columns" ng-show="showFilter">
                                <a class="button" ng-click="togglePreset(); valueNull(); " style="width: 100%; text-align: center;">Switch Date Filter</a>
                            </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="six columns">
                            <div ng-show="showFilter">
                                <div class="row" ng-hide="showSchoolFilter">
                                    <div class="twelve columns" ng-hide="<?php if($userType > 2){ echo "true"; }else echo "false"; ?>">
                                        <select name="institutionID" id="institutionID" style="color: black; width: 100%">
                                           <option value="">All Institutions</option>
                                            @foreach($institutions as $institution)
                                              <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <?php if($userType > 2){
                                        echo '<input type="hidden" name="institutionID" value="'.$institutionID.'">';
                                    } ?>
                                </div>
                                <div class="row" ng-hide="datePreset">
                                    <div class="six columns">
                                        <p style="text-align: left;" ng-hide="datePreset"><strong>From:</strong></p>
                                        <input class="u-full-width" type="date" ng-model="fromRange" name="fromDate" id="fromDate" ng-hide="datePreset"></div>
                                    <div class="six columns">
                                        <p style="text-align: left;" ng-hide="datePreset"><strong>To: </strong></p>
                                        <input class="u-full-width" type="date" ng-model="toRange" name="toDate" id="toDate" ng-hide="datePreset">
                                    </div>
                                </div>
                                <div class="row" ng-show="datePreset">
                                    <select name="datePreset" ng-model="preset" style="color: black; width: 100%">
                                        <option value="0" selected>Select Date Preset</option>
                                        <option value="1">2 Weeks</option>
                                        <option value="2">Last Month</option>
                                        <option value="3">Last 3 Months</option>
                                        <option value="4">Last 6 Months</option>
                                        <option value="5">Last 1 Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="twelve columns tooltip">
                                   <span class="tooltiptext">Show me the trips and their emissions</span>
                                    <input type="submit" class="button-primary" ng-click='addReport("trip");' value="Trip Report" style="width: 100%">
                                </div>
                                <div class="twelve columns tooltip">
                                    <span class="tooltiptext">Show me how vehicles are utilized</span>
                                    <input type="submit" class="button-primary" ng-click="addReport('vehicleUsage')" value="Vehicle Utilization Report" style="width: 100%">
                                </div>
                                <div class="twelve columns tooltip" ng-hide="true">
                                    <span class="tooltiptext">Let me compare emissions from two different times</span>
                                    <input type="submit" class="button-primary" ng-click="addReport('comparison')" value="Comparison Report" style="width: 100%">
                                </div>
                                <div class="row">
                                <div class="one column tooltip">
                                    <span class="tooltiptext">Click on a report to generate it. You can filter with the filter button if needed.</span>
                                    <img src="{{ URL::asset('/images/qmark.png') }}" width="20" height="20">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="six columns">
                                <div class="row" ng-show="showFilter">
                                    <div class="four columns">
                                        <select class="u-full-width" name="carTypeID" id="carTypeID" style="color: black; width: 100%">
                                           <option value="">All Car Types</option>
                                            @foreach($carTypes as $carType)
                                              <option value="{{ $carType->carTypeID }}">{{ $carType->carTypeName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="four columns">
                                        <select class="u-full-width" name="fuelTypeID" id="fuelTypeID" style="color: black; width: 100%">
                                             <option value="">All Fuel Types</option>
                                              @foreach($fuelTypes as $fuelType)
                                                <option value="{{ $fuelType->fuelTypeID }}">{{ $fuelType->fuelTypeName }}</option>
                                              @endforeach
                                        </select>
                                    </div>
                                <div class="four columns">
                                        <select class="u-full-width" name="carBrandID" id="carbrandID" style="color: black; width: 100%">
                                             <option value="">All Car Brands</option>
                                              @foreach($carBrands as $carBrand)
                                                <option value="{{ $carBrand->carBrandID }}">{{ $carBrand->carBrandName }}</option>
                                              @endforeach
                                        </select>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="twelve columns tooltip" ng-hide="true">
                                   <span class="tooltiptext">Show me the emissions</span>
                                    <input type="submit" class="button-primary" ng-click='addReport("emission");' value="Emission Report" style="width: 100%">
                                </div>
                                <div class="twelve columns tooltip">
                                   <span class="tooltiptext">Show me how much C02 our trees get</span>
                                    <input type="submit" class="button-primary" ng-click="addReport('treeSeq')" value="Tree Sequestration Report" style="width: 100%">
                                </div>
                                <div class="twelve columns tooltip">
                                    <span class="tooltiptext">Show me predicted emissions next month</span>
                                    <input type="submit" class="button-primary" ng-click="addReport('forecast')" value="Forecast Report" style="width: 100%">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    <!--angular js script-->
    <script>
        var app = angular
            .module("myapp", [])
            .controller("MyController", function($scope) {
                $scope.dboardType = ['Emissions', 'Number of Trips'];
                $scope.nonschool = false;
                $scope.showFilter = false;
                $scope.showRecurrFilter = false;
                $scope.datePreset = false;
                $scope.reportName = "";
                $scope.toRange = "";
                $scope.fromRange = "";
                $scope.preset = "";
                $scope.plusMinus = "Add ";

                $scope.toggleFilter = function() {
                    $scope.showFilter = !$scope.showFilter
                    if($scope.showFilter){
                        $scope.plusMinus = "Remove ";
                    }else $scope.plusMinus = "Add ";
                };

                $scope.toggleRecurrFilter = function() {
                    $scope.showRecurrFilter = !$scope.showRecurrFilter
                };

                $scope.addReport = function(name) {
                    $scope.reportName = name
                };

                $scope.togglePreset = function() {
                    $scope.datePreset = !$scope.datePreset

                };
                
                $scope.valueNull = function() {
                        $scope.preset = "0";
                        $scope.toRange = "";
                        $scope.fromRange = "";
                };
            });
    </script>
    <!--angular js script-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script>
    $(document).ready(function() {
        $.noConflict();
        $('#table_id').DataTable();
    });
    </script>
    <script>
        var xport = {
            _fallbacktoCSV: true,
            toXLS: function(tableId, filename) {
                this._filename = (typeof filename == 'undefined') ? tableId : filename;

                //var ieVersion = this._getMsieVersion();
                //Fallback to CSV for IE & Edge
                if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
                    return this.toCSV(tableId);
                } else if (this._getMsieVersion() || this._isFirefox()) {
                    alert("Not supported browser");
                }

                //Other Browser can download xls
                var htmltable = document.getElementById(tableId);
                var html = htmltable.outerHTML;

                this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls');
            },
            toCSV: function(tableId, filename) {
                this._filename = (typeof filename === 'undefined') ? tableId : filename;
                // Generate our CSV string from out HTML Table
                var csv = this._tableToCSV(document.getElementById(tableId));
                // Create a CSV Blob
                var blob = new Blob([csv], {
                    type: "text/csv"
                });

                // Determine which approach to take for the download
                if (navigator.msSaveOrOpenBlob) {
                    // Works for Internet Explorer and Microsoft Edge
                    navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
                } else {
                    this._downloadAnchor(URL.createObjectURL(blob), 'csv');
                }
            },
            _getMsieVersion: function() {
                var ua = window.navigator.userAgent;

                var msie = ua.indexOf("MSIE ");
                if (msie > 0) {
                    // IE 10 or older => return version number
                    return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
                }

                var trident = ua.indexOf("Trident/");
                if (trident > 0) {
                    // IE 11 => return version number
                    var rv = ua.indexOf("rv:");
                    return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
                }

                var edge = ua.indexOf("Edge/");
                if (edge > 0) {
                    // Edge (IE 12+) => return version number
                    return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
                }

                // other browser
                return false;
            },
            _isFirefox: function() {
                if (navigator.userAgent.indexOf("Firefox") > 0) {
                    return 1;
                }

                return 0;
            },
            _downloadAnchor: function(content, ext) {
                var anchor = document.createElement("a");
                anchor.style = "display:none !important";
                anchor.id = "downloadanchor";
                document.body.appendChild(anchor);

                // If the [download] attribute is supported, try to use it

                if ("download" in anchor) {
                    anchor.download = this._filename + "." + ext;
                }
                anchor.href = content;
                anchor.click();
                anchor.remove();
            },
            _tableToCSV: function(table) {
                // We'll be co-opting 'slice' to create arrays
                var slice = Array.prototype.slice;

                return slice
                    .call(table.rows)
                    .map(function(row) {
                        return slice
                            .call(row.cells)
                            .map(function(cell) {
                                return '"t"'.replace("t", cell.textContent);
                            })
                            .join(",");
                    })
                    .join("\r\n");
            }
        };
    </script>
    <?php 
        if(isset($tripData)){
            echo '<script type="text/javascript">
			var chart;
            var chart = AmCharts.makeChart("chartdiv",
				{
					"type": "serial",
					"categoryField": "tripDate",
					"startDuration": 1,
					"theme": "light",
					"categoryAxis": {
						"gridPosition": "start"
					},
					"chartCursor": {
						"enabled": true
					},
					"chartScrollbar": {
						"enabled": true
					},
					"trendLines": [],
					"graphs": [
						{
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"title": "Trips",
							"type": "column",
							"valueField": "emission"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "Number of Trips"
						}
					],
					"allLabels": [],
					"balloon": {},
                    "export": {
                        "enabled": true
                      },
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": "Trip Count per Month"
						}
					],
					"dataProvider":'.json_encode($monthlyTrip);
            echo '
				}
			);
            
		</script>';
        
        echo '<script type="text/javascript">
			var chart;
            var chart = AmCharts.makeChart("chartdiv2",
				{
					"type": "serial",
					"categoryField": "tripDate",
					"dataDateFormat": "YYYY-MM-DD",
					"startDuration": 1,
					"categoryAxis": {
						"gridPosition": "start",
						"parseDates": true
					},
					"chartCursor": {
						"enabled": true
					},
					"chartScrollbar": {
						"enabled": true
					},
					"trendLines": [],
					"graphs": [
						{
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"title": "Trips",
							"type": "column",
							"valueField": "emission"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "C02 Emissions in MT"
						}
					],
					"allLabels": [],
					"balloon": {},
                    "export": {
                        "enabled": true
                      },
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": "Trip Emissions"
						}
					],
					"dataProvider":'.json_encode($tripData);
            echo '
				}
			);
            
             var btn = document.getElementById(\'exportToPDF\');
        btn.onclick = function() {
            var exp = new AmCharts.AmExport(chart);
            exp.init();
            exp.output({
                format: \'png\'
            });
        };
		</script>';
        }
        elseif(isset($vehicleData)){ 
            $carTypeEmissions = DB::table('trips')
                ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
                ->join('carType_ref', 'vehicles_mv.carTypeID', '=', 'carType_ref.carTypeID')
                ->select('carType_ref.carTypeName', 'carType_ref.carTypeID', DB::raw('round(sum(trips.emissions), 4) as emission'))
                ->groupBy(DB::raw('1'))
                ->orderByRaw('2')
                ->get();
                    $ctr = 0;
                    foreach($carTypeEmissions as $carType){
                        $carTypeEmissions[$ctr]->tripRows = DB::table('trips')->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')->select(DB::raw('vehicles_mv.modelName as carTypeName, round(sum(trips.emissions), 4) as emission'))->whereRaw('vehicles_mv.carTypeID='.($ctr+1))->groupBy(DB::raw('1'))->get();
                        $ctr++;
                    }
            echo '<script>
                var chartData = '.json_encode($carTypeEmissions).'

var chart = AmCharts.makeChart("chartdiv2", {
  "type": "serial",
  "creditsPosition": "top-right",
  "autoMargins": false,
  "marginLeft": 30,
  "marginRight": 8,
  "marginTop": 10,
  "marginBottom": 26,
  "titles": [{
    "text": "Car Type Data"
  }],
  "dataProvider": chartData,
  "startDuration": 1,
  "graphs": [{
    "alphaField": "alpha",
    "balloonText": "<span style=\'font-size:13px;\'>[[title]] of [[carTypeName]] car type:<b>[[value]] MT CO2</b>",
    "dashLengthField": "dashLengthColumn",
    "fillAlphas": 1,
    "title": "Emissions",
    "type": "column",
    "valueField": "emission",
    "urlField": "url"
  }],
  "valueAxes": [
        {
            "id": "ValueAxis-1",
            "title": "C02 Emissions in MT"
        }
    ],
  "categoryField": "carTypeName",
  "export": {
    "enabled": true
  },
  "categoryAxis": {
    "gridPosition": "start",
    "axisAlpha": 0,
    "tickLength": 0
  }
});

 var btn = document.getElementById(\'exportToPDF\');
        btn.onclick = function() {
            var exp = new AmCharts.AmExport(chart);
            exp.init();
            exp.output({
                format: \'png\'
            });
        };

chart.addListener("clickGraphItem", function(event) {
  if (\'object\' === typeof event.item.dataContext.tripRows) {

    // set the monthly data for the clicked month
    event.chart.dataProvider = event.item.dataContext.tripRows;

    // update the chart title
    event.chart.titles[0].text =\' Trip Rows\';

    // let\'s add a label to go back to yearly data
    event.chart.addLabel(
      35, 20,
      "< Go back to all car type data",
      undefined,
      15,
      undefined,
      undefined,
      undefined,
      true,
      \'javascript:resetChart();\');

    // validate the new data and make the chart animate again
    event.chart.validateData();
    event.chart.animateAgain();
  }
});

// function which resets the chart back to yearly data
function resetChart() {
  chart.dataProvider = chartData;
  chart.titles[0].text = \'All car type data\';

  // remove the "Go back" label
  chart.allLabels = [];

  chart.validateData();
  chart.animateAgain();
}
                            </script>';
        }
        elseif(isset($regressionLine)){
            echo '<script type="text/javascript">
			var chart;
            var chart = AmCharts.makeChart("chartdiv2",
				{
					"type": "serial",
					"categoryField": "monthYear",
					"startDuration": 1,
					"theme": "light",
					"categoryAxis": {
						"gridPosition": "start"
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": "[[title]]: [[value]]",
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"labelText": "[[value]]",
							"title": "Emission",
							"type": "column",
							"valueField": "emission"
						},
						{
							"balloonText": "[[title]]: [[value]]",
							"bullet": "round",
							"id": "AmGraph-2",
							"lineThickness": 2,
							"title": "Forecasted Value",
							"valueField": "forecastPoint"
						}
					],
					"guides": [],
                    "export": {
                        "enabled": true
                      },
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "C02 Emission in MT"
						}
					],
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"useGraphSettings": true
					},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": "Emissions and Forecasted Value"
						}
					],
					"dataProvider": '.json_encode($forecastData).'
				}
			);
            
             var btn = document.getElementById(\'exportToPDF\');
        btn.onclick = function() {
            var exp = new AmCharts.AmExport(chart);
            exp.init();
            exp.output({
                format: \'png\'
            });
        };
		</script>';
        }
        elseif(isset($monthlyEmissions)){
            echo '<script type="text/javascript">
			var chart;
            var chart = AmCharts.makeChart("chartdiv2",
				{
					"type": "serial",
					"categoryField": "monthYear",
					"colors": [
						"#b93e3d",
						"#84b761",
						"#fdd400",
						"#cc4748",
						"#cd82ad",
						"#2f4074",
						"#448e4d",
						"#b7b83f",
						"#b9783f",
						"#b93e3d",
						"#913167"
					],
					"startDuration": 1,
					"theme": "light",
					"categoryAxis": {
						"gridPosition": "start"
					},
					"trendLines": [],
					"graphs": [
						{
							"balloonText": "[[category]]: [[value]]",
							"fillAlphas": 1,
							"id": "AmGraph-1",
							"title": "Emissions",
							"type": "column",
							"valueField": "emission"
						},
						{
							"balloonText": "[[category]]: [[value]]",
							"fillAlphas": 1,
							"id": "AmGraph-2",
							"title": "Tree Sequestration",
							"type": "column",
							"valueField": "treeSeq"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": ""
						}
					],
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"useGraphSettings": true
					},
					"titles": [
						{
							"id": "Title-1",
							"size": 15,
							"text": "Emission vs Tree Sequestration"
						}
					],
					"dataProvider": '.json_encode($monthlyEmissions).'
				}
			);
             var btn = document.getElementById(\'exportToPDF\');
        btn.onclick = function() {
            var exp = new AmCharts.AmExport(chart);
            exp.init();
            exp.output({
                format: \'png\'
            });
        };
		</script>';
        }
    ?>
    <script>
        $(document).ready(function() {
            $('#cmd').click(function() {
                $("svg").attr("id", "svg") //Assign ID to SCG tag

                // first convert your svg to png
                exportInlineSVG(svg, function(data, canvas) {
                    svg.parentNode.replaceChild(canvas, svg);
                     html2canvas(document.getElementById('chartdiv2')).then(function(can) {
                        can.id = 'canvas'; document.getElementById('printDiv').appendChild(can);
                    });
        
                });
                function exportInlineSVG(svg, receiver, params, quality) {
                    if (!svg || !svg.nodeName || svg.nodeName !== 'svg') {
                        console.error('Wrong arguments : should be \n exportSVG(SVGElement, function([dataURL],[canvasElement]) || IMGElement || CanvasElement [, String_toDataURL_Params, Float_Params_quality])')
                        return;
                    }

                    var xlinkNS = "http://www.w3.org/1999/xlink";
                    var clone;
                    // This will convert an external image to a dataURL
                    var toDataURL = function(image) {

                        var img = new Image();
                        // CORS workaround, this won't work in IE<11
                        // If you are sure you don't need it, remove the next line and the double onerror handler
                        // First try with crossorigin set, it should fire an error if not needed
                        img.crossOrigin = 'Anonymous';

                        img.onload = function() {
                            // we should now be able to draw it without tainting the canvas
                            var canvas = document.createElement('canvas');
                            var bbox = image.getBBox();
                            canvas.width = bbox.width;
                            canvas.height = bbox.height;
                            // draw the loaded image
                            canvas.getContext('2d').drawImage(this, 0, 0, bbox.width, bbox.height);
                            // set our original <image>'s href attribute to the dataURL of our canvas
                            image.setAttributeNS(xlinkNS, 'href', canvas.toDataURL());
                            // that was the last one
                            if (++encoded === total) exportDoc()
                        }

                        // No CORS set in the response		
                        img.onerror = function() {
                            // save the src
                            var oldSrc = this.src;
                            // there is an other problem
                            this.onerror = function() {
                                console.warn('failed to load an image at : ', this.src);
                                if (--total === encoded && encoded > 0) exportDoc();
                            }
                            // remove the crossorigin attribute
                            this.removeAttribute('crossorigin');
                            // retry
                            this.src = '';
                            this.src = oldSrc;
                        }
                        // load our external image into our img
                        img.src = image.getAttributeNS(xlinkNS, 'href');
                    }

                    // The final function that will export our svgNode to our receiver
                    var exportDoc = function() {
                        // check if our svgNode has width and height properties set to absolute values
                        // otherwise, canvas won't be able to draw it
                        var bbox = svg.getBBox();
                        // avoid modifying the original one
                        clone = svg.cloneNode(true);
                        if (svg.width.baseVal.unitType !== 1) clone.setAttribute('width', bbox.width);
                        if (svg.height.baseVal.unitType !== 1) clone.setAttribute('height', bbox.height);

                        parseStyles();

                        // serialize our node
                        var svgData = (new XMLSerializer()).serializeToString(clone);
                        // remember to encode special chars
                        var svgURL = 'data:image/svg+xml; charset=utf8, ' + encodeURIComponent(svgData);

                        var svgImg = new Image();

                        svgImg.onload = function() {
                            // if we set a canvas as receiver, then use it
                            // otherwise create a new one
                            var canvas = (receiver && receiver.nodeName === 'CANVAS') ? receiver : document.createElement('canvas');
                            // IE11 doesn't set a width on svg images...
                            canvas.width = this.width || bbox.width;
                            canvas.height = this.height || bbox.height;
                            canvas.getContext('2d').drawImage(this, 0, 0, canvas.width, canvas.height);

                            // try to catch IE
                            try {
                                // if we set an <img> as receiver
                                if (receiver.nodeName === 'IMG') {
                                    // make the img looks like the svg
                                    receiver.setAttribute('style', getSVGStyles(receiver));
                                    receiver.src = canvas.toDataURL(params, quality);
                                } else {
                                    // make the canvas looks like the canvas
                                    canvas.setAttribute('style', getSVGStyles(canvas));
                                    // a container element
                                    if (receiver.appendChild && receiver !== canvas)
                                        receiver.appendChild(canvas);
                                    // if we set a function
                                    else if (typeof receiver === 'function')
                                        receiver(canvas.toDataURL(params, quality), canvas);
                                }
                            } catch (ie) {
                                console.warn("Your ~browser~ has tainted the canvas.\n The canvas is returned");
                                if (receiver.nodeName === 'IMG') receiver.parentNode.replaceChild(canvas, receiver);
                                else receiver(null, canvas);
                            }
                        }
                        svgImg.onerror = function(e) {
                            if (svg._cleanedNS) {
                                console.error("Couldn't export svg, please check that the svgElement passed is a valid svg document.");
                                return;
                            }
                            // Some non-standard NameSpaces can cause this issues
                            // This will remove them all
                            function cleanNS(el) {
                                var attr = el.attributes;
                                for (var i = 0; i < attr.length; i++) {
                                    if (attr[i].name.indexOf(':') > -1) el.removeAttribute(attr[i].name)
                                }
                            }
                            cleanNS(svg);
                            for (var i = 0; i < svg.children.length; i++)
                                cleanNS(svg.children[i]);
                            svg._cleanedNS = true;
                            // retry the export
                            exportDoc();
                        }
                        svgImg.src = svgURL;
                    }
                    // ToDo : find a way to get only usefull rules
                    var parseStyles = function() {
                        var styleS = [],
                            i;
                        // transform the live StyleSheetList to an array to avoid endless loop
                        for (i = 0; i < document.styleSheets.length; i++)
                            styleS.push(document.styleSheets[i]);
                        // Do we have a `<defs>` element already ?
                        var defs = clone.querySelector('defs') || document.createElementNS('http://www.w3.org/2000/svg', 'defs');
                        if (!defs.parentNode)
                            clone.insertBefore(defs, clone.firstElementChild);

                        // iterate through all document's stylesheets
                        for (i = 0; i < styleS.length; i++) {
                            var style = document.createElement('style');
                            var rules = styleS[i].cssRules,
                                l = rules.length;
                            for (var j = 0; j < l; j++)
                                style.innerHTML += rules[j].cssText + '\n';

                            defs.appendChild(style);
                        }
                        // small hack to avoid border and margins being applied inside the <img>
                        var s = clone.style;
                        s.border = s.padding = s.margin = 0;
                        s.transform = 'initial';
                    }
                    var getSVGStyles = function(node) {
                        var dest = node.cloneNode(true);
                        svg.parentNode.insertBefore(dest, svg);
                        var dest_comp = getComputedStyle(dest);
                        var svg_comp = getComputedStyle(svg);
                        var mods = "";
                        for (var i = 0; i < svg_comp.length; i++) {
                            if (svg_comp[svg_comp[i]] !== dest_comp[svg_comp[i]])
                                mods += svg_comp[i] + ':' + svg_comp[svg_comp[i]] + ';';
                        }
                        svg.parentNode.removeChild(dest);
                        return mods;
                    }

                    var images = svg.querySelectorAll('image'),
                        total = images.length,
                        encoded = 0;
                    // Loop through all our <images> elements
                    for (var i = 0; i < images.length; i++) {
                        // check if the image is external
                        if (images[i].getAttributeNS(xlinkNS, 'href').indexOf('data:image') < 0)
                            toDataURL(images[i]);
                        // else increment our counter
                        else if (++encoded === total) exportDoc()
                    }
                    // if there were no <image> element
                    if (total === 0) exportDoc();
                }
            })

        })
    </script>
    <script>
        $(function() {
        

          $("#btnSave2").click(function() {
            html2canvas(document.getElementById('context')).then(function(canvas) {
                saveAs(canvas.toDataURL(), 'canvas.png');
              }
            );
          });

          function saveAs(uri, filename) {
            var link = document.createElement('a');
            if (typeof link.download === 'string') {
              link.href = uri;
              link.download = filename;

              //Firefox requires the link to be in the body
              document.body.appendChild(link);

              //simulate click
              link.click();

              //remove the link when done
              document.body.removeChild(link);
            } else {
              window.open(uri);
            }
          }
        });
    </script>

    @endsection