<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $booking_id = $request->query('booking_id');

        $booking = Booking::where('id', $booking_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            return redirect()->route('pilih-kursi')->with('error', 'Booking tidak ditemukan atau tidak valid.');
        }

        return view('payment', compact('booking'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'booking_id' => 'required|exists:bookings,id',
        ]);
    
        if (!Auth::check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu!'], 401);
        }
    
        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->first();
    
        if (!$booking || $booking->status !== 'pending') {
            return response()->json(['error' => 'Booking tidak valid atau sudah diproses.'], 400);
        }
    
        try {
            // Simpan bukti pembayaran
            $file = $request->file('proof_of_payment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/payments', $filename);
    
            Payment::create([
                'user_id' => Auth::id(),
                'booking_id' => $booking->id,
                'payment_method' => $request->payment_method,
                'proof_of_payment' => $filename,
                'status' => 'pending',
            ]);
    
            $booking->update(['status' => 'waiting_payment_confirmation']);
    
            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dikirim.']);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan pembayaran.'], 500);
        }
    }
    
}
