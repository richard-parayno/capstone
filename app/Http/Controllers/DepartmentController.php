<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deptsperinstitution;
use Validator;

class DepartmentController extends Controller
{
    public function create(Request $request){
      if ($request->has('department-mother')) {
        $data = $request->all();

        $validator = Validator::make($data, [
          'institutionID' => 'required|int|max:100',
          'deptName' => 'required|string|max:45',
          'motherDeptID' => 'nullable|int',
        ]);

        if ($validator->fails()) {
          return redirect('/dashboard/department-add')->withErrors($validator)->withInput();
        }

        else if ($validator->passes()) {
          $department = new Deptsperinstitution;
          $department->institutionID = $data['institutionID'];
          $department->deptName = $data['deptName'];
          $department->motherDeptID = $data['department-mother'];
          $department->save();

          return redirect('/dashboard/department-add')->with('success', true)->with('message', $data['deptName'].' added!');
        }
      } else {
        $data = $request->all();

        $validator = Validator::make($data, [
          'institutionID' => 'required|int|max:100',
          'deptName' => 'required|string|max:45',          
        ]);

        if ($validator->fails()) {
          return redirect('/dashboard/department-add')->withErrors($validator)->withInput();
        }

        else if ($validator->passes()) {
          $department = new Deptsperinstitution;
          $department->institutionID = $data['institutionID'];
          $department->deptName = $data['deptName'];
          $department->save();

          return redirect('/dashboard/department-add')->with('success', true)->with('message', $data['deptName'].' successfully added!');
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
}
