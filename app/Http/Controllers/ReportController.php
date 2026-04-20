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
        $startDate = \Carbon\Carbon::now()->subDays(29)->startOfDay();
        $endDate = \Carbon\Carbon::now()->endOfDay();

        // 2. Data Laporan Harian (Untuk Tabel & Chart Bar Pendapatan)
        $laporanHarian = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Lunas')
            ->select(
                \Illuminate\Support\Facades\DB::raw('DATE(created_at) as tanggal'),
                \Illuminate\Support\Facades\DB::raw('SUM(total_pembayaran) as total_pendapatan'),
                \Illuminate\Support\Facades\DB::raw('COUNT(id_transaksi) as jumlah_transaksi')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        $labelTanggal = [];
        $dataPendapatan = [];
        $dataPengeluaran = []; // Array untuk data chart bar pengeluaran
        $totalSemuaPendapatan = 0;
        $totalSemuaTransaksi = 0;

        foreach ($laporanHarian as $data) {
            $labelTanggal[] = \Carbon\Carbon::parse($data->tanggal)->format('d M');
            $dataPendapatan[] = $data->total_pendapatan;

            // Catatan: Karena belum tahu struktur tabel Pengeluaranmu,
            // ini saya isi dengan data dummy (acak) agar chart langsung tampil mirip gambarmu.
            // Jika tabel Pengeluaran sudah ada, ganti kode ini dengan kueri database sungguhan.
            $dataPengeluaran[] = rand(500000, 2500000);

            $totalSemuaPendapatan += $data->total_pendapatan;
            $totalSemuaTransaksi += $data->jumlah_transaksi;
        }

        // 3. Data Metode Pembayaran (Untuk Chart Donut)
        $metodePembayaran = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Lunas')
            ->select('metode_pembayaran', \Illuminate\Support\Facades\DB::raw('COUNT(id_transaksi) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        $labelMetode = $metodePembayaran->pluck('metode_pembayaran')->toArray();
        $dataMetode = $metodePembayaran->pluck('total')->toArray();

        return view('report.index', compact(
            'laporanHarian', 'labelTanggal', 'dataPendapatan', 'dataPengeluaran',
            'totalSemuaPendapatan', 'totalSemuaTransaksi',
            'labelMetode', 'dataMetode'
        ));
    }

    public function print()
    {
        // Ambil data yang sama untuk halaman cetak
        $laporanHarian = Transaction::where('status', 'Lunas')
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_pembayaran) as total_pendapatan'),
                DB::raw('COUNT(id_transaksi) as jumlah_transaksi')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc') // Diurutkan dari yang terbaru
            ->get();

        $totalPendapatan = $laporanHarian->sum('total_pendapatan');

        return view('report.print', compact('laporanHarian', 'totalPendapatan'));
    }
}
