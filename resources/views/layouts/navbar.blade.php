<header class="top-navbar">

    <div class="navbar-left">
        <h2 class="page-title">Kasir</h2>
        <p class="page-subtitle">Cafe simpang MI</p>
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

        <div class="nav-box profile-box">
            <img src="https://ui-avatars.com/api/?name=Akbar+Hidayat&background=random" alt="Profil" class="profile-img">
            <div class="nav-text">
                <span class="nav-title">Akbar Hidayat</span>
                <span class="nav-desc">Kasir</span>
            </div>
        </div>

    </div>
</header>

<script>
    // Script agar jam berjalan otomatis
    setInterval(() => {
        const time = new Date().toLocaleTimeString('id-ID', { hour12: false });
        document.getElementById('clock').textContent = time + ' WIB';
    }, 1000);
</script>
