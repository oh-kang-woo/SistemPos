<aside class="sidebar">

    <div class="sidebar-header">
        <div class="header-brand">
            <div class="logo-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="logo-text">
                <h1>Pos System</h1>
                <p>Sistem kasir</p>
            </div>
        </div>
        <button class="toggle-btn">
            <i class="fas fa-angle-double-left"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('kasir.index') }}" class="menu-item {{ request()->routeIs('kasir.*') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i>
            <span>Kasir</span>
        </a>

        <a href="{{ route('product.index') }}" class="menu-item {{ request()->routeIs('product.index') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            <span>Manajemen Produk</span>
        </a>

        <a href="{{ route('transaction.index') }}" class="menu-item {{ request()->routeIs('transaction.index') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Riwayat Transaksi</span>
        </a>

        <a href="{{ url('/laporan') }}" class="menu-item {{ request()->is('laporan') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan</span>
        </a>

        <a href="{{ url('/pengeluaran') }}" class="menu-item {{ request()->is('pengeluaran') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i>
            <span>Pengeluaran</span>
        </a>

        <a href="{{ url('/pengaturan') }}" class="menu-item {{ request()->is('pengaturan') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <button class="menu-item">
            <div class="menu-item-between">
                <div class="menu-item-left">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Mode Tampilan</span>
                </div>
                <i class="fas fa-moon"></i>
            </div>
        </button>

        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit" class="menu-item logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>
