@extends('layouts.main')

@section('styling')
<style>
    /** TODO: Push margin more to the right. Make the box centered to the user. **/

    #box-form {
        margin-top: 20px;
        padding: 40px;   
    }

    #box-form h1 {
        text-align: center;
        color: black;
    }

    #box-form label {
        color: black;
    }

    #box-form select {
        color: black;
    }
</style>
@endsection

@section('content')
<?php
    $userType = Auth::user()->userTypeID;
    if($userType > 2){
        $institutionID = Auth::user()->institutionID;
        $filter = true;
    }

    if(isset($institutionID)){
            $treeRaw = "institutionID = ".$institutionID;

            $totalTreesPlanted = DB::table('institutionbatchplant')
                ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
                ->whereRaw($treeRaw)
                ->groupBy(DB::raw('1'))
                ->get();
          
            $totalEmissions = DB::table('trips')
                ->select(DB::raw('SUM(emissions) as totalEmissions'))
                ->whereRaw($treeRaw)
                ->get();
        }
        else{
            
            $totalTreesPlanted = DB::table('institutionbatchplant')
                ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
                ->groupBy(DB::raw('1'))
                ->get();
            
            $totalEmissions = DB::table('trips')
                ->select(DB::raw('SUM(emissions) as totalEmissions'))
                ->get();
        }
    $seq = 0;
    for($x = 0; $x < count($totalTreesPlanted); $x++){
        $seq += $totalTreesPlanted[$x]->monthsPlanted * $totalTreesPlanted[$x]->totalPlanted * 0.00183;
    }
     $seq = round($seq, 4);
        
    $thresholds = DB::table('thresholds_ref')
        ->select(DB::raw('*'))
        ->get();
        
        if(count($totalEmissions)==0){
            $start = 0;
        }else{
            $start = $seq;
        }
        $green = $thresholds->get(0)->value;
        $orange = $thresholds->get(1)->value;
        $red = $thresholds->get(2)->value;
        $yellow = $thresholds->get(3)->value;

        $tillOrange = ($red * $totalEmissions->get(0)->totalEmissions) - $start;
        $tillYellow = ($orange * $totalEmissions->get(0)->totalEmissions) - $start;
        $tillGreen = ($yellow * $totalEmissions->get(0)->totalEmissions) - $start;

?>
<div class="six columns offset-by-one" id="box-form">
    <h1>We Planted Trees</h1>
    <form method="post" action="{{ route('process-trees') }}">
        {{ csrf_field() }}
        @if(Session::has('success'))
            <div class="twelve columns" id="success-message" style="color: green; margin-bottom: 20px;">
                <strong>Success! </strong> {{ Session::get('message', '') }}
            </div>
        @endif
        <?php
            if(!isset($institutionID)){
                echo '
                <div class="twelve columns">
                    <label for="institutionID">Choose a Campus</label>
                    <select class="u-full-width" name="institutionID" id="institution">';
                        foreach($institutions as $institution){
                            echo '<option value="'.$institution->institutionID.'">'.$institution->institutionName.'</option>';
                        }
                    echo '</select>
                </div>
                ';
            }else{
                echo '<input type="hidden" name="institutionID" value="'.$institutionID.'">';
            }
        ?>
        @if ($errors->has('institutionID'))
            <span class="help-block">
                <strong>{{ $errors->first('institutionID') }}</strong>
            </span>
        @endif
        <div class="twelve columns">
            <label for="numOfPlantedTrees">Number of Trees Planted</label>
            <input class="u-full-width" type="text" name="numOfPlantedTrees" id="numOfPlantedTrees">
        </div>
        @if ($errors->has('numOfPlantedTrees'))
            <span class="help-block">
                <strong>{{ $errors->first('numOfPlantedTrees') }}</strong>
            </span> 
        @endif
        <div class="twelve columns">
            <label for="datePlanted">Date Planted</label>
            <input class="u-full-width" type="date" name="datePlanted" id="datePlanted">
        </div>
        @if ($errors->has('datePlanted'))
            <span class="help-block">
                <strong>{{ $errors->first('datePlanted') }}</strong>
            </span> 
        @endif 
        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                    <li> {{ $error }} </li>
                    @endforeach
                </ul>
            </div>
        @endif
        <input class="button-primary u-pull-right" type="submit" value="Add Planted Trees" style="color: white;">
        <a class="button button-primary u-pull-left" onClick="goBack()">Go Back</a>
    </form>
