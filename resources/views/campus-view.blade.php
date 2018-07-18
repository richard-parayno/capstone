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
  <div id="campus-table-dom"></div>
  <br>
  <a href="{{ route('campus-add') }}">
    <button class="button-primary u-pull-right">New Campus</button>
  </a>
</div>
@endsection