<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|unique:categories,nama_kategori',
            'deskripsi' => 'nullable',
            'gambar_kategori' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_kategori')) {
            $file = $request->file('gambar_kategori');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['gambar_kategori'] = $filename;
        }

        Category::create([
            'nama_kategori' => $data['nama_kategori'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'gambar_kategori' => $data['gambar_kategori'] ?? null
        ]);

        return redirect()->route('product.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        if ($category->products()->count() > 0) {
            return redirect()->route('product.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk terkait.');
        }

        $category->delete();
        return redirect()->route('product.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
