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
<div class="eight columns offset-by-two" id="box-form">
  <!-- TODO: Process add-user logic after submitting form. -->
  <h1>New Department</h1>    
  <form method="post" action="{{ route('department-add-process') }}">
    {{ csrf_field() }}
    @if(Session::has('success'))
    <div class="twelve columns" style="color: green;">
      <strong>Success!</strong> {{ Session::get('message', '') }}
    </div>
    @endif
    <div class="twelve columns">
      <label for="institutionID">Home Campus</label>
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
      <label for="deptName">Department Name</label>
      <input class="u-full-width" type="text" name="deptName" id="deptName" placeholder="College of Computer Studies">
    </div>
    <div class="twelve columns">
      <label for="department-mother">Mother Department</label>
      <select class="u-full-width" name="department-mother" id="department-mother" style="color: black;">
        <option value="">Make Department Separate</option>
        @foreach($departments as $depts)
        @php
          echo "<option value=".$depts->deptID.">".$depts->deptName."</option>";
        @endphp
        @endforeach
      </select>
    </div>
    @if ($errors->has('deptName'))
    <span class="help-block">
      <strong>{{ $errors->first('deptName') }}</strong>
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

    <input class="button-primary u-pull-right" type="submit" value="Add Department/Offices">
  </form>
</div>
@endsection