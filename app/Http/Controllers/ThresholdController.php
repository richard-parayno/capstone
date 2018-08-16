<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThresholdsRef;

class ThresholdController extends Controller
{
    //
    public function index() {
        $thresholds = ThresholdsRef::all();
        $thresholds->toArray();
        

        return response()->json($thresholds);
    }

    public function update(Request $request) {
        $data = $request->all();
        $greenThreshold = ThresholdsRef::find("GREEN");
        $orangeThreshold = ThresholdsRef::find("ORANGE");
        $redThreshold = ThresholdsRef::find("RED");
        $yellowThreshold = ThresholdsRef::find("YELLOW");

        if (isset($data['greenThreshold'])) {
            $greenThreshold->value = $data['greenThreshold'];
        }
        if (isset($data['orangeThreshold'])) {
            $orangeThreshold->value = $data['orangeThreshold'];
        }
        if (isset($data['redThreshold'])) {
            $redThreshold->value = $data['redThreshold'];
        }
        if (isset($data['yellowThreshold'])) {
            $yellowThreshold->value =$data['yellowThreshold'];
        }

        $greenThreshold->save();
        $orangeThreshold->save();
        $redThreshold->save();
        $yellowThreshold->save();

        $thresholdsArray = array();

        $thresholdsArray = array(
            'Green Threshold Updated Value' => $greenThreshold->value,
            'Orange Threshold Updated Value' => $orangeThreshold->value,
            'Red Threshold Updated Value' => $redThreshold->value,
            'Yellow Threshold Updated Value' => $yellowThreshold->value
        );
    
    
        return response()->json($thresholdsArray);
      }
}
