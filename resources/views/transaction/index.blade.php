@extends('layouts.app')
@section('content')
<div class="content-header">
    <h2>Riwayat Transaksi</h2>
    <p>Lihat dan kelola riwayat penjualan</p>
</div>

<div class="summary-cards" style="display: flex; gap: 20px; margin-bottom: 20px;">
    <div class="card" style="flex: 1; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <div style="color: #64748b; font-size: 14px;">Total transaksi</div>
        <div style="font-size: 24px; font-weight: bold; color: #8b5cf6;">3</div>
    </div>
    <div class="card" style="flex: 1; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <div style="color: #64748b; font-size: 14px;">Total penjualan</div>
        <div style="font-size: 24px; font-weight: bold; color: #3b82f6;">Rp 31.000</div>
    </div>
    <div class="card" style="flex: 1; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0;">
        <div style="color: #64748b; font-size: 14px;">Laba kotor</div>
        <div style="font-size: 24px; font-weight: bold; color: #10b981;">Rp 14.000</div>
    </div>
</div>

<div class="action-bar" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
    <button class="btn btn-outline"><i class="fas fa-calendar"></i> Filter periode</button>
    <div class="search-box">
        <input type="text" class="form-control" placeholder="Cari nama atau kode barang...">
    </div>
</div>

<div class="table-container">
    <table class="table" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="border-bottom: 2px solid #e2e8f0; text-align: left;">
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
            <tr style="border-bottom: 1px solid #e2e8f0;">
                <td>TRX-2025-001</td>
                <td>22/12/2025 12:00</td>
                <td>Akbar Hidayat</td>
                <td>20</td>
                <td>Rp 5.000</td>
                <td>Tunai</td>
                <td><span style="background: #475569; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">Lunas</span></td>
                <td>
                    <button class="btn-icon" title="Lihat Detail"><i class="far fa-eye"></i></button>
                    <button class="btn-icon" title="Cetak"><i class="fas fa-print"></i></button>
                </td>
            </tr>
            </tbody>
    </table>
</div>

@endsection
