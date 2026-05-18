<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| RUTE UMUM (Bisa diakses siapa saja tanpa login)
|--------------------------------------------------------------------------
*/
// Saat pertama kali dijalankan (mengakses localhost:8000), langsung buka landing page
Route::get('/', function () {
    return view('landingpage'); // Memanggil resources/views/landingpage.blade.php
})->name('landing');


/*
|--------------------------------------------------------------------------
| RUTE UNTUK TAMU (Hanya bisa diakses jika BELUM Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


/*
|--------------------------------------------------------------------------
| RUTE TERPROTEKSI (Hanya bisa diakses jika SUDAH Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |----------------------------------------------------------------------
    | A. Akses Bersama (Manajer & Karyawan Toko Bisa Masuk)
    |----------------------------------------------------------------------
    */
    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman Utama Kasir & UI Layouts
    Route::get('/kasir', [CashierController::class, 'index'])->name('kasir.index');
    Route::get('/modalpay', function () { return view('components.modalpembayaran'); });
    Route::get('/app', function () { return view('layouts.app'); });

    // Modul Transaksi & Cetak Struk Kasir
    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::post('/transaksi/checkout', [TransactionController::class, 'checkout'])->name('transaksi.checkout');
    Route::get('/riwayat-transaksi/{id}/cetak', [TransactionController::class, 'print'])->name('transaction.print');

    // Routes untuk laporan
    Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
    Route::get('/laporan/cetak', [ReportController::class, 'print'])->name('report.print');

    // Routes untuk pengeluaran
    Route::get('/pengeluaran', [ExpenseController::class, 'index'])->name('expense.index');
    Route::post('/pengeluaran/kategori', [ExpenseController::class, 'storeCategory'])->name('pengeluaran.kategori.store');
    Route::post('/pengeluaran', [ExpenseController::class, 'storeExpense'])->name('pengeluaran.store');
    Route::put('/pengeluaran/{id}', [ExpenseController::class, 'updateExpense'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{id}', [ExpenseController::class, 'destroyExpense'])->name('pengeluaran.destroy');
    Route::get('/pengeluaran-print', [ExpenseController::class, 'print'])->name('pengeluaran.print');

    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.edit');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Routes untuk pengaturan
    Route::get('/pengaturan', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/pengaturan/profil', [SettingController::class, 'updateProfil'])->name('setting.updateProfil');
    Route::post('/pengaturan/struk', [SettingController::class, 'updateStruk'])->name('setting.updateStruk');
    Route::post('/pengaturan/user', [SettingController::class, 'storeUser'])->name('setting.storeUser')->middleware('auth');

});
