@extends('layouts.main')
@section('header')
<meta name="_token" content="{{ csrf_token() }}">
@endsection

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
<div class="ten columns offset-by-one" id="box-form">
  <h1>Manage Departments</h1>    
  <table class="u-full-width myTable">
    <thead>
      <tr>
        <th>Department Name</th>
        <th>From Campus</th>
        <th>From Department</th>
        <th>Department Action</th>
      </tr>
    </thead>
    <tbody>
      @php
      use App\Models\Deptsperinstitution;
      @endphp
      @foreach($departments as $department)
      <tr>
        <td>{{ $department->deptName }}</td>
        @foreach($institutions as $institution)
          @if($department->institutionID == $institution->institutionID)
            <td style="text-align: center;">{{ $institution->institutionName }}</td>
          @endif
        @endforeach
        @php           
          $motherDept = Deptsperinstitution::find($department->motherDeptID);
        @endphp
        @if($motherDept == null)
        <td style="text-align: center;">N/A</td>
        @else
        <td style="text-align: center;">{{ $motherDept->deptName }}</td>
        @endif

        <td style="text-align: center;">
          @if (isset($motherDept))
          <a href="{{ route('department-editinfo', array('department' => $department->deptID, 'mother' => $motherDept->deptID)) }}">Edit Department Info</a>
          @else
          <a href="{{ route('department-editinfo', array('department' => $department->deptID)) }}">Edit Department Info</a>
          @endif 
        </td>
      </tr>
      @endforeach
    </tbody>
    <!-- action shortcuts -->
    <a href="{{ route('department-add') }}">
    <button class="button-primary">New Department</button>
    </a>
    <div class="u-pull-right">
      <span>Search Departments: </span>
      <input type="text" placeholder="Information Technology Services" id="searchBox">
    </div>
    <!-- action shortcuts -->              
  </table>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $('#searchBox').on('keyup', function () {
    $value = $(this).val();
    $.ajax({
      type: 'get',
      url: '{{URL::route('department-search')}}',
      data: {
        'searchBox': $value
      },
      success: function (data) {
        $('tbody').html(data);
      }
    });
  })
</script>

<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'csrftoken': '{{ csrf_token() }}'
    }
  });
</script>
@endsection