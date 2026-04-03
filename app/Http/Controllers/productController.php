<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class productController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category');
        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%')
                ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();
        $lowStockCount = Product::whereRaw('jumlah_stok < min_stok')->count();

        return view('product.index', compact('products', 'categories', 'lowStockCount'));
    }
}
