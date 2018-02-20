@extends('layouts.main')


@section('styling')
<style>
  #analytics {
    margin-top: 30px;
    background: #363635;
    box-shadow: 5px 10px 20px 0 rgba(0,0,0,0.20);  
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="seven column" id="analytics">

  </div>
</div>
<div class="row">
  <div class="seven column">
  </div>
</div>
@endsection

@section('scripts')
  <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>
  <script src="{{ asset('/js/highcharts/code/highcharts.js') }}"></script>
  <script src="{{ asset('/js/highcharts/code/modules/drilldown.js') }}"></script>
  <script src="{{ asset('/js/highcharts/code/modules/exporting.js') }}"></script>
  <script type="text/javascript"> 
  // Create the chart
  $(function () {
      $('#analytics').highcharts({
        chart: {
          type: 'line',
          events: {
            drilldown: function (e) {
              if (!e.seriesOptions) {
                var chart = this,
                  drilldowns = {
                    'December 2017': {
                        name: 'Trips',
                        data: [
                            ['Cows', 10],
                            ['Sheep', 20]
                        ],
                    },
                    'December 2017-2': {
                        name: 'Cars',
                        colors: Highcharts.getOptions().colors[1],
                        data: [
                            ['Apples', 15],
                            ['Oranges', 25],
                            ['Bananas', 30]
                        ],
                        drilldown: true
                    },
                    'January 2018': {
                        name: 'Trips',
                        data: [
                            ['Cows', 2],
                            ['Sheep', 3]
                        ]
                    },
                    'January 2018-2': {
                        name: 'Cars',
                        data: [
                            ['Apples', 5],
                            ['Oranges', 7],
                            ['Bananas', 2]
                        ]
                    },
                    'February 2018': {
                        name: 'Trips',
                        data: [
                            ['Cows', 2],
                            ['Sheep', 3]
                        ]
                    },
                    'February 2018-2': {
                        name: 'Cars',
                        data: [
                            ['Apples', 5],
                            ['Oranges', 7],
                            ['Bananas', 2]
                        ]
                    }
                  },
                  series = [drilldowns[e.point.name], drilldowns[e.point.name + '-2']];
                  chart.addSingleSeriesAsDrilldown(e.point, series[0]);
                  chart.addSingleSeriesAsDrilldown(e.point, series[1]);
                  chart.applyDrilldown();
              }
            }
          }
        },
        title: {
            text: 'Analytics'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
              text: 'Tonnes'
            }
        },

        legend: {
            enabled: true
        },

        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true
                }
            }
        },

        exporting: {
            chartOptions: { // specific options for the exported image
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                }
            },
            fallbackToExportServer: false
        },

        series: [{
            name: 'Carbon Emissions in Tonnes',
            data: [{
              name: 'December 2017',
              y: 1.5504,
              drilldown: true
            }, {
              name: 'January 2018',
              y: 1.1371,
              drilldown: true
            }, {
              name: 'February 2018',
              y: 1.2101,
              drilldown: true                  
            }]
        }, {
          name: 'Analytics Values',
          data: [{
              name: 'December 2017',
              y: 101.22,
            }, {
              name: 'January 2018',
              y: 2.66,
            }, {
              name: 'February 2018',
              y: 11.62,
            }]
        }, {
          name: 'Carbon Sequestrated in Tonnes',
          data: [{
              name: 'December 2017',
              y: 120.958873
            }, {
              name: 'January 2018',
              y: 120.958873
            }, {
              name: 'February 2018',
              y: 120.958873
            }]
        }, {
          name: 'Threshold (25%)',
          data: [{
              name: 'December 2017',
              y: 4.8
            }, {
              name: 'January 2018',
              y: 4.8
            }, {
              name: 'February 2018',
              y: 4.8
            }]
        }],

        drilldown: {
            series: []
        }
      });
    });
  </script>
@endsection