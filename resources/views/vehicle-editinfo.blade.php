@extends('layouts.main')

@section('styling')
  <style>
    /** TODO: Push margin more to the right. Make the box centered to the user. **/
    #box-form {
      margin-top: 20px;
      padding: 40px;
      box-shadow: 5px 10px 20px 0 rgba(0,0,0,0.20);
      border-radius: 20px;
    }

    #box-form h1 {
      text-align: center;
      color: black;
    }

    #box-form label {
      color: black;
    }

  </style>
@endsection

@section('content')
    <div class="eight columns offset-by-two" id="box-form">
      <h1>Update Vehicle Info</h1>    
      <form action="{{ route('vehicle-editinfo-process' )}}">
        @php
          use App\Models\CarbrandRef;
          use App\Models\CartypeRef;
          use App\Models\Institution;
          use App\Models\FueltypeRef;
          use App\Models\VehiclesMv;

          $currentVehicle = $_GET['vehicle'];
          echo ("<input class=\"u-full-width\" type=\"hidden\" name=\"vehicle-current\" id=\"vehicle-current\" value=\"$currentVehicle\">");

          $selected = VehiclesMv::find($currentVehicle);
          $selectedBrand = CarbrandRef::find($selected->carBrandID);
          $selectedType = CartypeRef::find($selected->carTypeID);
          $selectedCampus = Institution::find($selected->institutionID);
          $selectedFuel = FueltypeRef::find($selected->fuelTypeID);

          $brands = CarbrandRef::all();
          $cartypes = CartypeRef::all();
          $campuses = Institution::all();
          $fueltypes = FueltypeRef::all();

          echo "<p>Selected Vehicle's Plate Number: ".$currentVehicle."</p>";
          echo "<p>Car Model: ".$selected->modelName."</p>";
          echo "<p>Car Brand: ".$selectedBrand->carBrandName."</p>";
          echo "<p>Car Type: ".$selectedType->carTypeName."</p>";
          echo "<p>Campus: ".$selectedCampus->institutionName."</p>";
          echo "<p>Fuel Type: ".$selectedFuel->fuelTypeName."</p>";

          echo "<br>";
        @endphp

        <div class="twelve columns">
          <label for="vehicle-campus">Update Campus</label>
          <select class="u-full-width" name="vehicle-campus" id="vehicle-campus" style="color: black;">
            @foreach($campuses as $campus)
              <option value="{{ $campus->institutionID }}">{{ $campus->institutionName }}</option>
            @endforeach
          </select>
        </div>
        <div class="twelve columns">
          <label for="vehicle-brand">Update Vehicle Brand</label>
          <select class="u-full-width" name="vehicle-brand" id="vehicle-brand" style="color: black;">
            @foreach($brands as $brand)
              <option value="{{ $brand->carBrandID }}">{{ $brand->carBrandName }}</option>
            @endforeach
          </select>
        </div>
        <div class="twelve columns">
          <label for="vehicle-type">Update Vehicle Type</label>
          <select class="u-full-width" name="vehicle-type" id="vehicle-type" style="color: black;">
              @foreach($cartypes as $cartype)
              <option value="{{ $cartype->carTypeID }}">{{ $cartype->carTypeName }}</option>
            @endforeach
          </select>
        </div>
        <div class="twelve columns">
          <label for="vehicle-fuel">Update Fuel Type</label>
          <select class="u-full-width" name="vehicle-fuel" id="vehicle-fuel" style="color: black;">
              @foreach($fueltypes as $fueltype)
              <option value="{{ $fueltype->fuelTypeID }}">{{ $fueltype->fuelTypeName }}</option>
            @endforeach
          </select>
        </div>
        <div class="twelve columns" style="margin: 0px;">
          <label for="vehicle-model">Update Model Name</label>
          <input class="u-full-width" type="text" name="vehicle-model" id="vehicle-model" placeholder="L300">
        </div>
        <div class="six columns" style="margin: 0px;">
          <label for="vehicle-plate">Update Plate Number</label>
          <input class="u-full-width" type="text" name="vehicle-plate" id="vehicle-plate" placeholder="ABC123" maxlength="6">
        </div>
        <div class="six columns">
          <label for="vehicle-year">Update Manufacturing Year</label>
          <input class="u-full-width" type="number" name="vehicle-year" id="email" placeholder="2017">
        </div>
        
        
        <input class="button-primary u-pull-right" type="submit" value="Update Vehicle" style="color: white;">
        <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>
        
      </form>
    </div>
@endsection