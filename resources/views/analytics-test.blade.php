<!DOCTYPE html>
@extends('layouts.main') @section('styling')
<style>
    #main-content {
        padding-right: 200px;
    }
</style>
@endsection

<?php
/*
$filterData = true;
$institutionID = 1;
$carFilter = 2;
$gasFilter = 1;
$fromDateFilter = "2017-6-12";
$toDateFilter = "2017-8-15";
*/
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
        $rawDB .= "trips.tripDate <= '" . $toDateFilter . "' AND trips.tripDate >= '" . $fromDateFilter. "'";
    }elseif($data['fromDate'] != null && $data['toDate'] != null){
        if($add){
            $rawDB .= " AND ";
        }
        $rawDB .= "trips.tripDate <= '" . $toDateFilter . "'";
    }elseif($data['fromDate'] != null && $data['toDate'] != null){
        if($add){
            $rawDB .= " AND ";
        }
        $rawDB .= "trips.tripDate >= '" . $fromDateFilter . "'";
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
    ->get();    
    $chartTitle = "DLSU";
}
?>

    @section('content')
    <!-- analytics sidenav -->
    <div class="container u-pull-right" id="analytics-sidebar">
        <form method="post" action="{{ route('analytics-test-process') }}">
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
                    <font color="black">
                        <select class="u-full-width" name="carTypeID" id="carTypeID">
                       <option value="">All Car Types</option>
                          @foreach($carTypes as $carType)
                            <option value="{{ $carType->carTypeID }}">{{ $carType->carTypeName }}</option>
                          @endforeach
                    </select>
                    </font>
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

    <div class="twelve columns" id="chartdiv" style="width: 100%; height: 400px; background-color: #222222;" ></div>

    @endsection @section('scripts')
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
    
    <script type="text/javascript">
        var chart;
        AmCharts.theme = AmCharts.themes.dark;
        var chartTitle = "All Institutions";
        var chartDataIndexes = [];
        var chartData = [  
        
        <?php
        $x = 1;
          foreach($emissionData as $emission) {
            echo '{"date": "' . $emission->tripDate . '",';
            echo ' "value": ' . $emission->emission . ',';
            echo ' "regression": 3, ';
            echo '"sequestration": 30 }';
            if($x != count($emissionData)) {
                echo ",
                ";
            }
            $x++;
          };
        ?>,
            {
            "date": "2009-02-01",
            "value": 5,
            "regression": 4,
            "sequestration": 30
        }, {
            "date": "2009-03-01",
            "value": 15,
            "regression": 12,
            "sequestration": 30,
            "bullet": "round",
            "subSetTitle": "Second level",
            "subSet": [{
                "date": "2009-03-01",
                "value": 3,
                "regression": 2,
                "sequestration": 5
            }, {
                "date": "2009-03-02",
                "value": 3,
                "regression": 2,
                "sequestration": 5
            }, {
                "date": "2009-03-03",
                "value": 3,
                "regression": 2,
                "sequestration": 5
            }, {
                "date": "2009-03-04",
                "value": 3,
                "regression": 2,
                "sequestration": 5,
                "bullet": "round",
                "subSetTitle": "Third level",
                "subSet": [{
                    "date": "2009-03-04 01:00",
                    "value": 3,
                    "regression": 2,
                    "sequestration": 5
                }, {
                    "date": "2009-03-04 02:00",
                    "value": 4,
                    "regression": 3,
                    "sequestration": 6
                }, {
                    "date": "2009-03-04 03:00",
                    "value": 5,
                    "regression": 4,
                    "sequestration": 6,
                    "bullet": "round",
                    "subSetTitle": "Fourth level",
                    "subSet": [{
                        "date": "2009-03-04 03:10",
                        "value": 3,
                        "regression": 2,
                        "sequestration": 5
                    }, {
                        "date": "2009-03-04 03:20",
                        "value": 2,
                        "regression": 1,
                        "sequestration": 3
                    }, {
                        "date": "2009-03-04 03:30",
                        "value": 3,
                        "regression": 2,
                        "sequestration": 5
                    }, {
                        "date": "2009-03-04 03:40",
                        "value": 4,
                        "regression": 3,
                        "sequestration": 5
                    }, {
                        "date": "2009-03-04 03:50",
                        "value": 3,
                        "regression": 2,
                        "sequestration": 5,
                        // "bullet": "round",
                        "subSet": [
                            // And so on...
                        ]
                    }]
                }, {
                    "date": "2009-03-04 04:00",
                    "value": 3,
                    "regression": 2,
                    "sequestration": 5
                }, {
                    "date": "2009-03-04 05:00",
                    "value": 1,
                    "regression": 0,
                    "sequestration": 2
                }]
            }, {
                "date": "2009-03-05",
                "value": 3,
                "regression": 2,
                "sequestration": 5
            }, {
                "date": "2009-03-06",
                "value": 3,
                "regression": 2,
                "sequestration": 5
            }, {
                "date": "2009-03-07",
                "value": 3,
                "regression": 2,
                "sequestration": 5
            }]
        }, {
            "date": "2009-04-01",
            "value": 13,
            "regression": 10.4,
            "sequestration": 30
        }, {
            "date": "2009-05-01",
            "value": 17,
            "regression": 13.6,
            "sequestration": 30
        }, {
            "date": "2009-06-01",
            "value": 15,
            "regression": 12,
            "sequestration": 30
        }, {
            "date": "2009-07-01",
            "value": 19,
            "regression": 15.2,
            "sequestration": 30
        }, {
            "date": "2009-08-01",
            "value": 21,
            "regression": 16.8,
            "sequestration": 30
        }, {
            "date": "2009-09-01",
            "value": 20,
            "regression": 16,
            "sequestration": 30
        }, {
            "date": "2009-10-01",
            "value": 20,
            "regression": 16,
            "sequestration": 30
        }, {
            "date": "2009-11-01",
            "value": 19,
            "regression": 15.2,
            "sequestration": 30
        }, {
            "date": "2009-12-01",
            "value": 25,
            "regression": 20,
            "sequestration": 30
        }];
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
            },{
                "valueField": "regression",
                "fillAlphas": 0,
                "bulletField": "bullet"
            },{
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