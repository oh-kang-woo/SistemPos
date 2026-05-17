@extends('layouts.app')

@section('content')
<div class="profile-container" style="padding: 24px; font-family: 'Poppins', sans-serif; box-sizing: border-box; width: 100%;">

    <div style="margin-bottom: 24px;">
        <h2 style="font-size: 24px; font-weight: 600; color: #1e293b; margin: 0 0 4px 0;">Pengaturan Akun</h2>
        <p style="font-size: 14px; color: #64748b; margin: 0;">Update informasi profil, nomor kontak, dan pasfoto resmi Anda di sistem.</p>
    </div>

    @if (session('success'))
        <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid #10b981; color: #059669; padding: 14px 20px; border-radius: 12px; font-size: 14px; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
            <span>⚡</span> <strong>Berhasil!</strong> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display: grid; grid-template-columns: 320px 1fr; gap: 24px; align-items: start;">

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px 24px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                <div style="position: relative; width: 130px; height: 130px; margin: 0 auto 20px auto; border-radius: 50%; padding: 4px; background: linear-gradient(135deg, #6366f1, #06b6d4); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.2);">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; background: #f8fafc;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=f1f5f9&color=6366f1&size=256" style="width: 100%; height: 100%; border-radius: 50%;">
                    @endif
                </div>

                <h3 style="font-size: 18px; font-weight: 600; color: #1e293b; margin: 0 0 4px 0;">{{ $user->name }}</h3>
                <span style="display: inline-block; background: rgba(6, 182, 212, 0.1); color: #0891b2; font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 24px;">
                    {{ $user->role }}
                </span>

                <hr style="border: 0; border-top: 1px solid #f1f5f9; margin-bottom: 24px;">

                <label for="profile_photo" style="display: block; background: #6366f1; color: white; padding: 10px 16px; border-radius: 10px; font-size: 13px; font-weight: 500; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);" onmouseover="this.style.background='#4f46e5'" onmouseout="this.style.background='#6366f1'">
                    Ubah Foto Profil
                    <input type="file" id="profile_photo" name="profile_photo" style="display: none;" accept="image/*">
                </label>
                <small style="display: block; color: #94a3b8; font-size: 11px; margin-top: 8px;">Mendukung format JPG, JPEG, atau PNG. Maksimal 2MB.</small>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">

                <h3 style="font-size: 16px; font-weight: 600; color: #1e293b; margin: 0 0 20px 0; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">Informasi Personal</h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 8px; font-weight: 500;">Nama Lengkap</label>
                        <div style="position: relative;">
                            <input type="text" value="{{ $user->name }}" disabled style="width: 100%; background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 14px; border-radius: 10px; color: #94a3b8; font-size: 14px; cursor: not-allowed; box-sizing: border-box;">
                            <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #94a3b8; font-weight: 500;">🔒 Sistem</span>
                        </div>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 8px; font-weight: 500;">Alamat Email</label>
                        <div style="position: relative;">
                            <input type="text" value="{{ $user->email }}" disabled style="width: 100%; background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 14px; border-radius: 10px; color: #94a3b8; font-size: 14px; cursor: not-allowed; box-sizing: border-box;">
                            <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 11px; color: #94a3b8; font-weight: 500;">🔒 Sistem</span>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px;">
                    <div>
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 8px; font-weight: 500;">Otoritas / Jabatan</label>
                        <input type="text" value="{{ ucfirst($user->role) }}" disabled style="width: 100%; background: #f8fafc; border: 1px solid #e2e8f0; padding: 12px 14px; border-radius: 10px; color: #0891b2; font-weight: 600; font-size: 14px; cursor: not-allowed; box-sizing: border-box;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; color: #475569; margin-bottom: 8px; font-weight: 500;">Nomor Handphone Aktif</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required style="width: 100%; background: #ffffff; border: 1px solid #cbd5e1; padding: 12px 14px; border-radius: 10px; color: #1e293b; font-size: 14px; outline: none; transition: 0.2s; box-sizing: border-box;" onfocus="this.style.border='1px solid #6366f1'; this.style.boxShadow='0 0 0 3px rgba(99, 102, 241, 0.1)'" onblur="this.style.border='1px solid #cbd5e1'; this.style.boxShadow='none'">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 16px; border-top: 1px solid #f1f5f9; padding-top: 24px;">
                    <a href="{{ route('kasir.index') }}" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.2s;" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#64748b'">
                        Batal
                    </a>
                    <button type="submit" style="background: #1e293b; color: white; border: none; padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(30, 41, 59, 0.2);" onmouseover="this.style.background='#0f172a'" onmouseout="this.style.background='#1e293b'">
                        Simpan Perubahan
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection
