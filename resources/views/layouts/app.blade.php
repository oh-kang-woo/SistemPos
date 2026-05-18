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
            /* Memberikan transisi smooth saat sidebar mengecil/melebar */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
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
        // 1. LOGIKA SIDEBAR MINIMIZE (FITUR BARU)
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
