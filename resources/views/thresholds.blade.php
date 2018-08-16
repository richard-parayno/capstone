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
  <h1>Manage Thresholds</h1>
  <br/>
  <div class="twelve columns" id="threshold-control"></div>
  
</div>
@endsection