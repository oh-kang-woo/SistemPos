<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        // Ambil business_id dari user yang sedang login
        $businessId = auth()->user()->business_id;

        $request->validate([
            // Validasi UNIQUE dikunci hanya untuk business_id toko yang sama
            'nama_kategori' => [
                'required',
                Rule::unique('categories', 'nama_kategori')->where(function ($query) use ($businessId) {
                    return $query->where('business_id', $businessId);
                })
            ],
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

        // Menyisipkan business_id saat membuat kategori baru
        Category::create([
            'business_id' => $businessId, // Mengunci kategori ke toko ini
            'nama_kategori' => $data['nama_kategori'],
            'deskripsi' => $data['deskripsi'] ?? null,
            'gambar_kategori' => $data['gambar_kategori'] ?? null
        ]);

        return redirect()->route('product.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroyCategory($id)
    {
        // Mencari kategori berdasarkan primary key khususmu yaitu 'id_kategori'
        $category = Category::where('id_kategori', $id)
                            ->where('business_id', auth()->user()->business_id) // Pengaman ekstra agar tidak menghapus kategori toko lain
                            ->firstOrFail();

        if ($category->products()->count() > 0) {
            return redirect()->route('product.index')->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk terkait.');
        }

        // Hapus file gambar jika ada sebelum record di-delete (Opsional tapi bagus untuk kebersihan storage)
        if ($category->gambar_kategori && file_exists(public_path('images/' . $category->gambar_kategori))) {
            unlink(public_path('images/' . $category->gambar_kategori));
        }

        $category->delete();
        return redirect()->route('product.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
