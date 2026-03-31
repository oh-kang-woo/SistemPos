<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            /* Warna background abu-abu kebiruan persis di gambar */
            background-color: #E6EDF2;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Flexbox Utama: Sidebar di Kiri, Konten di Kanan */
        .app-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Bungkus untuk bagian kanan (Navbar + Konten) */
        .content-area {
            flex: 1; /* Mengambil sisa ruang di sebelah kanan sidebar */
            display: flex;
            flex-direction: column; /* Navbar di atas, konten di bawah */
            overflow: hidden;
        }

        /* Area untuk halaman utama */
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

</body>
</html>
