<?php
    if(isset($data)){  
        $filterMessage = "";
        if($data['reportName']=="trip"){
            if($data['isFiltered']=="true"){
                if($data['institutionID'] != null || $data['datePreset']!=0 || $data['fromDate'] != null || $data['toDate'] != null){
        $rawDB = "";
        if($data['institutionID'] != null){
                $userSchool = $data['institutionID'];
                $schoolSort = true;
                $add = true;
                $filterMessage .= $userSchool;
                $rawDB.="trips.institutionID=".$userSchool;
        if($data['carTypeID']!=null){
            if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " by " . $data['carTypeID'];
                }
                $rawDB .= "cartype_ref.carTypeID = ".$data['carTypeID'];
        }
        if($data['fuelTypeID']!=null){
            if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " by " . $data['fuelTypeID'];
                }
                $rawDB .= "fueltype_ref.fuelTypeID = ".$data['fuelTypeID'];
        }
        if($data['carBrandID']!=null){
            if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " by " . $data['carBrandID'];
                }
                $rawDB .= "carbrand_ref.carBrandID = ".$data['carBrandID'];
        }
        }if($data['datePreset']==0){   
            if($data['fromDate'] != null && $data['toDate'] != null){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " dated ";
                }
                $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "' AND trips.tripDate >= '" . $data['fromDate'] . "'";
                $filterMessage .= $data['toDate']. " to ". $data['fromDate'];
            }elseif(!isset($data['fromDate']) && $data['toDate'] != null){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " dated ";
                }
                $rawDB .= "trips.tripDate <= '" . $data['toDate'] . "'";
                $filterMessage .= "before ".$data['toDate'];
            }elseif($data['fromDate'] != null && !isset($data['toDate'])){
                if($add){
                    $rawDB .= " AND ";
                    $filterMessage .= " dated  ";
                }
                $rawDB .= "trips.tripDate >= '" . $data['fromDate'] . "'";
                $filterMessage .= "after ".$data['fromDate'];
            }
        }else{
            switch($data['datePreset']){
                case "1": {
                        if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 2 WEEK";
                    $filterMessage .= "from 2 weeks ago";
                    break;
                }
                case "2": {
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 MONTH";
                    $filterMessage .= "from 1 month ago";
                    break;
                } 
                case "3": {
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 3 MONTH";
                    $filterMessage .= "from 3 month ago";
                    break;
                }
                case "4": {
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 6 MONTH";
                    $filterMessage .= "from 6 month ago";
                    break;
                }
                case "5": {
                    if($add){
                        $rawDB .= " AND ";
                        $filterMessage .= " dated ";
                    }
                    $rawDB .= "trips.tripDate >= NOW() - INTERVAL 1 YEAR";
                    $filterMessage .= "from 1 year ago";
                    break;
                }
                default: $rawDB .= "";
            }
        }
        }
                $tripData=DB::table('trips')
                    ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('trips.tripDate', 'trips.tripTime','institutions.institutionName', 'deptsperinstitution.deptName', 'trips.plateNumber', 'trips.kilometerReading', 'trips.remarks', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'carbrand_ref.carBrandName', 'vehicles_mv.modelName', 'vehicles_mv.active', 'trips.emissions')
                    ->whereRaw($rawDB)
                    ->orderByRaw('1 ASC, 3 ASC')
                    ->get();
            }else{
                $tripData=DB::table('trips')
                    ->join('deptsperinstitution', 'deptsperinstitution.deptID', '=', 'trips.deptID')
                    ->join('institutions', 'institutions.institutionID', '=', 'trips.institutionID')
                    ->join('vehicles_mv', 'trips.plateNumber', '=', 'vehicles_mv.plateNumber')
                    ->join('cartype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('fueltype_ref', 'vehicles_mv.carTypeID', '=', 'cartype_ref.carTypeID')
                    ->join('carbrand_ref', 'vehicles_mv.carBrandID', '=', 'carbrand_ref.carBrandID')
                    ->select('trips.tripDate', 'trips.tripTime','institutions.institutionName', 'deptsperinstitution.deptName', 'trips.plateNumber', 'trips.kilometerReading', 'trips.remarks', 'fueltype_ref.fuelTypeName', 'cartype_ref.carTypeName', 'carbrand_ref.carBrandName', 'vehicles_mv.modelName', 'vehicles_mv.active', 'trips.emissions')
                    ->orderByRaw('1 ASC, 3 ASC')
                    ->get();
            }
        }
    }

    $institutions = DB::table('institutions')->get();
    $departments = DB::table('deptsperinstitution')->get();   
    $fuelTypes = DB::table('fueltype_ref')->get();
    $carTypes = DB::table('cartype_ref')->get();
    $carBrands = DB::table('carbrand_ref')->get();