</div>
<div class="five columns" id="box-form" ng-app="" style="text-align:center">
    <h1>Current Zone Gauge</h1>
    <div class="row">
       <label for=timeFrame>Select a Time Frame for Tree Calculation:</label>
        <select class="u-full-width" ng-model="timeFilter" id="timeFrame" name="timeFrame">
            <option value="1" selected>1 Month</option>
            <option value="2">3 Months</option>
            <option value="3">6 Months</option>
            <option value="4">1 Year</option>
        </select>
    </div>
    <div>
        <canvas class="u-full-width" id="foo"></canvas>
    </div>
    <?php
        $currentZone = 0;
        if($seq <= $red * $totalEmissions->get(0)->totalEmissions){
            $currentZone = 1;
        }elseif($seq > $red * $totalEmissions->get(0)->totalEmissions && $seq <= $orange * $totalEmissions->get(0)->totalEmissions){
            $currentZone = 2;
        }elseif($seq > $orange * $totalEmissions->get(0)->totalEmissions && $seq <= $yellow * $totalEmissions->get(0)->totalEmissions){
            $currentZone = 3;
        }else{
            $currentZone = 4;
        }
        if($tillOrange > 0 ){
            $treesLeft = ($tillOrange / 0.001) / (22 / 12); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'1\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:orange\"> Orange Zone (" . $red * 100 . '%) in a month</p></div>';
            
            $treesLeft = ($tillOrange / 0.001) / (22 / 4); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'2\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:orange\"> Orange Zone (" . $red * 100 . '%) in 3 months</p></div>';
            
            $treesLeft = ($tillOrange / 0.001) / (22 / 2); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'3\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:orange\"> Orange Zone (" . $red * 100 . '%) in 6 months</p></div>';
            
            $treesLeft = ($tillOrange / 0.001) / (22); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'4\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:orange\"> Orange Zone (" . $red * 100 . '%) in a year</p></div>';
        }
        if($tillOrange <= 0 ){
            $treesLeft = ($tillOrange / 0.001); //number of trees to catch up in a year
            echo '<br>It will only take <strong>' . abs(round($treesLeft,2)) . "</strong> MT of C02 to go back to the <p style=\"color:red\"> Red Zone (" . $red * 100 . '%)</p>';
        }
        if($tillYellow > 0 ){
            $treesLeft = ($tillYellow / 0.001) / (22 / 12); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'1\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the <p style=\"color:#d8d515\"> Yellow Zone (" . $orange * 100 . '%) in a month.</p></div>';
            
            $treesLeft = ($tillYellow / 0.001) / (22 / 4); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'2\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the <p style=\"color:#d8d515\"> Yellow Zone (" . $orange * 100 . '%) in 3 months.</p></div>';
            
            $treesLeft = ($tillYellow / 0.001) / (22 / 2); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'3\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the <p style=\"color:#d8d515\"> Yellow Zone (" . $orange * 100 . '%) in 6 months.</p></div>';
            
            $treesLeft = ($tillYellow / 0.001) / (22); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'4\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the <p style=\"color:#d8d515\"> Yellow Zone (" . $orange * 100 . '%) in a year.</p></div>';
        }
        if($tillYellow <= 0 ){
            $treesLeft = ($tillYellow / 0.001); //number of trees to catch up in a year
            echo '<br>It will only take <strong>' . abs(round($treesLeft,2)) . "</strong> MT of C02 to go back to the<p style=\"color:orange\"> Orange Zone (" . $orange * 100 . '%)</p>';
        }
        if($tillGreen > 0 ){
            $treesLeft = ($tillGreen / 0.001) / (22 / 12); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'1\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:#579529\"> Green Zone (" . $yellow * 100 . '%) in a month.</p></div>';
            
            $treesLeft = ($tillGreen / 0.001) / (22 / 4); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'2\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:#579529\"> Green Zone (" . $yellow * 100 . '%) in 3 months.</p></div>';
            
            $treesLeft = ($tillGreen / 0.001) / (22 / 2); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'3\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:#579529\"> Green Zone (" . $yellow * 100 . '%) in 6 months.</p></div>';
            
            $treesLeft = ($tillGreen / 0.001) / (22 / 1); //number of trees to catch up in a year
            echo '<div class="row" ng-hide="timeFilter!=\'4\'">You need to plant at least ' . round($treesLeft) . " tree/s to reach the<p style=\"color:#579529\"> Green Zone (" . $yellow * 100 . '%) in a year.</p></div>';
        }
        if($tillGreen <= 0 ){
            $treesLeft = ($tillGreen / 0.001); //number of trees to catch up in a year
            echo '<br>It will only take <strong>' . abs(round($treesLeft,2)) . "</strong> MT of C02 to go back to the<p style=\"color:#d8d515\"> Yellow Zone (" . $yellow * 100 . '%)</p>';
        }        
    ?><div class="row">
       <?php
        echo '<br>';
        switch($currentZone){
            case 1:{
                echo '<span style="background-color: #8c1f13; color: #FFFFFF"><strong>You are in the RED zone. </strong></span>&nbsp;';
                $message = 'Plant Trees Now!';
            }
            break;
            case 2:{
                echo '<span style="background-color: #f7c820"><strong>You are in the ORANGE zone. </strong></span>&nbsp;';
                $message = 'Plant Trees Now!';
            }
            break;
            case 3:{
                echo '<span style="background-color: #ffff87"><strong>You are in the YELLOW zone. </strong></span>&nbsp';
                $message = 'Plant Trees Now!';
            }
            break;
            case 4:{
                echo '<span style="background-color: #579529; color: #FFFFFF"><strong>You are in the Green zone. </strong></span>&nbsp';
                $message = 'Plant More Trees to keep it going!';
            }
                break;
        }
        ?>
    </div>
    <br>
