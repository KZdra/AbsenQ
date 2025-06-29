<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportAbsenController extends Controller
{
    public function index(){
        return view('reportabsen.index');
    }
}
