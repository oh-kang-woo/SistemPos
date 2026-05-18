<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SwifttBill - Kelola Bisnis & Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>

    <nav class="navbar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 40px; background: #ffffff; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
        <div class="brand" style="font-weight: 700; font-size: 20px; color: #192231;">SwifttBill</div>

        <div>
            @auth
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout" style="text-decoration: none; display: inline-block; text-align: center; background: #192231; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: 600; font-family: 'Poppins', sans-serif; font-size: 13px;">
                        Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-logout" style="text-decoration: none; display: inline-block; text-align: center; background: #192231; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 600; font-size: 13px;">
                    Log In
                </a>
            @endauth
        </div>
    </nav>

    <header class="hero-section">
        <div class="hero-content animate-fade-in">
            <h1>Kelola Bisnis &amp; Cafe Dengan<br>Presisi Maksimal</h1>
            <p>Sistem Point of Sale yang dirancang untuk efisiensi tinggi. Pantau stok secara real-time, kelola transaksi dalam hitungan detik, dan analisis performa bisnis Anda dari satu dashboard terintegrasi.</p>

            @auth
                <a href="{{ url('/kasir') }}" class="btn-primary" style="text-decoration: none;">Buka Aplikasi <i class="fa-solid fa-arrow-right"></i></a>
            @else
                <a href="{{ route('register') }}" class="btn-primary" style="text-decoration: none;">Mulai Sekarang <i class="fa-solid fa-arrow-right"></i></a>
            @endauth
        </div>
        <div class="hero-image animate-fade-in">
            <img src="{{ asset('images/tablet.jpeg') }}" alt="SwifttBill Tablet Dashboard">
        </div>
    </header>

    <section class="features-section">
        <h2 class="section-title">Fitur Unggulan SwifttBill</h2>
        <p class="section-subtitle">Solusi lengkap untuk manajemen operasional harian Anda.</p>

        <div class="features-container-grid">
            <div class="feature-card">
                <div>
                    <div class="icon-badge badge-blue"><i class="fa-solid fa-cart-shopping"></i></div>
                    <h3>Sistem Kasir Cepat</h3>
                    <p>Transaksi kilat dengan antarmuka intuitif. Mendukung berbagai metode pembayaran mulai dari Tunai, QRIS, hingga Kartu Debit.</p>
                </div>
            </div>

            <div class="feature-card">
                <div>
                    <div class="icon-badge badge-slate"><i class="fa-solid fa-box"></i></div>
                    <h3>Manajemen Produk</h3>
                    <p>Atur stok, kategori, dan varian produk dengan mudah. Notifikasi otomatis saat stok barang mulai menipis.</p>
                </div>
            </div>

            <div class="feature-card">
                <div>
                    <div class="icon-badge badge-indigo"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                    <h3>Laporan Penjualan</h3>
                    <p>Dapatkan wawasan mendalam melalui laporan harian, mingguan, dan bulanan yang akurat dan mudah dimengerti.</p>
                </div>
            </div>

            <div class="history-card">
                <div class="history-content">
                    <h2>Riwayat Transaksi Terpusat</h2>
                    <p>Akses semua data transaksi dari masa lalu hingga sekarang dengan sistem pencarian filter yang sangat detail.</p>
                    <a href="#" class="btn-secondary">Cek Riwayat</a>
                </div>
                <i class="fa-solid fa-clock-rotate-left bg-icon-clock"></i>
            </div>

            <div class="feature-card">
                <div>
                    <div class="icon-badge badge-red"><i class="fa-solid fa-money-bill-wave"></i></div>
                    <h3>Catat Pengeluaran</h3>
                    <p>Pantau arus kas keluar masuk untuk menjaga kesehatan finansial bisnis Anda tetap stabil.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="analytics-banner">
        <div class="analytics-visual">
            <div class="chart-header">
                <span>Grafik Pendapatan</span>
                <span style="color: #64748b;">Minggu Ini</span>
            </div>
            <div class="chart-bars-solid">
                <div class="bar-solid bs-1"></div>
                <div class="bar-solid bs-2"></div>
                <div class="bar-solid bs-3"></div>
                <div class="bar-solid bs-4"></div>
                <div class="bar-solid bs-5"></div>
                <div class="bar-solid bs-6"></div>
                <div class="bar-solid bs-7"></div>
            </div>
            <div class="chart-footer">
                <div class="stat-box"><span>Total Txs</span><h4>1.284</h4></div>
                <div class="stat-box"><span>Laba Kotor</span><h4>45.2jt</h4></div>
                <div class="stat-box"><span>Growth</span><h4 class="text-green">+12%</h4></div>
            </div>
        </div>

        <div class="analytics-content">
            <h2>Analitik Cerdas dalam Genggaman</h2>
            <p>Jangan biarkan bisnis berjalan tanpa arah. SwifttBill menyediakan data analitik real-time yang membantu Anda membuat keputusan strategis berbasis fakta, bukan sekadar intuisi.</p>
            <div class="checklist-items">
                <div class="check-item"><i class="fa-regular fa-circle-check"></i> Monitor performa outlet kapan pun dan di mana pun.</div>
                <div class="check-item"><i class="fa-regular fa-circle-check"></i> Identifikasi produk paling laku dan paling tidak laku.</div>
                <div class="check-item"><i class="fa-regular fa-circle-check"></i> Ekspor laporan keuangan hanya dengan satu klik.</div>
            </div>
        </div>
    </section>

</body>
</html>
