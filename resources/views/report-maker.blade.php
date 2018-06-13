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
<div ng-app="">
    <div class="ten columns offset-by-one" id="box-form">
        <div class="twelve columns">
            <input type="text" name="reportTitle" placeholder="Enter Report Title Here" ng-model="test">
            <button class="primary">Save</button>
            <button>Run</button>
        </div>
        <div class="twelve columns">
            <div class="six columns">
                <select name="table" id="table">
                    <option value="">Sample</option>
                </select>
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
            <div class="six columns">
                <div class="six columns">
                    <select name="avail" id="avail">
                        <option value="">Sample</option>
                    </select>
                </div>
                <div class="six columns">
                    <input type="textarea">
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
                <div class="six columns"><input type="date" name="fromDate"></div>
                <div class="six columns"><input type="date" name="toDate"></div>
            </div>
        </div>
        <?php echo "{{test}}"; ?>
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
@endsection @section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.10/angular.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#table_id').DataTable();
    });
</script>

@endsection