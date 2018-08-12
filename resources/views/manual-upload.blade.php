@extends('layouts.main')

@section('styling')
<style>
  #box-form {
    margin-top: 20px;
    padding: 40px;
  }
  #box-form h1 {
    text-align: center;
    color: black;
  }
  #box-form label {
    color: black;
  }

  #box-form select {
    color: black;
  }
</style>
@endsection

@section('content')
<div class="eight columns offset-by-two" id="box-form">
  <div id="trip-data">
    <h1>Manual Trip Data Upload</h1>
    @if(Session::has('success'))
      <div class="twelve columns" id="success-message" style="color: green; margin-bottom: 20px;">
          <strong>Success! </strong> {{ Session::get('message', '') }}
      </div>
    @endif 
    <form method="post" action="{{ route('manual-upload-process') }}">
      {{ csrf_field() }}
      <div class="six columns" style="margin-left: 0px;">
        <label for="tripDate">Trip Date:</label>
        <input class="u-full-width" type="date" name="tripDate" id="tripDate">
      </div>
      <div class="six columns">
        <label for="tripTime">Trip Time:</label>      
        <input class="u-full-width" type="time" name="tripTime" id="tripTime">
      </div>
      <div class="twelve columns">
        <label for="deptID">Requesting Department:</label>      
        <select class="u-full-width" name="deptID" id="deptID" style="color: black;">
            @foreach($departments as $dept)
              <option value="{{ $dept->deptID }}">{{ $dept->deptName }}</option>
            @endforeach
        </select>
      </div>
      <div class="six columns" style="margin-left: 0px;">
        <label for="plateNumber">Plate Number:</label> 
        <input class="u-full-width" type="text" name="plateNumber" id="plateNumber">
      </div>
      <div class="six columns">
        <label for="kilometerReading">Kilometer Reading:</label>
        <input class="u-full-width" type="number" name="kilometerReading" id="kilometerReading">
      </div>
      <div class="twelve columns">
        <label for="remarks">Destinations:</label>
        <input class="u-full-width" type="text" name="remarks" id="remarks">
      </div>
      <div class="twelve columns">
        <input class="button button-primary u-pull-right" type="submit" value="Confirm Manual Trip Data Upload" style="color: white;">
        <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>  
      </div>
    </form>
  </div>
</div>


<div class="eight columns offset-by-two" id="box-form">
  <div id="vehicle-active-table"></div>
  
</div>

@endsection

