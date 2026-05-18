<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // <-- TAMBAHKAN INI JIKA BELUM ADA
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        // 1. Ambil business_id dari user yang sedang login
        $businessId = auth()->user()->business_id;

        // 2. Ambil produk yang aktif di toko ini
        $products = Product::where('business_id', $businessId)
                           ->where('status', 'aktif')
                           ->get();

        // 3. Ambil juga kategori yang terdaftar di toko ini (Solusi Error)
        $categories = Category::where('business_id', $businessId)->get();

        // 4. Kirim KEDUA variabel ($products dan $categories) ke dalam view kasir
        return view('cashier.index', compact('products', 'categories'));
    }
}
