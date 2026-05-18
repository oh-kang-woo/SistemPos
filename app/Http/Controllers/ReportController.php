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
    $businessId = auth()->user()->business_id;

        // 2. Data Penjualan & Modal Barang
        $laporanHarian = DB::table('transactions')
            ->join('transaction_details', 'transactions.id_transaksi', '=', 'transaction_details.transaksi_id')
            ->join('products', 'transaction_details.produk_id', '=', 'products.id_produk')
            ->whereBetween('transactions.created_at', [$startDate, $endDate])
            ->where('transactions.status', 'Lunas')
            ->select(
                DB::raw('DATE(transactions.created_at) as tanggal'),
                DB::raw('COUNT(DISTINCT transactions.id_transaksi) as jumlah_transaksi'),
                DB::raw('SUM(transaction_details.jumlah * products.harga_jual) as total_pendapatan'),
                DB::raw('SUM(transaction_details.jumlah * products.harga_beli) as total_modal_barang')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get();

        // 3. Tarik Data Pengeluaran Operasional per Hari
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

        // 4. Gabungkan Data (Modal + Operasional)
        foreach ($laporanHarian as $data) {
            $tglString = Carbon::parse($data->tanggal)->format('Y-m-d');
            $opExpense = $pengeluaranOperasional[$tglString] ?? 0;

            $labelTanggal[] = Carbon::parse($data->tanggal)->format('d M');
            $dataPendapatan[] = $data->total_pendapatan;
            $dataPengeluaran[] = $opExpense;

            $totalSemuaPendapatan += $data->total_pendapatan;
            $totalSemuaTransaksi += $data->jumlah_transaksi;
        }

        // Hitung total pengeluaran keseluruhan (modal + operasional)
        $totalSemuaPengeluaran = $pengeluaranOperasional->sum();

        // 5. Hitung Pendapatan Bersih Real (Pendapatan - (Modal + Operasional))
        $totalPendapatanBersih = $totalSemuaPendapatan - $totalSemuaPengeluaran;

        // 6. Data Metode Pembayaran (Chart Donut)
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
        // Sesuaikan jika diperlukan
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
