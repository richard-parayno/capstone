@extends('layouts.main')
@section('styling')
<style>
  /** TODO: Push margin more to the right. Make the box centered to the user. **/
  #box-form {
    margin-top: 20px;
    padding: 40px;
    border-radius: 10px;
  }
  #box-form h1 {
    text-align: center;
    color: black;
  }
  #box-form label {
    color: black;
  }
</style>
@endsection

@section('content')
<div class="eight columns offset-by-two" id="box-form">
  <!-- TODO: Process add-user logic after submitting form. -->
  <h1>Create New User Account</h1>    
  <form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    @if(Session::has('success'))
      <div class="twelve columns" id="success-message" style="color: green;">
          <strong>Success! </strong> {{ Session::get('message', '') }}
      </div>
    @endif
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
      <label for="firstName">First Name</label>
      <input class="u-full-width" type="text" name="firstName" id="firstName" placeholder="Richard Lance" value="{{ old('firstName') }}" required>
      @if ($errors->has('firstName'))
        <span class="help-block">
          <strong>{{ $errors->first('firstName') }}</strong>
        </span>
      @endif
    </div>
    <div class="six columns" style="margin: 0px;">
      <label for="lastName">Last Name</label>
      <input class="u-full-width" type="text" name="lastName" id="lastName" placeholder="Parayno" value="{{ old('lastName') }}" required>
      @if ($errors->has('lastName'))
        <span class="help-block">
          <strong>{{ $errors->first('lastName') }}</strong>
        </span>
      @endif
    </div>
    <div class="twelve columns">
      <label for="userTypeID">Select User Type</label>
      <select class="u-full-width" name="userTypeID" id="userTypeID" style="color: black;">
        @foreach($userTypes as $userType)
          <option value="{{ $userType->userTypeID }}">{{ $userType->userTypeName }}</option>
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

    <!-- hidden input for account status -->
    <input type="hidden" name="status" id="status" value="Active">

    <input class="button-primary u-pull-right" type="submit" value="Add User">
    <!--<input class="button-primary u-pull-left" type="submit" value="Cancel">-->
  </form>
</div>
@endsection