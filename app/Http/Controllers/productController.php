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

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:categories,id_kategori',
            'kode_produk' => 'required|unique:products,kode_produk',
            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'jumlah_stok' => 'required|integer',
            'min_stok' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
            'gambar_produk' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['gambar_produk'] = $filename;
        }

        Product::create([
            'kategori_id' => $data['kategori_id'],
            'kode_produk' => $data['kode_produk'],
            'nama_produk' => $data['nama_produk'],
            'satuan' => $data['satuan'],
            'harga_beli' => $data['harga_beli'],
            'harga_jual' => $data['harga_jual'],
            'jumlah_stok' => $data['jumlah_stok'],
            'min_stok' => $data['min_stok'],
            'status' => $data['status'],
            'gambar_produk' => $data['gambar_produk'] ?? null
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:categories,id_kategori',
            'kode_produk' => 'required|unique:products,kode_produk,' . $product->id_produk . ',id_produk',
            'nama_produk' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer',
            'jumlah_stok' => 'required|integer',
            'min_stok' => 'required|integer',
            'status' => 'required|in:aktif,nonaktif',
            'gambar_produk' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['gambar_produk'] = $filename;
        }

        $product->update([
            'kategori_id' => $data['kategori_id'],
            'kode_produk' => $data['kode_produk'],
            'nama_produk' => $data['nama_produk'],
            'satuan' => $data['satuan'],
            'harga_beli' => $data['harga_beli'],
            'harga_jual' => $data['harga_jual'],
            'jumlah_stok' => $data['jumlah_stok'],
            'min_stok' => $data['min_stok'],
            'status' => $data['status'],
            'gambar_produk' => $data['gambar_produk'] ?? null
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus.');
    }
}
