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
  Highcharts.chart('analytics', {
      chart: {
          type: 'line'
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

      plotOptions: {
          series: {
              borderWidth: 0,
              dataLabels: {
                  enabled: true
              }
          }
      },

      series: [{
          name: '2010',
          data: [{
              name: 'Republican',
              y: 5,
              drilldown: 'republican-2010'
          }, {
              name: 'Democrats',
              y: 2,
              drilldown: 'democrats-2010'
          }, {
              name: 'Other',
              y: 4,
              drilldown: 'other-2010'
          }]
      }, {
          name: '2014',
          data: [{
              name: 'Republican',
              y: 4,
              drilldown: 'republican-2014'
          }, {
              name: 'Democrats',
              y: 4,
              drilldown: 'democrats-2014'
          }, {
              name: 'Other',
              y: 4,
              drilldown: 'other-2014'
          }]
      }],
      drilldown: {
          series: [{
              id: 'republican-2010',
              data: [
                  ['East', 4],
                  ['West', 2],
                  ['North', 1],
                  ['South', 4]
              ]
          }, {
              id: 'democrats-2010',
              data: [
                  ['East', 6],
                  ['West', 2],
                  ['North', 2],
                  ['South', 4]
              ]
          }, {
              id: 'other-2010',
              data: [
                  ['East', 2],
                  ['West', 7],
                  ['North', 3],
                  ['South', 2]
              ]
          }, {
              id: 'republican-2014',
              data: [
                  ['East', 2],
                  ['West', 4],
                  ['North', 1],
                  ['South', 7]
              ]
          }, {
              id: 'democrats-2014',
              data: [
                  ['East', 4],
                  ['West', 2],
                  ['North', 5],
                  ['South', 3]
              ]
          }, {
              id: 'other-2014',
              data: [
                  ['East', 7],
                  ['West', 8],
                  ['North', 2],
                  ['South', 2]
              ]
          }]
      }
  });
  </script>
@endsection