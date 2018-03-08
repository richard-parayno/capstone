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
  <h1>Update Campus Information</h1>    
  <form action="{{ route('campus-editinfo-process') }}">
    @php
      use App\Models\Institution;
      use App\Models\SchooltypeRef;
    
      $currentInstitution = $_GET['institution'];
     
      $institution = Institution::find($currentInstitution);

      $schoolType = SchooltypeRef::find($institution->schoolTypeID);

      $schools = SchooltypeRef::all();

      echo "<p>Selected Campus: ".$institution->institutionName."</p>";
      echo "<p>Campus Location: ".$institution->location."</p>";
      echo "<p>Campus Classification: ".$schoolType->schoolTypeName."</p>";
      echo ("<input class=\"u-full-width\" type=\"hidden\" name=\"current-ci\" id=\"current-ci\" value=\"$currentInstitution\">");
      echo "<br>";
    @endphp
    <div class="twelve columns">
      <label for="ci-name">Updated Campus Name</label>
      <input class="u-full-width" type="text" name="ci-name" id="ci-name" placeholder="La Salle Greenhills">
    </div>
    <div class="twelve columns">
      <label for="ci-location">Updated Location</label>
      <input class="u-full-width" type="text" name="ci-location" id="email" placeholder="GH pare">
    </div>
    <div class="twelve columns">
      <label for="ci-type">Updated Classification</label>
      <select class="u-full-width" name="ci-type" id="ci-type" style="color: black;">
        @foreach($schools as $schoolTypes)
          <option value="{{ $schoolTypes->schoolTypeID }}">{{ $schoolTypes->schoolTypeName }}</option>
        @endforeach
      </select>
    </div>
    <input class="button-primary u-pull-right" type="submit" value="Edit Campus/Institute Info">
  </form>
</div>
@endsection