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
  @auth
  @section('topbar')
  @if (Route::currentRouteName() != 'analytics-test')
  <div id="topbar">
    <div class="twelve column bar">
      <strong><p style="text-align: center; margin: 0px;">De La Salle Philippines</p></strong>
      <strong><p style="text-align: center; margin: 0px;">Carbon Emission Dashboard</p></strong>      
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
  <div class="container u-pull-left" id="sidebar">
    <div class="twelve column bar">
      @php
      $userTypeID = Auth::user()->userTypeID;
      $result = DB::table('usertypes_ref')->select('userTypeName')->where('userTypeID', $userTypeID)->first();
      @endphp
      <div id="current-user">
        <span>{{ Auth::user()->accountName }}</span>
        <br>
        <span>{{ $result->userTypeName }}</span>
        <br>
        <a href="{{ route('logout' )}}">Click Here to Logout</a>
      </div>
    </div>
    @if (Auth::user()->userTypeID == 1) <!-- sysadmin -->
      <style>
        #topbar {
          background-color: black;  
        }

        #analytics-topbar {
          background-color: black;
        }
      </style>

      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('reports') }}">Reports</a></li>                        
            <li><a href="{{ route('upload-view') }}">Trip Data</a></li>
            <li><a href="{{ route('tree-view') }}">We Planted Trees</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Account Management</strong></p>
        <ul>
            <li><a href="{{ route('user-view') }}">User Management</a></li>
            <!--<li><a href="{{ route('user-add') }}">Create New User Account</a></li>
            <li><a href="{{ route('user-editinfo') }}">Edit User Account Information</a></li>
            <li><a href="{{ route('user-editcreds') }}">Edit User Account Credentials</a></li>-->
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Campus Information Management</strong></p>
        <ul>
            <li><a href="{{ route('campus-view') }}">Campus Management</a></li>
            <!--<li><a href="{{ route('campus-add') }}">Add New Campus/Institute</a></li>
            <li><a href="{{ route('campus-editinfo') }}">Edit Campus/Institute Info</a></li>-->
            <li><a href="{{ route('department-view') }}">Department Management</a></li>
            <!--<li><a href="{{ route('department-add') }}">Add New Department/Offices</a></li>
            <li><a href="{{ route('department-editinfo') }}">Edit Department/Offices Info</a></li>-->       
            <li><a href="{{ route('vehicle-view') }}">Vehicle Management</a></li>
            <!--<li><a href="{{ route('vehicle-add') }}">Add New Vehicle</a></li>
            <li><a href="{{ route('vehicle-editinfo') }}">Edit Vehicle Info</a></li>
            <li><a href="{{ route('vehicle-decommission') }}">Decommission Vehicle</a></li>-->
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 2) <!-- life -->
      <style>
        #topbar {
          background-color: #087830;  
        }

        #analytics-topbar {
          background-color: #087830;
        }
      </style>

      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('reports') }}">Reports</a></li>                                    
            <li><a href="{{ route('upload-view') }}">Trip Data</a></li>
            <li><a href="{{ route('tree-view') }}">We Planted Trees</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Account Management</strong></p>
        <ul>
            <li><a href="{{ route('user-view') }}">User Management</a></li>
            
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Campus Information Management</strong></p>
        <ul>
            <li><a href="{{ route('campus-view') }}">Campus Management</a></li>
            <li><a href="{{ route('department-view') }}">Department Management</a></li>
            <li><a href="{{ route('vehicle-view') }}">Vehicle Management</a></li>

        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 3) <!-- champion -->
      <style>
        #topbar {
          background-color: #2222ab;    
        }
        #analytics-topbar {
          background-color: #2222ab;
        }
      </style>
      <div class="twelve column bar">
        <!-- add view trees planted -->
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('reports') }}">Reports</a></li>                                    
            <li><a href="{{ route('upload-view') }}">Trip Data</a></li>
            <li><a href="{{ route('tree-view') }}">We Planted Trees</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 4) <!-- dispatching -->
      <style>
        #topbar {
          background-color: #b4b050;  
        }
        #analytics-topbar {
          background-color: #b4b050;
        }
      </style>
      <div class="twelve column bar">
        <!-- add view trees planted -->
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('upload-view') }}">Trip Data</a></li>
            <li><a href="{{ route('tree-view') }}">We Planted Trees</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 5) <!-- social action -->
      <style>
        #topbar {
          background-color: #800000;  
        }
        #analytics-topbar {
          background-color: #800000;
        }
      </style>
      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('reports') }}">Reports</a></li>                                            
            <li><a href="{{ route('upload-view') }}">Trip Data</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <!-- add view trips -->
        <p><strong>Campus Information Management</strong></p>
        <ul>
            <li><a href="{{ route('vehicle-view') }}">Vehicle Management</a></li>
        </ul>
      </div> 
    @endif
  </div>


  @show
  <!-- side nav -->
  @endauth
  
  <!-- main content -->
  <div id="overlay">
    <div id="progstat">Loading page...</div>
    <div id="progress"></div>
  </div>
  <div class="container" id="main-content">
    @yield('content')
  </div>
  <!-- main content -->
</body>

@section('scripts')
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