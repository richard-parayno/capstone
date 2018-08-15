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
        
            $seqTotal = DB::table('institutionbatchplant')
                ->select(DB::raw('sum(numOfPlantedTrees) as totalSeq'))
                ->whereRaw($treeRaw)
                ->get();

            $totalTreesPlanted = DB::table('institutionbatchplant')
                ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
                ->whereRaw($treeRaw)
                ->groupBy(DB::raw('1'))
                ->get();
        }
        else{
            $seqTotal = DB::table('institutionbatchplant')
                ->select(DB::raw('sum(numOfPlantedTrees) as totalSeq'))
                ->get();

            $totalTreesPlanted = DB::table('institutionbatchplant')
                ->select(DB::raw('ROUND(DATEDIFF(now(), datePlanted)*0.0328767) as monthsPlanted, sum(numOfPlantedTrees) as totalPlanted'))
                ->groupBy(DB::raw('1'))
                ->get();
        }
        
    
    $totalEmissions = DB::table('monthlyemissionsperschool')
        ->select(DB::raw('SUM(emission) as totalEmissions'))
        ->whereRaw('institutionID = 1')
        ->get();
    
    $monthCount = DB::table('monthlyemissionsperschool')
        ->select(DB::raw('count(emission) as monthcount'))
        ->whereRaw('institutionID = 1')
        ->get();
    
    $thresholds = DB::table('thresholds_ref')
        ->select(DB::raw('*'))
        ->get();
        
        $emissionData = DB::table('trips')
            ->join('institutions', 'trips.institutionID', '=', 'institutions.institutionID')
            ->select('trips.tripDate', 'trips.tripTime', 'deptsperinstitution.deptName' , 'trips.plateNumber', 
                    'trips.kilometerReading', 'trips.remarks', 'trips.emissions', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'vehicles_mv.modelName', 'vehicles_mv.active') 
            ->whereRaw($rawDB)
            ->orderBy('trips.tripDate', 'asc')
            ->get();
        
        if(count($emissionData)==0){
            $start = 0;
        }else{
            $start = $totalTreesPlanted->get(0)->totalPlanted * 22 * 0.001;
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
        <div class="twelve columns">
            <label for="institutionID">Choose a Campus</label>
            <select class="u-full-width" name="institutionID" id="institution">
                @foreach($institutions as $institution)
                    <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
                @endforeach
            </select>
        </div>
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
<div class="five columns" id="box-form">
    <h1>Current Zone Gauge</h1>    
    <div>
        <canvas class="u-full-width" id="foo"></canvas>
    </div>
    <?php
        //add change time period
        //add change threshold values
        if($tillOrange > 0 ){
            $treesLeft = ($tillOrange / 0.001) / 22; //number of trees to catch up in a year
            echo '<br><p>You need to plant at least ' . round($treesLeft) . " trees to reach the Orange Zone (" . $red * 100 . '%)</p>';
        }
        if($tillYellow > 0 ){
            $treesLeft = ($tillYellow / 0.001) / 22; //number of trees to catch up in a year
            echo '<br><p>You need to plant at least ' . round($treesLeft) . " trees to reach the Yellow Zone (" . $orange * 100 . '%)</p>';
        }
        if($tillGreen > 0 ){
            $treesLeft = ($tillGreen / 0.001) / 22; //number of trees to catch up in a year
            echo '<br><p>You need to plant at least ' . round($treesLeft) . " trees to reach the Green Zone (" . $yellow * 100 . '%)</p>';
        }        
    ?>
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
            color: "#FFFFFF", // Optional: Label text color
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

@endsection
