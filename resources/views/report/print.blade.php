<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; margin: 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        h1 { margin: 0; font-size: 24px; }
        .date { color: #666; font-size: 14px; margin-top: 5px; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Pendapatan Penjualan</h1>
        <div class="date">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th class="text-right">Jumlah Transaksi</th>
                <th class="text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanHarian as $index => $hari)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($hari->tanggal)->translatedFormat('d F Y') }}</td>
                <td class="text-right">{{ $hari->jumlah_transaksi }} Trx</td>
                <td class="text-right">Rp {{ number_format($hari->total_pendapatan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-right bold">TOTAL KESELURUHAN</td>
                <td class="text-right bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
