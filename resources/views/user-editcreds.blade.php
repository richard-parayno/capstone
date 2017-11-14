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
    <div class="nine columns" id="box-form">
      <!-- TODO: Process edit-user logic after submitting form. -->
      <h1>Edit User Account Credentials</h1>

      <form action="/edit-user">
        <div class="twelve columns">
          <label for="username">Username</label>
          <input class="u-full-width" type="text" name="username" id="username" placeholder="richard.parayno">
        </div>
        <div class="twelve columns">
          <label for="username">E-mail</label>
          <input class="u-full-width" type="email" name="email" id="email" placeholder="richard_parayno@dlsu.edu.ph">
        </div>
        <div class="twelve columns">
          <label for="password">Password</label>
          <input class="u-full-width" type="password" name="password" id="password" placeholder="Password">
        </div>
        <input class="button-primary u-pull-right" type="submit" value="Update">
        <input class="button-primary u-pull-left" type="submit" value="Cancel">      
      </form>
    </div>
  </div>
  <!-- main content -->
</body>
  
</script>
</html>