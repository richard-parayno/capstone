<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Institutionbatchplant;
use Validator;

class InstitutionBatchPlantController extends Controller
{
    public function add(Request $request) {
        $data = $request->all();
        
        $validator = Validator::make($data, [
          'institutionID' => 'required|int|max:45|',
          'numOfPlantedTrees' => 'required|string|max:300',
          'datePlanted' => 'required|date',
        ]);
    
        if ($validator->fails()) {
          return redirect('/tree-plant')->withErrors($validator)->withInput();
        }
    
        else if ($validator->passes()) {
          /** 
          $institution = Institution::create([
            'institutionName' => $data['institutionName'],
            'location' => $data['location'],
            'schoolTypeID' => $data['schoolTypeID'],
          ]); */
    
          $plant = new Institutionbatchplant;
          $plant->institutionID = $data['institutionID'];
          $plant->numOfPlantedTrees = $data['numOfPlantedTrees'];
          $plant->datePlanted = $data['datePlanted'];
          $plant->save();
    
          return redirect('/tree-plant')->with('success', true)->with('message', 'Successfully added '.$data['numOfPlantedTrees'].' planted trees! (Plant Date: '.$data['datePlanted'].')');
        }
    }
}
