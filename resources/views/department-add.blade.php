@extends('layouts.main')

@section('styling')
<style>
  /** TODO: Push margin more to the right. Make the box centered to the user. **/
  #box-form {
    background-color: #363635;
    margin-top: 20px;
    padding: 40px;
    box-shadow: 5px 10px 20px 0 rgba(0,0,0,0.20);
    border-radius: 20px;
  }
  #box-form h1 {
    text-align: center;
    color: white;
  }
  #box-form label {
    color: white;
  }
</style>
@endsection

@section('content')
<div class="eight columns" id="box-form">
  <!-- TODO: Process add-user logic after submitting form. -->
  <h1>Add Department/Offices</h1>    
  <form action="/add-department">
    <div class="twelve columns">
      <label for="find-campus">Select Campus/Institute</label>
      <select class="u-full-width" id="find-campus"></select>
    </div>
    <div class="twelve columns">
      <label for="department-name">Department Name</label>
      <input class="u-full-width" type="text" name="department-name" id="username" placeholder="College of Computer Studies">
    </div>
    <input class="button-primary u-pull-right" type="submit" value="Add Department/Offices">
  </form>
</div>
@endsection