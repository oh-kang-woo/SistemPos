@extends('layouts.app')

@section('content')

<style>
    /* CSS Khusus Halaman Pengeluaran */
    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
    .page-title h2 { font-size: 24px; font-weight: bold; color: #1e293b; margin: 0 0 8px 0; }
    .page-title p { font-size: 14px; color: #64748b; margin: 0; }

    .btn-outline { background: white; border: 1px solid #cbd5e1; color: #1e293b; padding: 10px 16px; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 14px; }
    .btn-primary { background: #1e293b; border: 1px solid #1e293b; color: white; padding: 10px 16px; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 14px; }
    .btn-danger { background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500;}

    .summary-card { background: #fff1f2; border: 1px solid #fda4af; border-radius: 8px; padding: 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .summary-card .label { color: #e11d48; font-size: 14px; font-weight: 500; }
    .summary-card .amount { color: #e11d48; font-size: 24px; font-weight: bold; margin-top: 4px; }
    .summary-card .count { color: #e11d48; font-size: 14px; font-weight: bold; }

    .filter-section { display: flex; justify-content: space-between; gap: 16px; margin-bottom: 20px; }
    .filter-left { display: flex; gap: 12px; }
    .filter-select, .filter-btn, .search-input { padding: 10px 16px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; outline: none; }
    .search-input { width: 300px; }

    .table-container { background: white; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background: #f8fafc; padding: 16px; font-size: 13px; color: #1e293b; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
    td { padding: 16px; font-size: 14px; color: #475569; border-bottom: 1px solid #e2e8f0; }
    tr:last-child td { border-bottom: none; }
    .text-red { color: #ef4444; font-weight: 500; }

    .badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500; color: white; display: inline-block;}
    .badge-1 { background: #d97706; } /* Orange */
    .badge-2 { background: #16a34a; } /* Green */
    .badge-3 { background: #9333ea; } /* Purple */
    .badge-4 { background: #1e293b; } /* Navy */

    /* CSS Modal */
    .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; z-index: 1000; }
    .modal-content { background: white; padding: 24px; border-radius: 12px; width: 100%; max-width: 500px; position: relative; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-header h3 { margin: 0; font-size: 18px; color: #1e293b; }
    .close-btn { background: none; border: none; font-size: 20px; cursor: pointer; color: #64748b; }

    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 13px; color: #475569; margin-bottom: 6px; font-weight: 500;}
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #e2e8f0; border-radius: 6px; outline: none; font-size: 14px; box-sizing: border-box;}
    .modal-footer { display: flex; justify-content: space-between; gap: 12px; margin-top: 24px; }
    .modal-footer button { flex: 1; }
</style>

@if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<div class="page-header">
    <div class="page-title">
        <h2>Pengeluaran Toko</h2>
        <p>Catat dan kelola pengeluaran operasional</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <button class="btn-outline" onclick="openModal('modalKategori')">+ Tambah Kategori</button>
        <button class="btn-primary" onclick="openModal('modalPengeluaran')">+ Tambah Pengeluaran</button>
    </div>
</div>

<div class="summary-card">
    <div>
        <div class="label">Total pengeluaran</div>
        <div class="amount">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
    </div>
    <div class="count">{{ $jumlahPengeluaran }} Pengeluaran tercatat</div>
</div>

<div class="filter-section">
    <div class="filter-left">
        <select class="filter-select">
            <option>Semua kategori</option>
            @foreach($kategori as $kat)
                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
            @endforeach
        </select>
        <button class="filter-btn">📅 Filter periode</button>
    </div>
    <div>
        <input type="text" class="search-input" placeholder="🔍 Cari deskripsi pengeluaran...">
    </div>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori pengeluaran</th>
                <th>Deskripsi</th>
                <th>Nominal</th>
                <th>Pengguna</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengeluaran as $index => $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="badge badge-{{ ($index % 4) + 1 }}">
                        {{ $item->category->nama_kategori ?? 'Umum' }}
                    </span>
                </td>
                <td>{{ $item->deskripsi ?? '-' }}</td>
                <td class="text-red">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                <td>{{ $item->pengguna }}</td>
                <td>
                    <button style="background:none; border:none; cursor:pointer;">✏️</button>
                    <button style="background:none; border:none; cursor:pointer; color:red;">🗑️</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 30px;">Belum ada data pengeluaran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
    <span style="font-size: 13px; color: #64748b;">Menampilkan 1 - {{ $jumlahPengeluaran }} dari {{ $jumlahPengeluaran }} data</span>
    <button class="btn-outline">🖨️ Cetak Pengeluaran</button>
</div>

<div class="modal-overlay" id="modalKategori">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Kategori Baru</h3>
            <button class="close-btn" onclick="closeModal('modalKategori')">×</button>
        </div>
        <form action="{{ route('pengeluaran.kategori.store') }}" method="POST">
            @csrf
            <p style="font-size: 13px; color: #64748b; margin-top: 0;">Masukkan detail Kategori baru</p>

            <div class="form-group">
                <label>Nama Kategori *</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Makanan" required>
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 12px;">
                <label style="margin: 0;">Status aktif</label>
                <input type="checkbox" name="status_aktif" checked style="width: 40px; height: 20px; cursor: pointer;">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-outline" onclick="closeModal('modalKategori')">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modalPengeluaran">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Pengeluaran Baru</h3>
            <button class="close-btn" onclick="closeModal('modalPengeluaran')">×</button>
        </div>
        <form action="{{ route('pengeluaran.store') }}" method="POST">
            @csrf
            <p style="font-size: 13px; color: #64748b; margin-top: 0;">Catat pengeluaran operasional toko</p>

            <div class="form-group">
                <label>Tanggal *</label>
                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label>Kategori *</label>
                <select name="expense_category_id" class="form-control" required>
                    <option value="">Pilih kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi (opsional)</label>
                <textarea name="deskripsi" class="form-control" placeholder="Deskripsi singkat barang (opsional)" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Nominal pengeluaran (Rp) *</label>
                <input type="number" name="nominal" class="form-control" placeholder="Rp 0" required>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-outline" onclick="closeModal('modalPengeluaran')">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script sederhana untuk buka/tutup pop-up (Modal)
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    // Tutup modal jika user klik area luar (background gelap)
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection
