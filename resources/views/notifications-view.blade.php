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
  #box-form input {
    color: black;
  }
</style>
@endsection

@section('content')
<div class="twelve columns" id="box-form">
      <h1>View All Notifications</h1>
      <div id="notifications-all"></div>
</div>

@endsection

