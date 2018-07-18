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
  #box-form input {
    color: white;
  }
</style>
@endsection

@section('content')
<div class="ten columns offset-by-one" id="box-form">
    <h1>Trip Data</h1>
    <table class="u-full-width">
      <thead>
        <tr>
          <th>Date</th>
          <th>Departure Time</th>
          <th>Requesting Department</th>
          <th>Plate Number</th>
          <th>Kilometer Reading</th>
          <th>Destinations</th>
        </tr>
      </thead>
      <tbody>
        @php
        use App\Models\Deptsperinstitution;
        foreach ($trips as $trip) {
          echo "<tr>";
          echo "<td>".$trip->tripDate."</td>";
          echo "<td>".$trip->tripTime."</td>";
          $requestingDepartment = Deptsperinstitution::where('deptID', $trip->deptID)->first();          
          echo "<td>".$requestingDepartment->deptName."</td>";
          echo "<td>".$trip->plateNumber."</td>";
          echo "<td>".$trip->kilometerReading."</td>";
          echo "<td>".$trip->remarks."</td>";
          echo "</tr>";
        }
        @endphp
      </tbody>
      <!-- action shortcuts -->
      <a href="{{ route('upload-files') }}">
        <button class="button-primary">Upload Trip Data (Excel)</button>
      </a>
      <a href="{{ route('manual-upload') }}">
        <button class="button-primary">Upload Trip Data (Manual)</button>
      </a>
      <a href="{{ route('download-template') }}">
        <button class="button button-primary">Download Trip Data Template</button>
      </a> 
      <!-- action shortcuts -->   
    </table>
</div>

@endsection

