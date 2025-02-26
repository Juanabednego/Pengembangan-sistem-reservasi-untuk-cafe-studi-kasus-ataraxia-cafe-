<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PilihKursiController extends Controller
{
    public function index()
    {
        return view('pilihkursi');
    }
}
