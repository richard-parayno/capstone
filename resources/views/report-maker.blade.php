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

    textarea {
        resize: none;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;

        width: 100%;
    }
</style>
@endsection @section('content')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular.min.js" type="text/javascript"></script>
<script>
    var app = angular
        .module("myapp", [])
        .controller("MyController", function($scope) {
            $scope.text = "text";
            $scope.columnList = [];
            $scope.tripsColumns = [
                "Institution", "Department", "Plate Number", "Kilometer Raading", "Emission", "Tripi Date/Time", "Destinations"
            ];
            $scope.listArea = [];
            $scope.tableList = [{
                    name: "Trips",
                    value: "trips" 
            }];
            $scope.appendColumn = function(input) {
                $scope.listArea.push(input);
                
            };

            //resets answer field to zero
            $scope.reset = function() {
                $scope.listArea = [];
                $scope.tripsColumns = [
                "Institution", "Department", "Plate Number", "Kilometer Raading", "Emission", "Tripi Date/Time", "Destinations"
                ];
            };

            /*
            $scope.operate = function(input) {
                $scope.holder = $scope.answer;
                $scope.operation = input;
                $scope.reset();
            };

            $scope.equals = function() {
                switch ($scope.operation) {
                    case '+':
                        {
                            $scope.answer = $scope.holder + $scope.answer;
                            break;
                        }
                    case '-':
                        {
                            $scope.answer = $scope.holder - $scope.answer;
                            break;
                        }
                    case '*':
                        {
                            $scope.answer = $scope.holder * $scope.answer;
                            break;
                        }
                    case '/':
                        {
                            $scope.answer = $scope.holder / $scope.answer;
                            break;
                        }
                    default:
                        {
                            $scope.reset();
                        }
                }
            };

            //cart functions
            $scope.itemList = [];
            $scope.cart = [];
            $scope.name = "";
            $scope.price = "";

            //adds item x quantity to inventory
            $scope.addItem = function(name, priceEach) {
                $scope.itemList.push({
                    itemName: name,
                    priceEach: priceEach
                });
                $scope.name = "";
                $scope.price = "";
            };

            //adds item and quantity to cart
            $scope.addToCart = function(name, priceeach, quantity) {
                $scope.cart.push({
                    itemName: name,
                    priceEach: priceeach,
                    itemQuantity: quantity
                });
            };

            //totals all in cart
            $scope.totalCart = 0;
            $scope.checkout = function() {
                for (var x = 0; x < $scope.cart.length; x++) {
                    $scope.totalCart += $scope.cart[x].priceEach * $scope.cart[x].itemQuantity;
                }
            };

            //resets all in cart
            $scope.resetCart = function() {
                $scope.cart = [];
            };
            */
        });
</script>
<div ng-app="myapp" style="color:black;">
    <div ng-controller="MyController">
        <div class="ten columns offset-by-one" id="box-form">
            <div class="twelve columns">
                <input type="text" name="reportTitle" placeholder="Enter Report Title Here" ng-model="test">
                <button class="primary">Save</button>
                <button>Run</button>
            </div>
            <div class="twelve columns">
                <div class="five columns">
                    <select name="table" ng-model="table">
                    <?php 
                    echo "<option ng-repeat='entry in tableList' value='{{entry.value}}'>{{entry.name}}</option>";
                    ?></select>
                    <div class="twelve columns">
                        <select name="type" id="type">
                        <option value="">Sample</option>
                    </select>
                    </div>
                    <div class="twelve columns">
                        <select name="group" id="group">
                        <option value="">Sample</option>
                    </select>
                    </div>
                </div>
                <div class="seven columns">
                    <div class="five columns">
                        <select name="x" id="x" ng-hide="table=='trips'"></select>
                        <select name="availTrips" id="availTrips" ng-show="table=='trips'">
                        <option value="institution">Institution</option>
                        <option value="department">Department</option>
                        <option value="plateNumber">Plate Number</option>
                        <option value="kmReading">Kilometer Reading</option>
                        <option value="emission">Emission</option>
                        <option value="tripDate">Trip Date/Time</option>
                        <option value="remarks">Destinations</option>
                    </select>
                    </div>
                    <div class="two columns">
                        <button style="display: block;
                        margin: 10px 0;
                        padding: 10px;
                        width: 100%;">>></button>
                        <button style="display: block;
                        margin: 10px 0;
                        padding: 10px;
                        width: 100%;"><<</button>
                        <button style="display: block;
                        margin: 10px 0;
                        padding: 10px;
                        width: 100%;">Reset</button>
                    </div>
                    <div class="five columns">
                        <textarea rows="120" cols="10" disabled readonly> 
                    </textarea>
                    </div>

                </div>
            </div>
            <br>
            <div class="twelve columns"><br></div>
            <div class="twelve columns">
                <div class="twelve columns">
                    <input type="checkbox" ng-model="filter">Filter
                </div>
                <div class="twelve columns" ng-show="filter">
                    <div class="six columns"><input type="date" name="fromDate" style="color:black;"></div>
                    <div class="six columns"><input type="date" name="toDate" style="color:black;"></div>
                </div>
            </div>
            <?php echo "SELECT {{column}} FROM {{table}}";
            $join = false;
            if($join){
                echo "JOIN ";
            }
        ?>
        </div>
        <div class="ten columns offset-by-one" id="box-form">
            <table id="table_id" class="display">
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
    </div>
</div>
@endsection @section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable();
    });
</script>
@endsection