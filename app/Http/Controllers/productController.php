<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. MENAMPILKAN PRODUK & KATEGORI PER TOKO
   public function index()
    {
        $businessId = auth()->user()->business_id;

        // 1. Ambil produk milik toko ini
        $products = Product::where('business_id', $businessId)
                        ->with('category')
                        ->get();

        // 2. Ambil kategori milik toko ini untuk dropdown form
        $categories = Category::where('business_id', $businessId)->get();

        // 3. HITUNG PRODUK STOK MENIPIS (Solusi Error)
        // Menghitung berapa banyak produk yang jumlah_stok-nya kurang dari atau sama dengan min_stok
        $lowStockCount = Product::where('business_id', $businessId)
                                ->whereRaw('jumlah_stok <= min_stok')
                                ->count();

        // 4. Kirim ketiga variabel ke view
        return view('product.index', compact('products', 'categories', 'lowStockCount'));
    }

    // 2. MENYIMPAN PRODUK BARU (KUNCI HANYA ADA SATU DI SINI)
    public function store(Request $request)
    {
        $businessId = auth()->user()->business_id;

        $request->validate([
            'kategori_id'   => ['required'],
            'kode_produk'   => ['required', 'string', 'unique:products,kode_produk'],
            'nama_produk'   => ['required', 'string', 'max:255'],
            'harga_beli'    => ['required', 'numeric'],
            'harga_jual'    => ['required', 'numeric'],
            'jumlah_stok'   => ['required', 'numeric'],
            'gambar_produk' => ['nullable', 'image', 'max:2048']
        ]);

        $gambarName = null;
        if ($request->hasFile('gambar_produk')) {
            $file = $request->file('gambar_produk');
            $gambarName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/produk'), $gambarName);
        }

        // Simpan produk dengan mengunci ke business_id toko tersebut
        Product::create([
            'business_id'   => $businessId,
            'kategori_id'   => $request->kategori_id,
            'kode_produk'   => $request->kode_produk,
            'nama_produk'   => $request->nama_produk,
            'satuan'        => $request->satuan ?? 'pcs',
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'jumlah_stok'   => $request->jumlah_stok,
            'min_stok'      => $request->min_stok ?? 10,
            'status'        => 'aktif',
            'gambar_produk' => $gambarName
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan ke toko Anda.');
    }

 public function update(Request $request, $id)
{
    // 1. Validasi Input Data (Disamakan dengan form input)
    $request->validate([
        'nama_produk'   => 'required|string|max:255',
        'kategori_id'   => 'required',
        'satuan'        => 'required|string',
        'harga_beli'    => 'required|numeric|min:0',
        'harga_jual'    => 'required|numeric|min:0',
        'jumlah_stok'   => 'required|numeric|min:0',
        'min_stok'      => 'required|numeric|min:0',
        'status'        => 'required|string',
        'gambar_produk' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // 2. Cari data produk berdasarkan id_produk
    $product = Product::findOrFail($id);

    // 3. Siapkan array data perubahan
    $data = [
        'nama_produk' => $request->nama_produk,
        'kategori_id' => $request->kategori_id,
        'satuan'      => $request->satuan,
        'harga_beli'  => $request->harga_beli,
        'harga_jual'  => $request->harga_jual,
        'jumlah_stok' => $request->jumlah_stok,
        'min_stok'    => $request->min_stok,
        'status'      => $request->status,
    ];

    // 4. Proses Upload Gambar Baru (Jika user mengganti gambar)
    if ($request->hasFile('gambar_produk')) {
        // Hapus gambar lama di folder public/images/produk jika ada
        if ($product->gambar_produk && file_exists(public_path('images/produk/' . $product->gambar_produk))) {
            @unlink(public_path('images/produk/' . $product->gambar_produk));
        }

        // Upload gambar baru dengan memindahkannya ke public_path (konsisten dengan fungsi store)
        $file = $request->file('gambar_produk');
        $gambarName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('images/produk'), $gambarName);

        $data['gambar_produk'] = $gambarName;
    }

    // 5. Jalankan update ke database
    $product->update($data);

    // 6. Alihkan kembali dengan notifikasi sukses
    return redirect()->route('product.index')->with('success', 'Data produk berhasil diperbarui!');
}

public function destroy($id)
{
    // 1. Cari data produk berdasarkan ID, lempar eror 404 jika tidak ketemu
    $product = Product::findOrFail($id);

    // 2. Hapus berkas gambar produk dari storage (jika ada dan bukan gambar default)
    if ($product->gambar && $product->gambar !== 'default.png') {
        Storage::disk('public')->delete('products/' . $product->gambar);
    }

    // 3. Hapus baris data produk dari tabel database
    $product->delete();

    // 4. Kembali ke halaman utama produk dengan notifikasi sukses
    return redirect()->route('product.index')
        ->with('success', 'Produk berhasil dihapus dari sistem!');
}
}
