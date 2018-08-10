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

  public function store(Request $request) {

  }

  public function update(Request $request) {
    $data = $request->all();
    $originalDept = $data['originalDept'];

    $dept = Deptsperinstitution::find($originalDept);

    $this->validate($request, [
      'institutionID' => [
        Rule::unique('deptsperinstitution')->ignore($request->input('institution'), 'institutionID')
      ],
      'deptName' => [
        'required',
        Rule::unique('deptsperinstitution')->ignore($request->input('deptName'), 'deptName')
      ],
      'motherDeptID' => [
        Rule::unique('deptsperinstitution')->ignore($request->input('motherDept'), 'motherDeptID')
        ]
      ], [
        'deptName.required' => 'The \'Update Department Name\' field is required!', 
        'institutionID.required' => 'The \'Update Campus\' field is required!',  
      ]);

    if (isset($data['institution']))
      $dept->institutionID = $data['institution'];
    if (isset($data['deptName']))    
      $dept->deptName = $data['deptName'];
    if (isset($data['motherDeptID']))
      $dept->motherDeptID = $data['motherDept'];
    
    $dept->save();

    return response()->json($dept);
  }

  public function delete(Deptsperinstitution $department) {

  }
}
