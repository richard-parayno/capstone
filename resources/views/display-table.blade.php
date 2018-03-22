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
  <h1>Confirm Trip Data</h1>
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
      $z = 0;
      @endphp
      @for($x = 0; $x < $y; $x++)
        @php 
        $checker = DB::table('vehicles_mv')->where('plateNumber', $data[$x]['plate_number'])->first();
        if ($checker == null) {
          $throw[$z]['date'] = $data[$x]['date'];
          $throw[$z]['tripTime'] = $data[$x]['tripTime'];
          $throw[$z]['requesting_department'] = $data[$x]['requesting_department'];
          $throw[$z]['plate_number'] = $data[$x]['plate_number'];
          $throw[$z]['kilometer_reading'] = $data[$x]['kilometer_reading'];
          $throw[$z]['destinations'] = $data[$x]['destinations'];
          $z++;
        } else {
          echo "<tr>";
          echo "<td>".$data[$x]['date']."</td>";
          echo "<td>".$data[$x]['tripTime']."</td>";
          echo "<td>".$data[$x]['requesting_department']."</td>";
          echo "<td>".$data[$x]['plate_number']."</td>";
          echo "<td>".$data[$x]['kilometer_reading']."</td>";
          echo "<td>".$data[$x]['destinations']."</td>";
          echo "</tr>";
        }
        @endphp
      @endfor
    </tbody>
  </table>
    <form action="{{ route('process-file') }}" method="POST">
      {{ csrf_field() }}
      @php
        echo "<input type='hidden' name='data' value='".json_encode($data)."'>'";
      @endphp

      <input class="button button-primary u-pull-right" type="submit" value="Confirm Trip Data Upload">
      <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>  
    </form>
</div>

<div class="ten columns offset-by-one" id="box-form">
    <h1>Data Set Errors</h1>
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

@endsection

