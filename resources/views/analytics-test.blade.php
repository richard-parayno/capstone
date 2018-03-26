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
    if(isset($universityIDFilter)){
        $rawDB .= " institutionID = " . $data['institutionID'];
        $add = true;
    }
    if(isset($carFilter)){
        if($add){
            $rawDB .= " AND ";
        }
        $rawDB .= "cartype_ref.carTypeID = " . $data['carType'];
        $add = true;
    }
    if(isset($gasFilter)){
        if($add){
            $rawDB .= " AND ";
        }
        $add = true;
        $rawDB .= "fueltype_ref.fueltypeID = " . $data['fuelType'];
    }
    if(isset($fromDateFilter) && isset($toDateFilter)){
        if($add){
            $rawDB .= " AND ";
        }
        $rawDB .= "trips.tripDate <= '" . $toDateFilter . "' AND trips.tripDate >= '" . $fromDateFilter. "'";
    }elseif(!isset($fromDateFilter) && isset($toDateFilter)){
        if($add){
            $rawDB .= " AND ";
        }
        $rawDB .= "trips.tripDate <= '" . $toDateFilter . "'";
    }elseif(isset($fromDateFilter) && !isset($toDateFilter)){
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
                          @foreach($fuelTypes as $fuelType)\
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
                <input class="button-primary" type="submit"></input>
            </div>
        </form>
    </div>
    <!-- analytics sidenav -->

    <div class="twelve columns" id="chartdiv" style="width: 640px; height: 400px;"></div>

    @endsection @section('scripts')
    <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

    <script type="text/javascript">
        var chart;
        AmCharts.theme = AmCharts.themes.dark;
        var chartTitle = "All Institutions";
        var chartDataIndexes = [];
        var chartData = [{

            "date": "2009-01-01",
            "value": 3,
            "fromValue": 2,
            "toValue": 5
        }, {
            "date": "2009-02-01",
            "value": 5,
            "fromValue": 4,
            "toValue": 6
        }, {
            "date": "2009-03-01",
            "value": 15,
            "fromValue": 12,
            "toValue": 18,
            "bullet": "round",
            "subSetTitle": "Second level",
            "subSet": [{
                "date": "2009-03-01",
                "value": 3,
                "fromValue": 2,
                "toValue": 5
            }, {
                "date": "2009-03-02",
                "value": 3,
                "fromValue": 2,
                "toValue": 5
            }, {
                "date": "2009-03-03",
                "value": 3,
                "fromValue": 2,
                "toValue": 5
            }, {
                "date": "2009-03-04",
                "value": 3,
                "fromValue": 2,
                "toValue": 5,
                "bullet": "round",
                "subSetTitle": "Third level",
                "subSet": [{
                    "date": "2009-03-04 01:00",
                    "value": 3,
                    "fromValue": 2,
                    "toValue": 5
                }, {
                    "date": "2009-03-04 02:00",
                    "value": 4,
                    "fromValue": 3,
                    "toValue": 6
                }, {
                    "date": "2009-03-04 03:00",
                    "value": 5,
                    "fromValue": 4,
                    "toValue": 6,
                    "bullet": "round",
                    "subSetTitle": "Fourth level",
                    "subSet": [{
                        "date": "2009-03-04 03:10",
                        "value": 3,
                        "fromValue": 2,
                        "toValue": 5
                    }, {
                        "date": "2009-03-04 03:20",
                        "value": 2,
                        "fromValue": 1,
                        "toValue": 3
                    }, {
                        "date": "2009-03-04 03:30",
                        "value": 3,
                        "fromValue": 2,
                        "toValue": 5
                    }, {
                        "date": "2009-03-04 03:40",
                        "value": 4,
                        "fromValue": 3,
                        "toValue": 5
                    }, {
                        "date": "2009-03-04 03:50",
                        "value": 3,
                        "fromValue": 2,
                        "toValue": 5,
                        // "bullet": "round",
                        "subSet": [
                            // And so on...
                        ]
                    }]
                }, {
                    "date": "2009-03-04 04:00",
                    "value": 3,
                    "fromValue": 2,
                    "toValue": 5
                }, {
                    "date": "2009-03-04 05:00",
                    "value": 1,
                    "fromValue": 0,
                    "toValue": 2
                }]
            }, {
                "date": "2009-03-05",
                "value": 3,
                "fromValue": 2,
                "toValue": 5
            }, {
                "date": "2009-03-06",
                "value": 3,
                "fromValue": 2,
                "toValue": 5
            }, {
                "date": "2009-03-07",
                "value": 3,
                "fromValue": 2,
                "toValue": 5
            }]
        }, {
            "date": "2009-04-01",
            "value": 13,
            "fromValue": 10.4,
            "toValue": 15.6
        }, {
            "date": "2009-05-01",
            "value": 17,
            "fromValue": 13.6,
            "toValue": 20.4
        }, {
            "date": "2009-06-01",
            "value": 15,
            "fromValue": 12,
            "toValue": 18
        }, {
            "date": "2009-07-01",
            "value": 19,
            "fromValue": 15.2,
            "toValue": 22.8
        }, {
            "date": "2009-08-01",
            "value": 21,
            "fromValue": 16.8,
            "toValue": 25.2
        }, {
            "date": "2009-09-01",
            "value": 20,
            "fromValue": 16,
            "toValue": 24
        }, {
            "date": "2009-10-01",
            "value": 20,
            "fromValue": 16,
            "toValue": 24
        }, {
            "date": "2009-11-01",
            "value": 19,
            "fromValue": 15.2,
            "toValue": 22.8
        }, {
            "date": "2009-12-01",
            "value": 25,
            "fromValue": 20,
            "toValue": 30
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
                "id": "fromGraph",
                "lineAlpha": 0,
                "showBalloon": false,
                "valueField": "fromValue",
                "fillAlphas": 0
            }, {
                "fillAlphas": 0.2,
                "fillToGraph": "fromGraph",
                "lineAlpha": 0,
                "showBalloon": false,
                "valueField": "toValue"
            }, {
                "valueField": "value",
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
    <script>
    </script>

    @endsection