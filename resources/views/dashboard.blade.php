@extends('layouts.main')

@section('styling')
<style>
  #trips-overview-div {
    margin-top: 30px;
    background: #363635;
    box-shadow: 5px 10px 20px 0 rgba(0,0,0,0.20);  
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="seven column" id="trips-overview-div">
    <canvas id="trips-overview"></canvas>
  </div>
</div>
<div class="row">
  <div class="seven column">
  </div>
</div>
@endsection

@section('scripts')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js"></script>
  <script src="{{ url('/js/dashboard-trips.js') }}"></script>
@endsection