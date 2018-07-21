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
  #box-form table {
    color: black;
  }
  #box-form table th {
    text-align: center;
  }
</style>
@endsection

@section('content')
<div class="ten columns offset-by-one" id="box-form">  
  <h1>Manage Departments</h1>
  <a href="{{ route('department-add') }}">
    <button class="button-primary u-pull-right">New Department</button>
  </a> <br/>
  <div class="twelve columns" id="department-table"></div><br>
  <a href="{{ route('department-add') }}">
    <button class="button-primary u-pull-right">New Department</button>
  </a>
</div>
@endsection