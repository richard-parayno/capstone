<?php
    $schoolSort = false;
    $emptySet = false;
    $userType = Auth::user()->userTypeID;  
    $add = false;
    $filterMessage = "Showing Data from ";
    if($userType > 2){
        $userSchool = Auth::user()->institutionID;
        $schoolSort = true; 
        $rawDB="trips.institutionID=".$userSchool;
    }
    if(isset($data)){
        $rawDB = "";
        if($data['institutionID'] != null){
                $userSchool = $data['institutionID'];
                $schoolSort = true;
                $add = true;
                $filterMessage .= $userSchool;
                $rawDB.="trips.institutionID=".$userSchool;
        }if(!isset($data['datePreset'])){   
            if($data['fromDate'] != null && $data['toDate'] != null){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " dated ";
                }
                $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "' AND trips.tripDate >= '" . $data['fromDate'] . "'";
                $filterMessage .= $data['toDate']. " to ". $data['fromDate'];
            }elseif(!isset($data['fromDate']) && $data['toDate'] != null){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " dated ";
                }
                $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "'";
                $filterMessage .= "before ".$data['toDate'];
            }elseif($data['fromDate'] != null && !isset($data['toDate'])){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " dated  ";
                }
                $rawDB .= "trips.tripDate >= '" . $data['fromDate'] . "'";
                $filterMessage .= "after ".$data['fromDate'];
            }
        }else{
            switch($data['datePreset']){
                case "1": {
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 2 WEEK";
                    $filterMessage .= "from 2 weeks ago";
                    break;
                }
                case "2": {
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 MONTH";
                    $filterMessage .= "from 1 month ago";
                    break;
                } 
                case "3": {
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 3 MONTH";
                    $filterMessage .= "from 3 month ago";
                    break;
                }
                case "4": {
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 6 MONTH";
                    $filterMessage .= "from 6 month ago";
                    break;
                }
                case "5": {
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 YEAR";
                    $filterMessage .= "from 1 year ago";
                    break;
                }
                default: $rawDB .= "";
            }
        }
    }
    if($schoolSort){

    //include institution
    //get most department type contributions (emission total)
    if(isset($data) && !isset($data['ínstitutionID'])){
        $rawDB .= 'AND trips.institutionID = '.$userSchool;
    }
    $columnTable = DB::table('trips')
        ->select(DB::raw('sum(trips.emissions) as emissions'))
        ->whereRaw($rawDB)
        ->get();
    if(!$columnTable->isEmpty()){
        $emptySet = false;
        $column = "round((SUM(trips.emissions) * 100 / ".$columnTable[0]->emissions."),2) as percentage";
        
    //get most vehicle type contributions (emission total)
    $vehicleContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw($column))
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy('carTypeName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
    $deptContributions = DB::table('trips')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
        ->select('deptsperinstitution.deptName', DB::raw($column))
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy('deptsperinstitution.deptID')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();

    //get most car type contributions (emission total)
    $carContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'institutions.institutionID','=', 'vehicles_mv.institutionID')
        ->select('vehicles_mv.modelName', DB::raw($column))
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy('vehicles_mv.modelName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
     //get most car brand type contributions (emission total)
    $carBrandContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carBrandName', DB::raw($column))
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy('carbrand_ref.carbrandName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();

    $columnTable = DB::table('trips')
        ->select(DB::raw('count(trips.emissions) as tripCount'))
        ->whereRaw($rawDB)
        ->get();
    $column = "count(trips.emissions) as percentage";   
    
    $institutionTripNumber = DB::table('trips')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select('institutions.institutionName', DB::raw($column))
        ->orderByRaw('2 DESC')
        ->groupBy(DB::raw('1'))
        ->limit(2)
        ->get();
        
    //trip number
    //get most car brand type contributions (trip number)
     $carBrandTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carbrandName', DB::raw($column))
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
        //get most car contributions (trip number)
    $carTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'institutions.institutionID','=', 'vehicles_mv.institutionID')
        ->select('vehicles_mv.modelName', DB::raw($column))  
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy('modelName')
        ->orderByRaw('2 desc')
        ->limit(2)
        ->get();
        
    //get most vehicle type contributions (trip number)
    $vehicleTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw($column))
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy('carTypeName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
    
    //get most department type contributions (trip number)
    $deptTripNumber = DB::table('trips')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
        ->select('deptsperinstitution.deptName', DB::raw($column))
        ->whereRaw('trips.institutionID = '.$userSchool)
        ->groupBy('deptsperinstitution.deptName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
    }else {
        $filterMessage = "Filter returned an empty set.";
        $emptySet = true;
    }
}
    else{
        
    if(!isset($data)){    
        $columnTable = DB::table('trips')
            ->select(DB::raw('sum(trips.emissions) as emissions'))
            ->get();
        if(!$columnTable->isEmpty()){
        $emptySet = false;     
        $column = "round((SUM(trips.emissions) * 100 / ".$columnTable[0]->emissions."),2) as percentage";
        $institutionEmissions = DB::table('trips')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select('institutions.institutionName', DB::raw($column))
        ->orderByRaw('2 DESC')
        ->groupBy(DB::raw('1'))
        ->limit(2)
        ->get();
        
    //get most vehicle type contributions (emission total)
    $vehicleContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw($column))
        ->groupBy('carTypeName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
    $deptContributions = DB::table('trips')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
         ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
        ->groupBy('deptsperinstitution.deptID')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();

    //get most car type contributions (emission total)
    $carContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'institutions.institutionID','=', 'vehicles_mv.institutionID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
     //get most car brand type contributions (emission total)
    $carBrandContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carBrandName', DB::raw($column))
        ->groupBy('carbrand_ref.carbrandName')
        ->orderByRaw('2 DESC')
        ->limit(2)
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
        ->limit(2)
        ->get();
        
    //trip number
    //get most car brand type contributions (trip number)
     $carBrandTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carbrandName', DB::raw($column))
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
    //get most car contributions (trip number)
    $carTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 desc')
        ->limit(2)
        ->get();
        
    //get most vehicle type contributions (trip number)
    $vehicleTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw($column))
        ->groupBy('carTypeName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
    
    //get most department type contributions (trip number)
    $deptTripNumber = DB::table('trips')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
    }
        else {
        $filterMessage = "Filter returned an empty set.";
        $emptySet = true;
    }    
    
        }
    else{
        $columnTable = DB::table('trips')
            ->select(DB::raw('sum(trips.emissions) as emissions'))
            ->whereRaw($rawDB)
            ->get();
        if(!$columnTable->isEmpty()){
        $column = "round((SUM(trips.emissions) * 100 / ".$columnTable[0]->emissions."),2) as percentage";
        
        $institutionEmissions = DB::table('trips')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select('institutions.institutionName', DB::raw($column))
        ->whereRaw($rawDB)
            ->orderByRaw('2 DESC')
        ->groupBy(DB::raw('1'))
        ->limit(2)
        ->get();
        
    //get most vehicle type contributions (emission total)
    $vehicleContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw($column))
        ->whereRaw($rawDB)
        ->groupBy('carTypeName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
    $deptContributions = DB::table('trips')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
         ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
        ->whereRaw($rawDB)
        ->groupBy('deptsperinstitution.deptID')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();

    //get most car type contributions (emission total)
    $carContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'institutions.institutionID','=', 'vehicles_mv.institutionID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
        ->whereRaw($rawDB)
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
     //get most car brand type contributions (emission total)
    $carBrandContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carBrandName', DB::raw($column))
        ->whereRaw($rawDB)
        ->groupBy('carbrand_ref.carbrandName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();

    $columnTable = DB::table('trips')
        ->select(DB::raw('count(trips.emissions) as tripCount'))
        ->whereRaw($rawDB)
        ->get();
    $column = "count(trips.emissions) as percentage";    
        
     $institutionTripNumber = DB::table('trips')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select('institutions.institutionName', DB::raw($column))
        ->whereRaw($rawDB)
         ->orderByRaw('2 DESC')
        ->groupBy(DB::raw('1'))
        ->limit(2)
        ->get();
        
    //trip number
    //get most car brand type contributions (trip number)
     $carBrandTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carbrandName', DB::raw($column))
        ->whereRaw($rawDB)
         ->groupBy(DB::raw('1'))
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
    //get most car contributions (trip number)
    $carTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", vehicles_mv.modelName) as modelName'), DB::raw($column))  
        ->whereRaw($rawDB)
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 desc')
        ->limit(2)
        ->get();
        
    //get most vehicle type contributions (trip number)
    $vehicleTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw($column))
        ->whereRaw($rawDB)
        ->groupBy('carTypeName')
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
    
    //get most department type contributions (trip number)
    $deptTripNumber = DB::table('trips')
        ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
        ->select(DB::raw('CONCAT(institutions.institutionName, ", ", deptsperinstitution.deptName) as deptName'), DB::raw($column))
        ->whereRaw($rawDB)
        ->groupBy(DB::raw('1'))
        ->orderByRaw('2 DESC')
        ->limit(2)
        ->get();
        
    }
    else{
        $filterMessage = "Filter returned an empty set.";
        $emptySet = true;
    }        
    }
    }
?>
    @extends('layouts.main') @section('styling')
    <style>
        /** TODO: Push margin more to the right. Make the box centered to the user. **/

        #box-form {
            background-color: #363635;
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

        #institutionChartDiv {
            width: 100%;
            height: 500px;
        }

        #deptChartDiv {
            width: 100%;
            height: 500px;
        }
    </style>
    @endsection @section('content')
    <!-- analytics sidenav -->
    <?php 
        /*
    <div class="container u-pull-right" id="analytics-sidebar">
        <form method="post" action="{{ route('dashboard-process') }}">
            {{ csrf_field() }}
            <div class="twelve column bar">
                <p><strong>Campus</strong></p>
                <br>
                <div style="padding-left: 5px; padding-right: 5px; border: none;">
                    <select class="u-full-width" name="institutionID" id="institutionID" style="color: black;">
                       <option value="">All Institutions</option>
                        @foreach($institutions as $institution)
                          <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="twelve column bar">
                <p><strong>Date</strong></p>
                <div style="padding-left: 5px; padding-right: 5px; border: none;">
                    <p style="text-align: left;">From: </p>
                    <input class="u-full-width" type="date" name="fromDate" id="fromDate">
                    <p style="text-align: left;">Until: </p>
                    <input class="u-full-width" type="date" name="toDate" id="toDate">
                </div>
            </div>
            <div class="twelve column bar">
                <input class="button-primary" type="submit">
            </div>
        </form>
    </div>
    */
