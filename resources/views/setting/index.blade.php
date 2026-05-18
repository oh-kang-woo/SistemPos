@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/pengaturan.css') }}">

<div class="setting-container">

    <div class="setting-header" style="margin-bottom: 24px;">
        <h2>Pengaturan Toko</h2>
        <p>Konfigurasi sistem dan preferensi toko</p>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="tab-navigation">
        <button class="tab-btn active" onclick="switchTab(event, 'tab-profil')">🏪 Profil Toko</button>
        <button class="tab-btn" onclick="switchTab(event, 'tab-struk')">🧾 Struk</button>
        <button class="tab-btn" onclick="switchTab(event, 'tab-pengguna')">👥 Pengguna</button>
    </div>

    <div class="setting-card">

        <div id="tab-profil" class="tab-content">
            <h3 style="font-size: 18px; font-weight: 600; margin-top: 0; margin-bottom: 4px;">Informasi Toko</h3>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Lengkapi detail identitas toko Anda</p>

            <form id="form-update-profil" action="{{ route('setting.updateProfil') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama toko <span style="color: red;">*</span></label>
                    <input type="text" name="nama_toko" class="form-control" value="{{ $setting->nama_toko }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Alamat lengkap <span style="color: red;">*</span></label>
                    <textarea name="alamat_lengkap" class="form-control" rows="3" required>{{ $setting->alamat_lengkap }}</textarea>
                </div>

                <div class="flex-row form-group">
                    <div class="flex-child">
                        <label class="form-label">Nomor telepon <span style="color: red;">*</span></label>
                        <input type="text" name="nomor_telepon" class="form-control" value="{{ $setting->nomor_telepon }}" required>
                    </div>
                    <div class="flex-child">
                        <label class="form-label">Nomor WhatsApp <span style="color: red;">*</span></label>
                        <input type="text" name="nomor_whatsapp" class="form-control" value="{{ $setting->nomor_whatsapp }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">NPWP (opsional)</label>
                    <input type="text" name="npwp" class="form-control" value="{{ $setting->npwp }}">
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">Logo toko (opsional)</label>
                    @if($setting->logo_toko)
                        <div style="margin-bottom: 8px;">
                            <img src="{{ asset('storage/'.$setting->logo_toko) }}" alt="Logo" style="height: 60px; border-radius: 6px;">
                        </div>
                    @endif
                    <input type="file" name="logo_toko" class="form-control">
                    <span style="font-size: 12px; color: #94a3b8;">Format: JPG, PNG, atau SVG. Ukuran maksimal: 2MB</span>
                </div>

                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </form>
        </div>

        <div id="tab-struk" class="tab-content" style="display: none;">
            <h3 style="font-size: 18px; font-weight: 600; margin-top: 0; margin-bottom: 20px;">Nomor Dokumen & Printer</h3>

            <form action="{{ route('setting.updateStruk') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Format Nomor Transaksi</label>
                    <input type="text" name="format_nomor_transaksi" class="form-control" value="{{ $setting->format_nomor_transaksi }}">
                    <span style="font-size: 12px; color: #94a3b8;">{DD} = Tanggal, {MM} = Bulan, {YYYY} = Tahun</span>
                </div>

                <div class="form-group" style="margin-bottom: 24px;">
                    <label class="form-label">Reset Nomor Urut</label>
                    <select name="reset_nomor_urut" class="form-control">
                        <option value="reset_bulan" {{ $setting->reset_nomor_urut == 'reset_bulan' ? 'selected' : '' }}>Reset setiap bulan</option>
                        <option value="reset_tahun" {{ $setting->reset_nomor_urut == 'reset_tahun' ? 'selected' : '' }}>Reset setiap tahun</option>
                    </select>
                </div>

                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 24px 0;">
                <h4 style="font-size: 16px; font-weight: 600; margin-bottom: 16px;">Printer</h4>

                <div class="form-group">
                    <label class="form-label">Ukuran Kertas</label>
                    <select name="ukuran_kertas" class="form-control">
                        <option value="Thermal 88mm" {{ $setting->ukuran_kertas == 'Thermal 88mm' ? 'selected' : '' }}>Thermal 88mm</option>
                        <option value="Thermal 58mm" {{ $setting->ukuran_kertas == 'Thermal 58mm' ? 'selected' : '' }}>Thermal 58mm</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label">Margin (mm)</label>
                    <input type="number" name="margin" class="form-control" value="{{ $setting->margin }}">
                </div>

                <div class="switch-container">
                    <div>
                        <span style="font-size: 14px; font-weight: 500; display: block;">Cetak Otomatis</span>
                        <span style="font-size: 12px; color: #64748b;">Cetak struk secara otomatis setelah pembayaran</span>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="cetak_otomatis" value="1" {{ $setting->cetak_otomatis ? 'checked' : '' }}>
                        <span class="slider round"></span>
                    </label>
                </div>

                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn-submit">Simpan Format Nomor</button>
                    <button type="button" class="btn-outline" style="padding: 10px 16px;">Tes Cetak</button>
                </div>
            </form>
        </div>

        <div id="tab-pengguna" class="tab-content" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="font-size: 18px; font-weight: 600; margin: 0;">Daftar Pengguna</h3>
                    <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">Manajemen hak akses pengguna aplikasi</p>
                </div>

                <button type="button" onclick="bukaModalUser()" style="background-color: #1e293b; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-user-plus"></i> Tambah Pengguna
                </button>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Posisi (Role)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td style="font-weight: 500;">{{ $user->nama ?? $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge-role">{{ $user->role ?? 'Kasir' }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="padding: 20px; text-align: center; color: #94a3b8;">Belum ada data pengguna.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="modalNativeUser" class="modal-overlay" style="display: none;">
    <div class="modal-content-box">
        <div class="modal-header">
            <h5 style="margin: 0; font-weight: 600; font-size: 16px;">Tambah Pengguna Baru</h5>
            <button type="button" onclick="tutupModalUser()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
        </div>

        <form action="{{ route('setting.storeUser') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Pengguna <span style="color: red;">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Akbar Hidayat">
                </div>

                <div class="form-group">
                    <label class="form-label">Email <span style="color: red;">*</span></label>
                    <input type="email" name="email" class="form-control" required placeholder="email@toko.com">
                </div>

                <div class="form-group">
                    <label class="form-label">Posisi <span style="color: red;">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="" selected disabled>Pilih Posisi</option>
                        <option value="admin">Admin / Pemilik</option>
                        <option value="kasir">Kasir</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Password <span style="color: red;">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="******">
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Profil (opsional)</label>
                    <div class="upload-dashed-box" onclick="document.getElementById('profile_photo').click()" style="cursor: pointer;">
                        <i class="fas fa-file-upload" style="font-size: 24px; color: #94a3b8; margin-bottom: 8px;"></i>
                        <p style="font-size: 12px; color: #64748b; margin: 0;">Klik untuk upload</p>
                        <span style="font-size: 11px; color: #94a3b8;">Format: JPG, PNG, atau SVG (Maks: 2MB)</span>
                        <input type="file" id="profile_photo" name="profile_photo" style="display: none;">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="tutupModalUser()" class="btn-outline" style="flex: 1; padding: 10px;">Batal</button>
                <button type="submit" class="btn-submit" style="flex: 1; padding: 10px;">Simpan Pengguna</button>
            </div>
        </form>
    </div>
</div>

<script>
// FIX: Fungsi untuk berpindah antar Tab yang sebelumnya hilang
function switchTab(event, tabId) {
    // Hide semua konten tab
    const tabContents = document.getElementsByClassName("tab-content");
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].style.display = "none";
    }

    // Hilangkan class 'active' dari semua tombol tab
    const tabButtons = document.getElementsByClassName("tab-btn");
    for (let i = 0; i < tabButtons.length; i++) {
        tabButtons[i].classList.remove("active");
    }

    // Tampilkan tab yang sedang dipilih dan set tombol menjadi aktif
    document.getElementById(tabId).style.display = "block";
    event.currentTarget.classList.add("active");
}

// FIX: Fungsi kontrol Modal Tambah Pengguna
function bukaModalUser() {
    document.getElementById('modalNativeUser').style.display = 'flex';
}

function tutupModalUser() {
    document.getElementById('modalNativeUser').style.display = 'none';
}

document.addEventListener("DOMContentLoaded", function() {
    const formProfil = document.getElementById('form-update-profil');

    if (formProfil) {
        formProfil.addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const navbarNama = document.getElementById('navbar-nama-toko');
                    if (navbarNama) {
                        navbarNama.textContent = data.nama_toko;
                    }

                    const navbarAlamat = document.getElementById('navbar-alamat-toko');
                    if (navbarAlamat && data.alamat_lengkap) {
                        navbarAlamat.textContent = data.alamat_lengkap;
                    }

                    alert('Pengaturan berhasil disimpan dan Navbar diperbarui!');
                } else {
                    alert('Gagal memperbarui profil.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi sistem saat menyimpan.');
            });
        });
    }
});
</script>
@endsection
