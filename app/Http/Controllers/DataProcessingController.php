<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataProcessingController extends Controller
{

    public function configureRawDataLines()
    {
        return view('dashboard.preli-processing.configure-data-line');
    }

}
