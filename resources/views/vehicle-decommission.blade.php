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
      <!-- TODO: Process add-user logic after submitting form. -->
      <h1>Decommission Vehicle</h1>    
      <form action="/decommission-vehicle">
        <div class="twelve columns">
          <label for="vehicle-campus">Select Campus/Institute</label>
          <select class="u-full-width" id="vehicle-campus"></select>
        </div>
        <div class="twelve columns">
          <label for="vehicle-brand">Vehicle Brand</label>
          <select class="u-full-width" id="vehicle-brand"></select>
        </div>
        <div class="eight columns" style="margin: 0px;">
          <label for="vehicle-model">Model Name</label>
          <input class="u-full-width" type="text" name="vehicle-model" id="vehicle-model" placeholder="L300">
        </div>
        <div class="four columns">
          <label for="vehicle-year">Manufacturing Year</label>
          <input class="u-full-width" type="number" name="vehicle-year" id="email" placeholder="2017">
        </div>
        <input class="button-primary u-pull-right" type="submit" value="Decommission Vehicle">
      </form>
    </div>
@endsection