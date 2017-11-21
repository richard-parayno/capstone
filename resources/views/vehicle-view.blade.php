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
  #box-form table {
    color: white;
  }
  #box-form table th {
    text-align: center;
  }
</style>
@endsection

@section('content')
<div class="twelve columns" id="box-form">
  <h1>View Vehicles</h1>    
  <table class="u-full-width">
    <thead>
      <tr>
        <th>Car Type</th>
        <th>Car Brand</th>
        <th>Car Model</th>
        <th>Plate Number</th>
        <th>Manufacturing Year</th>
        <th>Home Campus/Institute</th>
        <th>Fuel Type</th>
        <th>Status</th>
        <th>Vehicle Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($vehicles as $vehicle)
      <tr>
        @foreach($cartypes as $cartype)
          @if($vehicle->carTypeID == $cartype->carTypeID)
            <td>{{ $cartype->carTypeName }}</td>
          @endif
        @endforeach

        @foreach($brands as $brand)
          @if($vehicle->carBrandID == $brand->carBrandID)
            <td>{{ $brand->carBrandName }}</td>
          @endif
        @endforeach

        <td>{{ $vehicle->modelName }}</td>
        <td>{{ $vehicle->plateNumber }}</td>
        <td>TODO</td>

        @foreach($institutions as $institution)
          @if($vehicle->institutionID == $institution->institutionID)
            <td>{{ $institution->institutionName }}</td>
          @endif
        @endforeach

        @foreach($fueltype as $fuel)
          @if($vehicle->fuelTypeID == $fuel->fuelTypeID)
            <td>{{ $fuel->fuelTypeName }}</td>
          @endif
        @endforeach

        @if($vehicle->active >= 1)
          <td>Active</td>
        @else
          <td>Inactive</td>
        @endif

        <td style="text-align: center;">
          <a href="{{ route('vehicle-editinfo') }}">Edit Vehicle Info</a> <br>
          <a href="{{ route('vehicle-decommission') }}">Decommission Vehicle</a>
        </td>
      </tr>
      @endforeach
    </tbody>
    <!-- action shortcuts -->
    <span>Shortcuts: </span>
    <a href="{{ route('vehicle-add') }}">Add New Vehicle</a>
    <div class="u-pull-right">
      <span>Search Vehicle: </span>
      <input type="text" placeholder="LamborGHini" id="searchBox">
    </div>
    <!-- action shortcuts -->              
  </table>
</div>
@endsection