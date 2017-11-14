<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Carbon Emission Dashboard</title>
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../css/skeleton.css">
  <link rel="stylesheet" type="text/css" href="../css/style-dash.css">
  <style>
    /** TODO: Push margin more to the right. Make the box centered to the user. **/
    #box-form {
      background-color: #363635;
      margin-top: 20px;
      padding: 40px;
      box-shadow: 5px 10px 20px 0 rgba(0,0,0,0.20);
      border-radius: 20px;
    }

    #box-form h1 {
      text-align: center;
      color: white;
    }

    #box-form label {
      color: white;
    }

  </style>
</head>
<body>
  <!-- side nav -->
  <div class="container u-pull-left" id="sidebar">
    <div class="twelve column bar">
      <strong><p style="text-align: center; margin: 0px;">Carbon Emission Dashboard</p></strong>
    </div>

    <div class="twelve column bar">
      <span><strong>Current User:</strong></span>
      <p>Systems Administrator</p>
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
  <!-- side nav -->
  <!-- main content -->
  <div class="container" id="main-content">
    <div class="seven columns" id="box-form">
      <!-- TODO: Process add-user logic after submitting form. -->
      <h1>Add Vehicle</h1>    
      <form action="/add-vehicle">
        <div class="twelve columns">
          <label for="vehicle-campus">Select Campus/Institute</label>
          <select class="u-full-width" id="vehicle-campus"></select>
        </div>
        <div class="six columns" style="margin: 0px;">
          <label for="vehicle-fuel">Fuel Type</label>
          <select class="u-full-width" id="vehicle-fuel"></select>
        </div>
        <div class="six columns">
          <label for="vehicle-brand">Vehicle Brand</label>
          <select class="u-full-width" id="vehicle-brand"></select>
        </div>
        <div class="eight columns" style="margin: 0px;">
          <label for="vehicle-model">Model Name</label>
          <input class="u-full-width" type="text" name="vehicle-model" id="vehicle-model" placeholder="L300">
        </div>
        <div class="four columns">
          <label for="vehicle-year">Manufacturing Year</label>
          <input class="u-full-width" type="number" name="vehicle-year" id="email" placeholder="2017">
        </div>
        <input class="button-primary u-pull-right" type="submit" value="Add Vehicle">
      </form>
    </div>
  </div>
  <!-- main content -->
</body>

</html>