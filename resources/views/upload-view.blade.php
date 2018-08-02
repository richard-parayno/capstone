@extends('layouts.main')

@section('styling')
<style>
  /** TODO: Push margin more to the right. Make the box centered to the user. **/
  #box-form {
    margin-top: 20px;
    padding: 40px;
    border-radius: 10px;
  }
  #box-form h1 {
    text-align: center;
    color: black;
  }
  #box-form input {
    color: black;
  }
</style>
@endsection

@section('content')
<div class="twelve columns">
      <h1>Manage Trips</h1>
      <a href="{{ route('upload-files') }}">
        <button class="button-primary">Upload Trip Data (Excel)</button>
      </a>
      <a href="{{ route('manual-upload') }}">
        <button class="button-primary">Upload Trip Data (Manual)</button>
      </a>
      <a href="{{ route('download-template') }}">
        <button class="button button-primary">Download Trip Data Template</button>
      </a> 
      <div id="uploaded-trip-table"></div>
</div>

@endsection

