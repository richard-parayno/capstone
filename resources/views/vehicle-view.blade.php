@layouts('layouts.main')

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
<div class="twelve columns" id="box-form">
  <h1>View Vehicles</h1>    
  <table class="u-full-width">
    <thead>
      <tr>
        <th>Car Type</th>
        <th>Car Brand</th>
        <th>Car Model</th>
        <th>Plate Number</th>
        <th>Manufacturing Year</th>
        <th>Home Campus/Institute</th>
        <th>Fuel Type</th>
        <th>Status</th>
        <th>Vehicle Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Sedan</td>
        <td>Toyota</td>
        <td>Vios</td>
        <td>ZAW-941</td>
        <td>2015</td>
        <td>De La Salle University - Manila</td>
        <td>Diesel</td>
        <td>Active</td>
        <td style="text-align: center;">
          <a href="{{ route('vehicle-editinfo') }}">Edit Vehicle Info</a> <br>
          <a href="{{ route('vehicle-decommission') }}">Decommission Vehicle</a>
        </td>
      </tr>
    </tbody>
    <!-- action shortcuts -->
    <span>Shortcuts: </span>
    <a href="{{ route('vehicle-add') }}">Add New Vehicle</a>
    <div class="u-pull-right">
      <span>Search Vehicle: </span>
      <input type="text" placeholder="LamborGHini" id="searchBox">
    </div>
    <!-- action shortcuts -->              
  </table>
</div>
@endsection