@extends('layouts.main')

@section('styling')
<style>
  /** TODO: Push margin more to the right. Make the box centered to the user. **/
  #box-form {
    margin-top: 20px;
    padding: 40px;
    
  }
  #box-form h1 {
    text-align: center;
    color: black;
  }
  #box-form table {
    color: black;
  }
  #box-form table th {
    text-align: center;
  }
</style>
@endsection

@section('content')
<div class="twelve columns" id="box-form">
  <h1>Manage Users</h1>
  <a href="{{ route('user-add') }}">
    <button class="button-primary u-pull-right">Create User Account</button>
  </a> <br/>
  <div class="twelve columns" id="user-table"></div>
  <br>
  <a href="{{ route('user-add') }}">
    <button class="button-primary u-pull-right">Create User Account</button>
  </a>
</div>
@endsection