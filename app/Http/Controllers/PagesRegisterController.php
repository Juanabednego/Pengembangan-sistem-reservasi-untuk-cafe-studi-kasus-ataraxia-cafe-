<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesRegisterController extends Controller
{
    public function index()
    {
        return view('admin.pages-register');
    }
}
