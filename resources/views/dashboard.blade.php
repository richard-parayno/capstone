<?php
    //initialization
    {
    $filter = false;
    $filterPost = false;
    $emptySet = true;
    $dataSet = false;
        
    $fuelTypes = DB::table('fueltype_ref')->get();
    $carTypes = DB::table('cartype_ref')->get();
    $carBrands = DB::table('carbrand_ref')->get();
    $userType = Auth::user()->userTypeID;
    if($userType > 2){
        $institutionID = Auth::user()->institutionID;
        $filter = true;
    }

    if(isset($data)){
        if($data['filter']=='true'){
            $filterPost = true;
        }
    }
    }
    //filtering
    {
    if($filter || $filterPost){
        $filterMessage = "";
        $rawDB = "";
        $add = false;
        if($filterPost){
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
        }
        if(isset($institutionID)){
            if($add){
                $rawDB .= " AND ";
                $filterMessage .= " by " . $data['carTypeID'];
            }
            $rawDB .= "institutions.institutionID = ".$institutionID;
        }
    }
    }
    //table fetch
    {
    //Filtered queries
    if($filter || $filterPost){
        $column = "SUM(trips.emissions) as percentage";
        
        $institutionEmissions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('institutions.institutionName', DB::raw($column))
            ->whereRaw($rawDB)
            ->orderByRaw('2 DESC')
            ->groupBy(DB::raw('1'))
            ->get();
        
        $minQ = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('trips.tripDate')
            ->whereRaw($rawDB)
            ->orderByRaw('1 ASC')
            ->limit('1')
            ->get();
        
        $min = $minQ[0]->tripDate;
        
        $maxQ = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('trips.tripDate')
            ->whereRaw($rawDB)
            ->orderByRaw('1 DESC')
            ->limit('1')
            ->get();

        $max = $maxQ[0]->tripDate;
        
        $columnTable = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('sum(trips.emissions) as emissions'))
            ->whereRaw($rawDB)
            ->get();
        
        if($columnTable[0]->emissions!=null)
        $column = "SUM(trips.emissions) as percentage";
        
        $institutionEmissions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('institutions.institutionName', DB::raw($column))
            ->whereRaw($rawDB)
            ->orderByRaw('2 DESC')
            ->groupBy(DB::raw('1'))
            ->get();
            
        //get most vehicle type contributions (emission total)
        $vehicleContributions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('cartype_ref.carTypeName', DB::raw($column))
            ->whereRaw($rawDB)
            ->groupBy('carTypeName')
            ->orderByRaw('2 DESC')
            ->get();

        $deptContributions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
            ->whereRaw($rawDB)
            ->groupBy('deptsperinstitution.deptID')
            ->orderByRaw('2 DESC')
            ->get();

        $fuelContributions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('fuelType_ref.fuelTypeName', DB::raw($column))
            ->whereRaw($rawDB)
                ->groupBy('fuelType_ref.fuelTypeName')
            ->orderByRaw('2 DESC')
            ->get();


        //get most car type contributions (emission total)
        $carContributions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
            ->whereRaw($rawDB)
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 DESC')
            ->get();

         //get most car brand type contributions (emission total)
        $carBrandContributions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('carbrand_ref.carBrandName', DB::raw($column))
            ->whereRaw($rawDB)
            ->groupBy('carbrand_ref.carbrandName')
            ->orderByRaw('2 DESC')
            ->get();

        $columnTable = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('count(trips.emissions) as tripCount'))
            ->whereRaw($rawDB)
            ->get();
            
        $column = "count(trips.emissions) as percentage";    

         $institutionTripNumber = DB::table('trips')
             ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
             ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('institutions.institutionName', DB::raw($column))
            ->whereRaw($rawDB)
            ->orderByRaw('2 DESC')
            ->groupBy(DB::raw('1'))
            ->get();

        //trip number
        //get most car brand type contributions (trip number)
         $carBrandTripNumber = DB::table('trips')
             ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
             ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('carbrand_ref.carbrandName', DB::raw($column))
            ->whereRaw($rawDB)
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 DESC')
            ->get();

        //get most car contributions (trip number)
        $carTripNumber = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
            ->whereRaw($rawDB)
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 desc')
            ->get();

        //get most vehicle type contributions (trip number)
        $vehicleTripNumber = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('cartype_ref.carTypeName', DB::raw($column))
            ->whereRaw($rawDB)
            ->groupBy('carTypeName')
            ->orderByRaw('2 DESC')
            ->get();

        //get most department type contributions (trip number)
        $deptTripNumber = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
            ->whereRaw($rawDB)
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 DESC')
            ->get();

        $totalTreesPlanted = DB::table('institutionbatchplant')
            ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
            ->groupBy(DB::raw('1'))
            ->get();

        $totalEmissions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('SUM(emissions) as totalEmissions'))
            ->whereRaw($rawDB)
            ->get();
            
        $monthCount = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('EXTRACT(YEAR_MONTH FROM tripDate) as monthYear'))
            ->whereRaw($rawDB)
            ->groupby(DB::raw('1'))
            ->get();
            
        $tripCountTotal = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select(DB::raw('count(emissions) as totalCount'))
            ->whereRaw($rawDB)
            ->get();
        if(isset($institutionID)){
            $treeRaw = "institutionID = ".$institutionID;
        
            $seqTotal = DB::table('institutionbatchplant')
                ->select(DB::raw('sum(numOfPlantedTrees) as totalSeq'))
                ->whereRaw($treeRaw)
                ->get();

            $totalTreesPlanted = DB::table('institutionbatchplant')
                ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
                ->whereRaw($treeRaw)
                ->groupBy(DB::raw('1'))
                ->get();
        }
        else{
            $seqTotal = DB::table('institutionbatchplant')
                ->select(DB::raw('sum(numOfPlantedTrees) as totalSeq'))
                ->get();

            $totalTreesPlanted = DB::table('institutionbatchplant')
                ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
                ->groupBy(DB::raw('1'))
                ->get();
        }
        
            
        $thresholds = DB::table('thresholds_ref')
            ->select(DB::raw('*'))
            ->get();

        
        $emissionData = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('trips.tripDate', 'trips.tripTime', 'deptsperinstitution.deptName' , 'trips.plateNumber', 
                    'trips.kilometerReading', 'trips.remarks', 'trips.emissions', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'vehicles_mv.modelName', 'vehicles_mv.active') 
            ->whereRaw($rawDB)
            ->orderBy('trips.tripDate', 'asc')
            ->get();
        
        if(count($emissionData)==0){
            $start = 0;
        }else{
            $start = $totalTreesPlanted->get(0)->totalPlanted * 22 * 0.001;
        }
        
            $green = $thresholds->get(0)->value;
            $orange = $thresholds->get(1)->value;
            $red = $thresholds->get(2)->value;
            $yellow = $thresholds->get(3)->value;

            $tillOrange = ($red * $totalEmissions->get(0)->totalEmissions) - $start;
            $tillYellow = ($orange * $totalEmissions->get(0)->totalEmissions) - $start;
            $tillGreen = ($yellow * $totalEmissions->get(0)->totalEmissions) - $start;
    }
    //no filter
    else{
        $column = "SUM(trips.emissions) as percentage";
        
        $institutionEmissions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->select('institutions.institutionName', DB::raw($column))
            ->orderByRaw('2 DESC')
            ->groupBy(DB::raw('1'))
            ->get();
        
        $minQ = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('trips.tripDate')
            ->orderByRaw('1 ASC')
            ->limit('1')
            ->get();
        
        $min = $minQ[0]->tripDate;
        
        $maxQ = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
            ->select('trips.tripDate')
            ->orderByRaw('1 DESC')
            ->limit('1')
            ->get();

        $max = $maxQ[0]->tripDate;
        
        $columnTable = DB::table('trips')
            ->select(DB::raw('sum(trips.emissions) as emissions'))
            ->get();
        
        //$column = "round((SUM(trips.emissions) * 100 / ".$columnTable[0]->emissions."),2) as percentage";
        $column = "SUM(trips.emissions) as percentage";
        
        $institutionEmissions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->select('institutions.institutionName', DB::raw($column))
            ->orderByRaw('2 DESC')
            ->groupBy(DB::raw('1'))
            ->get();
        
        //get most vehicle type contributions (emission total)
        $vehicleContributions = DB::table('trips')
            ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
            ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
            ->select('cartype_ref.carTypeName', DB::raw($column))
            ->groupBy('carTypeName')
            ->orderByRaw('2 DESC')
            ->get();

        $deptContributions = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
            ->groupBy('deptsperinstitution.deptID')
            ->orderByRaw('2 DESC')
            ->get();

        $fuelContributions = DB::table('trips')
            ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
            ->join('fuelType_ref', 'vehicles_mv.fuelTypeID', '=', 'fuelType_ref.fuelTypeID')
            ->select('fuelType_ref.fuelTypeName', DB::raw($column))
            ->groupBy('fuelType_ref.fuelTypeName')
            ->orderByRaw('2 DESC')
            ->get();


        //get most car type contributions (emission total)
        $carContributions = DB::table('trips')
            ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
            ->join('institutions', 'institutions.institutionID','=', 'vehicles_mv.institutionID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 DESC')
            ->get();

         //get most car brand type contributions (emission total)
        $carBrandContributions = DB::table('trips')
            ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
            ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
            ->select('carbrand_ref.carBrandName', DB::raw($column))
            ->groupBy('carbrand_ref.carbrandName')
            ->orderByRaw('2 DESC')
            ->get();

        $columnTable = DB::table('trips')
            ->select(DB::raw('count(trips.emissions) as tripCount'))
            ->get();

        $column = "count(trips.emissions) as percentage";    

        $institutionTripNumber = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->select('institutions.institutionName', DB::raw($column))
            ->orderByRaw('2 DESC')
            ->groupBy(DB::raw('1'))
            ->get();

        //trip number
        //get most car brand type contributions (trip number)
        $carBrandTripNumber = DB::table('trips')
            ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
            ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
            ->select('carbrand_ref.carbrandName', DB::raw($column))
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 DESC')
            ->get();

        //get most car contributions (trip number)
        $carTripNumber = DB::table('trips')
            ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 desc')
            ->get();

        //get most vehicle type contributions (trip number)
        $vehicleTripNumber = DB::table('trips')
            ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
            ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
            ->select('cartype_ref.carTypeName', DB::raw($column))
            ->groupBy('carTypeName')
            ->orderByRaw('2 DESC')
            ->get();

        //get most department type contributions (trip number)
        $deptTripNumber = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
            ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
            ->groupBy(DB::raw('1'))
            ->orderByRaw('2 DESC')
            ->get();

        $totalTreesPlanted = DB::table('institutionbatchplant')
            ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
            ->groupBy(DB::raw('1'))
            ->get();

        $tripCountTotal = DB::table('trips')
            ->select(DB::raw('count(emissions) as totalCount'))
            ->get();

        $seqTotal = DB::table('institutionbatchplant')
            ->select(DB::raw('sum(numOfPlantedTrees) as totalSeq'))
            ->get();

        $totalEmissions = DB::table('trips')
            ->select(DB::raw('SUM(emissions) as totalEmissions'))
            ->get();

        $monthCount = DB::table('trips')
            ->select(DB::raw('EXTRACT(YEAR_MONTH FROM tripDate) as monthYear'))
            ->groupby(DB::raw('1'))
            ->get();

        $thresholds = DB::table('thresholds_ref')
            ->select(DB::raw('*'))
            ->get();

        $start = $totalTreesPlanted->get(0)->totalPlanted * 22 * 0.001;

        $green = $thresholds->get(0)->value;
        $orange = $thresholds->get(1)->value;
        $red = $thresholds->get(2)->value;
        $yellow = $thresholds->get(3)->value;

        $tillOrange = ($red * $totalEmissions->get(0)->totalEmissions) - $start;
        $tillYellow = ($orange * $totalEmissions->get(0)->totalEmissions) - $start;
        $tillGreen = ($yellow * $totalEmissions->get(0)->totalEmissions) - $start;

        $emissionData = DB::table('trips')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->select('trips.tripDate', 'trips.tripTime', 'deptsperinstitution.deptName' , 'trips.plateNumber', 
                    'trips.kilometerReading', 'trips.remarks', 'trips.emissions', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'vehicles_mv.modelName', 'vehicles_mv.active') 
            ->orderBy('trips.tripDate', 'asc')
            ->get();
        }
    }
    //empty set checker
    {
        if(count($emissionData)>0){
            $emptySet = false;
        }
    }

    //debuggers
    {
        //dd($notifications);
        //dd($rawDB);
        //dd($min);
    }
    
