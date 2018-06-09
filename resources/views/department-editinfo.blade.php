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
  <h1>Update Department Info</h1>    
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
          echo "<p>Selected Department: ".$department->deptName."</p>";
          echo "<p>From Campus: ".$campus->institutionName."</p>";
        } else {
          echo "<p>Selected Department: ".$department->deptName."</p>";
          echo "<p>From Campus: ".$campus->institutionName."</p>";
          echo "<p>Currently Under: ".$motherDept->deptName."</p>";
        }

        echo ("<input class=\"u-full-width\" type=\"hidden\" name=\"department-current\" id=\"department-current\" value=\"$currentDepartment\">");

        echo "<br>";
      @endphp
    <div class="twelve columns">
      <label for="find-campus">Select Campus</label>
      <select class="u-full-width" name="department-campus" id="department-campus" style="color: black;">
        @foreach($campusList as $campuses)
          <option value="{{ $campuses->institutionID }}">{{ $campuses->institutionName }}</option>
        @endforeach
      </select>
    </div>
    <div class="twelve columns">
      <label for="department-name">Department Name</label>
      <input class="u-full-width" type="text" name="department-name" id="department-name" placeholder="College of Computer Studies">
    </div>
    <div class="twelve columns">
      <label for="department-mother">Select Mother Department</label>
      <select class="u-full-width" name="department-mother" id="department-mother" style="color: black;">
        <option value="">Make Department Separate</option>
        @foreach($departmentList as $depts)
        @php
          //$dupliChecker = Deptsperinstitution::where('deptId', '=', $currentDepartment)->first();
          if ($depts->deptID == $currentDepartment) {
            //alaws men
            echo "<option value=".$depts->deptID." hidden>".$depts->deptName."</option>";
          }
          else {
            echo "<option value=".$depts->deptID.">".$depts->deptName."</option>";
          }
        @endphp
        @endforeach
      </select>
    </div>
    <input class="button-primary u-pull-right" type="submit" value="Update Department Info" style="color: white;">
    <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>
    
  </form>
</div>
@endsection