?>
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
    <div ng-app="myapp">
        <div ng-controller="MyController">
            <?php
    if(isset($tripData)){
        echo "<div ng-hide=\"true\">
    <table id=\"".$data['reportName']."report-".(new \DateTime())->format('Y-m-d H:i:s')."\">
      <thead>
          <tr>
              <th>
                <td>Preared By: ".$userType = Auth::user()->accountName."</td>
                <td>Prepared On: ".(new \DateTime())->format('Y-m-d H:i:s')."</td>
              </th>
          </tr>
      </thead>";
         foreach($tripData as $trip){
             echo "<tr>";
                 echo "<td>".$trip->tripDate."</td>";
                 echo "</td>".$trip->tripTime."</td>";
                 echo "<td>".$trip->institutionName."</td>";
                 echo "<td>".$trip->deptName."</td>";
                 echo "<td>".$trip->plateNumber."</td>";
                 echo "<td>".$trip->kilometerReading."</td>";
                 echo "<td>".$trip->fuelTypeName."</td>";
                 echo "<td>".$trip->carTypeName."</td>";
                 echo "<td>".$trip->modelName."</td>";
                 echo "<td>".$trip->active."</td>";
                 echo "<td>".$trip->remarks."</td>";
                 echo "<td>".$trip->emissions."</td>";
             echo "</tr>";
            }
            echo "<tr>
                <td>Showing ".count($tripData)." Rows</td>
            </tr>
    </table>
</div>";
    }
