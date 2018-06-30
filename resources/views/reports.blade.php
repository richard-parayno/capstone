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
   <ul>
       <li>
           <a href="{{ route('emissionsreport') }}">Emissions Report</a>
       </li>
       <li>
           <a href="">Car Report</a>
       </li>
   </ul>
    
</div>

@endsection
