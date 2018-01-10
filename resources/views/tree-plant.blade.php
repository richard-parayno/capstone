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
<div class="eight columns" id="box-form">
  <!-- TODO: Process add-user logic after submitting form. -->
  <h1>Add Trees Planted</h1>    
  <form method="post" action="{{ route('process-trees') }}">
    {{ csrf_field() }}
    @if(Session::has('success'))
    <div class="twelve columns" style="color: green;">
      <strong>Success!</strong> {{ Session::get('message', '') }}
    </div>
    @endif
    <div class="twelve columns">
      <label for="institutionID">Select Campus/Institute</label>
      <select class="u-full-width" name="institutionID" id="institution">
        @foreach($institutions as $institution)
          <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
        @endforeach
      </select>
    </div>
    @if ($errors->has('institutionID'))
      <span class="help-block">
        <strong>{{ $errors->first('institutionID') }}</strong>
      </span>
    @endif
    <div class="twelve columns">
      <label for="numOfPlantedTrees">Number of Planted Trees</label>
      <input class="u-full-width" type="text" name="numOfPlantedTrees" id="numOfPlantedTrees" >
    </div>
    @if ($errors->has('numOfPlantedTrees'))
      <span class="help-block">
        <strong>{{ $errors->first('numOfPlantedTrees') }}</strong>
      </span>
    @endif
    <div class="twelve columns">
      <label for="datePlanted">Date Planted</label>
      <input class="u-full-width" type="date" name="datePlanted" id="datePlanted" >
    </div>
    @if ($errors->has('datePlanted'))
      <span class="help-block">
        <strong>{{ $errors->first('datePlanted') }}</strong>
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

    <input class="button-primary u-pull-right" type="submit" value="Add Planted Trees">
  </form>
</div>
@endsection