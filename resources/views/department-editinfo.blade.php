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
  <h1>Edit Department/Offices Info</h1>    
  <form action="{{ route('department-editinfo-process') }}">
      @php
        use App\Models\Deptsperinstitution;
        use App\Models\Institution;
      
        $currentDepartment = $_GET['department'];
        if (isset($_GET['mother'])) {
          $currentMother = $_GET['mother'];

          $motherDept = Deptsperinstitution::find($currentMother);
        }
       
        $department = Deptsperinstitution::find($currentDepartment);
  
        $campus = Institution::find($department->institutionID);
  
        $campusList = Institution::all();
        $departmentList = Deptsperinstitution::all();
  
        if (!isset($currentMother)) {
          echo "<p>Selected Department: </p>".$department->deptName;
          echo "<p>From Campus: </p>".$campus->institutionName;
        } else {
          echo "<p>Selected Department: </p>".$department->deptName;
          echo "<p>From Campus: </p>".$campus->institutionName;
          echo "<p>Currently Under: </p>".$motherDept->deptName;
        }

        echo ("<input class=\"u-full-width\" type=\"hidden\" name=\"department-current\" id=\"department-current\" value=\"$currentDepartment\">");
      @endphp
    <div class="twelve columns">
      <label for="find-campus">Select Campus</label>
      <select class="u-full-width" id="department-campus" style="color: black;">
        @foreach($campusList as $campuses)
          <option value="{{ $campuses->institutionID }}">{{ $campuses->institutionName }}</option>
        @endforeach
      </select>
    </div>
    <div class="twelve columns">
      <label for="department-name">Department Name</label>
      <input class="u-full-width" type="text" name="department-name" id="department-name" placeholder="College of Computer Studies">
    </div>
    @if(isset($currentMother))
    <div class="twelve columns">
      <label for="department-mother">New Mother Department</label>
      <select class="u-full-width" id="department-campus" style="color: black;">
        <option value="">Make Department Separate</option>
        @foreach($departmentList as $depts)
        @if (Deptsperinstitution::find($currentDepartment))
        @else
        <option value="{{ $depts->deptID }}">{{ $depts->institutionName }}</option>
        @endif
        @endforeach
      </select>
    </div>
    @endif
    <input class="button-primary u-pull-right" type="submit" value="Edit Department/Offices Info">
  </form>
</div>
@endsection