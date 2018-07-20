@extends('layouts.main')

@section('styling')
<style>
  /** TODO: Push margin more to the right. Make the box centered to the user. **/
  #box-form {
    background-color: #363635;
    margin-top: 20px;
    padding: 40px;
    border-radius: 10px;
  }
  #box-form h1 {
    text-align: center;
    color: white;
  }
  #box-form input {
    color: white;
  }
</style>
@endsection

@section('content')
<?php
    if(isset($data)){
        dd($data);
    }
?>
<div class="ten columns offset-by-one" id="box-form">
   <form method="post" action="{{ route('reports-process') }}">
            {{ csrf_field() }}
            <div class="twelve columns">
                <select name="reportType" id="">
                    <option value="0" selected>Select Report</option>
                    <option value="1">Emissions Report</option>
                    <option value="2">Vehicle Report</option>
                </select>
            </div>
            <div class="twelve column bar">
                <input class="button-primary" type="submit">
            </div>
        </form>
</div>

@endsection
