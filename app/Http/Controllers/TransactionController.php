<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;

class TransactionController extends Controller
{
    public function index()
    {
        // 1. Ambil business_id dari user yang sedang login
        $businessId = auth()->user()->business_id;

        // 2. Ambil data transaksi toko ini beserta relasi detail dan data user/kasir
        $transactions = Transaction::where('business_id', $businessId)
                                    ->with(['details', 'user'])
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        // 3. Hitung data untuk Kartu Ringkasan
        $totalTransaksi = $transactions->count();
        $totalPenjualan = $transactions->sum('total_harga'); // Sesuai kolom database

        // 4. Hitung Laba Kotor dari detail transaksi toko ini
        $labaKotor = 0;

        $semuaDetail = TransactionDetail::whereHas('transaction', function ($query) use ($businessId) {
            $query->where('business_id', $businessId);
        })->get();

        foreach ($semuaDetail as $detail) {
            $produk = Product::where('id_produk', $detail->produk_id)
                             ->where('business_id', $businessId)
                             ->first();

            $hargaModal = $produk ? $produk->harga_beli : 0;
            $totalModalItem = $hargaModal * $detail->jumlah;

            $labaKotor += ($detail->subtotal - $totalModalItem);
        }

        return view('transaction.index', compact('transactions', 'totalTransaksi', 'totalPenjualan', 'labaKotor'));
    }

    public function checkout(Request $request)
    {
        $businessId = auth()->user()->business_id;

        DB::beginTransaction();

        try {
            // 1. Simpan data ke tabel transactions sesuai dengan struktur migrasi asli
            $transaksi = new Transaction();
            $transaksi->business_id   = $businessId;
            $transaksi->nomor_invoice = 'TRX-' . $businessId . '-' . time();
            $transaksi->user_id       = auth()->id();
            $transaksi->total_harga   = $request->total_pembayaran; // Diambil dari input form kasir
            $transaksi->bayar         = $request->uang_diterima;    // Diambil dari input form kasir
            $transaksi->kembali       = $request->uang_kembali;      // Diambil dari input form kasir
            $transaksi->save();

            // 2. Loop data keranjang dari request AJAX
            foreach ($request->cart as $item) {
                $produk = Product::where('id_produk', $item['id'])
                                 ->where('business_id', $businessId)
                                 ->first();

                if (!$produk || $produk->jumlah_stok < $item['qty']) {
                    throw new \Exception("Stok untuk produk " . $item['name'] . " tidak mencukupi.");
                }

                // Simpan data ke tabel transaction_details
                $detail = new TransactionDetail();
                $detail->transaksi_id = $transaksi->id_transaksi; // Primary key dari tabel transaksi asli
                $detail->produk_id    = $item['id'];
                $detail->nama_produk  = $item['name'];
                $detail->harga_satuan = $item['price'];
                $detail->jumlah       = $item['qty'];
                $detail->subtotal     = $item['price'] * $item['qty'];
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
        $businessId = auth()->user()->business_id;

        $transaction = Transaction::where('id_transaksi', $id_transaksi)
                                  ->where('business_id', $businessId)
                                  ->with('details')
                                  ->firstOrFail();

        return view('transaction.print', compact('transaction'));
    }
}
