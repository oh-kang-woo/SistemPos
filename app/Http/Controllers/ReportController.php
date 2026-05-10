<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Tentukan rentang waktu (30 hari terakhir)
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // 2. Data Laporan Harian (Query Join yang sudah disesuaikan dengan DB Anda)
        $laporanHarian = DB::table('transactions')
            ->join('transaction_details', 'transactions.id_transaksi', '=', 'transaction_details.transaksi_id')
            ->join('products', 'transaction_details.produk_id', '=', 'products.id_produk') // Disesuaikan!
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->where('transactions.status', 'Lunas')
            ->select(
                DB::raw('DATE(transactions.created_at) as tanggal'),
                DB::raw('COUNT(DISTINCT transactions.id_transaksi) as jumlah_transaksi'),
                DB::raw('SUM(transaction_details.jumlah * products.harga_jual) as total_pendapatan'), // Total Harga Jual
                DB::raw('SUM(transaction_details.jumlah * products.harga_beli) as total_pengeluaran') // Total Harga Beli (Modal)
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $labelTanggal = [];
        $dataPendapatan = [];
        $dataPengeluaran = [];

        $totalSemuaPendapatan = 0;
        $totalSemuaPengeluaran = 0; // Ini adalah total modal barang yang terjual
        $totalSemuaTransaksi = 0;

        foreach ($laporanHarian as $data) {
            $labelTanggal[] = Carbon::parse($data->tanggal)->format('d M');
            $dataPendapatan[] = $data->total_pendapatan;
            $dataPengeluaran[] = $data->total_pengeluaran;

            $totalSemuaPendapatan += $data->total_pendapatan;
            $totalSemuaPengeluaran += $data->total_pengeluaran;
            $totalSemuaTransaksi += $data->jumlah_transaksi;
        }

        // 3. Hitung Pendapatan Bersih Keseluruhan (Pendapatan - Modal)
        $totalPendapatanBersih = $totalSemuaPendapatan - $totalSemuaPengeluaran;

        // 4. Data Metode Pembayaran (Untuk Chart Donut)
        $metodePembayaran = DB::table('transactions')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Lunas')
            ->select('metode_pembayaran', DB::raw('COUNT(id_transaksi) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        $labelMetode = $metodePembayaran->pluck('metode_pembayaran')->toArray();
        $dataMetode = $metodePembayaran->pluck('total')->toArray();

        return view('report.index', compact(
            'laporanHarian', 'labelTanggal', 'dataPendapatan', 'dataPengeluaran',
            'totalSemuaPendapatan', 'totalSemuaTransaksi', 'totalPendapatanBersih',
            'labelMetode', 'dataMetode'
        ));
    }

    public function print()
    {
        // Sesuaikan kueri print jika dibutuhkan
        $laporanHarian = DB::table('transactions')
            ->join('transaction_details', 'transactions.id_transaksi', '=', 'transaction_details.transaksi_id')
            ->join('products', 'transaction_details.produk_id', '=', 'products.id_produk')
            ->where('transactions.status', 'Lunas')
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
