<!DOCTYPE html>
<html lang="id"
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
      :data-theme="darkMode ? 'dark' : null">
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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

        /*Fix untuk mode gelap-terang*/
        /* 1. Fix Logo & Teks Sidebar yang Hilang */
        [data-theme="dark"] .sidebar-header {
            background-color: transparent !important;
        }
        [data-theme="dark"] .sidebar-header h1,
        [data-theme="dark"] .sidebar-header .logo-text h1 {
            color: #FFFFFF !important;
        }
        [data-theme="dark"] .sidebar-header p,
        [data-theme="dark"] .sidebar-header .logo-text p {
            color: #94A3B8 !important;
        }

        /* 2. Fix Latar Belakang Modal (Overlay) Jadi Gelap Pejal */
        /* Memaksa background overlay kembali menjadi transparan (rgba) */
        [data-theme="dark"] .modal-overlay,
        [data-theme="dark"] .modal-backdrop,
        [data-theme="dark"] [class*="overlay"] {
            background-color: rgba(15, 23, 42, 0.75) !important;
        }
        [data-theme="dark"] .modal-content,
        [data-theme="dark"] [class*="modal-dialog"] > div {
            background-color: var(--bg-dark-card) !important;
            color: var(--text-dark-main) !important;
            border: 1px solid var(--border-dark) !important;
        }

        /* 3. Fix Kontainer, Card, & Area Pagination yang Masih Putih */
        [data-theme="dark"] .bg-white,
        [data-theme="dark"] .card,
        [data-theme="dark"] .card-body,
        [data-theme="dark"] .pagination-container {
            background-color: var(--bg-dark-card) !important;
            border-color: var(--border-dark) !important;
            color: var(--text-dark-main) !important;
        }

        /* 4. Fix Tombol Utama (Seperti "Tambah Barang") */
        /* Diubah menjadi biru terang agar menyala dan kontras di mode gelap */
        [data-theme="dark"] .btn-primary,
        [data-theme="dark"] .add-product-btn,
        [data-theme="dark"] button[class*="btn-primary"] {
            background-color: #3b82f6 !important;
            border: 1px solid #2563eb !important;
            color: #ffffff !important;
        }
        [data-theme="dark"] .btn-primary:hover,
        [data-theme="dark"] .add-product-btn:hover {
            background-color: #60a5fa !important;
        }

        /* Mengalahkan aturan .main-content > div agar overlay tetap transparan */
        [data-theme="dark"] body .main-content > .modal-overlay,
        [data-theme="dark"] body .modal-overlay,
        [data-theme="dark"] body .modal {
            background-color: rgba(15, 23, 42, 0.75) !important;
        }

        /* Pastikan isi modal tetap solid dan elegan */
        [data-theme="dark"] .modal-content {
            background-color: var(--bg-dark-card) !important;
            border: 1px solid var(--border-dark) !important;
            color: var(--text-dark-main) !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5) !important;
        }

        /* Perbaiki warna inputan form di dalam modal */
        [data-theme="dark"] .modal-content input,
        [data-theme="dark"] .modal-content select,
        [data-theme="dark"] .modal-content textarea {
            background-color: #1A222F !important;
            color: #FFFFFF !important;
            border: 1px solid #3B4D66 !important;
        }

        [data-theme="dark"] .modal-header {
            border-bottom-color: #3B4D66 !important;
        }
        [data-theme="dark"] .modal-footer {
            border-top-color: #3B4D66 !important;
        }

        /* 1. Ubah background utama kotak Cart */
        [data-theme="dark"] .cart-area {
            background-color: var(--bg-dark-card) !important;
            border: 1px solid var(--border-dark) !important;
        }

        /* 2. Ubah warna semua teks dasar di dalam Cart */
        [data-theme="dark"] .cart-area h3,
        [data-theme="dark"] .cart-area h2,
        [data-theme="dark"] .cart-area p,
        [data-theme="dark"] .cart-area span,
        [data-theme="dark"] .cart-area div {
            color: var(--text-dark-main) !important;
        }

        /* 3. Redupkan teks abu-abu terang agar nyaman di mata */
        [data-theme="dark"] .cart-area p[style*="#94a3b8"],
        [data-theme="dark"] .cart-area p[style*="#64748b"],
        [data-theme="dark"] .cart-area p[style*="#475569"] {
            color: var(--text-dark-muted) !important;
        }

        /* 4. Gelapkan background item belanjaan, badge, dan box metode */
        [data-theme="dark"] #cart-total-items,
        [data-theme="dark"] #cart-items-container > div,
        [data-theme="dark"] .cart-area > div > div[style*="#eef2f6"] {
            background-color: #1A222F !important;
            border: 1px solid #3B4D66 !important;
        }

        /* 5. Sesuaikan warna Input form dan Dropdown Diskon */
        [data-theme="dark"] .cart-area input,
        [data-theme="dark"] .cart-area select {
            background-color: #1A222F !important;
            color: #ffffff !important;
            border: 1px solid #3B4D66 !important;
        }

        /* 6. Gelapkan tombol QRIS & Debit (yang aslinya putih) */
        [data-theme="dark"] .cart-area button[style*="background: white"] {
            background-color: #1A222F !important;
            color: #ffffff !important;
            border-color: #3B4D66 !important;
        }

        /* 7. Perbaiki Tombol Plus/Minus dan Delete di dalam daftar belanja JavaScript */
        [data-theme="dark"] #cart-items-container button {
            background-color: #2A374A !important;
            color: #ffffff !important;
            border: 1px solid #3B4D66 !important;
        }

        [data-theme="dark"] #cart-items-container button i {
            color: #ef4444 !important; /* Pastikan ikon tong sampah tetap merah */
        }

        /* 8. Selaraskan garis pembatas (Border-top) di atas ringkasan */
        [data-theme="dark"] .cart-area > div[style*="border-top"] {
            border-top-color: var(--border-dark) !important;
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

    });
</script>

</body>
</html>
