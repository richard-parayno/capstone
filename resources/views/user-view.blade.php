@extends('layouts.main')

@section('styling')
<style>
  /** TODO: Push margin more to the right. Make the box centered to the user. **/
  #box-form {
    background-color: #0b5023;
    margin-top: 20px;
    padding: 40px;
    border-radius: 10px;
  }
  #box-form h1 {
    text-align: center;
    color: white;
  }
  #box-form table {
    color: white;
  }
  #box-form table th {
    text-align: center;
  }
</style>
@endsection

@section('content')
<div class="ten columns offset-by-one" id="box-form">
  <h1>View Users</h1>    
  <table class="u-full-width">
    <thead>
      <tr>
        <th>User Type</th>
        <th>Account Name</th>
        <th>Username</th>
        <th>E-mail</th>
        <th>Account Status</th>
        <th>Account Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        @foreach($userTypes as $userType)
          @if($user->userTypeID == $userType->userTypeID)
            <td>{{ $userType->userTypeName }}</td>
          @endif
        @endforeach
        <td>{{ $user->accountName }}</td>
        <td>{{ $user->username }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->status }}</td>
        <td style="text-align: center;">
          <a href="{{ route('user-editinfo', array('user' => $user->userTypeID, 'name' => $user->accountName)) }}">Edit User Info</a>
          <br>
          <a href="{{ route('user-editcreds', array('user' => $user->userTypeID, 'name' => $user->accountName)) }}">Update Account Credentials</a>
        </td>
      </tr>
      @endforeach
    </tbody>
    <!-- action shortcuts -->
    <span>Shortcuts: </span>
    <a href="{{ route('user-add') }}">Create User Account</a>
    <div class="u-pull-right">
      <span>Search User: </span>
      <input type="text" placeholder="Richard Parayno" id="searchBox">
    </div>
    <!-- action shortcuts -->              
  </table>
</div>
@endsection