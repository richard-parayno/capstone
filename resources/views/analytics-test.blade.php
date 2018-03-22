@extends('layouts.main') @section('styling')
<style>
    html,
    body {
        width: 100%;
        height: 100%;
        margin: 0px;
    }

    #chartdiv {
        width: 100%;
        height: 50%;
        margin: 20px;
    }
</style>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
@endsection 
<div class="container" id="main-content">
<div id="chartdiv"></div>
<div class="seven column" id="control">
    <select class="u-full-width" name="userTypeID" id="userTypeID" style="color: black;">
    </select>

    <div>
        <input class="u-full-width" name="date" id="date">
    </div>

</div>
</div>


@section('scripts')
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
    var chart;
    var chartTitle = "Base";
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
            "url": "javascript: goBack();void(0);"
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

    function goBack() {
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