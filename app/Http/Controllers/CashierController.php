<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        // Ambil semua kategori untuk tombol filter
        $categories = Category::all();

        // Ambil semua produk yang aktif beserta data kategorinya
        $products = Product::with('category')->where('status', 'aktif')->get();

        return view('cashier.index', compact('categories', 'products'));
    }
}
