<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesLoginController extends Controller
{
    public function index()
    {
        return view('admin.pages-login');
    }
}
