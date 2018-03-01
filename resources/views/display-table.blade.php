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


<div class="seven column" id="box-form">
  <h1>View Uploaded Excel File</h1>
  <table>
    <thead>
      <tr>
        <th>Date</th>
        <th>Requesting Department</th>
        <th>Plate Number</th>
        <th>Kilometer Reading</th>
        <th>Destinations</th>
      </tr>
    </thead>
    <tbody>
      @php
      $y = count($data);
      @endphp
      

      @for($x = 0; $x < $y; $x++)
        @php 
          $checker = DB::table('vehicles_mv')->where('plateNumber', $data[$x]['plate_number'])->first();
          if ($checker == null) {
          
          } else {
            echo "<tr>";
            echo "<td>".$data[$x]['date']."</td>";
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
</div>

@endsection

