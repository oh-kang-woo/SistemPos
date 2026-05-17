@extends('layouts.app')
@section('content')
<style>
    .tab-btn { background: none; border: none; padding: 8px 16px; font-size: 14px; font-weight: 500; color: #64748b; cursor: pointer; border-radius: 6px; transition: 0.2s; }
    .tab-btn.active { background: #e2e8f0; color: #1e293b; font-weight: 600; }
    .form-label { font-size: 13px; font-weight: 500; color: #334155; display: block; margin-bottom: 6px; }
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; font-size: 14px; box-sizing: border-box; transition: 0.2s; color: #334155;}
    .form-control:focus { border-color: #475569; box-shadow: 0 0 0 3px rgba(71, 85, 105, 0.1); }
    .btn-submit { background: #1e293b; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 500; font-size: 14px; cursor: pointer; width: 100%; transition: 0.2s; }
    .btn-submit:hover { background: #334155; }
    .btn-outline { background: white; border: 1px solid #cbd5e1; color: #475569; border-radius: 6px; cursor: pointer; font-size: 14px; }

    /* Toggle Switch CSS */
    .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; }
    .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .3s; }
    input:checked + .slider { background-color: #1e293b; }
    input:checked + .slider:before { transform: translateX(20px); }
    .slider.round { border-radius: 24px; }
    .slider.round:before { border-radius: 50%; }
</style>
<div style="padding: 24px; background-color: #f1f5f9; min-height: 100vh;">

    <div style="margin-bottom: 24px;">
        <h2 style="margin: 0; font-size: 24px; color: #1e293b; font-weight: 700;">Pengaturan Toko</h2>
        <p style="margin: 4px 0 0 0; color: #64748b; font-size: 14px;">Konfigurasi sistem dan preferensi toko</p>
    </div>

    @if(session('success'))
        <div style="padding: 14px; background-color: #dcfce7; color: #15803d; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; gap: 12px; margin-bottom: 20px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
        <button class="tab-btn active" onclick="switchTab(event, 'tab-profil')">🏪 Profil Toko</button>
        <button class="tab-btn" onclick="switchTab(event, 'tab-struk')">🧾 Struk</button>
        <button class="tab-btn" onclick="switchTab(event, 'tab-pengguna')">👥 Pengguna</button>
    </div>

    <div style="background: white; border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); max-width: 800px;">

        <div id="tab-profil" class="tab-content">
            <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin-top: 0; margin-bottom: 4px;">Informasi Toko</h3>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 20px;">Lengkapi detail identitas toko Anda</p>

            <form action="{{ route('setting.updateProfil') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Nama toko <span style="color: red;">*</span></label>
                    <input type="text" name="nama_toko" class="form-control" value="{{ $setting->nama_toko }}" required>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Alamat lengkap <span style="color: red;">*</span></label>
                    <textarea name="alamat_lengkap" class="form-control" rows="3" required>{{ $setting->alamat_lengkap }}</textarea>
                </div>

                <div style="display: flex; gap: 16px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label class="form-label">Nomor telepon <span style="color: red;">*</span></label>
                        <input type="text" name="nomor_telepon" class="form-control" value="{{ $setting->nomor_telepon }}" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label">Nomor WhatsApp <span style="color: red;">*</span></label>
                        <input type="text" name="nomor_whatsapp" class="form-control" value="{{ $setting->nomor_whatsapp }}" required>
                    </div>
                </div>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">NPWP (opsional)</label>
                    <input type="text" name="npwp" class="form-control" value="{{ $setting->npwp }}">
                </div>

                <div style="margin-bottom: 24px;">
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
            <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin-top: 0; margin-bottom: 20px;">Nomor Dokumen & Printer</h3>

            <form action="{{ route('setting.updateStruk') }}" method="POST">
                @csrf
                <div style="margin-bottom: 16px;">
                    <label class="form-label">Format Nomor Transaksi</label>
                    <input type="text" name="format_nomor_transaksi" class="form-control" value="{{ $setting->format_nomor_transaksi }}">
                    <span style="font-size: 12px; color: #94a3b8;">{DD} = Tanggal, {MM} = Bulan, {YYYY} = Tahun</span>
                </div>

                <div style="margin-bottom: 24px;">
                    <label class="form-label">Reset Nomor Urut</label>
                    <select name="reset_nomor_urut" class="form-control">
                        <option value="reset_bulan" {{ $setting->reset_nomor_urut == 'reset_bulan' ? 'selected' : '' }}>Reset setiap bulan</option>
                        <option value="reset_tahun" {{ $setting->reset_nomor_urut == 'reset_tahun' ? 'selected' : '' }}>Reset setiap tahun</option>
                    </select>
                </div>

                <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 24px 0;">
                <h4 style="font-size: 16px; font-weight: 600; color: #1e293b; margin-bottom: 16px;">Printer</h4>

                <div style="margin-bottom: 16px;">
                    <label class="form-label">Ukuran Kertas</label>
                    <select name="ukuran_kertas" class="form-control">
                        <option value="Thermal 88mm" {{ $setting->ukuran_kertas == 'Thermal 88mm' ? 'selected' : '' }}>Thermal 88mm</option>
                        <option value="Thermal 58mm" {{ $setting->ukuran_kertas == 'Thermal 58mm' ? 'selected' : '' }}>Thermal 58mm</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="form-label">Margin (mm)</label>
                    <input type="number" name="margin" class="form-control" value="{{ $setting->margin }}">
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 14px; border-radius: 8px; margin-bottom: 24px;">
                    <div>
                        <span style="font-size: 14px; font-weight: 500; color: #1e293b; display: block;">Cetak Otomatis</span>
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
            <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 0;">Daftar Pengguna</h3>
            <p style="font-size: 13px; color: #64748b; margin: 4px 0 0 0;">Manajemen hak akses pengguna aplikasi</p>
        </div>

        <button type="button" onclick="bukaModalUser()" style="background-color: #1e293b; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-user-plus"></i> Tambah Pengguna
        </button>
    </div>

    <div id="modalNativeUser" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.6); align-items: center; justify-content: center;">

        <div style="background-color: #ffffff; width: 500px; max-width: 90%; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); overflow: hidden; position: relative;">

            <div style="padding: 16px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <h5 style="margin: 0; font-weight: 600; color: #1e293b; font-size: 16px;">Tambah Pengguna Baru</h5>
                <button type="button" onclick="tutupModalUser()" style="background: none; border: none; font-size: 20px; color: #64748b; cursor: pointer;">&times;</button>
            </div>

            <form action="{{ route('setting.storeUser') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="padding: 24px; max-height: 70vh; overflow-y: auto;">

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #334155;">Nama Pengguna <span style="color: red;">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Akbar Hidayat" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #334155;">Nomor telepon <span style="color: red;">*</span></label>
                        <input type="text" name="phone" required placeholder="+62" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #334155;">Posisi <span style="color: red;">*</span></label>
                        <select name="role" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; box-sizing: border-box;">
                            <option value="" selected disabled>Pilih Posisi</option>
                            <option value="admin">Admin / Pemilik</option>
                            <option value="kasir">Kasir</option>
                        </select>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #334155;">Password <span style="color: red;">*</span></label>
                        <input type="password" name="password" required placeholder="******" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; color: #334155;">Foto Profil (opsional)</label>
                        <div style="border: 2px dashed #cbd5e1; border-radius: 8px; padding: 20px; text-align: center; cursor: pointer; background: #f8fafc;" onclick="document.getElementById('profile_photo').click()">
                            <i class="fas fa-file-upload" style="font-size: 24px; color: #94a3b8; margin-bottom: 8px;"></i>
                            <p style="font-size: 12px; color: #64748b; margin: 0;">Klik untuk upload</p>
                            <span style="font-size: 11px; color: #94a3b8;">Format: JPG, PNG, atau SVG (Maks: 2MB)</span>
                            <input type="file" id="profile_photo" name="profile_photo" style="display: none;">
                        </div>
                    </div>
                </div>

                <div style="padding: 16px 24px; border-top: 1px solid #e2e8f0; display: flex; gap: 12px; background: #f8fafc;">
                    <button type="button" onclick="tutupModalUser()" style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; background: white; color: #475569; border-radius: 6px; font-weight: 500; cursor: pointer;">Batal</button>
                    <button type="submit" style="flex: 1; padding: 10px; border: none; background: #1e293b; color: white; border-radius: 6px; font-weight: 500; cursor: pointer;">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 12px; color: #475569;">Nama Pengguna</th>
                    <th style="padding: 12px; color: #475569;">Email</th>
                    <th style="padding: 12px; color: #475569;">Posisi (Role)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px; color: #1e293b; font-weight: 500;">{{ $user->nama ?? $user->name }}</td>
                    <td style="padding: 12px; color: #64748b;">{{ $user->email }}</td>
                    <td style="padding: 12px;"><span style="background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 6px; font-size: 12px;">{{ $user->role ?? 'Kasir' }}</span></td>
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
<script>
    function switchTab(evt, tabId) {
        let i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tab-btn");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabId).style.display = "block";
        evt.currentTarget.classList.add("active");
    }
    function bukaModalUser() {
        // Mengubah display menjadi flex agar posisinya ke tengah layar
        document.getElementById('modalNativeUser').style.display = 'flex';
    }

    function tutupModalUser() {
        // Menyembunyikan kembali modalnya
        document.getElementById('modalNativeUser').style.display = 'none';
    }

    // Tutup modal jika user mengklik area gelap di luar kotak putih
    window.onclick = function(event) {
        var modal = document.getElementById('modalNativeUser');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
