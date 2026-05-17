<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengeluaran</title>
    <style>
        /* Gaya CSS khusus agar rapi saat diprint di kertas */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            background-color: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2 { margin: 0; padding: 0; }
        .header p { margin: 5px 0 0 0; font-size: 12px; color: #555; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th { background-color: #f2f2f2; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>LAPORAN PENGELUARAN TOKO</h2>
        <p>Waktu Cetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 40%;">Deskripsi</th>
                <th class="text-right" style="width: 20%;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            {{-- Variabel bantuan untuk menghitung total pengeluaran --}}
            @php $totalKeseluruhan = 0; @endphp

            @forelse($pengeluaran as $index => $item)
                @php $totalKeseluruhan += $item->nominal; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $item->category->nama_kategori ?? 'Umum' }}</td>
                    <td>{{ $item->deskripsi ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 20px;">Tidak ada data pengeluaran pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right font-bold">Total Pengeluaran</td>
                <td class="text-right font-bold">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
