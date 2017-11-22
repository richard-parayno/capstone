<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deptsperinstitution;
use Validator;

class DepartmentController extends Controller
{
    public function create(Request $request){
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

          return redirect('/dashboard/department-add')->with('success', true)->with('message', 'Department/Office successfully added!');
        }

    }
}
