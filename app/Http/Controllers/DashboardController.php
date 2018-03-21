<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function main() {
        return view('analytics-test');
    }
    
    public function getRegressionLine($emissionData){
        function getRegressionLine($emissionData){
            //step 1
            //calculate pearson's correlation coefficient - r
            //step 2
            //compute for the standard deviation of months (x) and emisisons (y) - Sx and Sy
            //step 3
            //compute for slope - b
            //step 4
            //compute for y-intercept - a
            //Linear Regression
            //y = a + bx

            //Pearson's Correlation Coefficient calculation
            //numerator calculation
            $r = 0;
            $summationOfNumerator = 0;
            $xAve = 0;
            $yAve = 0;
            for($x = 0; $x < count($emissionData); $x++) {
                $xAve += $emissionData[$x][0];
            }
            for($x = 0; $x < count($emissionData); $x++) {
                $yAve += $emissionData[$x][1];
            }
            $xAve = $xAve/count($emissionData);
            $yAve = $yAve/count($emissionData);
            for($x = 0; $x < count($emissionData); $x++) {
                $summationOfNumerator+=($emissionData[$x][0] - $xAve)*($emissionData[$x][1] - $yAve);
            }

            //denominator 
            $denominator = 0;
            $summationTerm1 = 0;
            $summationTerm2 = 0;
            for($x = 0; $x < count($emissionData); $x++) {
                $summationTerm1+=($emissionData[$x][0] - $xAve)*($emissionData[$x][0] - $xAve);
                $summationTerm2+=($emissionData[$x][1] - $yAve)*($emissionData[$x][1] - $yAve);
            }

            $denominator = sqrt($summationTerm1 * $summationTerm2);
            $r = $summationOfNumerator/$denominator;

            //standard deviation calculation
            $Sy = sqrt($summationTerm2/(count($emissionData)-1));
            $Sx = sqrt($summationTerm1/(count($emissionData)-1));

            //slope calculation
            $b = $r * ($Sy/$Sx);

            //y-intercept calculation
            $a;
            $a = $yAve - ($b * $xAve);

            $regressionLine = array($a, $b);

            return regressionLine;
        }
    }
}

?>