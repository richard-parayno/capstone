@extends('layouts.main') 

@section('styling')
<style>
    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0px;
    }

   
</style>
@endsection

<?php
$filterData = true;
$institutionID = 1;
$carFilter = 2;
$gasFilter = 1;
if(!$filterData){
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
    $rawDB = "+";
    echo $rawDB;
    $add = false;
    if(isset($universityIDFilter)){
        $rawDB .= " institutionID = " . $universityIDFilter;
        $add = true;
        echo $rawDB;
    }
    if(isset($carFilter)){
        if($add){
            $rawDB .= " AND ";
        }
        $rawDB .= "carType_ref.carTypeID = " . $carFilter;
        $add = true;
        echo $rawDB;
    }
    if(isset($gasFilter)){
        if($add){
            $rawDB .= " AND ";
        }
        $add = true;
        $rawDB .= "fueltype_ref.fueltypeID = " . $gasFilter;
        echo $rawDB;
    }
    if(isset($toDateFilter) | isset($fromDateFilter)){
        if($add){
            $rawDB .= " AND ";
        }
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
dd($emissionData);
//$filtered;
/*
if(!isset($filtered)){
    $chartTitle = "All Emissions";
    $emissionData = DB::select('trips.tripDate','trips.tripTime','deptsperinstitution.deptName','trips.plateNumber','trips.kilometerReading','trips.remarks','monthlyemissionsperschool.emission')
		->addSelect(DB::raw('CONCAT(YEAR(trips.tripDate))'), '-', DB::raw('MONTH(trips.tripDate)')
		->from('trips')
		->join('deptsperinstitution', function($join) {
			$join->on('trips.deptID', '=', 'deptsperinstitution.deptID');
			})
		->join('monthlyemissionsperschool', function($join) {
			$join->on(DB::raw('CONCAT(YEAR(trips.tripDate), "-", MONTH(trips.tripDate));'), '=', DB::raw('CONCAT(YEAR(monthlyemissionsperschool.monthYear), "-", MONTH(monthlyemissionsperschool.monthYear));')
			)})
		->get();
    //2d array containing emissions grouped by month
    //$emissionArray = [][];
    for(all rows in emissionData){
        if(!(isset($emissionArray[x])){
            $emissionsArray[x] = [$emissionData[x].monthYear, $emissionData[x].emissions];
            //for all same monthyear group //monthYear==previous
            {
                emissionArray[x][y] = emmisionData[x];    
            }
        }else {
            
        }
}
    
}else{
    //filtered query here
}
*/

?>

@section('content')
<div class="eight columns offset-by-two" id="chartdiv" style="width: 640px; height: 400px;"></div>
<div class="eight columns offset-by-two" id="control">
    <select class="u-full-width" name="userTypeID" id="userTypeID" style="color: black;">
    </select>

    <div>
        <input class="u-full-width" name="date" id="date">
    </div>

</div>
@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
    var chart;
    var chartTitle = "<?php echo $chartTitle; ?>";
    var chartDataIndexes = [];
    var chartData = [{
        "date": "2009-03-01",
        "value": 15,
        "fromValue": 12,
        "toValue": 18,
        "bullet": "round",
        "subSetTitle": "Second level",
        "subSet": [{
            "date": "2009-03-04",
            "value": 3,
            "fromValue": 2,
            "toValue": 5,
            "bullet": "round",
            "subSetTitle": "Third level",
            "subSet": [{
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
                }]
            }]
        }]
    }];

    chart = AmCharts.makeChart("chartdiv", {
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
        }
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
    const picker = datepicker('#date');
</script>

@endsection
