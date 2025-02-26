<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookTableController extends Controller
{
    public function index()
    {
        return view('BookTable'); // Pastikan Anda memiliki view dengan nama BookTable.blade.php
    }
}