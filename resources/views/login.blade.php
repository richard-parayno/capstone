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
  <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}">
</head>
<body>
  <div class="row">
    <div class="container">
      <div class="twelve columns">
        <h1 style="text-align: center; color: white; margin-top: 10%;">Carbon Emission Dashboard</h1>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="container">
      <div class="five columns" id="box">
        <form action="/submit">
          <div class="twelve columns">
            <label for="username">Username</label>
            <input class="u-full-width" type="text" name="username" id="username">
          </div>
          <div class="twelve columns">
            <label for="password">Password</label>
            <input class="u-full-width" type="password" name="password" id="password">
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>