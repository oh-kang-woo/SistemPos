@php
    // FIX: Ambil data pengaturan toko berdasarkan business_id milik user yang sedang login
    $currentSetting = null;
    if (auth()->check()) {
        $currentSetting = \App\Models\Setting::where('business_id', auth()->user()->business_id)->first();
    }

    $namaTokoAktif = $currentSetting ? $currentSetting->nama_toko : 'SwiftBill';
    $alamatTokoAktif = $currentSetting ? $currentSetting->alamat_lengkap : 'Powered by our system';
@endphp

<header class="top-navbar">
    <div class="navbar-left">
        <h2 class="page-title" id="navbar-nama-toko">{{ $namaTokoAktif }}</h2>
        <p class="page-subtitle" id="navbar-alamat-toko">{{ $alamatTokoAktif }}</p>
    </div>

    <div class="navbar-right">
        <button class="nav-btn-icon">
            <i class="far fa-bell"></i>
        </button>

        <div class="nav-box">
            <div class="nav-text">
                <span class="nav-title">Waktu</span>
                <span class="nav-desc" id="clock">15:07:14 WIB</span>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="nav-box profile-box" style="text-decoration: none; color: inherit; cursor: pointer;">
            @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profil" class="profile-img">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Profil" class="profile-img">
            @endif

            <div class="nav-text">
                <span class="nav-title">{{ Auth::user()->name }}</span>
                <span class="nav-desc">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </a>
    </div>
</header>

<script>
    // Script agar jam berjalan otomatis
    setInterval(() => {
        const time = new Date().toLocaleTimeString('id-ID', { hour12: false });
        const clockEl = document.getElementById('clock');
        if(clockEl) {
            clockEl.textContent = time + ' WIB';
        }
    }, 1000);
</script>
