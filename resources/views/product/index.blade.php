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

    .alert-success { background-color: #ecfdf5; border: 1px solid #a7f3d0; padding: 16px; border-radius: 8px; display: flex; align-items: center; margin-bottom: 24px; }
    .alert-success i { color: #059669; font-size: 18px; margin-right: 12px; }
    .alert-success span { font-size: 14px; color: #065f46; font-weight: 500; }

    /* --- MODAL STYLING --- */
    .modal-overlay {
        position: fixed; top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center; align-items: center;
        z-index: 1000;
    }
    .modal-content {
        background-color: #ffffff; border-radius: 12px;
        width: 100%; max-width: 500px;
        max-height: 90vh; overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .modal-content.large { max-width: 700px; }
    .modal-header {
        padding: 20px 24px; border-bottom: 1px solid #e5e7eb;
        display: flex; justify-content: space-between; align-items: center;
    }
    .modal-header h3 { margin: 0; font-size: 18px; color: #111827; }
    .close-btn { background: none; border: none; font-size: 24px; color: #6b7280; cursor: pointer; }
    .close-btn:hover { color: #111827; }
    .modal-body { padding: 24px; }
    .modal-footer {
        padding: 16px 24px; border-top: 1px solid #e5e7eb;
        display: flex; justify-content: flex-end; gap: 12px;
    }

    /* Form Inputs */
    .form-group { margin-bottom: 16px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .form-label span { color: #ef4444; }
    .form-control {
        width: 100%; padding: 10px 12px; border: 1px solid #d1d5db;
        border-radius: 6px; font-size: 14px; box-sizing: border-box;
        font-family: inherit;
    }
    .form-control:focus { outline: none; border-color: #2563eb; }
</style>

<div class="product-wrapper">

    <div class="header-section">
        <div>
            <h1 class="header-title">Daftar Barang</h1>
            <p class="header-subtitle">Kelola data barang & inventori</p>
        </div>
        <div class="header-actions">
            <button class="btn btn-outline" onclick="openModal('modalCategory')">
                <i class="fas fa-plus"></i> Tambah Kategori
            </button>
            <button class="btn btn-outline" onclick="openModal('modalKelolaCategory')">
                <i class="fas fa-cog"></i> Kelola Kategori
            </button>
            <button class="btn btn-primary" onclick="openModal('modalProduct')">
                <i class="fas fa-plus"></i> Tambah Barang
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

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
                <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau kode barang...">
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
                <tbody id="tableBody">
                    @forelse($products as $p)
                    <tr>
                        <td style="font-weight: 600; color: #111827;">{{ $p->kode_produk }}</td>
                        <td>{{ $p->nama_produk }}</td>
                        <td>{{ $p->category ? $p->category->nama_kategori : '-' }}</td>
                        <td>{{ $p->satuan }}</td>
                        <td>Rp {{ number_format($p->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                        <td class="{{ $p->jumlah_stok < $p->min_stok ? 'text-danger' : '' }}">{{ $p->jumlah_stok }}</td>
                        <td>{{ $p->min_stok }}</td>
                        <td><span class="badge {{ $p->status == 'Aktif' ? 'badge-active' : 'badge-inactive' }}">{{ $p->status }}</span></td>
                        <td>
                            <div class="action-cell">
                                <button type="button" class="action-btn action-edit" title="Edit"
                                    onclick="openEditModal(this)"
                                    data-id="{{ $p->id_produk ?? $p->id }}"
                                    data-kode="{{ $p->kode_produk }}"
                                    data-nama="{{ $p->nama_produk }}"
                                    data-kategori="{{ $p->kategori_id }}"
                                    data-satuan="{{ $p->satuan }}"
                                    data-hargabeli="{{ $p->harga_beli }}"
                                    data-hargajual="{{ $p->harga_jual }}"
                                    data-stok="{{ $p->jumlah_stok }}"
                                    data-minstok="{{ $p->min_stok }}"
                                    data-status="{{ strtolower($p->status) }}"
                                    data-route="{{ route('product.update', $p->id_produk ?? $p->id) }}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form action="{{ route('product.destroy', $p->id_produk ?? $p->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini? Data yang dihapus tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-delete" title="Hapus"><i class="far fa-trash-alt"></i></button>
                                </form>
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
            <button class="btn btn-outline"><i class="fas fa-download"></i> Ekspor PDF</button>
        </div>
    </div>
</div>

<div id="modalCategory" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Kategori</h3>
            <button type="button" class="close-btn" onclick="closeModal('modalCategory')">&times;</button>
        </div>
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Kategori <span>*</span></label>
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Makanan" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Deskripsi (Opsional)</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat kategori"></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Gambar Kategori (Opsional)</label>
                    <input type="file" name="gambar" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalCategory')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<div id="modalKelolaCategory" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Kelola Kategori</h3>
            <button class="close-btn" onclick="closeModal('modalKelolaCategory')">×</button>
        </div>
        <div class="modal-body">
            <label style="font-size: 13px; color: #475569; font-weight: 500; display: block; margin-bottom: 10px;">Daftar Kategori Tersedia</label>
            <div style="max-height: 200px; overflow-y: auto; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px;">
                @foreach($categories as $category)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; border-bottom: 1px solid #e2e8f0;">
                    <span style="font-size: 14px; color: #1e293b;">{{ $category->nama_kategori }}</span>
                    <form action="{{ route('category.destroy', $category->id_kategori) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua barang yang terkait dengan kategori ini juga akan terhapus.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 14px;">🗑️ Hapus</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div id="modalProduct" class="modal-overlay">
    <div class="modal-content large">
        <div class="modal-header">
            <h3>Tambah Barang Baru</h3>
            <button type="button" class="close-btn" onclick="closeModal('modalProduct')">&times;</button>
        </div>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama barang <span>*</span></label>
                        <input type="text" name="nama_produk" class="form-control" placeholder="Contoh: Barang A" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode barang <span>*</span></label>
                        <input type="text" name="kode_produk" class="form-control" placeholder="Contoh: BRG-001" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kategori <span>*</span></label>
                        <select name="kategori_id" class="form-control" required>
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_kategori }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan <span>*</span></label>
                        <select name="satuan" class="form-control" required>
                            <option value="Pcs">Pcs</option>
                            <option value="Box">Box</option>
                            <option value="Kg">Kg</option>
                            <option value="Cup">Cup</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Harga beli (Rp) <span>*</span></label>
                        <input type="number" name="harga_beli" class="form-control" placeholder="Rp 0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga jual (Rp) <span>*</span></label>
                        <input type="number" name="harga_jual" class="form-control" placeholder="Rp 0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Stok awal <span>*</span></label>
                        <input type="number" name="jumlah_stok" class="form-control" placeholder="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Minimum stok <span>*</span></label>
                        <input type="number" name="min_stok" class="form-control" placeholder="0" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Gambar produk (Opsional)</label>
                        <input type="file" name="gambar_produk" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalProduct')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Barang</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditProduct" class="modal-overlay">
    <div class="modal-content large">
        <div class="modal-header">
            <h3>Edit Data Barang</h3>
            <button type="button" class="close-btn" onclick="closeModal('modalEditProduct')">&times;</button>
        </div>
        <form id="formEditProduct" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama barang <span>*</span></label>
                        <input type="text" name="nama_produk" id="edit_nama_produk" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kode barang (Tidak dapat diubah)</label>
                        <input type="text" id="edit_kode_produk" class="form-control" disabled style="background-color: #f3f4f6;">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kategori <span>*</span></label>
                        <select name="kategori_id" id="edit_kategori_id" class="form-control" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_kategori }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan <span>*</span></label>
                        <select name="satuan" id="edit_satuan" class="form-control" required>
                            <option value="Pcs">Pcs</option>
                            <option value="Box">Box</option>
                            <option value="Kg">Kg</option>
                            <option value="Cup">Cup</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Harga beli (Rp) <span>*</span></label>
                        <input type="number" name="harga_beli" id="edit_harga_beli" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga jual (Rp) <span>*</span></label>
                        <input type="number" name="harga_jual" id="edit_harga_jual" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Stok <span>*</span></label>
                        <input type="number" name="jumlah_stok" id="edit_jumlah_stok" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Minimum stok <span>*</span></label>
                        <input type="number" name="min_stok" id="edit_min_stok" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" id="edit_status" class="form-control">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ganti Gambar produk (Opsional)</label>
                        <input type="file" name="gambar_produk" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modalEditProduct')">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function openEditModal(button) {
        const id = button.getAttribute('data-id');
        const kode = button.getAttribute('data-kode');
        const nama = button.getAttribute('data-nama');
        const kategori = button.getAttribute('data-kategori');
        const satuan = button.getAttribute('data-satuan');
        const hargabeli = button.getAttribute('data-hargabeli');
        const hargajual = button.getAttribute('data-hargajual');
        const stok = button.getAttribute('data-stok');
        const minstok = button.getAttribute('data-minstok');
        const status = button.getAttribute('data-status');
        const routeUrl = button.getAttribute('data-route');

        document.getElementById('edit_nama_produk').value = nama;
        document.getElementById('edit_kode_produk').value = kode;
        document.getElementById('edit_kategori_id').value = kategori;
        document.getElementById('edit_satuan').value = satuan;
        document.getElementById('edit_harga_beli').value = hargabeli;
        document.getElementById('edit_harga_jual').value = hargajual;
        document.getElementById('edit_jumlah_stok').value = stok;
        document.getElementById('edit_min_stok').value = minstok;
        document.getElementById('edit_status').value = status;

        // Pasang rute aksi update dinamis dari Laravel
        document.getElementById('formEditProduct').action = routeUrl;

        openModal('modalEditProduct');
    }
</script>

@endsection
