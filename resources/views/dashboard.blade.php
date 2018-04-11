<!DOCTYPE html> @extends('layouts.main') @section('styling')
<style>
    #main-content {
        padding-right: 200px;
    }
</style>
@endsection

<?php

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

    @endsection