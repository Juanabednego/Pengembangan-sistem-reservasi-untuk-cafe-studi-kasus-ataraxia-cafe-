<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;

class TablesDataController extends Controller
{
    public function index()
    {
        // Ambil semua data booking & pembayaran yang telah dilakukan
        $bookings = Booking::with(['user', 'payment'])->get();
        
        return view('admin.tables-data', compact('bookings'));
    }
}
