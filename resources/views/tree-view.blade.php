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
<div class="eight columns offset-by-two" id="box-form">
    <h1>We Planted Trees</h1>
    @if(Session::has('success'))
      <div class="twelve columns" id="success-message" style="color: green; margin-bottom: 20px;">
          <strong>Success! </strong> {{ Session::get('message', '') }}
      </div>
    @endif    
    <table class="u-full-width">
      <thead>
        <tr>
          <th>Institution</th>
          <th>Number of Planted Trees</th>
          <th>Date Planted</th>
        </tr>
      </thead>
      <tbody>
        @foreach($treesPlanted as $trees)
        <tr>
          @foreach($institutions as $institution)
            @if($trees->institutionID == $institution->institutionID)
              <td>{{ $institution->institutionName }}</td>
            @endif
          @endforeach
          <td> {{ $trees->numOfPlantedTrees }} </td>
          <td> {{ $trees->datePlanted }} </td>
        </tr>
        @endforeach
      </tbody>
      <!-- action shortcuts -->
      <a href="{{ route('tree-plant') }}">
        <button class="button-primary">New Tree Plant</button>
      </a>
      <!-- action shortcuts -->   
    </table>
</div>

@endsection

