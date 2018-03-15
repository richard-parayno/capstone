<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Deptsperinstitution;
use Debugbar;

class ViewUserController extends Controller
{
    public function viewUsers() {
        $users = DB::table('users')->get();
        $userTypes = DB::table('usertypes_ref')->get();
        
        return view('user-view', compact('users', 'userTypes'));        
    }

    public function viewCampus() {
        $institutions = DB::table('institutions')->get();
        $schools = DB::table('schooltype_ref')->get();

        return view('campus-view', compact('institutions', 'schools'));
    }

    public function viewDepartments() {
        $departments = DB::table('deptsperinstitution')->get();
        $institutions = DB::table('institutions')->get();

        return view('department-view', compact('departments', 'institutions'));
    }

    public function viewDepartmentsSearch() {
        $departments = DB::table('deptsperinstitution')->get();
        $institutions = DB::table('institutions')->get();

        return view('department-view-search', compact('departments', 'institutions'));
    }
    
    public function viewDepartmentsProcess(Request $request) {
        if($request->ajax()) {
            $output="";
            Debugbar::info("ajax");
            
            $dept = DB::table('deptsperinstitution')
                      ->join('institutions', 'deptsperinstitution.institutionID', '=', 'institutions.institutionID')
                      ->where('deptsperinstitution.deptName', 'LIKE', '%'.$request->search.'%')
                      ->select('deptsperinstitution.deptID','deptsperinstitution.deptName', 'institutions.institutionName', 'deptsperinstitution.motherDeptID')
                      ->get();
            Debugbar::info("initialized");
            Debugbar::info($dept);
            $motherDeptArray = Deptsperinstitution::all();                  
        
            $motherDeptStuff = "";
            $actionStuff = "";
            $td = "";
            $deptStuff = "";

            if($dept) {
              foreach ($dept as $key => $dept) {
                $deptStuff.='<tr>'.
                '<td>'.$dept->deptName.'</td>'.
                '<td>'.$dept->institutionName.'</td>';
                /** 
                if ($motherDept == null) {
                    $motherDeptStuff.=$deptStuff.'<td>N/A</td>';
                }
                else {
                    $motherDeptStuff.=$deptStuff.'<td>'.$motherDept->deptName.'</td>';
                }
                $td.=$motherDeptStuff."<td style='text-align=center;'>";
                if (isset($motherDept)) {
                    $actionStuff.=$td."<a href={{ route ('department-editinfo', array('department' =>".$dept->deptID.", 'mother' =>".$motherDept->deptID.")) }}> Update Department Info</a>";
                } else {
                    $actionStuff.=$td."<a href={{ route ('department-editinfo', array('department' =>".$dept->deptID.")) }}> Update Department Info</a>";
                }
                $output.=$actionStuff."</td>"."</tr>";**/
                $output.=$deptStuff."</td>";
              }
              return Response($output);
            }
        }
    }

    public function viewVehicles() {
        $vehicles = DB::table('vehicles_mv')->where('active', 1)->get();
        $inactive = DB::table('vehicles_mv')->where('active', 0)->get();
        $brands = DB::table('carbrand_ref')->get();
        $institutions = DB::table('institutions')->get(); 
        $fueltype = DB::table('fueltype_ref')->get();
        $cartypes = DB::table('cartype_ref')->get();

        return view('vehicle-view', compact('vehicles', 'inactive', 'brands', 'institutions', 'fueltype', 'cartypes'));
    }


}
