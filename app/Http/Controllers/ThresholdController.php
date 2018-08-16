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

        $greenInput = $request->input('greenThreshold');
        $orangeInput = $request->input('orangeThreshold');
        $redInput = $request->input('redThreshold');
        $yellowInput = $request->input('yellowThreshold');

        if (isset($greenInput)) {
            $greenThreshold->value = $greenInput;
        }
        if (isset($orangeInput)) {
            $orangeThreshold->value = $orangeInput;
        }
        if (isset($redInput)) {
            $redThreshold->value = $redInput;
        }
        if (isset($yellowInput)) {
            $yellowThreshold->value =$yellowInput;
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
