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
<div class="ten columns offset-by-one" id="box-form" ng-app="myapp">
    <div ng-controller="MyController">
        <div class="twelve columns" id="allChartDiv" style="width: 100%; height: 400px; background-color: #222222;"></div>
        <h7>Unit of measurement:&nbsp;</h7>
        <select style="color:black;" ng-model="dboard">
                <option ng-repeat="type in dboardType" value="<?php echo '{{type}}'; ?>" style="color:black;"><?php echo "{{type}}";?></option>
            </select>
        <!--General Chart-->
        <!--Div of filtered dashboard-->
        <div class="twelve columns" ng-show="dboard=='Emissions'">
            <div class="six columns">
                <div id="institutionChartDiv"></div>
            </div>
            <div class="six columns">
                <div id="deptChartDiv"></div>
            </div>
        </div>
        <div class="twelve columns" ng-show="dboard=='Number of Trips'">
            <?php
                //by number of trips data
                ?>

        </div>
    </div>
    <?php
    /*
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
        ->select('trips.tripDate', 'trips.tripTime', 'deptsperinstitution.deptName' , 'trips.plateNumber', 
    'trips.kilometerReading', 'trips.remarks', 'trips.emissions', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate)) as monthYear'), 'monthlyemissionsperschool.emission', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'vehicles_mv.modelName', 'vehicles_mv.active')
        ->orderBy('trips.tripDate', 'asc')
        ->get();
        $emissionCount = DB::table('trips')
        ->join('monthlyemissionsperschool', DB::raw('CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))'), '=',  DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
        ->select(DB::raw('count(CONCAT(YEAR(trips.tripDate), "-",MONTH(trips.tripDate))) as monthYearCount'))
        ->groupBy(DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-",MONTH(monthlyemissionsperschool.monthYear))'))
        ->get();
    } else{
        $rawDB = "";
        $add = false;
        if($data['institutionID'] != null){
            $rawDB .= " vehicles_mv.institutionID = " . $data['institutionID'];
            $add = true;
        }
        if($data['carTypeID'] != null){
            if($add){
                $rawDB .= " AND ";
            }
            $rawDB .= "cartype_ref.carTypeID = " . $data['carTypeID'];
            $add = true;
        }
        if($data['fuelTypeID'] != null){
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
    ?>

        @section('content')
        <!-- analytics sidenav -->
        <div class="container u-pull-right" id="analytics-sidebar">
            <form method="post" action="{{ route('dashboard-process') }}">
                {{ csrf_field() }}
                <div class="twelve column bar">
                    <div id="current-user">
                        <p style="text-align: center; border: none;">Analytics Filters</p>
                    </div>
                </div>
                <style>
                    #topbar {
                        background-color: black;
                    }
                </style>

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
                    <p><strong>Vehicle Type</strong></p>
                    <br>
                    <div style="padding-left: 5px; padding-right: 5px; border: none;">
                        <select class="u-full-width" name="carTypeID" id="carTypeID" style="color: black;">
                           <option value="">All Car Types</option>
                            @foreach($carTypes as $carType)
                              <option value="{{ $carType->carTypeID }}">{{ $carType->carTypeName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="twelve column bar">
                    <p><strong>Fuel Type</strong></p>
                    <br>
                    <div style="padding-left: 5px; padding-right: 5px; border: none;">
                        <font color="black">
                            <select class="u-full-width" name="fuelTypeID" id="fuelTypeID">
                             <option value="">All Fuel Types</option>
                              @foreach($fuelTypes as $fuelType)
                                <option value="{{ $fuelType->fuelTypeID }}">{{ $fuelType->fuelTypeName }}</option>
                              @endforeach
                        </select>
                        </font>
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
        <!-- analytics sidenav -->

        <div class="twelve columns" id="chartdiv" style="width: 100%; height: 400px; background-color: #222222;"></div>

        @endsection @section('scripts')
        <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

        <script type="text/javascript">
            var chart;
            AmCharts.theme = AmCharts.themes.dark;
            var chartTitle = "Carbon Emission Chart"
            var chartDataIndexes = [];
            var chartData = [
                <?php
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
            chart = AmCharts.makeChart("chartdiv", {
                "backgroundAlpha": 1,
                "export": {
                    "enabled": true
                },
                "type": "serial",
                "titles": [{
                    "text": chartTitle
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
                "dataProvider": chartData,
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


            chart.addListener('clickGraphItem', function(evt) {
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
                var previousData = chartData;
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
                chart.allLabels[0].text = tmp.prev ? "Go Back " + tmp.prev : "";
                chart.titles[0].text = tmp.title || chartTitle;
                chart.dataProvider = previousData;
                chart.validateData();
            }
        </script>
        */?>
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
            if($data['institutionID'] != null){
                $rawDB .= " vehicles_mv.institutionID = " . $data['institutionID'];
                $add = true;
            }
            if($data['carTypeID'] != null){
                if($add){
                    $rawDB .= " AND ";
                }
                $rawDB .= "cartype_ref.carTypeID = " . $data['carTypeID'];
                $add = true;
            }
            if($data['fuelTypeID'] != null){
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

<!--top 2 institution chart-->
<script>
    <?php
         /*

            //carbrand to trips drilldown data for top2 brands

            //get most car brand type contributions (emission total)
            $carBrandContributions = DB::table('trips')
                ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
                ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
                ->select('carbrand_ref.carbrandName', DB::raw('SUM(trips.emissions) AS totalEmissions'))
                ->groupBy('carbrandName')
                ->orderByRaw('SUM(trips.emissions) DESC')
                ->limit(2)
                ->get();

            if(isset($carBrandContributions[1])){
                $carBrandTripRows = DB::table('trips')
                    ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
                    ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
                    ->select(DB::raw('*'))
                    ->whereRaw('carBrandName = \''.$carBrandContributions[0]->carbrandName.'\' || carBrandName = \''.$carBrandContributions[1]->carbrandName.'\'')
                    ->get();
            }else{
                $carBrandTripRows = DB::table('trips')
                    ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
                    ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
                    ->select(DB::raw('*'))
                    ->whereRaw('carBrandName = \''.$carBrandContributions[0]->carbrandName.'\'')
                    ->get();
            }
        */

            $institutionEmissions = DB::table('monthlyemissionsperschool')
            ->join('institutions', 'monthlyemissionsperschool.institutionID', '=', 'institutions.institutionID')
            ->select('institutions.institutionName', DB::raw('SUM(monthlyemissionsperschool.emission) AS emission'))
            ->groupBy('institutions.institutionID')
            ->orderByRaw('SUM(monthlyemissionsperschool.emission) DESC')
            ->limit(2)
            ->get();

            if(isset($institutionEmissions[1])){
                $institutionEmissionsTripRows = DB::table('monthlyemissionsperschool')
                ->join('institutions', 'monthlyemissionsperschool.institutionID', '=', 'institutions.institutionID')
                    ->select(DB::raw('*'))
                    ->whereRaw('institutions.institutionName = \''.$institutionEmissions[0]->institutionName.'\' || institutionName = \''.$institutionEmissions[1]->institutionName.'\'')
                    ->get();  
            }else{
                $institutionEmissionsTripRows = DB::table('monthlyemissionsperschool')
                    ->join('institutions', 'monthlyemissionsperschool.institutionID', '=', 'institutions.institutionID')
                    ->select(DB::raw('*'))
                    ->whereRaw('institutions.institutionName = \''.$institutionEmissions[0]->institutionName.'\'')
                    ->get();
            }

           echo "var institutionChart = [";
                for($x = 0; $x < count($institutionEmissions); $x++){
                    echo '{
                        "Institution": "'.$institutionEmissions[$x]->institutionName.'",
                        "Emission": '.$institutionEmissions[$x]->emission.',
                        "url": "#",
                        "description": "Click for Monthly Emissions",
                        "months": [';
                        for($y = 0; $y < count($institutionEmissionsTripRows); $y++){
                            echo '{
                                "Institution": "'.$institutionEmissionsTripRows[$y]->monthYear.'",
                                "Emission": '.$institutionEmissionsTripRows[$y]->emission.'
                            }';
                            if($y!=count($institutionEmissionsTripRows)-1){
                                echo ',';
                            }
                        }
                        echo ']';
                        echo '
                        }';
                        if($x!=count($institutionEmissions)-1){
                            echo ',';
                        }
                    }
                echo "];
                "
        /*    
        var institutionChart = [{
            "Institution": 2009,
            "Emission": 23.5,
            "url": "#",
            "description": "Click for Department data",
            "months": [{
                "category": 1,
                "income": 1
            }, {
                "category": 2,
                "income": 2
            }]
        }, {
            "Institution": 2010,
            "Emission": 26.2,
            "url": "#",
            "description": "click to drill-down",
            "months": [{
                "category": 1,
                "income": 4
            }, {
                "category": 2,
                "income": 3
            }]
        }];
        */
        ?>

    var chart = AmCharts.makeChart("institutionChartDiv", {
        "type": "serial",
        "creditsPosition": "top-right",
        "autoMargins": false,
        "marginLeft": 30,
        "marginRight": 8,
        "marginTop": 10,
        "marginBottom": 26,
        "titles": [{
            "text": "Top 2 Institutions on Emissions"
        }],
        "dataProvider": institutionChart,
        "startDuration": 1,
        "graphs": [{
            "alphaField": "alpha",
            "balloonText": "<span style='font-size:13px;'>Emission:<b>[[Emission]]</b>",
            "dashLengthField": "dashLengthColumn",
            "fillAlphas": 1,
            "title": "Institution Emission",
            "type": "column",
            "valueField": "Emission",
            "urlField": "url"
        }],
        "categoryField": "Institution",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "tickLength": 0
        }
    });

    chart.addListener("clickGraphItem", function(event) {
        if ('object' === typeof event.item.dataContext.months) {

            // set the monthly data for the clicked month
            event.chart.dataProvider = event.item.dataContext.months;

            // update the chart title
            event.chart.titles[0].text = event.item.dataContext.Institution + ' Monthly Emissions';

            // let's add a label to go back to yearly data
            event.chart.addLabel(
                35, 20,
                "< Go back to Intitution Level",
                undefined,
                15,
                undefined,
                undefined,
                undefined,
                true,
                'javascript:resetChart();');

            // validate the new data and make the chart animate again
            event.chart.validateData();
            event.chart.animateAgain();
        }
    });

    // function which resets the chart back to yearly data
    function resetChart() {
        chart.dataProvider = institutionChart;
        chart.titles[0].text = 'Top 2 Institutions on Emissions';

        // remove the "Go back" label
        chart.allLabels = [];

        chart.validateData();
        chart.animateAgain();
    }