?>
    @extends('layouts.main') 
    @section('styling')
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

        #institutioninstitutionPieChart {
            width: 100%;
            height: 500px;
        }

        #deptinstitutionPieChart {
            width: 100%;
            height: 500px;
        }
    </style>
    @endsection 
    @section('content')
    <div ng-app="myapp">
        <div ng-controller="MyController">
            <div ng-hide="<?php echo $emptySet; ?>">
                <form method="post" action="{{ route('dashboard-process') }}" <?php if($userType <=2 ){ echo "ng-init=\"nonschool=true;\""; } ?>> {{ csrf_field() }}
                <br>
                    <div class="row">
                        <div class="four columns" ng-hide="<?php echo $userType > 2 ?>">
                            <select class="u-full-width" name="institutionID" id="institutionID" style="color: black;">
                               <option value="">All Institutions</option>
                                @foreach($institutions as $institution)
                                  <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="two columns offset-by-one">
                            <a class="button" ng-click="toggleFilter();" style="width: 100%"><?php echo "{{plusMinus}}"; ?> Filters</a>
                        </div>
                        <div class="one column offset-by-four">
                            <input class="button-primary" type="submit">
                        </div>
                    </div>
                    <div class="row" ng-show="showFilter">
                        <div class="four columns" ng-hide="datePreset">
                            <div class="six columns">
                                <p style="text-align: left;" ng-hide="datePreset">From </p>
                                <input class="u-full-width" type="date" name="fromDate" id="fromDate" max="<?php echo "{{max}}"; ?>" ng-model="min" ng-hide="datePreset">
                            </div>
                            <div class="six columns">
                            <p style="text-align: left;"  ng-hide="datePreset">To: </p>
                            <input class="u-full-width" type="date" name="toDate" id="toDate" ng-model="max" min="<?php echo "{{min}}"; ?>" ng-hide="datePreset">
                        </div>
                        </div>
                        <div class="four columns" ng-show="datePreset">
                            <select class="u-full-width" name="datePreset" id="">
                                <option value="0" selected>Select Date Preset</option>
                                <option value="1">2 Weeks</option>
                                <option value="2">Last Month</option>
                                <option value="3">Last 3 Months</option>
                                <option value="4">Last 6 Months</option>
                                <option value="5">Last 1 Year</option>
                            </select>
                        </div>
                        <div class="two columns">
                            <a class="button" ng-click="togglePreset(); valueNull(); " style="width: 100%; text-align: left;">Date Filter</a>
                        </div>
                        <div class="two columns">
                            <select class="u-full-width" name="carTypeID" id="carTypeID" style="color: black; width: 100%">
                               <option value="">All Car Types</option>
                                @foreach($carTypes as $carType)
                                  <option value="{{ $carType->carTypeID }}">{{ $carType->carTypeName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="two columns">
                            <select class="u-full-width" name="fuelTypeID" id="fuelTypeID" style="color: black; width: 100%">
                                 <option value="">All Fuel Types</option>
                                  @foreach($fuelTypes as $fuelType)
                                    <option value="{{ $fuelType->fuelTypeID }}">{{ $fuelType->fuelTypeName }}</option>
                                  @endforeach
                            </select>
                        </div>
                        <div class="two columns">
                            <select class="u-full-width" name="carBrandID" id="carbrandID" style="color: black; width: 100%">
                                 <option value="">All Car Brands</option>
                                  @foreach($carBrands as $carBrand)
                                    <option value="{{ $carBrand->carBrandID }}">{{ $carBrand->carBrandName }}</option>
                                  @endforeach
                            </select>
                        </div>
                    </div>
                <input type="hidden" name="filter" value="<?php echo "{{showFilter}}"; ?>">
                </form>
                <div class="row">
                    <div class="four columns offset-by-one"><h5>Total Emissions: &nbsp;<strong><?php echo round($totalEmissions[0]->totalEmissions, 4);?> MT</strong></h5></div>
                    <div class="three columns"><h5>Total Trips: &nbsp;<strong><?php echo $tripCountTotal[0]->totalCount;?></strong></h5></div>
                    <div class="four columns"><h5>Total Sequestration: <strong><?php echo ($seqTotal[0]->totalSeq)*22*0.001;?> MT</strong></h5></div>
                </div>
                <div class="row" ng-init="showGenChartDiv=<?php echo !$emptySet;?>">
                    <div class="six columns" style="text-align: center;" ng-show="showGenChartDiv">
                        <?php 

                        if(!isset($institutionID)) echo '<div id="institutionPieChart" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>';
                        else echo '<div id="chartdiv2" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>';
                        ?>
                    </div>
                    <div class="six columns" style="text-align: center;">
                        <h5>Emissions to Sequestration Ratio</h5>    
                        <div>
                            <canvas class="u-full-width" id="foo"></canvas>
                            </div>
                            <?php
                                //add change time period
                                //add change threshold values
                                if($tillOrange > 0 ){
                                    $treesLeft = ($tillOrange / 0.001) / 22; //number of trees to catch up in a year
                                    echo '<br><p>You need to plant at least ' . round($treesLeft) . " trees to reach the Orange Zone (" . $red * 100 . '%)</p>';
                                }
                                if($tillYellow > 0 ){
                                    $treesLeft = ($tillYellow / 0.001) / 22; //number of trees to catch up in a year
                                    echo '<br><p>You need to plant at least ' . round($treesLeft) . " trees to reach the Yellow Zone (" . $orange * 100 . '%)</p>';
                                }
                                if($tillGreen > 0 ){
                                    $treesLeft = ($tillGreen / 0.001) / 22; //number of trees to catch up in a year
                                    echo '<br><p>You need to plant at least ' . round($treesLeft) . " trees to reach the Green Zone (" . $yellow * 100 . '%)</p>';
                                }        
                            ?>
                        </div>
                    </div>
                <div class="row">
                    <div class="four columns" style="text-align: center;"><div id="carTypePieChart" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div></div>
                    <div class="four columns" style="text-align: center;"><div id="fuelTypePieChart" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div></div>
                    <div class="four columns" style="text-align: center;"><div id="carBrandPieChart" style="min-width: 100%; height: 400px; max-width: 100%; margin: 0 auto"></div></div>
                </div>
            </div>
            <div ng-show="<?php echo $emptySet; ?>"><h4><br><div class="row" style="text-align: center"><?php echo "No Data Available"?><br><a href="{{ route('dashboard') }}" class="button button-primary">Go Back</a></div></h4></div>
        </div>
    </div>

    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/pie.js"></script>
    <script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/chalk.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

    <!--angular js script-->
    <script>
        var app = angular
            .module("myapp", [])
            .controller("MyController", function($scope) {
                $scope.dboardType = ['Emissions', 'Number of Trips'];
                $scope.nonschool = false;
                $scope.showFilter = false;
                $scope.datePreset = false;
                $scope.plusMinus = "+";

                $scope.toggleFilter = function() {
                    $scope.showFilter = !$scope.showFilter
                    if($scope.showFilter){
                        $scope.plusMinus = "-";
                    }else $scope.plusMinus = "+";
                };
                
                $scope.togglePreset = function() {
                    $scope.datePreset = !$scope.datePreset
                };
            });
    </script>
    <!--angular js script-->

    <?php
    
    if(!isset($institutionID)){

    echo "<script type=\"text/javascript\">
			// Build the chart
            Highcharts.chart('institutionPieChart', {
              chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
              },
              title: {
                text: 'Institution Emission Total'
              },
              tooltip: {
                pointFormat: '{series.name}: <b>{point.y:.4f}MT</b>'
              },
              plotOptions: {
                pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                    enabled: false
                  },
                  showInLegend: true
                }
              },
              series: [{
                name: 'Institutions',
                colorByPoint: true,";
                  
                        echo "data: [";
                        for($x = 0; $x < count($institutionEmissions); $x++){
                            echo '{
                                name: "'.$institutionEmissions[$x]->institutionName.'",
                                y: '.$institutionEmissions[$x]->percentage;
                            if($x==0){
                                echo ',
                                sliced: true,
                                    selected: true';
                            }
                                echo '
                                }';
                                if($x!=count($institutionEmissions)-1){
                                    echo ',';
                                }
                            }
                        echo "]
                       ";
              echo "}]
            });
		</script>";
    }
		?>
		
    <script type="text/javascript">
        // Build the chart
        Highcharts.chart('carTypePieChart', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Car Type Emissions'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.4f} MT</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Emission',
            colorByPoint: true,
            <?php
              if(!$emptySet){
                    echo "data: [";
                    for($x = 0; $x < count($vehicleContributions); $x++){
                        echo '{
                            name: "'.$vehicleContributions[$x]->carTypeName.'",
                            y: '.$vehicleContributions[$x]->percentage;
                        if($x==0){
                            echo ',
                            sliced: true,
                                selected: true';
                        }
                            echo '
                            }';
                            if($x!=count($vehicleContributions)-1){
                                echo ',';
                            }
                        }
                    echo "]
                   ";
              }
           ?>
          }]
        });
    </script>
    <script type="text/javascript">
        // Build the chart
        Highcharts.chart('fuelTypePieChart', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Fuel Type Emissions'
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.4f} MT</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Emissions',
            colorByPoint: true,
            <?php
              if(!$emptySet){
                    echo "data: [";
                    for($x = 0; $x < count($fuelContributions); $x++){
                        echo '{
                            name: "'.$fuelContributions[$x]->fuelTypeName.'",
                            y: '.$fuelContributions[$x]->percentage;
                        if($x==0){
                            echo ',
                            sliced: true,
                                selected: true';
                        }
                            echo '
                            }';
                            if($x!=count($fuelContributions)-1){
                                echo ',';
                            }
                        }
                    echo "]
                   ";
              }
           ?>
          }]
        });
    </script>
    <script type="text/javascript">
        // Build the chart
        Highcharts.chart('carBrandPieChart', {
          chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
          },
          title: {
            text: 'Car Brand Emissions '
          },
          tooltip: {
            pointFormat: '{series.name}: <b>{point.y:.4f} MT</b>'
          },
          plotOptions: {
            pie: {
              allowPointSelect: true,
              cursor: 'pointer',
              dataLabels: {
                enabled: false
              },
              showInLegend: true
            }
          },
          series: [{
            name: 'Emissions',
            colorByPoint: true,
               <?php
                if(!$emptySet){
                    echo "data: [";
                    for($x = 0; $x < count($carBrandContributions); $x++){
                        echo '{
                            name: "'.$carBrandContributions[$x]->carBrandName.'",
                            y: '.$carBrandContributions[$x]->percentage;
                        if($x==0){
                            echo ',
                            sliced: true,
                                selected: true';
                        }
                            echo '
                            }';
                            if($x!=count($carBrandContributions)-1){
                                echo ',';
                            }
                        }
                    echo "]
                   ";
                }
           ?>
          }]
        });
    </script>
    <?php
    {
     echo '<script type="text/javascript">
			AmCharts.makeChart("chartdiv2",
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
							"valueField": "emissions"
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
					"dataProvider":'.json_encode($emissionData);
            echo '
				}
			);
		</script>';
    }
    ?>
    <script type="application/javascript">
    <?php
        {
        echo "var start = " . $start . ';
        ';
        if( $start > ($totalEmissions->get(0)->totalEmissions) * ($thresholds->get(0)->value)){
            echo 'maxVal = ' . $start . ';
            ';
        }else echo 'maxVal = ' . $totalEmissions->get(0)->totalEmissions * ($thresholds->get(0)->value). ';
        ';
        }
        ?>
    var opts = {
        angle: 0.02,
        lineWidth: 0.2,
        radiusScale: 1,
        pointer: {
            length: 0.51,
            strokeWidth: 0.018,
            color: '#000000'
        },
        limitMax: false, // If false, max value increases automatically if value > maxValue
        limitMin: false, // If true, the min value of the gauge will be fixed
        generateGradient: true,
        highDpiSupport: true, // High resolution support
        staticZones: [{
                strokeStyle: "#F03E3E",
                min: 0,
                max: <?php echo $red * ($totalEmissions->get(0)->totalEmissions); ?>
            },
            {
                strokeStyle: "#f29924",
                min: <?php echo $red * ($totalEmissions->get(0)->totalEmissions); ?>,
                max: <?php echo $orange * ($totalEmissions->get(0)->totalEmissions); ?>
            },
            {
                strokeStyle: "#FFDD00",
                min: <?php echo $orange * ($totalEmissions->get(0)->totalEmissions); ?>,
                max: <?php echo $yellow * ($totalEmissions->get(0)->totalEmissions); ?>
            },
            {
                strokeStyle: "#30B32D",
                min: <?php echo $yellow * ($totalEmissions->get(0)->totalEmissions); ?>,
                max: maxVal
            },
        ],
        staticLabels: {
            font: "10px sans-serif", // Specifies font
            labels: [<?php echo $red * ($totalEmissions->get(0)->totalEmissions); ?>, <?php echo $orange * ($totalEmissions->get(0)->totalEmissions); ?>, <?php echo $yellow * ($totalEmissions->get(0)->totalEmissions); ?>, maxVal, start], // Print labels at these values
            color: "#000000", // Optional: Label text color
            fractionDigits: 2 // Optional: Numerical precision. 0=round off.
        },
        // renderTicks is Optional
        renderTicks: {
            divisions: 12,
            divWidth: 1.3,
            divLength: 0.56,
            divColor: '#333333',
            subDivisions: 4,
            subLength: 0.5,
            subWidth: 0.6,
            subColor: '#666666'
        }

    };
    var target = document.getElementById('foo'); // your canvas element
    var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
    gauge.maxValue = maxVal; // set max gauge value
    gauge.setMinValue(0); // Prefer setter over gauge.minValue = 0
    gauge.animationSpeed = 32; // set animation speed (32 is default value)
    gauge.set(start); // set actual value
    </script>

    @endsection 