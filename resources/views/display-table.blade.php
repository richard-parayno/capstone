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
  <h1>Excel Data</h1>
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
      $throw = array();
      @endphp
      

      @for($x = 0; $x < $y; $x++)
        @php 
        $checker = DB::table('vehicles_mv')->where('plateNumber', $data[$x]['plate_number'])->first();
        if ($checker == null) {
          $throw[$x]['date'] = $data[$x]['date'];
          $throw[$x]['requesting_department'] = $data[$x]['requesting_department'];
          $throw[$x]['plate_number'] = $data[$x]['plate_number'];
          $throw[$x]['kilometer_reading'] = $data[$x]['kilometer_reading'];
          $throw[$x]['destinations'] = $data[$x]['destinations'];
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

  <h1>Dataset Errors</h1>
  @php
  if ($throw != null) {
    echo "<table>";
    echo "<thead>";
    echo  "<tr>";
    echo    "<th>Date</th>";
    echo    "<th>Requesting Department</th>";
    echo    "<th>Plate Number</th>";
    echo    "<th>Kilometer Reading</th>";
    echo    "<th>Destinations</th>";
    echo  "</tr>";
    echo "</thead>";
    echo "<tbody>";
    for($x = 0; $x < count($throw); $x++) {
      echo"<tr>";
      echo"<td>".$throw[$x]['date']."</td>";
      echo"<td>".$throw[$x]['requesting_department']."</td>";
      echo"<td>".$throw[$x]['plate_number']."</td>";
      echo"<td>".$throw[$x]['kilometer_reading']."</td>";
      echo"<td>".$throw[$x]['destinations']."</td>";
      echo"</tr>";
    }
    echo "</tbody>";
    echo "</table>";
  }
  @endphp
</div>

@endsection

