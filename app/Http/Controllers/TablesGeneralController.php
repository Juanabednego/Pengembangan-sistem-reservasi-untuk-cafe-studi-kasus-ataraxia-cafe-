<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TablesGeneralController extends Controller
{
    public function index()
    {
        return view('admin.tables-general');
    }
}
