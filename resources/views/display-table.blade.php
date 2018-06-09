@extends('layouts.main')

@section('styling')
<style>
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
  <div id="trip-data">
    <h1>Confirm Trip Data</h1>
    @if(Session::has('success'))
        <div class="twelve columns" id="success-message" style="color: green; margin-bottom: 20px;">
            <strong>Success! </strong> {{ Session::get('message', '') }}
        </div>
    @endif
    <a class="button button-primary u-pull-left" href="#data-set-errors">View Data Set Errors</a>  
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
        $y = count($data);
        $throw = array();
        $cleaned = array();
        $z = 0;
        @endphp
        @for($x = 0; $x < $y; $x++)
          @php 
          $checkerPlate = DB::table('vehicles_mv')->where('plateNumber', $data[$x]['plate_number'])->first();
          $checkerDept = DB::table('deptsperinstitution')->where('deptName', $data[$x]['requesting_department'])->first();
          //dd($data);
          if ($checkerPlate == null || $checkerDept == null) {
            $throw[$z]['date'] = $data[$x]['date'];
            $throw[$z]['tripTime'] = $data[$x]['tripTime'];
            $throw[$z]['requesting_department'] = $data[$x]['requesting_department'];
            $throw[$z]['plate_number'] = $data[$x]['plate_number'];
            $throw[$z]['kilometer_reading'] = $data[$x]['kilometer_reading'];
            $throw[$z]['destinations'] = $data[$x]['destinations'];
            $z++;
          } else {
            $cleaned[$x]['date'] = $data[$x]['date'];
            $cleaned[$x]['tripTime'] = $data[$x]['tripTime'];
            $cleaned[$x]['requesting_department'] = $data[$x]['requesting_department'];
            $cleaned[$x]['plate_number'] = $data[$x]['plate_number'];
            $cleaned[$x]['kilometer_reading'] = $data[$x]['kilometer_reading'];
            $cleaned[$x]['departure_time'] = $data[$x]['departure_time'];
            $cleaned[$x]['destinations'] = $data[$x]['destinations'];
            echo "<tr>";
            echo "<td>".$cleaned[$x]['date']."</td>";
            echo "<td>".$cleaned[$x]['tripTime']."</td>";
            echo "<td>".$cleaned[$x]['requesting_department']."</td>";
            echo "<td>".$cleaned[$x]['plate_number']."</td>";
            echo "<td>".$cleaned[$x]['kilometer_reading']."</td>";
            echo "<td>".$cleaned[$x]['destinations']."</td>";
            echo "</tr>";
          }
          @endphp
        @endfor
      </tbody>
    </table>
    <form action="{{ route('process-file') }}" method="POST">
      {{ csrf_field() }}
      @php
        //dd($cleaned);
        echo "<input type='hidden' name='data' value='".json_encode($cleaned)."'>";
      @endphp

      <input class="button button-primary u-pull-right" type="submit" value="Confirm Trip Data Upload" style="color: white;">
      <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>  
    </form>
  </div>
</div>

<div class="ten columns offset-by-one" id="box-form">
  <div id="data-set-errors">
    <h1>Data Set Errors</h1>
    <div class="twelve columns" id="success-message" style="color: red; margin-bottom: 20px;">
        <strong>The following table shows errors in the dataset that you uploaded. Errors include the following: </strong> <br> <br>
        <strong>VEHICLE not existing in the System.</strong> <br>
        <strong>REQUESTING DEPARTMENT not existing in the System.</strong> <br> <br>
        <strong>It is recommended that you add the specific VEHICLE or DEPARTMENT needed before proceeding with the upload for it to be uploaded in the system.</strong>
    </div>
    <a class="button button-primary u-pull-left" href="#trip-data">View Trip Data to be Confirmed</a>      
    <a class="button button-primary u-pull-right" onClick="goBack()">Go Back</a>  
    
    <table>
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
        foreach ($throw as $x) {
          echo "<tr>";
          echo "<td>".$x['date']."</td>";
          echo "<td>".$x['tripTime']."</td>";
          echo "<td>".$x['requesting_department']."</td>";
          echo "<td>".$x['plate_number']."</td>";
          echo "<td>".$x['kilometer_reading']."</td>";
          echo "<td>".$x['destinations']."</td>";
          echo "</tr>";
        }
        @endphp
      </tbody>
    </table>
  </div>
</div>

@endsection

