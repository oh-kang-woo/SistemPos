<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modalpembayaran.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background-color: #E6EDF2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .app-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 0 32px 32px 32px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ==========================================================================
           PENGATURAN KHUSUS WARNA DARK MODE (AMBIL KONTROL SAAT ATRIBUT DARK AKTIF)
           ========================================================================== */
        [data-theme="dark"] {
            --bg-dark-body: #1E293B;
            --bg-dark-card: #2A374A;
            --text-dark-main: #FFFFFF;
            --text-dark-muted: #94A3B8;
            --border-dark: #3B4D66;
        }

        /* 1. Jalankan background utama aplikasi jadi gelap */
        [data-theme="dark"] body {
            background-color: var(--bg-dark-body) !important;
        }

        /* 2. FIX TEKS SIDEBAR (HANYA BERJALAN DI MODE GELAP) */
        /* Menu yang biasa/tidak aktif: buat abu-abu cerah agar tidak mati */
        [data-theme="dark"] .sidebar .menu-item:not(.active) span,
        [data-theme="dark"] .sidebar .menu-item:not(.active) i {
            color: #94A3B8 !important;
        }

        /* Menu biasa saat disentuh mouse (hover) */
        [data-theme="dark"] .sidebar .menu-item:not(.active):hover span,
        [data-theme="dark"] .sidebar .menu-item:not(.active):hover i {
            color: #FFFFFF !important;
        }

        /* Menu yang SEDANG AKTIF (ada class .active): Paksa tetap putih/terang */
        [data-theme="dark"] .sidebar .menu-item.active span,
        [data-theme="dark"] .sidebar .menu-item.active i {
            color: #FFFFFF !important;
            font-weight: 600;
        }

        /* Ubah warna background sorotan menu aktif di mode gelap agar kontras */
        [data-theme="dark"] .sidebar .menu-item.active {
            background-color: #3B4D66 !important;
        }

        /* Teks Logo Brand di atas */
        [data-theme="dark"] .sidebar .logo-text h1 { color: #FFFFFF !important; }
        [data-theme="dark"] .sidebar .logo-text p { color: #94A3B8 !important; }


        /* 3. Kotak putih besar pembungkus tabel & tombol filter */
        [data-theme="dark"] .main-content > div,
        [data-theme="dark"] select,
        [data-theme="dark"] .nav-box,
        [data-theme="dark"] .nav-btn-icon,
        [data-theme="dark"] .table-responsive,
        [data-theme="dark"] .card-footer {
            background-color: var(--bg-dark-card) !important;
            color: var(--text-dark-main) !important;
            border-color: var(--border-dark) !important;
        }

        /* Menghilangkan sisa background putih di bawah tabel / dekat tombol PDF */
        [data-theme="dark"] table + div,
        [data-theme="dark"] .main-content div:has(> a[href*="pdf"]),
        [data-theme="dark"] .main-content div:has(> button[class*="pdf"]) {
            background-color: var(--bg-dark-card) !important;
        }

        /* 4. Kolom input pencarian barang */
        [data-theme="dark"] input[type="text"],
        [data-theme="dark"] .products-search {
            background-color: #1A222F !important;
            color: var(--text-dark-main) !important;
            border: 1px solid var(--border-dark) !important;
        }
        [data-theme="dark"] input::placeholder {
            color: var(--text-dark-muted) !important;
        }

        /* 5. Teks judul halaman utama */
        [data-theme="dark"] h1,
        [data-theme="dark"] h2,
        [data-theme="dark"] h3,
        [data-theme="dark"] .page-title,
        [data-theme="dark"] .nav-title,
        [data-theme="dark"] .products-title {
            color: var(--text-dark-main) !important;
        }
        [data-theme="dark"] .page-subtitle,
        [data-theme="dark"] .nav-desc,
        [data-theme="dark"] .products-subtitle {
            color: var(--text-dark-muted) !important;
        }

        /* 6. Elemen-elemen di dalam tabel */
        [data-theme="dark"] table,
        [data-theme="dark"] th,
        [data-theme="dark"] td {
            background-color: var(--bg-dark-card) !important;
            color: var(--text-dark-main) !important;
            border-color: var(--border-dark) !important;
        }
        [data-theme="dark"] thead th {
            background-color: #1A222F !important;
        }

        /* 7. Tombol-tombol Aksi Sekunder di atas tabel */
        [data-theme="dark"] button:not(.btn-primary):not(.add-product-btn):not(.toggle-btn):not(.logout):not(.active),
        [data-theme="dark"] a[href*="pdf"],
        [data-theme="dark"] .btn-outline-secondary {
            background-color: #1A222F !important;
            color: var(--text-dark-main) !important;
            border: 1px solid var(--border-dark) !important;
        }
        [data-theme="dark"] button:not(.btn-primary):not(.toggle-btn):hover,
        [data-theme="dark"] a[href*="pdf"]:hover {
            background-color: #3B4D66 !important;
        }
    </style>

    {{-- SCRIPT INSTAN AGAR SAAT REFRESH TIDAK ADA EFEK BERKEDIP PUTIH (FLASH LIGHT) --}}
    <script>
        if (localStorage.getItem("theme") === "dark") {
            document.documentElement.setAttribute("data-theme", "dark");
        }
    </script>
</head>
<body>

    <div class="app-container">
        @include('layouts.sidebar')

        <div class="content-area">
            @include('layouts.navbar')

            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>

    @include('components.modalpembayaran')


<script>
    document.addEventListener("DOMContentLoaded", function() {

        // ==========================================
        // 1. LOGIKA SIDEBAR MINIMIZE
        // ==========================================
        const sidebar = document.querySelector(".sidebar");
        const toggleBtn = document.querySelector(".toggle-btn");

        // Cek ingatan browser, jika sebelumnya di-minimize, tetapkan tetap kecil
        if (localStorage.getItem("sidebar-state") === "minimized" && sidebar) {
            sidebar.classList.add("minimized");
        }

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener("click", function() {
                sidebar.classList.toggle("minimized");

                // Simpan status ke memori browser agar tidak reset saat pindah halaman
                if (sidebar.classList.contains("minimized")) {
                    localStorage.setItem("sidebar-state", "minimized");
                } else {
                    localStorage.setItem("sidebar-state", "expanded");
                }
            });
        }

        // ==========================================
        // 2. LOGIKA MODAL PEMBAYARAN
        // ==========================================
        const modal = document.getElementById('modalPembayaran');
        const btnClose = document.getElementById('closeModalBtn');

        // Logika Tombol Simpan (Menggunakan Event Delegation)
        document.addEventListener('click', function(e) {
            const btnSimpan = e.target.closest('.btn-save');

            if (btnSimpan) {
                e.preventDefault();

                if (modal) {
                    modal.classList.add('active'); // Munculkan Modal
                } else {
                    console.error("Error: Modal tidak ditemukan di halaman ini.");
                }
            }
        });

        // Logika Tombol Close Modal (Tanda Silang)
        if (btnClose && modal) {
            btnClose.addEventListener('click', function() {
                modal.classList.remove('active');
            });
        }

        // Logika Klik di luar Modal untuk menutup
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });

        // ==========================================
        // 3. LOGIKA DARK / LIGHT MODE TAMPILAN
        // ==========================================
        const themeToggleBtn = document.getElementById("theme-toggle");
        const themeIcon = document.getElementById("theme-icon");
        const currentTheme = localStorage.getItem("theme") || "light";

        // Atur ikon pelengkap di awal load jika dalam mode gelap
        if (currentTheme === "dark" && themeIcon) {
            themeIcon.classList.replace("fa-moon", "fa-sun");
        }

        if (themeToggleBtn) {
            themeToggleBtn.addEventListener("click", function () {
                let theme = document.documentElement.getAttribute("data-theme");

                if (theme === "dark") {
                    // Berubah ke Mode Terang
                    document.documentElement.removeAttribute("data-theme");
                    localStorage.setItem("theme", "light");
                    if (themeIcon) themeIcon.classList.replace("fa-sun", "fa-moon");
                } else {
                    // Berubah ke Mode Gelap
                    document.documentElement.setAttribute("data-theme", "dark");
                    localStorage.setItem("theme", "dark");
                    if (themeIcon) themeIcon.classList.replace("fa-moon", "fa-sun");
                }
            });
        }

    });
</script>

</body>
</html>
