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
</style>

<div class="content-header">
    <h2>Riwayat Transaksi</h2>
    <p>Lihat dan kelola riwayat penjualan</p>
</div>

<div class="summary-cards">
    <div class="summary-card">
        <div class="card-title">Total transaksi</div>
        <div class="card-value text-purple">3</div>
    </div>
    <div class="summary-card">
        <div class="card-title">Total penjualan</div>
        <div class="card-value text-blue">Rp 31.000</div>
    </div>
    <div class="summary-card">
        <div class="card-title">Laba kotor</div>
        <div class="card-value text-green">Rp 14.000</div>
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
            <tr>
                <td>TRX-2025-001</td>
                <td>22/12/2025 12:00</td>
                <td>Akbar Hidayat</td>
                <td>20</td>
                <td>Rp 5.000</td>
                <td>Tunai</td>
                <td><span class="badge-status">Lunas</span></td>
                <td>
                    <button class="btn-icon" title="Lihat Detail"><i class="far fa-eye"></i></button>
                    <button class="btn-icon" title="Cetak"><i class="fas fa-print"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
