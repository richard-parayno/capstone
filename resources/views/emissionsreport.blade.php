@extends('layouts.main') @section('styling')
<style>
    /** TODO: Push margin more to the right. Make the box centered to the user. **/

    #box-form {
        background-color: #363635;
        margin-top: 20px;
        padding: 40px;
        border-radius: 10px;
    }

    #box-form h1 {
        text-align: center;
        color: white;
    }

    #box-form input {
        color: white;
    }
</style>
@endsection @section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<div class="ten columns offset-by-one" id="box-form">

    <?php
//if data already has filters set
//if(isset($_POST['filters'])){
    //echo table

    //get most vehicle type contributions (trip number)
    $vehicleTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw('COUNT(cartype_ref.carTypeID) AS numberOfEntries'))
        ->groupBy('carTypeName')
        ->orderByRaw('COUNT(cartype_ref.carTypeID) DESC')
        ->limit(2)
        ->get();
    
    //get most department type contributions (trip number)
    $deptTripNumber = DB::table('trips')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
        ->select('deptsperinstitution.deptName', DB::raw('COUNT(deptsperinstitution.deptID) AS numberOfEntries'))
        ->groupBy('deptsperinstitution.deptID')
        ->orderByRaw('COUNT(deptsperinstitution.deptID) DESC')
        ->limit(2)
        ->get();
    
    //get most car contributions (trip number)
    $carTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'institutions.institutionID','=', 'vehicles_mv.institutionID')
        ->select('vehicles_mv.plateNumber', 'vehicles_mv.modelName', 'institutions.institutionName', DB::raw('COUNT(vehicles_mv.plateNumber) AS totalEntries'))
        ->groupBy('plateNumber')
        ->orderByRaw('COUNT(vehicles_mv.plateNumber) DESC')
        ->limit(2)
        ->get();
    
    //get most car brand type contributions (trip number)
     $carBrandTripNumber = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carbrandName', DB::raw('COUNT(carbrand_ref.carbrandID) AS numberOfEntries'))
        ->groupBy('carbrandName')
        ->orderByRaw('COUNT(carbrand_ref.carbrandID) DESC')
        ->limit(2)
        ->get();
    
    //get most vehicle type contributions (emission total)
    $vehicleContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('cartype_ref', 'cartype_ref.carTypeID','=', 'vehicles_mv.carTypeID')
        ->select('cartype_ref.carTypeName', DB::raw('SUM(trips.emissions) AS totalEmissions'))
        ->groupBy('carTypeName')
        ->orderByRaw('SUM(trips.emissions) DESC')
        ->limit(2)
        ->get();
    
    //include institution
    //get most department type contributions (emission total)
    $deptContributions = DB::table('trips')
        ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
        ->select('deptsperinstitution.deptName', DB::raw('SUM(trips.emissions) AS totalEmissions'))
        ->groupBy('deptsperinstitution.deptID')
        ->orderByRaw('SUM(trips.emissions) DESC')
        ->limit(2)
        ->get();
   
     
    //get most car brand type contributions (emission total)
    $carBrandContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('carbrand_ref', 'carbrand_ref.carbrandID','=', 'vehicles_mv.carbrandID')
        ->select('carbrand_ref.carbrandName', DB::raw('SUM(trips.emissions) AS totalEmissions'))
        ->groupBy('carbrandName')
        ->orderByRaw('SUM(trips.emissions) DESC')
        ->limit(2)
        ->get();
    
    //get most car type contributions (emission total)
    $carContributions = DB::table('trips')
        ->join('vehicles_mv', 'vehicles_mv.plateNumber', '=', 'trips.plateNumber')
        ->join('institutions', 'institutions.institutionID','=', 'vehicles_mv.institutionID')
        ->select('vehicles_mv.plateNumber', 'vehicles_mv.modelName', 'institutions.institutionName', DB::raw('SUM(trips.emissions) AS totalEmissions'))
        ->groupBy('plateNumber')
        ->orderByRaw('SUM(trips.emissions) DESC')
        ->limit(2)
        ->get();
    
    //dd($vehicleTripNumber);
    //dd($vehicleContributions);
    //dd($carTripNumber);
    //dd($carContributions);
    //dd($carBrandTripNumber);
    //dd($carBrandContributions);
    //dd($deptTripNumber);
    //dd($deptContributions);
    
    //data table to house data before data vis
    echo "
    <div class='ten columns offset-by-one' id='box-form'>
        <div id='customers'>
            <table id='table_id' class='display'>
                <thead>
                    <tr>
                        <th>Column 1</th>
                        <th>Column 2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Row 1 Data 1</td>
                        <td>Row 1 Data 2</td>
                    </tr>
                    <tr>
                        <td>Row 2 Data 1</td>
                        <td>Row 2 Data 2</td>
                    </tr>
                </tbody>
            </table>
        </div>
            <button onclick=\"demoFromHTML();\">Print to PDF</button>
    </div>
    ";
    
//no filters has been set yet
//}else{
    //set filters
    
//}

?>
</div>
@endsection @section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable();
    });
</script>
<script>
    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        source = $('#customers')[0];

        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function(element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
            source, // HTML string or DOM elem ref.
            margins.left, // x coord
            margins.top, { // y coord
                'width': margins.width, // max width of content on PDF
                'elementHandlers': specialElementHandlers
            },

            function(dispose) {
                // dispose: object with X, Y of the last line add to the PDF 
                //          this allow the insertion of new lines after html
                pdf.save('Test.pdf');
            }, margins);
    }
</script>
@endsection