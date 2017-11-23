@extends('layouts.main')

@section('styling')
@endsection

@section('content')

<div class="seven column" id="box-form">
  <form action="{{ route('process-file') }}" method="POST" enctype="multipart/form-data">
  {{ csrf_field() }}
  
    <input type="file" name="excelFile">
    <input type="submit" value="Submit">
  </form>
</div>

@endsection