?>
    <!-- analytics sidenav -->
    <div class="ten columns offset-by-one" id="box-form" ng-app="myapp">
        <div ng-controller="MyController">
            <div class="row">
                <!--General Chart-->
                <div class="twelve columns" id="allChartDiv" style="width: 100%; height: 400px; background-color: #222222;"></div><br>
            </div>
            <div class="twelve columns">
                <div class="five columns offset-by-one">
                    <?php 
                        if(isset($filterMessage)){
                            echo "<p style=\"color: red;\">".$filterMessage."<p>";
                        }
                    ?>
                    <h7>Unit of measurement:&nbsp;</h7>
                    <select style="color:black;" ng-model="dboard">
                        <option ng-repeat="type in dboardType" value="<?php echo '{{type}}'; ?>" style="color:black;"><?php echo "{{type}}";?></option>
                    </select>
                </div>
                <div class="six columns">
                    <input type="checkbox" ng-model="showFilters">Show Filters
                    <div ng-show="showFilters">
                        <input type="checkbox" ng-model="datePreset">Preset Date Ranges
                    </div>
                </div>
            </div>
            <div class="twelve columns" ng-show="showFilters">
                <form method="post" action="{{ route('dashboard-process') }}" <?php if($userType <=2 ){ echo "ng-init=\"nonschool=true\""; } ?>> {{ csrf_field() }}

                    <div class="five columns offset-by-one" ng-show="nonschool">
                        <p><strong>Campus</strong></p>
                        <select class="u-full-width" name="institutionID" id="institutionID" style="color: black;">
                           <option value="">All Institutions</option>
                            @foreach($institutions as $institution)
                              <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="six columns">
                        <p><strong>Date</strong></p>
                        <div class="three columns" ng-hide="datePreset">
                            <p style="text-align: left;">From: </p>
                            <input class="u-full-width" type="date" name="fromDate" id="fromDate">
                        </div>
                        <div class="three columns" ng-hide="datePreset">
                            <p style="text-align: left;">Until: </p>
                            <input class="u-full-width" type="date" name="toDate" id="toDate">
                        </div>
                        <div class="six columns" ng-show="datePreset">
                            <p style="text-align: left;">Presets: </p>
                            <select name="datePreset" id="">
                                <option value="1">2 Weeks</option>
                                <option value="2">Last Month</option>
                                <option value="3">Last 3 Months</option>
                                <option value="4">Last 6 Months</option>
                                <option value="5">Last 1 Year</option>
                            </select>
                        </div>
                        <div class="three columns">
                            <input class="button-primary" type="submit">
                        </div>
                    </div>
                </form>
            </div>
            <!--Div of filtered dashboard-->
            <div class="twelve columns" ng-show="dboard=='Emissions'">
                <?php       
                        if(!$emptySet)
                            if(!$schoolSort){   
                                echo '<div class="twelve columns"> <a href=""><div class="four columns offset-by-four">';
                                echo '<table border="1" style="width:100%;">
                                        <thead>
                                            <tr><td colspan="2" style="text-align:center;">Top Institutions on {{dboard}}</td></tr>
                                        </thead>
                                            <tbody>';
                                 for($x = 0; $x < count($institutionEmissions); $x++){
                                     $top = $x + 1;
                                     echo "<tr>
                                            <td>".$top.". ".$institutionEmissions[$x]->institutionName."</td><td style=\"text-align:right\">".$institutionEmissions[$x]->percentage."%</td>
                                            </tr>";
                                 }
                                echo "</tbody></table></div>";
                            }
                        ?>
                <div class="twelve columns">
                    <a href="">
                        <div class="three columns offset-by-one">
                            <?php
                                if(!$emptySet){
                                    
                            echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Departments on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($deptContributions); $x++){
                                 $top = $x + 1;
                                 echo "<tr>
                                        <td>".$top.". ".$deptContributions[$x]->deptName."</td><td style=\"text-align:right\">".$deptContributions[$x]->percentage."%</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                                }
                        ?>
                        </div>
                    </a>
                    <a href="">
                        <div class="three columns offset-by-one">
                            <?php
                                if(!$emptySet){
                                    
                             echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Vehicles on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($carContributions); $x++){
                                 $top = $x + 1;
                                 echo "<tr>
                                        <td>".$top.". ".$carContributions[$x]->modelName."</td><td style=\"text-align:right\">".$carContributions[$x]->percentage."%</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                                }
                        ?>
                        </div>
                    </a>
                    <a href="">
                        <div class="three columns offset-by-one">
                            <?php
                                if(!$emptySet){
                                    
                                echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Car Type on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($vehicleContributions); $x++){
                                 $top = $x + 1;
                                 echo "<tr>
                                        <td>".$top.". ".$vehicleContributions[$x]->carTypeName."</td><td style=\"text-align:right\">".$vehicleContributions[$x]->percentage."%</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                                }
                        ?>
                        </div>
                    </a>
                </div>
                <div class="twelve columns">
                    <a href="">
                        <div class="four columns offset-by-four">
                            <?php
                                if(!$emptySet){
                                    
                            echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Car Brand on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($carBrandContributions); $x++){
                                 $top = $x + 1;
                                echo "<tr>
                                        <td>".$top.". ".$carBrandContributions[$x]->carBrandName."</td><td style=\"text-align:right\">".$carBrandContributions[$x]->percentage."%</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                                }
                        ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="twelve columns" ng-show="dboard=='Number of Trips'">
            <?php   
                if(!$emptySet)
                    if(!$schoolSort){

                     echo '<div class="twelve columns"> <a href=""><div class="four columns offset-by-four">';
                                echo '<table border="1" style="width:100%;">
                                        <thead>
                                            <tr><td colspan="2" style="text-align:center;">Top Institutions on {{dboard}}</td></tr>
                                        </thead>
                                            <tbody>';
                     for($x = 0; $x < count($institutionTripNumber); $x++){
                         $top = $x + 1;
                         echo "<tr>
                                            <td>".$top.". ".$institutionTripNumber[$x]->institutionName."</td><td style=\"text-align:right\">".$institutionTripNumber[$x]->percentage."</td>
                                            </tr>";
                                 }
                                echo "</tbody></table></div>";
                            }
                        ?>
            <div class="twelve columns">
                <a href="">
                    <div class="three columns offset-by-one">
                        <?php
                            if(!$emptySet){
                                
                            echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Departments on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($deptTripNumber); $x++){
                                 $top = $x + 1;
                                 echo "<tr>
                                        <td>".$top.". ".$deptTripNumber[$x]->deptName."</td><td style=\"text-align:right\">".$deptTripNumber[$x]->percentage."</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                            }
                        ?>
                    </div>
                </a>
                <a href="">
                    <div class="three columns offset-by-one">
                        <?php
                            if(!$emptySet){
                                
                            echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Vehicles on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($carTripNumber); $x++){
                                 $top = $x + 1;
                                 echo "<tr>
                                        <td>".$top.". ".$carTripNumber[$x]->modelName."</td><td style=\"text-align:right\">".$carTripNumber[$x]->percentage."</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                            }
                        ?>
                    </div>
                </a>
                <a href="">
                    <div class="three columns offset-by-one">
                        <?php
                            if(!$emptySet){
                                
                            echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Car Type on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($vehicleTripNumber); $x++){
                                 $top = $x + 1;
                                  echo "<tr>
                                        <td>".$top.". ".$vehicleTripNumber[$x]->carTypeName."</td><td style=\"text-align:right\">".$vehicleTripNumber[$x]->percentage."</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                            }
                        ?>
                    </div>
                </a>
            </div>
            <div class="twelve columns">
                <a href="">
                    <div class="four columns offset-by-four">
                        <?php
                            if(!$emptySet){
                                
                            echo '<table border="1" style="width:100%;">
                                    <thead>
                                        <tr><td colspan="2" style="text-align:center;">Top Car Brand on {{dboard}}</td></tr>
                                    </thead>
                                        <tbody>';
                             for($x = 0; $x < count($carBrandTripNumber); $x++){
                                 $top = $x + 1;
                                 echo "<tr>
                                        <td>".$top.". ".$carBrandTripNumber[$x]->carbrandName."</td><td style=\"text-align:right\">".$carBrandTripNumber[$x]->percentage."</td>
                                        </tr>";
                             }
                                echo "</tbody></table>";
                            }
                        ?>
                    </div>
                </a>
            </div>
        </div>
    </div>
    </div>
    @endsection @section('scripts')
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular.min.js" type="text/javascript"></script>

    <!--angular js script-->
    <script>
        var app = angular
            .module("myapp", [])
            .controller("MyController", function($scope) {
                $scope.dboardType = ['Emissions', 'Number of Trips'];
                $scope.nonschool = false;

                /*
                $scope.operate = function(input) {
                    $scope.holder = $scope.answer;
                    $scope.operation = input;
                    $scope.reset();
                };

                $scope.equals = function() {
                    switch ($scope.operation) {
                        case '+':
                            {
                                $scope.answer = $scope.holder + $scope.answer;
                                break;
                            }
                        case '-':
                            {
                                $scope.answer = $scope.holder - $scope.answer;
                                break;
                            }
                        case '*':
                            {
                                $scope.answer = $scope.holder * $scope.answer;
                                break;
                            }
                        case '/':
                            {
                                $scope.answer = $scope.holder / $scope.answer;
                                break;
                            }
                        default:
                            {
                                $scope.reset();
                            }
                    }
                };

                //cart functions
                $scope.itemList = [];
                $scope.cart = [];
                $scope.name = "";
                $scope.price = "";

                //adds item x quantity to inventory
                $scope.addItem = function(name, priceEach) {
                    $scope.itemList.push({
                        itemName: name,
                        priceEach: priceEach
                    });
                    $scope.name = "";
                    $scope.price = "";
                };

                //adds item and quantity to cart
                $scope.addToCart = function(name, priceeach, quantity) {
                    $scope.cart.push({
                        itemName: name,
                        priceEach: priceeach,
                        itemQuantity: quantity
                    });
                };

                //totals all in cart
                $scope.totalCart = 0;
                $scope.checkout = function() {
                    for (var x = 0; x < $scope.cart.length; x++) {
                        $scope.totalCart += $scope.cart[x].priceEach * $scope.cart[x].itemQuantity;
                    }
                };

                //resets all in cart
                $scope.resetCart = function() {
                    $scope.cart = [];
                };
                */
            });
    </script>
    <!--angular js script-->

    <!-- general emission chart-->
    <script>
        <?php
        {
        function getRegressionLine($emissionData){
                    //step 1
                    //calculate pearson's correlation coefficient - r
                    //step 2
                    //compute for the standard deviation of months (x) and emisisons (y) - Sx and Sy
                    //step 3
                    //compute for slope - b
                    //step 4
                    //compute for y-intercept - a
                    //Linear Regression
                    //y = a + bx

                    //Pearson's Correlation Coefficient calculation
                    //numerator calculation
                    $r = 0;
                    $summationOfNumerator = 0;
                    $xAve = 0;
                    $yAve = 0;
                    for($x = 1; $x <= count($emissionData); $x++) {
                        $xAve += $x;
                    }
                    for($x = 0; $x < count($emissionData); $x++) {
                        $yAve += $emissionData[$x][1];
                    }
                    $xAve = $xAve/count($emissionData);
                    $yAve = $yAve/count($emissionData);
                    for($x = 1; $x <= count($emissionData); $x++) {
                        $summationOfNumerator+=($x - $xAve)*($emissionData[$x - 1][1] - $yAve);
                    }

                    //denominator 
                    $denominator = 0;
                    $summationTerm1 = 0;
                    $summationTerm2 = 0;
                    for($x = 1; $x <= count($emissionData); $x++) {
                        $summationTerm1+=($x - $xAve)*($x - $xAve);
                        $summationTerm2+=($emissionData[$x - 1][1] - $yAve)*($emissionData[$x - 1][1] - $yAve);
                    }

                    $denominator = sqrt($summationTerm1 * $summationTerm2);
                    $r = $summationOfNumerator/$denominator;

                    //standard deviation calculation
                    $Sy = sqrt($summationTerm2/(count($emissionData)-1));
                    $Sx = sqrt($summationTerm1/(count($emissionData)-1));

                    //slope calculation
                    $b = $r * ($Sy/$Sx);

                    //y-intercept calculation
                    $a;
                    $a = $yAve - ($b * $xAve);

                    $regressionLine = array($a, $b);

                    return $regressionLine;
                }

        if(!isset($data)){
            $chartTitle = 'All Universities';   
            $emissionData = DB::table('trips')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('monthlyemissionsperschool', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))'), '=',  DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->select('trips.tripDate', 'trips.tripTime', 'deptsperinstitution.deptName' , 'trips.plateNumber', 'trips.kilometerReading',             'trips.remarks', 'trips.emissions', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate)) as monthYear'),'monthlyemissionsperschool.emission', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'vehicles_mv.modelName', 'vehicles_mv.active')
            ->orderBy('trips.tripDate', 'asc')
            ->get();
            $emissionCount = DB::table('trips')
            ->join('monthlyemissionsperschool', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))'), '=',  DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
            ->select(DB::raw('count(CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))) as monthYearCount'))
            ->groupBy(DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
            ->get();
        } 
            else{
            $rawDB = "";
            $add = false;
            if(isset($data['institutionID'])){
                $rawDB .= " vehicles_mv.institutionID = " . $data['institutionID'];
                $add = true;
            }
            if(isset($data['carTypeID'])){
                if($add){
                    $rawDB .= " AND ";
                }
                $rawDB .= "cartype_ref.carTypeID = " . $data['carTypeID'];
                $add = true;
            }
            if(isset($data['fuelTypeID'])){
                if($add){
                    $rawDB .= " AND ";
                }
                $add = true;
                $rawDB .= "fueltype_ref.fueltypeID = " . $data['fuelTypeID'];
            }
            if($data['fromDate'] != null && $data['toDate'] != null){
                if($add){
                    $rawDB .= " AND ";
                }
                $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "' AND trips.tripDate >= '" . $data['fromDate'] . "'";
            }elseif($data['fromDate'] != null && $data['toDate'] != null){
                if($add){
                    $rawDB .= " AND ";
                }
                $rawDB .= "trips.tripDate <= '" . $toDate . "'";
            }elseif($data['fromDate'] != null && $data['toDate'] != null){
                if($add){
                    $rawDB .= " AND ";
                }
                $rawDB .= "trips.tripDate >= '" . $data['fromDate'] . "'";
            } 
            $emissionData = DB::table('trips')
            ->join('deptsperinstitution', 'trips.deptID', '=', 'deptsperinstitution.deptID')
            ->join('monthlyemissionsperschool', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))'), '=',  DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
            ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
            ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
            ->select('trips.tripDate', 'trips.tripTime', 'deptsperinstitution.deptName' , 'trips.plateNumber', 
                    'trips.kilometerReading', 'trips.remarks', 'trips.emissions', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate)) as monthYear'), 'monthlyemissionsperschool.emission', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'vehicles_mv.modelName', 'vehicles_mv.active') 
            ->whereRaw($rawDB)
            ->orderBy('trips.tripDate', 'asc')
            ->get();
             $emissionCount = DB::table('trips')
            ->join('monthlyemissionsperschool', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))'), '=',  DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
            ->select(DB::raw('count(CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))) as monthYearCount'))
            ->groupBy(DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
            ->get();
        }
    }
    ?>
        var allChart;
        AmCharts.theme = AmCharts.themes.dark;
        var allChartTitle = "Carbon Emission Chart"
        var allChartDataIndexes = [];
        var allChartData = [
            <?php
            {
            $x = 1;
            $prev;
            $monthlyEmissions = [];
            $monthCtr = 0;
              foreach($emissionData as $emission) {
                    if($x == 1){
                        $monthSum = 0;
                        $prev = substr($emission->tripDate, 0, 7);
                    }
                    if($prev == substr($emission->tripDate, 0, 7)){
                        $monthSum += $emission->emission; 
                        $x++;
                        if($x == count($emissionData) - 1){
                            $monthlyEmissions[$monthCtr] = [$prev, $monthSum];
                            $prev = substr($emission->tripDate, 0, 7);
                            $monthSum = 0;
                            $monthCtr++;
                        }
                    }else{
                            $monthlyEmissions[$monthCtr] = [$prev, $monthSum];
                            $prev = substr($emission->tripDate, 0, 7);
                            $monthSum = 0;
                            $monthCtr++;
                        };
              }

            $regressionLine = getRegressionLine($monthlyEmissions);
            $saveIndex = 0;
            for($x = 0 ; $x < count($monthlyEmissions); $x++) {
                echo '{
                "date": "' . $monthlyEmissions[$x][0].'",';
                echo '
                "value": ' . $monthlyEmissions[$x][1].',';
                echo ' 
                "regression": ' . ($regressionLine[0] + ($regressionLine[0] * $x)) . ', ';
                echo '
                "sequestration": 30,';
                echo ' 
                "bullet": "round",';
                echo '
                "subSetTitle": "Monthly Emissions",';
                echo  '
                "subSet": [';
                for($y = $saveIndex; $y < count($emissionData); $y++){
                    if($y==$saveIndex){
                        $prev = substr($emissionData[$y]->tripDate, 0 , 7);
                    }
                    if(substr($emissionData[$y]->tripDate, 0 , 7) == $prev){
                        echo '
                        {
                        "date": "' . $emissionData[$y]->tripDate . '",';
                        echo '
                        "value": "' . $emissionData[$y]->emission . '",';
                        echo '
                        "regression": ' . ($regressionLine[0] + ($regressionLine[0] * $x)) . ', ';
                        echo '
                        "sequestration": "' . 30 . '",';
                        echo '
                        "bullet": "round"  ';
                        $test = $y + 1;
                        if(substr($emissionData[$test]->tripDate, 0 , 7) != $prev){
                            $saveIndex = $y;
                            echo '}]},';
                        }else {
                            echo '},';
                        }

                    }
                }
            }
        }
        ?> {
                "date": <?php
                $yrmonth = end($monthlyEmissions);
                $month = (int) substr($yrmonth[0], 5, 2);
                $yr = (int) substr($yrmonth[0], 0, 4);
                if($month==12){
                    $month = (string) "01";
                    $yr++;
                }elseif($month>=9){
                    $month = (string) $month++;
                }else{
                    $month = (string) "0" . ($month + 1);
                }
                echo '"'.$yr . "-" . $month.'",
                ';
                 ?>
                "regression": <?php echo $regressionLine[0] + ($regressionLine[0] * count($monthlyEmissions) + 1); ?>
            }
        ];
        allChart = AmCharts.makeChart("allChartDiv", {
            "backgroundAlpha": 1,
            "export": {
                "enabled": true
            },
            "type": "serial",
            "titles": [{
                "text": allChartTitle
            }],
            "colors": [
                "#de4c4f",
                "#d8854f",
                "#77ee38",
                "#a7a737"
            ],
            "allLabels": [{
                "text": "",
                "x": 10,
                "y": 15,
                "url": "javascript: goBackChart();void(0);"
            }],
            "dataProvider": allChartData,
            "valueAxes": [{
                "axisAlpha": 0,
                "dashLength": 4,
                "position": "left"
            }],
            "graphs": [{
                "valueField": "value",
                "fillAlphas": 0,
                "bulletField": "bullet"
            }, {
                "valueField": "regression",
                "fillAlphas": 0,
                "bulletField": "bullet"
            }, {
                "valueField": "sequestration",
                "fillAlphas": 0,
                "bulletField": "bullet"
            }],
            "chartCursor": {
                "zoomable": false,
                "fullWidth": true,
                "cursorAlpha": 0.1,
                "categoryBalloonEnabled": false
            },
            "dataDateFormat": "YYYY-MM-DD HH:NN:SS",
            "categoryField": "date",
            "categoryAxis": {
                "parseDates": true,
                "minPeriod": "mm",
                "axisAlpha": 0,
                "minHorizontalGap": 50,
                "gridAlpha": 0,
                "tickLength": 0
            },
        });

        allChart.addListener('clickGraphItem', function(evt) {
            if (evt.item.dataContext.subSet) {
                chartDataIndexes.push({
                    index: evt.index,
                    title: evt.item.dataContext.subSetTitle,
                    prev: evt.chart.titles[0].text
                });
                evt.chart.dataProvider = evt.item.dataContext.subSet;
                evt.chart.allLabels[0].text = "Go Back " + evt.chart.titles[0].text;
                evt.chart.titles[0].text = evt.item.dataContext.subSetTitle;
                evt.chart.validateData();

            }
        });

        function goBackChart() {
            var previousData = allChartData;
            var tmp = {
                prev: ""
            }

            // Remove latest
            chartDataIndexes.pop();

            // Get previous cached object
            for (var i = 0; i < chartDataIndexes.length; i++) {
                tmp = chartDataIndexes[i];
                previousData = previousData[tmp.index].subSet;
            }

            // Apply titles and stuff
            allChart.allLabels[0].text = tmp.prev ? "Go Back " + tmp.prev : "";
            allChart.titles[0].text = tmp.title || allChartTitle;
            allChart.dataProvider = previousData;
            allChart.validateData();
        }
    </script>
    <!-- general emission chart-->
    @endsection