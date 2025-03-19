<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification; // Import notifikasi
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Ambil semua kursi yang sudah dibooking
        $bookedSeats = Booking::whereIn('status', ['confirmed', 'waiting_payment_confirmation'])
            ->pluck('seats')  // Mengambil kolom 'seats' yang berisi JSON kursi
            ->toArray();
    
        // Menggabungkan kursi yang dibooking
        $formattedSeats = [];
        foreach ($bookedSeats as $seatString) {
            $formattedSeats = array_merge($formattedSeats, json_decode($seatString, true) ?? []);
        }
    
        // Jika request dari AJAX, kirim data JSON
        if ($request->ajax()) {
            return response()->json(['formattedSeats' => $formattedSeats]);
        }
    
        // Kirim data kursi yang sudah dibooking ke view
        return view('Pilihkursi', compact('formattedSeats'));
    }
    
    

    public function store(Request $request)
    {
        $request->validate([
            'seats' => 'required|string',
            'total_price' => 'required|numeric'
        ]);
    
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu!'], 401);
        }
    
        $userId = Auth::id();
        $selectedSeats = explode(',', str_replace(' ', '', $request->seats));
    
        try {
            DB::beginTransaction();
    
            // Cek apakah kursi sudah dipesan oleh orang lain
            $existingBookings = Booking::where('status', '!=', 'cancelled')
                ->where(function ($query) use ($selectedSeats) {
                    foreach ($selectedSeats as $seat) {
                        $query->orWhereJsonContains('seats', $seat);
                    }
                })
                ->exists();
    
            if ($existingBookings) {
                return response()->json(['error' => 'Beberapa kursi yang dipilih sudah dibooking.'], 400);
            }
    
            $booking = Booking::create([
                'user_id' => $userId,
                'seats' => json_encode($selectedSeats),
                'total_price' => $request->total_price,
                'status' => 'pending'
            ]);
    
            DB::commit();
    
            Log::info('Booking berhasil dibuat', ['booking_id' => $booking->id, 'seats' => $selectedSeats]);
    
            return response()->json(['booking_id' => $booking->id]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan booking', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Terjadi kesalahan, silakan coba lagi.'], 500);
        }
    }

}
