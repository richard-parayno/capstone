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
<div class="twelve columns" id="box-form">
  @if(Session::has('success'))
      <div class="twelve columns" id="success-message" style="color: green; margin-bottom: 20px;">
          <strong>Success! </strong> {{ Session::get('message', '') }}
      </div>
  @endif    
  <br>
  <h1>Manage Vehicles</h1>
  <a href="{{ route('vehicle-add') }}">
    <button class="button-primary u-pull-right">New Vehicle</button>
  </a> <br/>
  <div class="twelve columns" id="vehicle-table"></div> <br>
  <a href="{{ route('vehicle-add') }}">
    <button class="button-primary u-pull-right">New Vehicle</button>
  </a>
</div>

@endsection