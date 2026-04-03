@extends('layouts.app')

@section('content')

<style>
    .product-wrapper {
        padding: 24px 32px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .header-title {
        font-size: 24px;
        font-weight: bold;
        color: #111827;
        margin: 0 0 4px 0;
    }
    .header-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin: 0;
    }
    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: 0.2s ease-in-out;
    }
    .btn-outline {
        background-color: #ffffff;
        border: 1px solid #d1d5db;
        color: #374151;
    }
    .btn-outline:hover { background-color: #f9fafb; }
    .btn-primary {
        background-color: #2d3748;
        color: #ffffff;
    }
    .btn-primary:hover { background-color: #1a202c; }

    .alert-box {
        background-color: #fffbeb;
        border: 1px solid #fde68a;
        padding: 16px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        margin-bottom: 24px;
    }
    .alert-icon {
        color: #d97706;
        font-size: 18px;
        margin-right: 12px;
    }
    .alert-text {
        font-size: 14px;
        color: #92400e;
    }

    .data-card {
        background-color: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }
    .card-toolbar {
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .filter-select, .search-input {
        padding: 10px 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        color: #374151;
        outline: none;
    }
    .filter-select {
        min-width: 200px;
        background-color: white;
    }
    .search-wrapper {
        position: relative;
        width: 300px;
    }
    .search-wrapper i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    .search-input {
        width: 100%;
        padding-left: 38px;
        box-sizing: border-box;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .data-table th {
        padding: 16px 20px;
        font-size: 12px;
        font-weight: 700;
        color: #111827;
        border-bottom: 1px solid #e5e7eb;
    }
    .data-table td {
        padding: 16px 20px;
        font-size: 14px;
        color: #4b5563;
        border-bottom: 1px solid #f3f4f6;
    }
    .data-table tr:hover td {
        background-color: #f9fafb;
    }

    /* Text Colors & Badges */
    .text-danger {
        color: #ef4444 !important;
        font-weight: 600;
    }
    .badge {
        padding: 4px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    .badge-active {
        background-color: #475569;
        color: #ffffff;
    }
    .badge-inactive {
        background-color: #e5e7eb;
        color: #4b5563;
    }

    .action-cell {
        display: flex;
        justify-content: center;
        gap: 16px;
    }
    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        padding: 4px;
    }
    .action-edit { color: #6b7280; }
    .action-edit:hover { color: #2563eb; }
    .action-delete { color: #ef4444; }
    .action-delete:hover { color: #b91c1c; }

    .card-footer {
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #6b7280;
    }
</style>

<div class="product-wrapper">

    <div class="header-section">
        <div>
            <h1 class="header-title">Daftar Barang</h1>
            <p class="header-subtitle">Kelola data barang & inventori</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-outline">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>
            <button class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Barang
            </button>
        </div>
    </div>

    @if($lowStockCount > 0)
    <div class="alert-box">
        <i class="fas fa-box alert-icon"></i>
        <span class="alert-text"><strong>{{ $lowStockCount }} barang</strong> memiliki stok di bawah minimum</span>
    </div>
    @endif

    <div class="data-card">

        <div class="card-toolbar">
            <select class="filter-select">
                <option value="">Semua kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id_kategori }}">{{ $category->nama_kategori }}</option>
                @endforeach
            </select>

            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Cari nama atau kode barang...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode barang</th>
                        <th>Nama barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga beli</th>
                        <th>Harga jual</th>
                        <th>Stok</th>
                        <th>Min. stok</th>
                        <th>Status</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td style="font-weight: 600; color: #111827;">{{ $p->kode_barang }}</td>
                        <td>{{ $p->nama_produk }}</td>
                        <td>{{ $p->category ? $p->category->nama_kategori : '-' }}</td>
                        <td>{{ $p->satuan }}</td>
                        <td>Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>

                        <td class="{{ $p->jumlah_stok < $p->min_stok ? 'text-danger' : '' }}">
                            {{ $p->jumlah_stok }}
                        </td>

                        <td>{{ $p->min_stok }}</td>
                        <td>
                            <span class="badge {{ $p->status == 'Aktif' ? 'badge-active' : 'badge-inactive' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-cell">
                                <button class="action-btn action-edit" title="Edit"><i class="fas fa-pen"></i></button>
                                <button class="action-btn action-delete" title="Hapus"><i class="far fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 48px 0;">
                            <i class="fas fa-box-open" style="font-size: 32px; color: #d1d5db; margin-bottom: 12px;"></i><br>
                            Belum ada data barang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            <span>Menampilkan 1 - {{ $products->count() }} dari {{ $products->count() }} data</span>
            <button class="btn btn-outline">
                <i class="fas fa-download"></i> Ekspor PDF
            </button>
        </div>

    </div>
</div>

@endsection
