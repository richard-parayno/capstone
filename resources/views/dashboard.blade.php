<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Carbon Emission Dashboard</title>
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ url('/css/normalize.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/css/skeleton.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('/css/style-dash.css') }}">
</head>
<body>
  <!-- side nav -->
  <div class="container u-pull-left" id="sidebar">
    <div class="twelve column bar">
      <img src="{{ url('/images/favicon.png') }}" alt="Icon"><a href="{{ route('profile') }}">Richard Parayno</a>
    </div>
    <div class="twelve column bar">
      <img src="{{ url('/images/favicon.png') }}" alt="Icon"><a href="{{ route('emissions') }}">Emissions</a>
    </div>
    <div class="twelve column bar">
      <img src="{{ url('/images/favicon.png') }}" alt="Icon"><a href="{{ route('trips') }}">Trips</a>
    </div>
    <div class="twelve column bar">
      <img src="{{ url('/images/favicon.png') }}" alt="Icon"><a href="{{ route('analytics') }}">Analytics</a>
    </div>
  </div>
  <!-- side nav -->
  <!-- main content -->
  <div class="container" id="main-content">
    <div class="row">
      <div class="seven column" id="trips-overview-div">
        <canvas id="trips-overview"></canvas>
      </div>
    </div>
    <div class="row">
      <div class="seven column">
      </div>
    </div>
  </div>
  <!-- main content -->
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
<script src="{{ url('/js/dashboard-trips.js') }}"></script>
  
</script>
</html>