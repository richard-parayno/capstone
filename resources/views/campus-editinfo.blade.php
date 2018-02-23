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
<div class="eight columns offset-by-two" id="box-form">
  <!-- TODO: Process add-campus logic after submitting form. -->
  <h1>Edit Campus/Institute Info</h1>    
  <form action="/add-campus">
    <label>
      <label>Campus or Institute?</label>
      <input type="radio" name="ci-type" id="type-campus" value="Campus">
      <span class="label-body">Campus</span>
      <br>
      <input type="radio" name="ci-type" id="type-institute" value="Institute">
      <span class="label-body">Institute</span>
    </label>
    <div class="twelve columns">
      <label for="ci-name">Campus/Institute Name</label>
      <input class="u-full-width" type="text" name="ci-name" id="ci-name" placeholder="La Salle Greenhills">
    </div>
    <div class="twelve columns">
      <label for="ci-location">Location</label>
      <input class="u-full-width" type="text" name="ci-location" id="email" placeholder="GH pare">
    </div>
    <input class="button-primary u-pull-right" type="submit" value="Edit Campus/Institute Info">
  </form>
</div>
@endsection