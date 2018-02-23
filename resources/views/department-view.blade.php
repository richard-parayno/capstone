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
<div class="ten columns offset-by-one" id="box-form">
  <h1>View Department/Offices</h1>    
  <table class="u-full-width">
    <thead>
      <tr>
        <th>Department/Office Name</th>
        <th>From Campus/Institute</th>
        <th>Department/Office Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($departments as $department)
      <tr>
        <td>{{ $department->deptName }}</td>
        @foreach($institutions as $institution)
          @if($department->institutionID == $institution->institutionID)
            <td>{{ $institution->institutionName }}</td>
          @endif
        @endforeach
        <td style="text-align: center;">
          <a href="{{ route('department-editinfo') }}">Edit Department/Office Info</a>
        </td>
      </tr>
      @endforeach
    </tbody>
    <!-- action shortcuts -->
    <span>Shortcuts: </span>
    <a href="{{ route('campus-add') }}">Add New Department/Office</a>
    <div class="u-pull-right">
      <span>Search Department/Office: </span>
      <input type="text" placeholder="Information Technology Services" id="searchBox">
    </div>
    <!-- action shortcuts -->              
  </table>
</div>
@endsection