</div>
<script type="application/javascript">
    <?php
        echo "var start = " . $start . ';
        ';
        if( $start > ($totalEmissions->get(0)->totalEmissions) * ($thresholds->get(0)->value)){
            echo 'maxVal = ' . $start . ';
            ';
        }else echo 'maxVal = ' . $totalEmissions->get(0)->totalEmissions * ($thresholds->get(0)->value). ';
        ';
    ?>
    var opts = {
        angle: 0.02,
        lineWidth: 0.2,
        radiusScale: 1,
        pointer: {
            length: 0.51,
            strokeWidth: 0.018,
            color: '#000000'
        },
        limitMax: false, // If false, max value increases automatically if value > maxValue
        limitMin: false, // If true, the min value of the gauge will be fixed
        generateGradient: true,
        highDpiSupport: true, // High resolution support
        staticZones: [{
                strokeStyle: "#F03E3E",
                min: 0,
                max: <?php echo $red * ($totalEmissions->get(0)->totalEmissions); ?>
            },
            {
                strokeStyle: "#f29924",
                min: <?php echo $red * ($totalEmissions->get(0)->totalEmissions); ?>,
                max: <?php echo $orange * ($totalEmissions->get(0)->totalEmissions); ?>
            },
            {
                strokeStyle: "#FFDD00",
                min: <?php echo $orange * ($totalEmissions->get(0)->totalEmissions); ?>,
                max: <?php echo $yellow * ($totalEmissions->get(0)->totalEmissions); ?>
            },
            {
                strokeStyle: "#30B32D",
                min: <?php echo $yellow * ($totalEmissions->get(0)->totalEmissions); ?>,
                max: maxVal
            },
        ],
        staticLabels: {
            font: "10px sans-serif", // Specifies font
            labels: [<?php echo $red * ($totalEmissions->get(0)->totalEmissions); ?>, <?php echo $orange * ($totalEmissions->get(0)->totalEmissions); ?>, <?php echo $yellow * ($totalEmissions->get(0)->totalEmissions); ?>, maxVal, start], // Print labels at these values
            color: "#000000", // Optional: Label text color
            fractionDigits: 2 // Optional: Numerical precision. 0=round off.
        },
        // renderTicks is Optional
        renderTicks: {
            divisions: 12,
            divWidth: 1.3,
            divLength: 0.56,
            divColor: '#333333',
            subDivisions: 4,
            subLength: 0.5,
            subWidth: 0.6,
            subColor: '#666666'
        }

    };
    var target = document.getElementById('foo'); // your canvas element
    var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
    gauge.maxValue = maxVal; // set max gauge value
    gauge.setMinValue(0); // Prefer setter over gauge.minValue = 0
    gauge.animationSpeed = 32; // set animation speed (32 is default value)
    gauge.set(start); // set actual value
</script>
<script>
var app = angular
            .module("myapp", [])
            .controller("MyController", function($scope) {
                $scope.timeFilter = ['1 Month', '3 Months', '6 Months', '1 Year'];
            });
</script>

@endsection
