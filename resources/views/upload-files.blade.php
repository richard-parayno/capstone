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

<div class="seven column" id="box-form">
  <h1>Upload Excel File</h1>
  <form action="{{ route('process-file') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="excelFile">
    <br>
    <input type="submit" value="Submit">
  </form>
</div>

@endsection

