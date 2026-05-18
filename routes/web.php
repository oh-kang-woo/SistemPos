<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;

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

    // Pengaturan Profil Pengguna
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.edit');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');


    /*
    |----------------------------------------------------------------------
    | B. Akses Khusus (Hanya Manajer Toko, Karyawan Otomatis Terblokir/403)
    |----------------------------------------------------------------------
    */
    Route::middleware('role:manajer')->group(function () {

        // Manajemen Inventori Produk & Kategori Toko
        Route::get('/produk', [ProductController::class, 'index'])->name('product.index');
        Route::post('/produk', [ProductController::class, 'store'])->name('product.store');
        Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('/kategori', [CategoryController::class, 'store'])->name('category.store');
        Route::delete('/kategori/{id}', [CategoryController::class, 'destroyCategory'])->name('category.destroy');

        // Analitik & Laporan Keuangan Toko
        Route::get('/laporan', [ReportController::class, 'index'])->name('report.index');
        Route::get('/laporan/cetak', [ReportController::class, 'print'])->name('report.print');

        // Pembukuan Pengeluaran Operasional Toko
        Route::get('/pengeluaran', [ExpenseController::class, 'index'])->name('expense.index');
        Route::post('/pengeluaran/kategori', [ExpenseController::class, 'storeCategory'])->name('pengeluaran.kategori.store');
        Route::post('/pengeluaran', [ExpenseController::class, 'storeExpense'])->name('pengeluaran.store');

    });

});
