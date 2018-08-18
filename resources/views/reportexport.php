<html>
<?php if(isset($data)){
   //filtering
    {
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
                dd($data['fromDate']);
            }
        }
        else{
        $showChartDiv = false;
    }
    }
    $rawDB = "";
    $institutions = DB::table('institutions')->get();
    $departments = DB::table('deptsperinstitution')->get();   
    $fuelTypes = DB::table('fueltype_ref')->get();
    $carTypes = DB::table('cartype_ref')->get();
    $carBrands = DB::table('carbrand_ref')->get();
    $tripYears = DB::table('trips')
        ->select(DB::raw('EXTRACT(year_month from tripDate) as monthYear'))
        ->groupBy(DB::raw('1'))
        ->orderByRaw('1')
        ->get();
    if(isset($data)){
        $showChartDiv = true;
        $filterMessage = "";
        $add = false;
        if($data['reportName']=="Trip Report"){
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
        elseif($data['reportName']=="Vehicle Usage Report"){
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
                
                $carTypeContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('carType_ref.carTypeName'), DB::raw($column))
                    ->whereRaw($rawDB)
                    ->groupBy('carType_ref.carTypeName')
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
                
                $carTypeContributions = DB::table('trips')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.fuelTypeID', '=', 'fueltype_ref.fuelTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select(DB::raw('carType_ref.carTypeName'), DB::raw($column))
                    ->groupBy('carType_ref.carTypeName')
                    ->orderByRaw('2 DESC')
                    ->limit(1)
                    ->get();
                     
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
        elseif($data['reportName']=="Forecast Report"){
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
        elseif($data['reportName']=='Tree Sequestration Report'){
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
}
?>
<head>
   <title>Generate report</title>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.2/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <style>
        #chartdiv2 {
            width: 80%;
            height: 75%;
        }
        .amcharts-export-menu {
            display: none;
        }
    </style>

</head>

<body ng-app="myapp">
    <?php $root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/'; ?>
   <div ng-controller="MyController">
    <button id="cmd" ng-click="togglePreset();" ng-hide="datePreset">Prepare Report</button>
    <button id="btnSave2" ng-show="datePreset">Export Report</button>
    <div id="printDiv" ng-show="datePreset">
        <table frame="box" style="table table-layout: fixed; width: 100%; border-spacing: 5px; object-fit:fill">
           <tr>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
               <td width=8.33%></td>
           </tr>
           <tr></tr>
           <tr></tr>
           <tr></tr>
           <tr></tr>
            <tr>
                <td colspan='1'>
                    <img src="<?php echo $root; ?>carbon-dash/public/images/dlsp.png" width="120" height="120">
                </td>
                <td colspan='1'>
                    <img src="<?php echo $root; ?>carbon-dash/public/images/life.jpg" width="130" height="130">
                </td>
                <td colspan='2'></td>
                <td colspan='4' style='vertical-align:center; text-align:center'>
                    <h3><?php echo $data['reportName']; if(isset($tripData)){echo "<br>".$tripData[0]->tripDate." - ".$tripData[count($tripData) - 1]->tripDate;}elseif(isset($vehicleData)){if(isset($data['toDate']) || isset($data['fromDate'])){echo '<br>'.$data['fromDate'].' - '.$data['toDate'];} }?></h3>
                </td>
            </tr>
        <tr>
           <td></td>
            <td colspan="10">
                <div id="forChart"></div>
                        
            </td>
            <td></td>
        </tr>
        <tr>
            <?php
                if(isset($tripData)){
                    echo '<td></td>
                        <td colspan=3>Total Trips: </td><td><b>'.count($tripData).'</b></td></tr><tr><td></td><td colspan=3>Total Emissions in MT of C02: </td><td><b>'.$tripEmissionTotal[0]->totalEmissions.'</b></td>';
                    echo '<tr></tr><tr></tr>';
                    echo '<tr>
                        <td></td>
                        <td colspan=10>In a span of '.date_diff(new DateTime($tripData[0]->tripDate), new DateTime($tripData[count($tripData) - 1]->tripDate))->format('%m month/s and %d day/s').'</b>, the average emission per trip is<b> '.round(($tripEmissionTotal[0]->totalEmissions/count($tripData)), 4).'</b> MT of C02.';
                        
                }elseif(isset($vehicleData)){
                    echo '</tr><tr>
                        <td></td>
                        <td colspan=2>Total Distance Covered:</td><td><b>'.$vehicleDataKMTotal[0]->totalKM.' KM</b></td><td></td><td colspan=2>Total Emissions:</td><td><b>'.$vehicleDataEmissionTotal[0]->totalEmissions.' MT of </b>C02</td></tr><tr></tr>
                        
                        </tr><tr><td></td>
                        <td colspan=2>Highest Vehicle Contributor:</td><td><b>'.$carContributions[0]->modelName.'</b></td><td><b>'.$carContributions[0]->emission.' MT C02</b></td><td></td>
                        <td colspan=2>Highest Car Brand Contributor:</td><td><b>'.$carBrandContributions[0]->carBrandName.'</b></td><td><b>'.$carBrandContributions[0]->emission.' MT C02</b></td></tr>
                        <tr><td></td>
                        <td colspan=2>Highest Car Type Contributor:</td><td><b>'.$carTypeContributions[0]->carTypeName.'</b></td><td><b>'.$carTypeContributions[0]->emission.' MT C02</b></td><td></td>
                        <td colspan=2>Highest Fuel Type Contributor:</td><td><b>'.$fuelContributions[0]->fuelTypeName.'</b></td><td><b>'.$fuelContributions[0]->emission.' MT C02</b></td></tr>';
                    echo '<tr></tr><tr></tr>
                        <td></td>
                        <td colspan=10></td>';
                }elseif(isset($regressionLine)){
                    echo '</tr><tr>
                        <td colspan=2></td>
                        <td colspan=3>Expected Emission for Next month:</td><td><b>'.$forecastData[count($forecastData) - 1]->forecastPoint.'</b></td></tr><tr><td colspan=2></td><td colspan=7>You need to plant at least <b> '.round((($forecastData[count($forecastData) - 1]->forecastPoint)/ 0.001) / (22)).' Trees</b> to mitigate or cancel out next month\'s expected emissions.</td></tr>';
                }
                echo '</tr>
                        <tr>
                        <td colspan=8></td>
                        <td colspan=2>Prepared By: </td>
                        <td colspan=2><b><u>'.$userType = Auth::user()->accountName.'<u><b></td>
                        </tr>
                        <tr>
                        <td colspan=8></td>
                        <td colspan=2>Date/Time Prepared: </td>
                        <td colspan=2><b><u>'.(new DateTime())->add(new DateInterval('PT8H'))->format('Y-m-d H:i:s').'<u><b></td>
                        </tr>
                        <tr></tr><tr></tr>
                        <tr>
                        <td></td>
                        <td colspan=10 style="text-align: center"><b><u>**END OF REPORT**<u><b></td>
                        </tr>';
            ?>
        </tr>
        </table>
    </div>
    <div id="chartdiv2" style="background-color: #FFFFFF;"></div>
    </div>
    <!-- angular -->
    <script>
        var app = angular
            .module("myapp", [])
            .controller("MyController", function($scope) {
                $scope.datePreset = false;

                $scope.togglePreset = function() {
                    $scope.datePreset = !$scope.datePreset
                };
            });
    </script>
    <!-- HTML2canvas -->
    <script>
        $(document).ready(function() {
           
            $('#cmd').click(function () {
                console.log('fire');
                $("svg").attr("id", "svg") //Assign ID to SCG tag

                // without converting the svg to png
                html2canvas(chartdiv2).then(function(can) {
                    //dirty.appendChild(can);
                });

                // first convert your svg to png
                
                  exportInlineSVG(svg, function(data, canvas) {
                    svg.parentNode.replaceChild(canvas, svg);
                    // then call html2canvas
                    
                     html2canvas(chartdiv2).then(function(can) {
                        can.id = 'canvas';
                        document.getElementById('forChart').appendChild(can);
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
    <!-- canvas save -->
    <?php
    {
    echo '
    <script>
        $(function() {
          $("#btnSave2").click(function() {
            html2canvas(document.getElementById(\'printDiv\')).then(function(canvas) {
                saveAs(canvas.toDataURL(), ';
    echo "'".$data['reportName']."report-".(new DateTime())->add(new DateInterval('PT8H'))->format('Y-m-d H:i:s').".png'";
        echo ')
              }
            );
          });

          function saveAs(uri, filename) {
            var link = document.createElement(\'a\');
            if (typeof link.download === \'string\') {
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
    </script>';
    }
    ?>
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
			AmCharts.makeChart("chartdiv2",
				{
					"type": "serial",
					"categoryField": "monthYear",
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
							"id": "",
							"title": "Forecast",
							"type": "column",
							"valueField": "forecastPoint"
						}
					],
					"guides": [],
					"valueAxes": [
						{
							"id": "ValueAxis-1",
							"title": "Forcasted Value"
						}
					],
					"allLabels": [],
					"balloon": {},
					"titles": [
						{
							"id": "Forecast",
							"size": 15
						}
					],
					"dataProvider": '.json_encode($forecastData).'
				}
			);
		</script>
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
</body>

</html>