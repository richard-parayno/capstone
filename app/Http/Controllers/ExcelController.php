<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Input;

class ExcelController extends Controller
{
    public function show() {

        return view('upload-files');
    }

    public function process() {
        $excelFile = Input::file('excelFile');

        Excel::load($excelFile, function($reader) {
            $result = $reader->get();
            $result->formatDates(true, 'mm-dd-yy');
            

            return view('display-table', compact('result'));
        });
    }
}
