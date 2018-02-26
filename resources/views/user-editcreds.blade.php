@extends('layouts.main')
@section('styling')
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
@endsection

@section('content')
<div class="eight columns offset-by-two" id="box-form">
  <!-- TODO: Process edit-user logic after submitting form. -->
  <h1>Change User Credentials</h1>
  <form action="{{ route('user-editcreds-process') }}">
    <div class="twelve columns" style="margin: 0px;">
        <p>Selected User: </p>
        @php
          $currentUser = $_GET['user'];
          
          $userdata = DB::table('users')->where('id', $currentUser)->first();
          $usertype = DB::table('usertypes_ref')->select('userTypeName')->where('userTypeID', $currentUser)->first();

          echo $userdata->accountName." - ".$usertype->userTypeName;
           
          echo ("<input class=\"u-full-width\" type=\"hidden\" name=\"current-user\" id=\"current-user\" value=\"$currentUser\">");
        @endphp
    </div>
    <div class="twelve columns">
      <label for="username">New Username</label>
      <input class="u-full-width" type="text" name="username" id="username" placeholder="richard.parayno">
    </div>
    <div class="twelve columns">
      <label for="username">New E-mail</label>
      <input class="u-full-width" type="email" name="email" id="email" placeholder="richard_parayno@dlsu.edu.ph">
    </div>
    <div class="twelve columns">
      <label for="password">New Password</label>
      <input class="u-full-width" type="password" name="password" id="password" placeholder="Password">
    </div>
    <input class="button-primary u-pull-right" type="submit" value="Update">
    <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>     
  </form>


</div>
@endsection
