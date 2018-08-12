<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deptsperinstitution;
use Validator;
use DB;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function create(Request $request){
      if ($request->has('department-mother')) {
        $data = $request->all();

        $validator = Validator::make($data, [
          'institutionID' => 'required|int|max:100',
          'deptName' => 'required|string|max:100',
          'motherDeptID' => 'nullable|int',
        ]);

        if ($validator->fails()) {
          return redirect('/department-add')->withErrors($validator)->withInput();
        }

        else if ($validator->passes()) {
          $department = new Deptsperinstitution;
          $department->institutionID = $data['institutionID'];
          $department->deptName = $data['deptName'];
          $department->motherDeptID = $data['department-mother'];
          $department->save();

          return redirect('/department-add')->with('success', true)->with('message', $data['deptName'].' added!');
        }
      } else {
        $data = $request->all();

        $validator = Validator::make($data, [
          'institutionID' => 'required|int|max:100',
          'deptName' => 'required|string|max:45',          
        ]);

        if ($validator->fails()) {
          return redirect('/department-add')->withErrors($validator)->withInput();
        }

        else if ($validator->passes()) {
          $department = new Deptsperinstitution;
          $department->institutionID = $data['institutionID'];
          $department->deptName = $data['deptName'];
          $department->save();

          return redirect('/department-add')->with('success', true)->with('message', $data['deptName'].' successfully added!');
        }
      }
    }

    public function edit(Request $request) {
      if ($request->has('department-mother')) {
        $data = $request->all();

        $currentDept = $data['department-current'];
        $campus = $data['department-campus'];
        $name = $data['department-name'];
        $mother = $data['department-mother'];
        
        $deptsdata = Deptsperinstitution::find($currentDept);
        $deptsdata->deptName = $name;
        $deptsdata->institutionID = $campus;
        $deptsdata->motherDeptID = $mother;

        $deptsdata->save();

        return redirect()->route('department-view');

      } else {
        $data = $request->all();

        $currentDept = $data['department-current'];
        $campus = $data['department-campus'];
        $name = $data['department-name'];

        $deptsdata = Deptsperinstitution::find($currentDept);
        $deptsdata->deptName = $name;
        $deptsdata->institutionID = $campus;

        $deptsdata->save();

        return redirect()->route('department-view')->with('success', true)->with('message', $deptsdata->deptName.' successfully updated to '.$name.' !');
      }
    }

    public function index() {
      $department = Deptsperinstitution::all();
      $department->toArray();
      
      foreach ($department as $x) {
        $motherDepartment = DB::table('Deptsperinstitution')->where('deptID', $x->motherDeptID)->first();
        $institution = DB::table('institutions')->where('institutionID', $x->institutionID)->first();
        if ($motherDepartment != null) {
          $x['motherDeptName'] = $motherDepartment->deptName;
        } else if ($motherDepartment == null) {
          $x['motherDeptName'] = "N/A";
        }
        if ($institution != null) {
          $x['institutionName'] = $institution->institutionName;
        }
      }

      return response()->json($department);
  }

  public function show(Deptsperinstitution $department) {
      $motherDepartment = DB::table('Deptsperinstitution')->where('deptID', $department->motherDeptID)->first();
      $institution = DB::table('institutions')->where('institutionID', $department->institutionID)->first();
      $department = $department->toArray();
      if ($motherDepartment != null) {
        $department['motherDeptName'] = $motherDepartment->deptName;
      } else {
        $department['motherDeptName'] = "N/A";
      }
      if ($institution != null) {
        $department['institutionName'] = $institution->institutionName;
      }
      

      return response()->json($department);

  }

  public function showSpecific(Deptsperinstitution $department) {
    $specific = DB::table('Deptsperinstitution')->where('institutionID', $department->institutionID)->where('deptID', '!=', $department->deptID)->get();
   
    return response()->json($specific);
  }

  public function store(Request $request) {

  }

  public function update(Request $request) {
    $data = $request->all();
    $originalDept = $data['originalDept'];

    $dept = Deptsperinstitution::find($originalDept);


    $this->validate($request, [
      'deptName' => [
        'required',
        Rule::unique('deptsperinstitution')->ignore($dept->deptID, 'deptID')
      ],
      'motherDeptID' => [
        Rule::unique('deptsperinstitution')->ignore($dept->deptID, 'deptID')
        ]
      ], [
        'deptName.required' => 'The \'Update Department Name\' field is required.', 
        'deptName.unique' => 'This Department Name has already been taken.', 
      ]);

    if (isset($data['deptName'])) {
      if ($data['deptName'] != $dept->deptName) {
        $dept->deptName = $data['deptName'];
      }
    }    
    if (isset($data['motherDept'])) {
      if ($data['motherDept'] != $dept->motherDeptID) {
        $dept->motherDeptID = $data['motherDept'];
      }
    } else if ($data['motherDept'] == null) {
      $dept->motherDeptID = null;
    }
    
        
    
    $dept->save();

    return response()->json($dept);
  }

  public function delete(Deptsperinstitution $department) {

    $department->delete();

    return response()->json();
  }
}
