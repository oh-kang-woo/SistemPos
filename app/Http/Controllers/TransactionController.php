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
        $businessId = auth()->user()->business_id;

        $transactions = Transaction::where('business_id', $businessId)
                                    ->with(['details', 'user'])
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        $totalTransaksi = $transactions->count();
        $totalPenjualan = $transactions->sum('total_harga');

        $labaKotor = 0;

        $semuaDetail = TransactionDetail::whereHas('transaction', function ($query) use ($businessId) {
            $query->where('business_id', $businessId);
        })->get();

        foreach ($semuaDetail as $detail) {
            $produk = Product::where('id_produk', $detail->produk_id)
                             ->where('business_id', $businessId)
                             ->first();

            // Pengaman kalkulasi: Jika produk sempat dihapus kasir, hitung estimasi modal agar laba tidak minus menor
            $hargaModal = $produk ? $produk->harga_beli : ($detail->harga_satuan * 0.7);
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
            $transaksi = new Transaction();
            $transaksi->business_id       = $businessId;
            $transaksi->nomor_invoice     = 'TRX-' . $businessId . '-' . time();
            $transaksi->user_id           = auth()->id();
            $transaksi->total_harga       = $request->total_pembayaran;
            $transaksi->bayar             = $request->uang_diterima;
            $transaksi->kembali           = $request->uang_kembali;
            $transaksi->metode_pembayaran = $request->input('metode_pembayaran', 'Tunai');
            $transaksi->nama_pelanggan    = $request->input('nama_pelanggan', 'Tanpa Nama');
            $transaksi->save();

            foreach ($request->cart as $item) {
                $produk = Product::where('id_produk', $item['id'])
                                 ->where('business_id', $businessId)
                                 ->first();

                if (!$produk || $produk->jumlah_stok < $item['qty']) {
                    throw new \Exception("Stok untuk produk " . $item['name'] . " tidak mencukupi.");
                }

                $detail = new TransactionDetail();
                $detail->transaksi_id = $transaksi->id_transaksi;
                $detail->produk_id    = $item['id'];
                $detail->nama_produk  = $item['name'];
                $detail->harga_satuan = $item['price'];
                $detail->jumlah       = $item['qty'];
                $detail->subtotal     = $item['price'] * $item['qty'];
                $detail->save();

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
