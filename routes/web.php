<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookTableController;
use App\Http\Controllers\PilihKursiController;
use App\Http\Controllers\IndexAdminController;
use App\Http\Controllers\PagesContactController;
use App\Http\Controllers\PagesLoginController;
use App\Http\Controllers\PagesRegisterController;
use App\Http\Controllers\TablesDataController;
use App\Http\Controllers\TablesGeneralController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KelolaEventController;
use App\Http\Controllers\AdminController;




Route::middleware('auth')->group(function () {
    // Booking & Payment
    Route::get('/pilih-kursi', [BookingController::class, 'index'])->name('pilih-kursi');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');

    // Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('/admin/tables-data', [AdminController::class, 'index'])->name('admin.tables-data');
        Route::put('/admin/booking/confirm/{id}', [AdminController::class, 'confirm'])->name('admin.booking.confirm');
        Route::put('/admin/booking/cancel/{id}', [AdminController::class, 'cancel'])->name('admin.booking.cancel');
    });
});

// Tables Data (Admin View)
Route::get('/tables-data', [TablesDataController::class, 'index'])->name('tables-data');


Route::get('/', function () {
    return view('index');
    require __DIR__.'/auth.php';
});

Route::get('/indexadmin', [IndexAdminController::class, 'index']);
Route::get('/pages-contact', [PagesContactController::class, 'index']);
Route::get('/tables-data', [TablesDataController::class, 'index'])->name('tables-data');



    Route::get('/kelola-event', [KelolaEventController::class, 'index'])->name('kelola-event');
    Route::post('/kelola-event/store', [KelolaEventController::class, 'store'])->name('kelola-event.store');
    Route::post('/kelola-event/{id}', [KelolaEventController::class, 'update'])->name('kelola-event.update');
    Route::delete('/kelola-event/{event}', [KelolaEventController::class, 'destroy'])->name('kelola-event.destroy');







Route::get('/index', function () {
    return view('index');
})->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


    Route::get('/book-table', [BookTableController::class, 'index'])->name('book.table')->middleware('auth');
    Route::get('/book-table', [KelolaEventController::class, 'showEvents'])->name('book-table')->middleware('auth');



Route::get('/pilihkursi', [PilihKursiController::class, 'index'])->name('pilihkursi');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');