<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
   public function index(Request $request)
{
    $businessId = auth()->user()->business_id;

    // Tentukan rentang tanggal (default 30 hari terakhir)
    $startDate = $request->get('start_date', now()->subDays(30)->format('Y-m-d') . ' 00:00:00');
    $endDate = $request->get('end_date', now()->format('Y-m-d') . ' 23:59:59');

    // 1. Query Data Laporan Utama (Tabel & Grafik Garis/Batang)
    $reportData = DB::table('transactions')
        ->join('transaction_details', 'transactions.id_transaksi', '=', 'transaction_details.transaksi_id')
        ->join('products', 'transaction_details.produk_id', '=', 'products.id_produk')
        ->select(
            DB::raw('DATE(transactions.created_at) as tanggal'),
            DB::raw('COUNT(DISTINCT transactions.id_transaksi) as jumlah_transaksi'),
            DB::raw('SUM(transaction_details.jumlah * products.harga_jual) as total_pendapatan'),
            DB::raw('SUM(transaction_details.jumlah * products.harga_beli) as total_pengeluaran')
        )
        ->where('transactions.business_id', $businessId)
        ->whereBetween('transactions.created_at', [$startDate, $endDate])
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

    // --- PERBAIKAN: Mengganti query metode_pembayaran yang eror dengan data default ---
    // Jika nanti kamu menambahkan kolom metode_pembayaran di migrasi, kamu bisa kembalikan ke query DB.
    $labelMetode = ['Tunai / Cash'];
    $dataMetode  = [$reportData->sum('jumlah_transaksi')]; // Mengasumsikan semua trx sementara dianggap tunai

    // 3. Kalkulasi Ringkasan Box Atas
    $totalSemuaPendapatan  = $reportData->sum('total_pendapatan');
    $totalPengeluaran       = $reportData->sum('total_pengeluaran');
    $totalPendapatanBersih  = $totalSemuaPendapatan - $totalPengeluaran;
    $totalSemuaTransaksi    = $reportData->sum('jumlah_transaksi');

    // 4. Ekstraksi Data Array Untuk Dikonsumsi Chart.js
    $labelTanggal    = [];
    $dataPendapatan  = [];
    $dataPengeluaran = [];

    foreach ($reportData as $row) {
        $labelTanggal[]    = \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M');
        $dataPendapatan[]  = (int) $row->total_pendapatan;
        $dataPengeluaran[] = (int) $row->total_pengeluaran;
    }

    return view('report.index', compact(
        'reportData',
        'totalSemuaPendapatan',
        'totalPendapatanBersih',
        'totalSemuaTransaksi',
        'labelTanggal',
        'dataPendapatan',
        'dataPengeluaran',
        'labelMetode',
        'dataMetode',
        'startDate',
        'endDate'
    ));
}

    public function print()
    {
        $businessId = auth()->user()->business_id;

        // PERBAIKAN: Menghapus filter status lunas yang merusak query SQL
        $laporanHarian = DB::table('transactions')
            ->join('transaction_details', 'transactions.id_transaksi', '=', 'transaction_details.transaksi_id')
            ->join('products', 'transaction_details.produk_id', '=', 'products.id_produk')
            ->where('transactions.business_id', $businessId)
            ->select(
                DB::raw('DATE(transactions.created_at) as tanggal'),
                DB::raw('COUNT(DISTINCT transactions.id_transaksi) as jumlah_transaksi'),
                DB::raw('SUM(transaction_details.jumlah * products.harga_jual) as total_pendapatan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPendapatan = $laporanHarian->sum('total_pendapatan');

        return view('report.print', compact('laporanHarian', 'totalPendapatan'));
    }
}
