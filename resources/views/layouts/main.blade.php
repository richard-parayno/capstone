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
      <span>{{ Auth::user()->accountName }}</span>
      <br>
      <span>{{ $result->userTypeName }}</span>
      <br>
      <a href="{{ route('logout' )}}">Click Here to Logout</a>
    </div>
    @if (Auth::user()->userTypeID == 1) <!-- sysadmin -->
      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">View Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Excel File</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Account Management</strong></p>
        <ul>
            <li><a href="{{ route('user-view') }}">View Users</a></li>
            <li><a href="{{ route('user-add') }}">Create New User Account</a></li>
            <li><a href="{{ route('user-editinfo') }}">Edit User Account Information</a></li>
            <li><a href="{{ route('user-editcreds') }}">Edit User Account Credentials</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Campus Information Management</strong></p>
        <ul>
            <li><a href="{{ route('campus-view') }}">View Campuses/Institutes</a></li>
            <li><a href="{{ route('campus-add') }}">Add New Campus/Institute</a></li>
            <li><a href="{{ route('campus-editinfo') }}">Edit Campus/Institute Info</a></li>
            <li><a href="{{ route('department-view') }}">View Departments/Offices</a></li>
            <li><a href="{{ route('department-add') }}">Add New Department/Offices</a></li>
            <li><a href="{{ route('department-editinfo') }}">Edit Department/Offices Info</a></li>          
            <li><a href="{{ route('vehicle-view') }}">View Vehicles</a></li>
            <li><a href="{{ route('vehicle-add') }}">Add New Vehicle</a></li>
            <li><a href="{{ route('vehicle-editinfo') }}">Edit Vehicle Info</a></li>
            <li><a href="{{ route('vehicle-decommission') }}">Decommission Vehicle</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 2) <!-- life -->
      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">View Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Excel File</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Account Management</strong></p>
        <ul>
            <li><a href="{{ route('user-view') }}">View Users</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <p><strong>Campus Information Management</strong></p>
        <ul>
            <li><a href="{{ route('campus-view') }}">View Campuses/Institutes</a></li>
            <li><a href="{{ route('department-view') }}">View Departments/Offices</a></li>       
            <li><a href="{{ route('vehicle-view') }}">View Vehicles</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 3) <!-- social action -->
      <div class="twelve column bar">
        <!-- add view trees planted -->
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">View Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Excel File</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 4) <!-- champions -->
      <div class="twelve column bar">
        <!-- add view trees planted -->
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('dashboard') }}">View Dashboard</a></li>
            <li><a href="{{ route('upload-files') }}">Upload Excel File</a></li>
            <li><a href="{{ route('tree-plant') }}">We Planted Trees</a></li>
        </ul>
      </div>
    @elseif(Auth::user()->userTypeID == 5) <!-- dispatch -->
      <div class="twelve column bar">
        <p><strong>Home</strong></p>
        <ul>
            <li><a href="{{ route('upload-files') }}">Upload Excel File</a></li>
        </ul>
      </div>
      <div class="twelve column bar">
        <!-- add view trips -->
        <p><strong>Campus Information Management</strong></p>
        <ul>
            <li><a href="{{ route('vehicle-view') }}">View Vehicles</a></li>
            <li><a href="{{ route('vehicle-add') }}">Add New Vehicle</a></li>
            <li><a href="{{ route('vehicle-editinfo') }}">Edit Vehicle Info</a></li>
            <li><a href="{{ route('vehicle-decommission') }}">Decommission Vehicle</a></li>
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

@show

</html>