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
        <th>Roundtrips?</th>
      </tr>
    </thead>
    <tbody>
      @php
      $y = count($data);
      @endphp
      

      @for($x = 0; $x < $y; $x++)
      <tr>
        <td>{{ $data[$x]['date'] }}</td>
        <td>{{ $data[$x]['requesting_department'] }}</td>
        <td>{{ $data[$x]['plate_number'] }}</td>
        <td>{{ $data[$x]['kilometer_reading'] }}</td>
        <td>{{ $data[$x]['destinations'] }}</td>
        <td>{{ $data[$x]['roundtripyn'] }}</td>
      </tr>
      @endfor

    </tbody>


  </table>
</div>

@endsection

