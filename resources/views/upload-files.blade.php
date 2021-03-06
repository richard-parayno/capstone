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

<!--
<div class="eight columns offset-by-two" id="box-form">
  <h1>Upload Trip Data</h1>
  
  <form action="{{ route('pre-process-files') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="excelFile">
    <br>
    <input class="button button-primary u-pull-right" type="submit" value="Submit">
    <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a> 
    
  </form>
</div>
-->
<div id="box-form">
  <h1>Upload Trip Data</h1>
  <div id="excel-upload"></div>
</div>
@endsection

