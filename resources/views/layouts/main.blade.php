<!DOCTYPE html>
<html lang="en" >
@php
use Illuminate\Support\Facades\Route;
@endphp

@section('header')
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Carbon Emission Dashboard</title>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/normalize.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/skeleton.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/style-dash.css') }}">
  <link href="{{ URL::asset('/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/css/metisMenu.min.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('/css/sb-admin-2.css') }}" rel="stylesheet">
  <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">
  <link rel="stylesheet" href="https://unpkg.com/react-table@latest/react-table.css">
  <script src="{{ URL::asset('/js/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ URL::asset('/js/metisMenu.min.js') }}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{ URL::asset('/js/raphael.min.js') }}"></script>
<script src="{{ URL::asset('/js/morris.min.js') }}"></script>
<script src="{{ URL::asset('/js/morris-data.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ URL::asset('/js/sb-admin-2.js') }}"></script>
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.js" type="text/javascript"></script>
<link href="https://www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css">
  <script src="http://bernii.github.io/gauge.js/dist/gauge.min.js"></script>  
  

  <script>
    (function(){
      function id(v){ return document.getElementById(v); }
      function loadbar() {
        var ovrl = id("overlay"),
            prog = id("progress"),
            stat = id("progstat"),
            img = document.images,
            c = 0,
            tot = img.length;
        if(tot == 0) return doneLoading();

        function imgLoaded(){
          c += 1;
          var perc = ((100/tot*c) << 0) +"%";
          prog.style.width = perc;
          stat.innerHTML = "Loading "+ perc;
          if(c===tot) return doneLoading();
        }
        function doneLoading(){
          ovrl.style.opacity = 0;
          setTimeout(function(){ 
            ovrl.style.display = "none";
          }, 1200);
        }
        for(var i=0; i<tot; i++) {
          var tImg     = new Image();
          tImg.onload  = imgLoaded;
          tImg.onerror = imgLoaded;
          tImg.src     = img[i].src;
        }    
      }
      document.addEventListener('DOMContentLoaded', loadbar, false);
    }());
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular.min.js" type="text/javascript"></script>
</head>

@section('styling')

@show
<body>
     <?php 
        $noNotifs = false;   
        //notif checker
        {
            $userID = Auth::user()->id;
            $notifications = DB::table('notifications')->whereRaw('toUserID = '.$userID)->get();
            if(count($notifications) > 0){
                $noNotifs = true;   
            }
        }

    ?>
  <div id="outer-container">
    <div id="sidebar"></div>
  @auth
  @section('topbar')
  @if (Route::currentRouteName() != 'analytics-test')
  <style>
      #topbar {
        background-color: black;  
      }

      #analytics-topbar {
        background-color: black;
      }
    </style>
  <div id="topbar">
    <div class="twelve column bar">
      <strong><p style="text-align: center; margin: 0px;">De La Salle Philippines</p></strong>
      <strong><p style="text-align: center; margin: 0px;">Carbon Emission Dashboard</p></strong>
      <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-bell fa-fw"></i> Notifications Panel
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="list-group">
                <a href="#" class="list-group-item">
                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                    <span class="pull-right text-muted small"><em>11:32 AM</em>
                    </span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-warning fa-fw"></i> Server Not Responding
                    <span class="pull-right text-muted small"><em>10:57 AM</em>
                    </span>
                </a>
            </div>
            <!-- /.list-group -->
            <a href="#" class="btn btn-default btn-block">View All Alerts</a>
        </div>
        <!-- /.panel-body -->
    </div>
    </div>
  </div>
  @else
  <div id="analytics-topbar">
    <div class="twelve column bar">
      <strong><p style="text-align: center; margin: 0px;">De La Salle Philippines</p></strong>
      <strong><p style="text-align: center; margin: 0px;">Carbon Emission Dashboard</p></strong>      
    </div>
  </div>
  @endif
  <!-- side nav -->
  @section('sidebar')
  


  @show
  <!-- side nav -->
  @endauth
  
  <!-- main content -->
  <div id="overlay">
    <div id="progstat">Loading page...</div>
    <div id="progress"></div>
  </div>
  <main class="container" id="page-wrap">
    <div>
      @yield('content')

    </div>
  </main>
  <!-- main content -->
    </div>
</body>

@section('scripts')
<script>
window.currentUserID = "<?php echo Auth::user()->id ?>"
</script>
<script>
window.logOut = "{{ route('logout') }}";
window.dashboard = "{{ route('dashboard') }}";
window.reports = "{{ route('reports') }}";
window.tripData = "{{ route('upload-view') }}";
window.wePlantedTrees = "{{ route('tree-view') }}";
window.userManagement = "{{ route('user-view') }}";
window.campusManagement = "{{ route('campus-view') }}";
window.departmentManagement = "{{ route('department-view') }}";
window.vehicleManagement = "{{ route('vehicle-view') }}";

</script>
<script language="javascript/text">
function copyDetails(text, field) {
document.getElementById(field).value = text;
}
</script>
<script>
function goBack() {
window.history.back();
}
</script>
<script>
var $root = $('html, body');
$('a[href^="#"]').click(function () {
$root.animate({
scrollTop: $( $.attr(this, 'href') ).offset().top
}, 800);
return false;
});
</script>
<script src="{{ URL::to('js/app.js') }}"></script>
@show

</html>