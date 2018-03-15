<?php


namespace App\Http\Controllers;



use Illuminate\Http\Request;

use DB;




class SearchController extends Controller

{

public function index()

{

return view('search.search');

}



public function search(Request $request)

{

if($request->ajax())

{

$output="";

$dept=DB::table('deptsperinstitution')->where('deptName','LIKE','%'.$request->search."%")->get();

if($dept)

{

foreach ($dept as $key => $dept) {

$output.='<tr>'.

'<td>'.$dept->deptID.'</td>'.

'<td>'.$dept->institutionID.'</td>'.

'<td>'.$dept->deptName.'</td>'.

'<td>'.$dept->motherDeptID.'</td>'.

'</tr>';

}



return Response($output);



}



}



}

}
