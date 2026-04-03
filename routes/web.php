<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('layouts.app');

});

Route::get('/produk', [ProductController::class, 'index'])->name('product.index');
