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
<div class="twelve columns" id="box-form">
  <h1>View Campuses/Institutes</h1>    
  <table class="u-full-width">
    <thead>
      <tr>
        <th>Campus/Institute Name</th>
        <th>Location</th>
        <th>Campus/Institute Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>De La Salle University - Manila</td>
        <td>2401 Taft Avenue, Manila</td>
        <td style="text-align: center;">
          <a href="{{ route('campus-editinfo') }}">Edit Campus/Institute Info</a>
        </td>
      </tr>
    </tbody>
    <!-- action shortcuts -->
    <span>Shortcuts: </span>
    <a href="{{ route('campus-add') }}">Add New Campus/Institute</a>
    <div class="u-pull-right">
      <span>Search Campus/Institute: </span>
      <input type="text" placeholder="De La Salle University" id="searchBox">
    </div>
    <!-- action shortcuts -->              
  </table>
</div>
@endsection