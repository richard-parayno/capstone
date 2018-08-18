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
<?php
    $userType = Auth::user()->userTypeID;
    if($userType > 2){
        $institutionID = Auth::user()->institutionID;
    }
?>
<div class="eight columns offset-by-two" id="box-form">
  <!-- TODO: Process add-user logic after submitting form. -->
  <h1>Add Vehicle</h1>    
  <form method="POST" action="{{ route('vehicle-add-process') }}">
    {{ csrf_field() }}
    @if(Session::has('success'))
      <div class="twelve columns" id="success-message" style="color: green;">
          <strong>Success! </strong> {{ Session::get('message', '') }}
      </div>
    @endif
    @if(Session::has('errors'))
      <div class="twelve columns" id="success-message" style="color: red;">
          @foreach($errors->all() as $error)
            <li> {{ $error }} </li>
          @endforeach
      </div>
    @endif
     <?php
            if(!isset($institutionID)){
                echo '
                <div class="twelve columns">
                    <label for="institutionID">Choose a Campus</label>
                    <select class="u-full-width" name="institutionID" id="institution">';
                        foreach($institutions as $institution){
                            echo '<option value="'.$institution->institutionID.'">'.$institution->institutionName.'</option>';
                        }
                    echo '</select>
                </div>
                ';
            }else{
                echo '<input type="hidden" name="institutionID" value="'.$institutionID.'">';
            }
        ?>
    <div class="twelve columns">
      <label for="carTypeID">Select Car Type</label>
      <select class="u-full-width" name="carTypeID" id="carTypeID">
      @foreach($carTypes as $carType)
        <option value="{{ $carType->carTypeID }}">{{ $carType->carTypeName }}</option>
      @endforeach
      </select>
    </div>
    <div class="six columns" style="margin: 0px;">
      <label for="fuelTypeID">Fuel Type</label>
      <select class="u-full-width" name="fuelTypeID" id="fuelTypeID">
      @foreach($fuelTypes as $fuelType)
        <option value="{{ $fuelType->fuelTypeID }}">{{ $fuelType->fuelTypeName }}</option>
      @endforeach
      </select>
    </div>
    <div class="six columns">
      <label for="carBrandID">Vehicle Brand</label>
      <select class="u-full-width" name="carBrandID" id="carBrandID">
      <?php
        for($x = 0; $x < count($brands); $x++){
            echo '<option value="'.$brands[$x]->carBrandID.'"';
            if($brands[$x]->discouraged == 1){
                echo 'style="color:red">(Discouraged) ';
            }else echo '>';
            echo $brands[$x]->carBrandName.'</option>';
        }  
        ?>
      @foreach($brands as $brand)
        <option value="{{ $brand->carBrandID }}">{{ $brand->carBrandName }}</option>
      @endforeach
      </select>
    </div>
    <div class="six columns" style="margin: 0px;">
      <label for="modelName">Model Name</label>
      <input class="u-full-width" type="text" name="modelName" id="modelName" placeholder="L300">
    </div>
    <div class="six columns">
      <label for="plateNumber">Plate Number</label>
      <input class="u-full-width" type="text" name="plateNumber" id="plateNumber" placeholder="ABC123">
    </div>
   
    <!--<div class="four columns offset-by-six">
      <label for="vehicle-year">Manufacturing Year</label>
      <input class="u-full-width" type="number" name="vehicle-year" id="email" placeholder="2017">
    </div>-->

    <input class="button-primary u-pull-right" type="submit" value="Add Vehicle" style="color: white;">
    <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>    
    </div>
  </form>
</div>
@endsection