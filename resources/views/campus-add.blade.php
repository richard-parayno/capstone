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
  <!-- TODO: Process add-campus logic after submitting form. -->
  <h1>Add New Campus</h1>    
  <form method="POST" action="{{ route('campus-add-process') }}">
    {{ csrf_field() }}
    @if(Session::has('success'))
      <div class="twelve columns" id="success-message" style="color: green;">
          <strong>Success! </strong> {{ Session::get('message', '') }}
      </div>
    @endif
    <div class="twelve columns">
      <label for="schoolTypeID">Select Campus Type</label>
      <select class="u-full-width" name="schoolTypeID" id="schoolTypeID" style="color: black;">
        @foreach($schoolTypes as $schoolType)
          <option value="{{ $schoolType->schoolTypeID }}">{{ $schoolType->schoolTypeName }}</option>
        @endforeach
      </select>
      @if ($errors->has('schoolTypeID'))
        <span class="help-block">
          <strong>{{ $errors->first('schoolTypeID') }}</strong>
        </span>
      @endif
    </div>
    <div class="twelve columns">
      <label for="ci-name">Campus Name</label>
      <input class="u-full-width" type="text" name="institutionName" id="institutionName" placeholder="De La Salle University - Manila">
      @if ($errors->has('institutionName'))
        <span class="help-block">
          <strong>{{ $errors->first('institutionName') }}</strong>
        </span>
      @endif
    </div>
    <div class="twelve columns">
      <label for="ci-location">Location</label>
      <input class="u-full-width" type="text" name="location" id="location" placeholder="2401 Taft Avenue">
    </div>
    @if ($errors->has('location'))
      <span class="help-block">
        <strong>{{ $errors->first('location') }}</strong>
      </span>
    @endif
    <input class="button-primary u-pull-right" type="submit" value="Add New Campus" style="color: white;">
    <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>    
  </form>
</div>
@endsection