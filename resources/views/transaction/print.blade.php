<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk - {{ $transaction->no_transaksi }}</title>
    <style>
        body { font-family: monospace; color: #000; width: 300px; margin: 0 auto; padding: 20px; font-size: 14px; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .divider { border-bottom: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { vertical-align: top; padding: 2px 0; }
        .bold { font-weight: bold; }
        @media print {
            body { width: 100%; margin: 0; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="text-center">
        <h2 style="margin-bottom: 5px;">POS SYSTEM</h2>
        <p style="margin-top: 0; font-size: 12px;">Jl. Contoh Alamat No. 123<br>Telp: 08123456789</p>
    </div>

    <div class="divider"></div>

    <table>
        <tr><td>No</td><td>: {{ $transaction->no_transaksi }}</td></tr>
        <tr><td>Tgl</td><td>: {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}</td></tr>
        <tr><td>Kasir</td><td>: {{ $transaction->nama_kasir }}</td></tr>
    </table>

    <div class="divider"></div>

    <table>
        @foreach($transaction->details as $item)
        <tr>
            <td colspan="3" class="bold">{{ $item->nama_produk }}</td>
        </tr>
        <tr>
            <td>{{ $item->jumlah }} x</td>
            <td>{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
            <td class="text-right">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="bold">Total</td>
            <td class="text-right bold">Rp {{ number_format($transaction->total_pembayaran, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bayar ({{ $transaction->metode_bayar }})</td>
            <td class="text-right">Rp {{ number_format($transaction->uang_diterima, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td class="text-right">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="text-center" style="margin-top: 20px;">
        <p>Terima Kasih<br>Selamat Belanja Kembali</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
