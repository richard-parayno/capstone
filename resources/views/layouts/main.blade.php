<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Carbon Emission Dashboard</title>
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/skeleton.css">
  <link rel="stylesheet" type="text/css" href="../css/style-dash.css">
</head>
@section('styling')

@show
<body>
  <!-- side nav -->
  @section('sidebar')
    <div class="container u-pull-left" id="sidebar">
      <div class="twelve column bar">
        <strong><p style="text-align: center; margin: 0px;">Carbon Emission Dashboard</p></strong>
      </div>

      <div class="twelve column bar">
        <span><strong>Current User:</strong></span>
        @php
        $userTypeID = Auth::user()->userTypeID;
        $result = DB::table('usertypes_ref')->select('userTypeName')->where('userTypeID', $userTypeID)->first();
        @endphp
        <p>{{ $result->userTypeName }} - {{ Auth::user()->accountName }}</p>
      </div>
      <div class="twelve column bar">
        <span><strong>Home</strong></span>
        <ul>
          <li>Dashboard</li>
          <ul>
            <li><a href="{{ route('dashboard') }}">View Dashboard</a></li>
          </ul>
        </ul>
      </div>
      <div class="twelve column bar">
        <span><strong>Account Management</strong></span>
        <ul>
          <li>User Accounts</li>
          <ul>
            <li><a href="{{ route('user-view') }}">View Users</a></li>
            <li><a href="{{ route('user-add') }}">Create New User Account</a></li>
            <li><a href="{{ route('user-editinfo') }}">Edit User Account Information</a></li>
            <li><a href="{{ route('user-editcreds') }}">Edit User Account Credentials</a></li>
          </ul>
        </ul>
      </div>
      <div class="twelve column bar">
        <span><strong>Campus Information Management</strong></span>
        <ul>
          <li>Campuses/Institutes</li>
          <ul>
            <li><a href="{{ route('campus-view') }}">View Campuses/Institutes</a></li>
            <li><a href="{{ route('campus-add') }}">Add New Campus/Institute</a></li>
            <li><a href="{{ route('campus-editinfo') }}">Edit Campus/Institute Info</a></li>
          </ul>
          <li>Department/Offices</li>
          <ul>
            <li><a href="{{ route('department-view') }}">View Departments/Offices</a></li>
            <li><a href="{{ route('department-add') }}">Add New Department/Offices</a></li>
            <li><a href="{{ route('department-editinfo') }}">Edit Department/Offices Info</a></li>          
          </ul>
          <li>Vehicles</li>
          <ul>
            <li><a href="{{ route('vehicle-view') }}">View Vehicles</a></li>
            <li><a href="{{ route('vehicle-add') }}">Add New Vehicle</a></li>
            <li><a href="{{ route('vehicle-editinfo') }}">Edit Vehicle Info</a></li>
            <li><a href="{{ route('vehicle-decommission') }}">Decommission Vehicle</a></li>
          </ul>
        </ul>
      </div>
    </div>
  @show
  <!-- side nav -->
  <!-- main content -->
  <div class="container" id="main-content">
    @yield('content')
  </div>
  <!-- main content -->
</body>

@section('scripts')

@show

</html>