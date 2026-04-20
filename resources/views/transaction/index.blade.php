@extends('layouts.app')

@section('content')

<style>
    .content-header {
        margin-bottom: 24px;
    }

    .content-header h2 {
        margin: 0 0 4px 0;
        color: #1e293b;
    }

    .content-header p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }

    .summary-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 24px;
    }

    .summary-card {
        flex: 1;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .card-title {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .card-value {
        font-size: 24px;
        font-weight: bold;
    }

    .text-purple { color: #8b5cf6; }
    .text-blue   { color: #3b82f6; }
    .text-green  { color: #10b981; }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-box input {
        min-width: 250px;
        padding: 8px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        outline: none;
    }

    .search-box input:focus {
        border-color: #3b82f6;
    }

    .table-container {
        background-color: #ffffff;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .classic-table {
        width: 100%;
        border-collapse: collapse;
    }

    .classic-table th,
    .classic-table td {
        padding: 12px 16px;
        text-align: left;
    }

    .classic-table th {
        background-color: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
    }

    .classic-table tr {
        border-bottom: 1px solid #e2e8f0;
    }

    .classic-table tr:last-child {
        border-bottom: none;
    }

    .classic-table tr:hover {
        background-color: #f1f5f9;
    }

    /* Badge Status */
    .badge-status {
        background-color: #475569;
        color: #ffffff;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Tombol Aksi */
    .btn-icon {
        background: none;
        border: none;
        color: #64748b;
        cursor: pointer;
        padding: 4px 8px;
        font-size: 16px;
        transition: color 0.2s;
    }

    .btn-icon:hover {
        color: #3b82f6;
    }

    .modal-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex; justify-content: center; align-items: center;
        z-index: 1000;
    }
    .modal-content {
        background: #fff; width: 500px; border-radius: 12px;
        padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .modal-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 12px;
    }
    .modal-header h3 { margin: 0; font-size: 18px; color: #1e293b; }
    .close-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b; }

    .info-box {
        background: #f8fafc; border-radius: 8px; padding: 16px;
        display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px;
    }
    .info-label { font-size: 12px; color: #94a3b8; margin-bottom: 4px; }
    .info-value { font-size: 14px; font-weight: 600; color: #1e293b; }

    .item-list { border-bottom: 1px dashed #cbd5e1; margin-bottom: 16px; padding-bottom: 16px; max-height: 200px; overflow-y: auto; }
    .item-row { display: flex; justify-content: space-between; margin-bottom: 12px; }
    .item-name { font-size: 14px; font-weight: 600; color: #1e293b; }
    .item-qty-price { font-size: 12px; color: #64748b; }
    .item-subtotal { font-size: 14px; font-weight: 600; color: #1e293b; }

    .summary-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; }
    .total-row { font-size: 18px; font-weight: bold; margin: 16px 0; border-top: 1px dashed #cbd5e1; padding-top: 16px; }
</style>

<div class="content-header">
    <h2>Riwayat Transaksi</h2>
    <p>Lihat dan kelola riwayat penjualan</p>
</div>

<div class="summary-cards">
    <div class="summary-card">
        <div class="card-title">Total transaksi</div>
        <div class="card-value text-purple">{{ number_format($totalTransaksi, 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
        <div class="card-title">Total penjualan</div>
        <div class="card-value text-blue">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
    </div>
    <div class="summary-card">
        <div class="card-title">Laba kotor</div>
        <div class="card-value text-green">Rp {{ number_format($labaKotor, 0, ',', '.') }}</div>
    </div>
</div>

<div class="action-bar">
    <button class="btn btn-outline"><i class="fas fa-calendar"></i> Filter periode</button>
    <div class="search-box">
        <input type="text" placeholder="Cari nama atau kode barang...">
    </div>
</div>

<div class="table-container">
    <table class="classic-table">
        <thead>
            <tr>
                <th>No. Transaksi</th>
                <th>Tanggal/Jam</th>
                <th>Kasir</th>
                <th>Total item</th>
                <th>Total pembayaran</th>
                <th>Metode bayar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            <tr>
                <td style="font-weight: 600;">{{ $trx->no_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $trx->nama_kasir }}</td>
                <td>{{ $trx->total_item }}</td>
                <td>Rp {{ number_format($trx->total_pembayaran, 0, ',', '.') }}</td>
                <td>{{ $trx->metode_bayar }}</td>
                <td>
                    <span class="badge-status" style="background-color: {{ $trx->status == 'Lunas' ? '#475569' : '#ef4444' }};">
                        {{ $trx->status }}
                    </span>
                </td>
                <td>
                    <button class="btn-icon" title="Lihat Detail"
                        onclick="openDetailModal(this)"
                        data-trx="{{ json_encode($trx) }}"
                        data-date="{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}">
                        <i class="far fa-eye"></i>
                    </button>
                    <a href="{{ route('transaction.print', $trx->id_transaksi) }}" target="_blank" class="btn-icon" title="Cetak" style="text-decoration: none;">
                        <i class="fas fa-print"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 30px; color: #64748b;">
                    <i class="fas fa-receipt" style="font-size: 32px; margin-bottom: 10px; color: #cbd5e1;"></i><br>
                    Belum ada riwayat transaksi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


<div id="modalDetail" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Transaksi</h3>
            <button class="close-btn" onclick="closeDetailModal()">&times;</button>
        </div>

        <div class="info-box">
            <div>
                <div class="info-label">No. Transaksi</div>
                <div class="info-value" id="mdl-no">TRX-000</div>
            </div>
            <div>
                <div class="info-label">Tanggal/Jam</div>
                <div class="info-value" id="mdl-date">00/00/0000</div>
            </div>
            <div>
                <div class="info-label">Kasir</div>
                <div class="info-value" id="mdl-kasir">Nama Kasir</div>
            </div>
            <div>
                <div class="info-label">Status</div>
                <div class="info-value"><span class="badge-status" id="mdl-status">Lunas</span></div>
            </div>
        </div>

        <div style="font-size: 14px; font-weight: bold; margin-bottom: 12px;">Item Transaksi</div>
        <div class="item-list" id="mdl-items">
            </div>

        <div class="summary-row total-row">
            <span>Total pembayaran</span>
            <span id="mdl-total">Rp 0</span>
        </div>

        <div style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">Pembayaran</div>
        <div class="summary-row">
            <span style="color: #64748b;" id="mdl-metode">Tunai</span>
            <span id="mdl-bayar">Rp 0</span>
        </div>
        <div class="summary-row">
            <span style="color: #10b981;">Kembalian</span>
            <span style="color: #10b981;" id="mdl-kembali">Rp 0</span>
        </div>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button onclick="closeDetailModal()" class="btn btn-outline" style="flex: 1; padding: 10px; border-radius: 6px; border: 1px solid #cbd5e1; background: white; cursor: pointer;">Tutup</button>
            <a href="#" id="mdl-btn-print" target="_blank" style="flex: 1; padding: 10px; border-radius: 6px; background: #1e293b; color: white; text-align: center; text-decoration: none; font-weight: 500;">
                <i class="fas fa-print"></i> Cetak ulang
            </a>
        </div>
    </div>
</div>

<script>
    function formatRupiah(angka) {
        return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
    }

    function openDetailModal(button) {
        // Ambil data JSON dari tombol
        let trx = JSON.parse(button.getAttribute('data-trx'));
        let date = button.getAttribute('data-date');

        // Isi informasi umum
        document.getElementById('mdl-no').innerText = trx.no_transaksi;
        document.getElementById('mdl-date').innerText = date;
        document.getElementById('mdl-kasir').innerText = trx.nama_kasir;
        document.getElementById('mdl-status').innerText = trx.status;

        // Isi total & pembayaran
        document.getElementById('mdl-total').innerText = formatRupiah(trx.total_pembayaran);
        document.getElementById('mdl-metode').innerText = trx.metode_bayar;
        document.getElementById('mdl-bayar').innerText = formatRupiah(trx.uang_diterima);
        document.getElementById('mdl-kembali').innerText = formatRupiah(trx.kembalian);

        // Atur URL tombol Cetak Ulang
        document.getElementById('mdl-btn-print').href = `/riwayat-transaksi/${trx.id_transaksi}/cetak`;

        // Susun daftar item
        let itemsHtml = '';
        trx.details.forEach(item => {
            itemsHtml += `
            <div class="item-row">
                <div>
                    <div class="item-name">${item.nama_produk}</div>
                    <div class="item-qty-price">${formatRupiah(item.harga_satuan)} x ${item.jumlah}</div>
                </div>
                <div class="item-subtotal">${formatRupiah(item.subtotal)}</div>
            </div>`;
        });
        document.getElementById('mdl-items').innerHTML = itemsHtml;

        // Tampilkan Modal
        document.getElementById('modalDetail').style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('modalDetail').style.display = 'none';
    }
</script>
@endsection
