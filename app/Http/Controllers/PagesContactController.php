<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesContactController extends Controller
{
    public function index()
    {
        return view('admin.pages-contact');
    }
}
