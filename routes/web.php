<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;


// Ubah bagian ini untuk menggunakan CashierController
Route::get('/', [CashierController::class, 'index'])->name('kasir.index');

Route::get('/modalpay', function () {
    return view('components.modalpembayaran');
});

Route::get('/app', function () {
    return view('layouts.app');
});

// Routes untuk produk dan kategori
Route::get('/produk', [ProductController::class, 'index'])->name('product.index');
Route::post('/produk', [ProductController::class, 'store'])->name('product.store');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/kategori', [CategoryController::class, 'store'])->name('category.store');
Route::delete('/kategori/{id}', [CategoryController::class, 'destroyCategory'])->name('category.destroy');

// Routes untuk transaksi
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

// Routes untuk pengaturan
Route::get('/pengaturan', [SettingController::class, 'index'])->name('setting.index');
Route::post('/pengaturan/profil', [SettingController::class, 'updateProfil'])->name('setting.updateProfil');
Route::post('/pengaturan/struk', [SettingController::class, 'updateStruk'])->name('setting.updateStruk');
