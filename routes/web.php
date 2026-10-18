<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KategoriController;


// Halaman utama: Dashboard
Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// AUTH
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {



    Route::get('/alat', [AlatController::class, 'index'])
        ->name('alat.index');

    Route::get('/alat/{id}', [AlatController::class, 'detail'])
        ->name('alat.detail');
    
        Route::get('/booking', [BookingController::class, 'index'])
        ->name('booking.index');

    Route::get('/booking/{id}', [BookingController::class, 'create'])
        ->name('booking.create');

    Route::post('/booking', [BookingController::class, 'store'])
        ->name('booking.store');

        Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::patch('/keranjang/ubah/{id}', [KeranjangController::class, 'ubah'])->name('keranjang.ubah');


});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');


        // Alat
        Route::get('/alat', [AlatController::class, 'adminIndex'])
            ->name('alat.index');

        Route::get('/alat/create', [AlatController::class, 'create'])
            ->name('alat.create');

        Route::post('/alat', [AlatController::class, 'store'])
            ->name('alat.store');

        Route::get('/alat/{id}/edit', [AlatController::class, 'edit'])
            ->name('alat.edit');

        Route::put('/alat/{id}', [AlatController::class, 'update'])
            ->name('alat.update');

        Route::delete('/alat/{id}', [AlatController::class, 'destroy'])
            ->name('alat.destroy');

            Route::get('/booking', [AdminBookingController::class, 'index'])->name('booking.index');
    Route::patch('/booking/{id}/setujui', [AdminBookingController::class, 'setujui'])->name('booking.setujui');
    Route::patch('/booking/{id}/tolak', [AdminBookingController::class, 'tolak'])->name('booking.tolak');
    Route::patch('/booking/{id}/kembali', [AdminBookingController::class, 'kembali'])->name('booking.kembali');

        Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');

        // User
        Route::resource('user', UserController::class);

        Route::resource('kategori', KategoriController::class);


        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

    });