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
      <h1>Update Vehicle Status</h1>    
      <form action="{{ route('vehicle-decommission-process') }}">
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
          echo "<p>Car Brand: ".$selectedBrand->carBrandName."</p>";
          echo "<p>Car Type: ".$selectedType->carTypeName."</p>";
          echo "<p>Campus: ".$selectedCampus->institutionName."</p>";
          echo "<p>Fuel Type: ".$selectedFuel->fuelTypeName."</p>";

          echo "<br>";
        @endphp

        @if ($selected->active == 1)
        <p>Are you sure you want to decommission this vehicle?</p>
        @elseif ($selected->active == 0)
        <p>Are you sure you want to make this vehicle active?</p>
        @endif
        <input type="radio" name="choice" value="yes">
        <span class="label-body">Yes</span>
        <br>
        <input type="radio" name="choice" value="no">
        <span class="label-body">No</span>
        <br>
        <a class="button button-primary u-pull-left" onClick="goBack()">Cancel Vehicle Status Update</a>
        <input class="button-primary u-pull-right" type="submit" value="Confirm Vehicle Status Update">
      </form>
    </div>
@endsection