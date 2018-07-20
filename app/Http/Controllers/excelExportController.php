<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

class excelExportController extends Controller
{
    public function Export () {
        Excel::create('clients', function($excel) {
            $excel->sheet('clients', function($sheet) {
                $sheet->loadView('excel');
            });
        })->export('xlsx');
    }
}
