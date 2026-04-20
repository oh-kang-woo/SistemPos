<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- INI TAMBAHAN WAJIB
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;

class TransactionController extends Controller
{
    public function index()
    {
        // 1. Ambil semua data transaksi beserta detailnya
        $transactions = Transaction::with('details')->orderBy('created_at', 'desc')->get();

        // 2. Hitung data untuk Kartu Ringkasan
        $totalTransaksi = $transactions->count();
        $totalPenjualan = $transactions->where('status', 'Lunas')->sum('total_pembayaran');

        // 3. Hitung Laba Kotor
        $labaKotor = 0;
        $semuaDetail = TransactionDetail::all();
        foreach ($semuaDetail as $detail) {
            $produk = Product::find($detail->produk_id);
            // Ambil harga modal dari tabel produk (jika produk sudah dihapus, anggap modal 0)
            $hargaModal = $produk ? $produk->harga_beli : 0;
            $totalModalItem = $hargaModal * $detail->jumlah;

            $labaKotor += ($detail->subtotal - $totalModalItem);
        }

        // 4. Kirim data ke tampilan (View)
        return view('transaction.index', compact('transactions', 'totalTransaksi', 'totalPenjualan', 'labaKotor'));
        }


    public function checkout(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1. Simpan data ke tabel transactions
            $transaksi = new Transaction();

            // Wajib diisi sesuai kolom databasemu
            $transaksi->no_transaksi = 'TRX-' . time();
            $transaksi->nama_kasir = 'Kasir Utama'; // Bisa kamu ganti auth()->user()->name nanti

            // Kolom nama_pelanggan & tanggal_transaksi DIHAPUS karena tidak ada di gambarmu

            $transaksi->total_item = $request->total_item;
            $transaksi->total_pembayaran = $request->total_pembayaran;
            $transaksi->uang_diterima = $request->uang_diterima;
            $transaksi->uang_kembali = $request->uang_kembali;
            $transaksi->metode_pembayaran = $request->metode_pembayaran;
            $transaksi->status = 'lunas'; // Sesuai databasemu
            $transaksi->save();

            // 2. Loop data keranjang dari request AJAX
            foreach ($request->cart as $item) {
                // Cari produk berdasarkan ID yang dikirim
                $produk = Product::where('id_produk', $item['id'])->first();

                // Cek apakah produk ada dan stoknya cukup
                if (!$produk || $produk->jumlah_stok < $item['qty']) {
                    throw new \Exception("Stok untuk produk " . $item['name'] . " tidak mencukupi (Sisa: " . ($produk->jumlah_stok ?? 0) . ").");
                }

                // Simpan data ke tabel transaction_details
                $detail = new TransactionDetail();
                $detail->transaksi_id = $transaksi->id_transaksi;
                $detail->produk_id = $item['id'];

                // Tambahan Wajib: nama_produk (sesuai gambarmu)
                $detail->nama_produk = $item['name'];

                $detail->harga_satuan = $item['price'];
                $detail->jumlah = $item['qty'];
                $detail->subtotal = $item['price'] * $item['qty'];
                $detail->save();

                // 3. Kurangi stok produk
                $produk->decrement('jumlah_stok', $item['qty']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dan stok sudah dikurangi!',
                'transaksi_id' => $transaksi->id_transaksi
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print($id_transaksi)
    {
        $transaction = Transaction::with('details')->findOrFail($id_transaksi);
        return view('transaction.print', compact('transaction'));
    }
}
