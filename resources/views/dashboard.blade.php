@extends('layouts.main')

@section('styling')
<style>
  #trips-overview-div {
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
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script type="text/javascript">
    $(function () { 
    var myChart = Highcharts.chart('analytics', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Analytics'
            },
            xAxis: {
                categories: ["Dec 16", "Jan 17", "Feb 17", "Mar 17", "Apr 17", "May 17", "Jun 17", "Jul 17", "Aug 17", "Sep 17", "Oct 17", "Nov 17", "Dec 17"]
            },
            yAxis: {
                title: {
                    text: 'Tonnes'
                }
            },
            series: [{
                name: 'Carbon Emissions in Tonnes',
                data: [1.5504, 1.1371, 1.2101, 1.701, 1.3407, 1.2123, 1.5433, 1.4343, 1.4566, 1.6876, 1.834, 1.79, 1.3208]
            }, {
                name: 'Analytics Values',
                data: [101.22, 2.66, 11.62, 20.58, 29.54, 38.50, 47.46, 56.42, 65.38, 74.34, 83.30, 92.26, 101.22]
            }, {
                name: 'Carbon Sequestrated in Tonnes',
                data: [120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873]
            }, {
                name: '25% Threshold',
                data: [4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8]
            }]
        });
    });
  </script>
@endsection