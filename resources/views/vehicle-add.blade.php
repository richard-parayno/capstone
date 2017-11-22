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

  #box-form select {
    color: black;
  }
</style>
@endsection

@section('content')
<div class="seven columns" id="box-form">
  <!-- TODO: Process add-user logic after submitting form. -->
  <h1>Add Vehicle</h1>    
  <form method="POST" action="{{ route('vehicle-add-process') }}">
    {{ csrf_field() }}
    @if(Session::has('success'))
    <div class="twelve columns" style="color: green;">
      <strong>Success!</strong> {{ Session::get('message', '') }}
    </div>
    @endif
    <div class="twelve columns">
      <label for="institutionID">Select Campus/Institute</label>
      <select class="u-full-width" name="institutionID" id="institutionID">
      @foreach($institutions as $institution)
        <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
      @endforeach
      </select>
    </div>
    <div class="twelve columns">
      <label for="carTypeID">Select Car Type</label>
      <select class="u-full-width" name="carTypeID" id="carTypeID">
      @foreach($carTypes as $carType)
        <option value="{{ $carType->carTypeID }}">{{ $carType->carTypeName }}</option>
      @endforeach
      </select>
    </div>
    @if ($errors->has('institutionID'))
      <span class="help-block">
        <strong>{{ $errors->first('institutionID') }}</strong>
      </span>
    @endif
    <div class="six columns" style="margin: 0px;">
      <label for="fuelTypeID">Fuel Type</label>
      <select class="u-full-width" name="fuelTypeID" id="fuelTypeID">
      @foreach($fuelTypes as $fuelType)
        <option value="{{ $fuelType->fuelTypeID }}">{{ $fuelType->fuelTypeName }}</option>
      @endforeach
      </select>
    </div>
    @if ($errors->has('fuelTypeID'))
      <span class="help-block">
        <strong>{{ $errors->first('fuelTypeID') }}</strong>
      </span>
    @endif
    <div class="six columns">
      <label for="carBrandID">Vehicle Brand</label>
      <select class="u-full-width" name="carBrandID" id="carBrandID">
      @foreach($brands as $brand)
        <option value="{{ $brand->carBrandID }}">{{ $brand->carBrandName }}</option>
      @endforeach
      </select>
    </div>
    @if ($errors->has('carBrandID'))
      <span class="help-block">
        <strong>{{ $errors->first('carBrandID') }}</strong>
      </span>
    @endif
    <div class="eight columns" style="margin: 0px;">
      <label for="modelName">Model Name</label>
      <input class="u-full-width" type="text" name="modelName" id="modelName" placeholder="L300">
    </div>
    @if ($errors->has('modelName'))
      <span class="help-block">
        <strong>{{ $errors->first('modelName') }}</strong>
      </span>
    @endif
    <div class="eight columns" style="margin: 0px;">
      <label for="plateNumber">Plate Number</label>
      <input class="u-full-width" type="text" name="plateNumber" id="plateNumber" placeholder="ABC-123">
    </div>
    @if ($errors->has('plateNumber'))
      <span class="help-block">
        <strong>{{ $errors->first('plateNumber') }}</strong>
      </span>
    @endif

    @if($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $error)
                <li> {{ $error }} </li>
            @endforeach
        </ul>
    </div> 
    @endif
    <!--
    <div class="four columns">
      <label for="vehicle-year">Manufacturing Year</label>
      <input class="u-full-width" type="number" name="vehicle-year" id="email" placeholder="2017">
    </div> -->
    
    <input class="button-primary u-pull-right" type="submit" value="Add Vehicle">
  </form>
</div>
@endsection