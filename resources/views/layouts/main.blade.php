<!DOCTYPE html>
<html lang="en" >
@php
use Illuminate\Support\Facades\Route;

$user = Auth::user();
$userType = DB::table('usertypes_ref')->where('userTypeID', $user->userTypeID)->first();

$mytime = Carbon\Carbon::now();

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
  <link rel="shortcut icon" href="{{ URL::asset('favicon.ico') }}">
  <link rel="stylesheet" href="https://unpkg.com/react-table@latest/react-table.css">
  

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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
  <script src="https://www.amcharts.com/lib/3/serial.js"></script>
  <script src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
  <script src="https://www.amcharts.com/lib/3/plugins/export/export.js" type="text/javascript"></script>
  <link href="https://www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css">
  <script src="http://bernii.github.io/gauge.js/dist/gauge.min.js"></script>  
  
  

</head>

@section('styling')

@show
<body>
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
      <strong><p style="text-align: center; margin: 0px;">De La Salle Philippines Carbon Emission Dashboard</p></strong>     
      <strong><p style="text-align: center; margin: 0px;">@php echo $user->accountName @endphp - @php echo $userType->userTypeName @endphp</p></strong>      
      <strong><p style="text-align: center; margin: 0px;">@php echo $mytime->toDateString(); @endphp</p></strong>      
    </div>
  </div>
  @else
  <div id="analytics-topbar">
    <div class="twelve column bar">
      <strong><p style="text-align: center; margin: 0px;">De La Salle Philippines Carbon Emission Dashboard</p></strong>      
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