</script>
<!--top 2 institution chart-->

<!--top 2 department chart-->
<script>
    <?php
            $deptContributions = DB::table('trips')
                ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
                ->select('deptsperinstitution.deptID', 'deptsperinstitution.deptName', DB::raw('SUM(trips.emissions) AS totalEmissions'))
                ->groupBy('deptsperinstitution.deptID')
                ->orderByRaw('SUM(trips.emissions) DESC')
                ->limit(2)
                ->get();
            
            if(isset($deptContributions[1])){
                $deptEmissionsTripRows = DB::table('trips')
                    ->select(DB::raw('SUBSTRING(tripDate, 1,7) as monthYear, SUM(emissions) as emissions'))
                    ->whereRaw('deptID = \''.$deptContributions[0]->deptID.'\' || deptID = \''.$deptContributions[1]->deptID.'\'')
                    ->groupBy(DB::raw('SUBSTRING(tripDate, 1,7)'))
                    ->get();
            }else{
                $deptEmissionsTripRows = DB::table('trips')
                    ->select(DB::raw('SUBSTRING(tripDate, 1,7) as monthYear, SUM(emissions) as emissions'))
                    ->whereRaw('deptID = \''.$deptContributions[0]->deptID.'\'')
                    ->groupBy(DB::raw('SUBSTRING(tripDate, 1,7)'))  
                    ->get();
            }

           echo "var deptChart = [";
                for($x = 0; $x < count($deptContributions); $x++){
                    echo '{
                        "Department": "'.$deptContributions[$x]->deptName.'",
                        "Emission": '.$deptContributions[$x]->totalEmissions.',
                        "url": "#",
                        "description": "Click for Monthly data",
                        "months": [';
                        for($y = 0; $y < count($deptEmissionsTripRows); $y++){
                            echo '{
                                "Department": "'.$deptEmissionsTripRows[$y]->monthYear.'",
                                "Emission": '.$deptEmissionsTripRows[$y]->emissions.'
                            }';
                            if($y!=count($deptEmissionsTripRows)-1){
                                echo ',';
                            }
                        }
                        echo ']';
                        echo '
                        }';
                        if($x!=count($deptContributions)-1){
                            echo ',';
                        }
                    }
                echo "];
                ";
        ?>

    var chart = AmCharts.makeChart("deptChartDiv", {
        "type": "serial",
        "creditsPosition": "top-right",
        "autoMargins": false,
        "marginLeft": 30,
        "marginRight": 8,
        "marginTop": 10,
        "marginBottom": 26,
        "titles": [{
            "text": "Top 2 Departments on Emissions"
        }],
        "dataProvider": deptChart,
        "startDuration": 1,
        "graphs": [{
            "alphaField": "alpha",
            "balloonText": "<span style='font-size:13px;'>Emission:<b>[[Emission]]</b>",
            "dashLengthField": "dashLengthColumn",
            "fillAlphas": 1,
            "title": "Department Emission",
            "type": "column",
            "valueField": "Emission",
            "urlField": "url"
        }],
        "categoryField": "Department",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "tickLength": 0
        }
    });

    chart.addListener("clickGraphItem", function(event) {
        if ('object' === typeof event.item.dataContext.months) {

            // set the monthly data for the clicked month
            event.chart.dataProvider = event.item.dataContext.months;

            // update the chart title
            event.chart.titles[0].text = event.item.dataContext.Department + ' Monthly Emissions';

            // let's add a label to go back to yearly data
            event.chart.addLabel(
                35, 20,
                "< Go back to Department Level",
                undefined,
                15,
                undefined,
                undefined,
                undefined,
                true,
                'javascript:resetChartDept();');

            // validate the new data and make the chart animate again
            event.chart.validateData();
            event.chart.animateAgain();
        }
    });

    // function which resets the chart back to yearly data
    function resetChartDept() {
        chart.dataProvider = deptChart;
        chart.titles[0].text = 'Top 2 Departments on Emissions';

        // remove the "Go back" label
        chart.allLabels = [];

        chart.validateData();
        chart.animateAgain();
    }
</script>
<!--top 2 institution chart-->
@endsection