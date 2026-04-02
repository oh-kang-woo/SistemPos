<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('cashier.dashboard');
});

Route::get('/modalpay', function () {
    return view('components.modalpembayaran');
});

