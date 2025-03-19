<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    public function run()
    {
        DB::table('bookings')->insert([
            ['nama_pelanggan' => 'John Doe', 'nomor_kursi' => '5', 'waktu_booking' => now(), 'jumlah_orang' => 4, 'status' => 'Pending'],
            ['nama_pelanggan' => 'Anna Smith', 'nomor_kursi' => '2', 'waktu_booking' => now(), 'jumlah_orang' => 2, 'status' => 'Confirmed'],
            ['nama_pelanggan' => 'Michael Brown', 'nomor_kursi' => '8', 'waktu_booking' => now(), 'jumlah_orang' => 6, 'status' => 'Canceled'],
        ]);
    }
}

