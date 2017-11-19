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
      border-radius: 10px;
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
    <div class="eight columns" id="box-form">
      <!-- TODO: Process add-user logic after submitting form. -->
      <h1>Create New User Account</h1>    
      <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="twelve columns">
          <label for="username">Username</label>
          <input class="u-full-width" type="text" name="username" id="username" placeholder="richard.parayno" value="{{ old('username') }}" required>

          @if ($errors->has('username'))
            <span class="help-block">
              <strong>{{ $errors->first('username') }}</strong>
            </span>
          @endif

        </div>
        <div class="twelve columns">
          <label for="email">E-mail</label>
          <input class="u-full-width" type="email" name="email" id="email" placeholder="richard_parayno@dlsu.edu.ph" value="{{ old('email') }}" required>

          @if ($errors->has('email'))
            <span class="help-block">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @endif

        </div>
        <div class="six columns" style="margin: 0px;">
          <label for="accountName">Full Name</label>
          <input class="u-full-width" type="text" name="accountName" id="accountName" placeholder="Richard Lance Parayno" value="{{ old('accountName') }}" required>

          @if ($errors->has('accountName'))
            <span class="help-block">
              <strong>{{ $errors->first('accountName') }}</strong>
            </span>
          @endif

        </div>
        <div class="twelve columns">
          <label for="userTypeID">Select User Type</label>
          <select class="u-full-width" name="userTypeID" id="userTypeID" style="color: black;">
            @foreach($userTypes as $userType)
              <option value="{{ (int)$userType->userTypeID }}">{{ $userType->userTypeName }}</option>
            @endforeach
          </select>

          @if ($errors->has('userTypeID'))
            <span class="help-block">
              <strong>{{ $errors->first('userTypeID') }}</strong>
            </span>
          @endif

        </div>
        <div class="twelve columns">
          <label for="password">Password</label>
          <input class="u-full-width" type="password" name="password" id="password" placeholder="Password" value="{{ old('password') }}" required>

          @if ($errors->has('password'))
            <span class="help-block">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
          @endif

        </div>

        <div class="twelve columns">
          <label for="password">Confirm Password</label>
          <input class="u-full-width" type="password" name="password_confirmation" id="password-confirm" placeholder="Password" required>
        </div>


        @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
        @endif

        <input class="button-primary u-pull-right" type="submit" value="Add User">
        <!--<input class="button-primary u-pull-left" type="submit" value="Cancel">-->
      </form>
    </div>
  </div>
  <!-- main content -->
</body>


  
</html>