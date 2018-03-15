<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Carbon Emission Dashboard</title>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/normalize.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/skeleton.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/style-dash.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/js-datepicker/datepicker.css">
  <script src="https://unpkg.com/js-datepicker"></script>
</head>
@section('styling')

@show
<body>
  @auth
  @section('topbar')
  <div id="topbar">
    <div class="twelve column bar">
      <strong><p style="text-align: center; margin: 0px;">De La Salle Philippines</p></strong>
      <strong><p style="text-align: center; margin: 0px;">Carbon Emission Dashboard</p></strong>      
    </div>

  </div>
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
      </style>

      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Analytics Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Trip Data</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
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
      </style>

      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Analytics Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Trip Data</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
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
      </style>
      <div class="twelve column bar">
        <!-- add view trees planted -->
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Analytics Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Trip Data</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 4) <!-- dispatching -->
      <style>
        #topbar {
          background-color: #b4b050;  
        }
      </style>
      <div class="twelve column bar">
        <!-- add view trees planted -->
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">Analytics Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Trip Data</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 5) <!-- social action -->
      <style>
        #topbar {
          background-color: #800000;  
        }
      </style>
      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('upload-files') }}">Upload Trip Data</a></li>
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
  <div class="container" id="main-content">
    @yield('content')
  </div>
  <!-- main content -->
</body>

@section('scripts')
<script>
  function goBack() {
    window.history.back();
  }
  </script>
@show

</html>