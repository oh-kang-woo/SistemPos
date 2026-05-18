<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil ID Bisnis User yang Sedang Login (Multi-Tenant System)
        $businessId = auth()->user()->business_id;

        // 2. Definisikan Rentang Tanggal Filter (Default: Sebulan Terakhir)
        $startDate = $request->input('start_date')
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->startOfMonth()->startOfDay();

        $endDate = $request->input('end_date')
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        // 3. Data Penjualan & Modal Barang
        $reportData = DB::table('transactions')
            ->where('transactions.business_id', $businessId)
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(transactions.created_at) as tanggal'),
                DB::raw('COUNT(DISTINCT transactions.id_transaksi) as jumlah_transaksi'),
                DB::raw('SUM(transactions.total_harga) as total_pendapatan'),
                DB::raw('SUM(transactions.total_harga * 0.7) as total_modal_barang') // Asumsi modal HPP 70%
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // 4. Tarik Data Pengeluaran Operasional per Hari
        $pengeluaranOperasional = DB::table('expenses')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('SUM(nominal) as total_operasional'))
            ->groupBy('tanggal')
            ->pluck('total_operasional', 'tanggal');

        $labelTanggal = [];
        $dataPendapatan = [];
        $dataPengeluaran = [];

        $totalSemuaPendapatan = 0;
        $totalSemuaTransaksi = 0;
        $totalSemuaModalBarang = 0;

        // 5. Gabungkan Data (Modal + Operasional)
        foreach ($reportData as $data) {
            $tglString = Carbon::parse($data->tanggal)->format('Y-m-d');
            $opExpense = $pengeluaranOperasional[$tglString] ?? 0;

            $totalPengeluaranHariIni = $data->total_modal_barang + $opExpense;

            $labelTanggal[] = Carbon::parse($data->tanggal)->format('d M');
            $dataPendapatan[] = $data->total_pendapatan;
            $dataPengeluaran[] = $totalPengeluaranHariIni;

            $totalSemuaPendapatan += $data->total_pendapatan;
            $totalSemuaTransaksi += $data->jumlah_transaksi;
            $totalSemuaModalBarang += $data->total_modal_barang;
        }

        // Hitung total biaya operasional murni dari tabel expenses
        $totalSemuaOperasional = $pengeluaranOperasional->sum();

        // 6. PERBAIKAN RUMUS: Pendapatan Bersih
        $totalPendapatanBersih = $totalSemuaPendapatan - ($totalSemuaModalBarang + $totalSemuaOperasional);

        // 7. PERBAIKAN UTAMA: Tarik Data Metode Pembayaran Asli secara Dinamis dari Database
        $metodePembayaranData = DB::table('transactions')
            ->where('business_id', $businessId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('metode_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        // Pecah menjadi array terpisah untuk dikirimkan ke Chart.js
        $labelMetode = $metodePembayaranData->pluck('metode_pembayaran')->toArray();
        $dataMetode = $metodePembayaranData->pluck('total')->toArray();

        // Formatisasi variabel tanggal untuk filter view halaman
        $startDateStr = $startDate->format('Y-m-d');
        $endDateStr = $endDate->format('Y-m-d');

        return view('report.index', compact(
            'reportData', 'labelTanggal', 'dataPendapatan', 'dataPengeluaran',
            'totalSemuaPendapatan', 'totalSemuaTransaksi', 'totalPendapatanBersih',
            'labelMetode', 'dataMetode', 'startDateStr', 'endDateStr'
        ));
    }

    public function print()
    {
        $businessId = auth()->user()->business_id;

        $laporanHarian = DB::table('transactions')
            ->where('business_id', $businessId)
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(DISTINCT id_transaksi) as jumlah_transaksi'),
                DB::raw('SUM(total_harga) as total_pendapatan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPendapatan = $laporanHarian->sum('total_pendapatan');

        return view('report.print', compact('laporanHarian', 'totalPendapatan'));
    }
}
