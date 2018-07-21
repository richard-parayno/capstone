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
<div class="eight columns offset-by-two" id="box-form">
    <h1>We Planted Trees</h1>
    <a href="{{ route('tree-plant') }}">
      <button class="button-primary u-pull-right">New Tree Plant</button>
    </a>
    <div class="twelve columns" id="tree-table"></div>
    <a href="{{ route('tree-plant') }}">
      <button class="button-primary u-pull-right">New Tree Plant</button>
    </a>
</div>

@endsection