?>
                <h5>&nbsp; Dashboard > Reports</h5>
                <form method="post" action="{{ route('reports-process') }}"> {{ csrf_field() }}
                    <input type="hidden" name="isFiltered" value="<?php echo " {{showFilter}} "?>">
                    <input type="hidden" name="isRecurrFiltered" value="<?php echo " {{showRecurrFilter}} "?>">
                    <input type="hidden" name="reportName" value='<?php echo "{{reportName}}"?>'>
                    <div class="row">
                        <div class="five columns offset-by-one">
                            <!-- GENERAL REPORTS -->
                            <div class="row">
                                <div class="five columns">
                                    <h5>General Reports</h5>
                                </div>
                                <div class="seven columns">
                                    <div class="row">
                                        <div class="six columns">
                                            <a class="button" ng-click="toggleFilter();" style="width: 100%">Filters</a>
                                        </div>
                                        <div class="six columns">
                                            <a class="button" ng-click="togglePreset(); valueNull(); " style="width: 100%; text-align: left;">Date Filter</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div ng-show="showFilter">
                                <div class="row">
                                    <div class="twelve columns">
                                        <select name="institutionID" id="institutionID" style="color: black; width: 100%">
                       <option value="">All Institutions</option>
                        @foreach($institutions as $institution)
                          <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
                        @endforeach
                    </select>
                                    </div>
                                </div>
                                <div class="row" ng-hide="datePreset">
                                    <div class="six columns">
                                        <p style="text-align: left;" ng-hide="datePreset"><strong>From:</strong></p>
                                        <input class="u-full-width" type="date" ng-model="fromRange" name="fromDate" id="fromDate" ng-hide="datePreset"></div>
                                    <div class="six columns">
                                        <p style="text-align: left;" ng-hide="datePreset"><strong>To: </strong></p>
                                        <input class="u-full-width" type="date" ng-model="toRange" name="toDate" id="toDate" ng-hide="datePreset">
                                    </div>
                                </div>
                                <div class="row" ng-show="datePreset">
                                    <select name="datePreset" ng-model="preset" style="color: black; width: 100%">
                                <option value="0" selected>Select Date Preset</option>
                                <option value="1">2 Weeks</option>
                                <option value="2">Last Month</option>
                                <option value="3">Last 3 Months</option>
                                <option value="4">Last 6 Months</option>
                                <option value="5">Last 1 Year</option>
                    </select>
                                </div>
                                <div class="row">
                                    <div class="four columns">
                                        <select class="u-full-width" name="carTypeID" id="carTypeID" style="color: black; width: 100%">
                           <option value="">All Car Types</option>
                            @foreach($carTypes as $carType)
                              <option value="{{ $carType->carTypeID }}">{{ $carType->carTypeName }}</option>
                            @endforeach
                        </select>
                                    </div>
                                    <div class="four columns">
                                        <select class="u-full-width" name="fuelTypeID" id="fuelTypeID" style="color: black; width: 100%">
                             <option value="">All Fuel Types</option>
                              @foreach($fuelTypes as $fuelType)
                                <option value="{{ $fuelType->fuelTypeID }}">{{ $fuelType->fuelTypeName }}</option>
                              @endforeach
                        </select>
                                    </div>
                                <div class="four columns">
                                        <select class="u-full-width" name="carBrandID" id="carbrandID" style="color: black; width: 100%">
                             <option value="">All Car Brands</option>
                              @foreach($carBrands as $carBrand)
                                <option value="{{ $carBrand->carBrandID }}">{{ $carBrand->carBrandName }}</option>
                              @endforeach
                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="twelve columns">
                                    <input type="submit" class="button-primary" ng-click='addReport("trip");' value="Trip Report" style="width: 100%">
                                </div>
                                <div class="twelve columns">
                                    <input type="submit" class="button-primary" ng-click="addReport('forecast')" value="Forecast Report" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        <div class="five columns">
                            <div class="row">
                                <div class="six columns">
                                    <h5>Recurring Reports</h5>
                                </div>
                                <div class="six columns"><a class="button" ng-click="toggleRecurrFilter();" style="width: 100%">Filters</a></div>
                            </div>
                            <div class="row" ng-show="showRecurrFilter">
                               <div class="twelve columns">
                                            <select name="recurrInstitutionID" id="institutionID" style="color: black; width: 100%">
                                   <option value="">All Institutions</option>
                                    @foreach($institutions as $institution)
                                      <option value="{{ $institution->institutionID }}">{{ $institution->institutionName }}</option>
                                    @endforeach
                                </select>
                               </div>
                                <div class="twelve columns">
                                    <select name="recurrPreset" id="irecurrPreset" style="color: black; width: 100%">
                                        <option value="0" selected>Select Date Preset</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Quarterly</option>
                                        <option value="3">Semi-Annual</option>
                                        <option value="4">Annual</option>
                                    </select>
                               </div>
                            </div>
                            <div class="row">
                                <div class="twelve columns">
                                    <input type="submit" class="button-primary" ng-click='addReport("trip");' value="Emission Report" style="width: 100%">
                                </div>
                                <div class="twelve columns">
                                    <input type="submit" class="button-primary" ng-click="addReport('forecast')" value="Mitigation Report" style="width: 100%">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
        </div>
    </div>

    @endsection @section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular.min.js" type="text/javascript"></script>
    <!--angular js script-->
    <script>
        var app = angular
            .module("myapp", [])
            .controller("MyController", function($scope) {
                $scope.dboardType = ['Emissions', 'Number of Trips'];
                $scope.nonschool = false;
                $scope.showFilter = false;
                $scope.showRecurrFilter = false;
                $scope.datePreset = false;
                $scope.reportName = "";
                $scope.toRange = "";
                $scope.fromRange = "";
                $scope.preset = "";

                $scope.toggleFilter = function() {
                    $scope.showFilter = !$scope.showFilter
                };

                $scope.toggleRecurrFilter = function() {
                    $scope.showRecurrFilter = !$scope.showRecurrFilter
                };

                $scope.addReport = function(name) {
                    $scope.reportName = name
                };

                $scope.togglePreset = function() {
                    $scope.datePreset = !$scope.datePreset

                };
                
                $scope.valueNull = function() {
                        $scope.preset = "0";
                        $scope.toRange = "";
                        $scope.fromRange = "";
                };
            });
    </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!--angular js script-->
    <script>
        var xport = {
            _fallbacktoCSV: true,
            toXLS: function(tableId, filename) {
                this._filename = (typeof filename == 'undefined') ? tableId : filename;

                //var ieVersion = this._getMsieVersion();
                //Fallback to CSV for IE & Edge
                if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
                    return this.toCSV(tableId);
                } else if (this._getMsieVersion() || this._isFirefox()) {
                    alert("Not supported browser");
                }

                //Other Browser can download xls
                var htmltable = document.getElementById(tableId);
                var html = htmltable.outerHTML;

                this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls');
            },
            toCSV: function(tableId, filename) {
                this._filename = (typeof filename === 'undefined') ? tableId : filename;
                // Generate our CSV string from out HTML Table
                var csv = this._tableToCSV(document.getElementById(tableId));
                // Create a CSV Blob
                var blob = new Blob([csv], {
                    type: "text/csv"
                });

                // Determine which approach to take for the download
                if (navigator.msSaveOrOpenBlob) {
                    // Works for Internet Explorer and Microsoft Edge
                    navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
                } else {
                    this._downloadAnchor(URL.createObjectURL(blob), 'csv');
                }
            },
            _getMsieVersion: function() {
                var ua = window.navigator.userAgent;

                var msie = ua.indexOf("MSIE ");
                if (msie > 0) {
                    // IE 10 or older => return version number
                    return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
                }

                var trident = ua.indexOf("Trident/");
                if (trident > 0) {
                    // IE 11 => return version number
                    var rv = ua.indexOf("rv:");
                    return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
                }

                var edge = ua.indexOf("Edge/");
                if (edge > 0) {
                    // Edge (IE 12+) => return version number
                    return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
                }

                // other browser
                return false;
            },
            _isFirefox: function() {
                if (navigator.userAgent.indexOf("Firefox") > 0) {
                    return 1;
                }

                return 0;
            },
            _downloadAnchor: function(content, ext) {
                var anchor = document.createElement("a");
                anchor.style = "display:none !important";
                anchor.id = "downloadanchor";
                document.body.appendChild(anchor);

                // If the [download] attribute is supported, try to use it

                if ("download" in anchor) {
                    anchor.download = this._filename + "." + ext;
                }
                anchor.href = content;
                anchor.click();
                anchor.remove();
            },
            _tableToCSV: function(table) {
                // We'll be co-opting 'slice' to create arrays
                var slice = Array.prototype.slice;

                return slice
                    .call(table.rows)
                    .map(function(row) {
                        return slice
                            .call(row.cells)
                            .map(function(cell) {
                                return '"t"'.replace("t", cell.textContent);
                            })
                            .join(",");
                    })
                    .join("\r\n");
            }
        };

        <?php
            if(isset($data)){
                echo "window.onload = function(){
                  javascript:xport.toCSV('".$data['reportName']."report-".(new \DateTime())->format('Y-m-d H:i:s')."');
                };";   
            }
           ?>
    </script>
    @endsection