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
        const modal = document.getElementById('modalPembayaran');
        const btnClose = document.getElementById('closeModalBtn');

        // 1. LOGIKA TOMBOL SIMPAN (Menggunakan Event Delegation)
        // Kita pantau semua klik di halaman...
        document.addEventListener('click', function(e) {
            // ...lalu kita cek apakah yang diklik itu tombol '.btn-save' atau icon di dalamnya
            const btnSimpan = e.target.closest('.btn-save');

            // Jika benar yang diklik adalah area tombol Simpan
            if (btnSimpan) {
                e.preventDefault();

                if (modal) {
                    modal.classList.add('active'); // Munculkan Modal
                } else {
                    console.error("Error: Modal tidak ditemukan di halaman ini.");
                }
            }
        });

        // 2. LOGIKA TOMBOL CLOSE (Tanda Silang)
        if (btnClose) {
            btnClose.addEventListener('click', function() {
                modal.classList.remove('active');
            });
        }

        // 3. LOGIKA KLIK DI LUAR MODAL (Untuk menutup)
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });
    });
</script>

</body>
</html>
