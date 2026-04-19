<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\TransactionController;


// Ubah bagian ini untuk menggunakan CashierController
Route::get('/', [CashierController::class, 'index'])->name('kasir.index');

Route::get('/modalpay', function () {
    return view('components.modalpembayaran');
});

Route::get('/app', function () {
    return view('layouts.app');
});

Route::get('/produk', [ProductController::class, 'index'])->name('product.index');
Route::post('/produk', [ProductController::class, 'store'])->name('product.store');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/kategori', [CategoryController::class, 'store'])->name('category.store');

Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');

Route::post('/transaksi/checkout', [TransactionController::class, 'checkout'])->name('transaksi.checkout');
