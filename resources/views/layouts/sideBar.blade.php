@php

    $globalSetting = \App\Models\Setting::first();
@endphp

        <aside class="sidebar">

                <div class="sidebar-header">
                    <div class="header-brand">
                        @if($globalSetting && $globalSetting->logo_toko)
                <div class="logo-img" style="margin-right: 12px; display: flex; align-items: center;">
                    <img
                        src="{{ asset($globalSetting->logo_toko) }}"
                        alt="Logo Toko"
                        style="height: 32px; width: 32px; object-fit: contain; border-radius: 4px;">
                </div>
            @else
                <div class="logo-icon" style="display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            @endif

            <div class="logo-text">
                <h1>{{ $globalSetting->nama_toko ?? 'Pos System' }}</h1>
                <p>Powered by Swiftbill</p>
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

        <a href="{{ route('report.index') }}" class="menu-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>
            <span>Laporan</span>
        </a>

        <a href="{{ route('expense.index') }}" class="menu-item {{ request()->routeIs('expense.*') ? 'active' : '' }}">
            <i class="fas fa-wallet"></i>
            <span>Pengeluaran</span>
        </a>

        <a href="{{ url('/pengaturan') }}" class="menu-item {{ request()->is('pengaturan') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>Pengaturan</span>
        </a>
    </div>

    <div class="sidebar-footer">
        {{-- SEKARANG SUDAH ADA id="theme-toggle" DI BAWAH INI --}}
        <button class="menu-item" id="theme-toggle" type="button">
            <div class="menu-item-between">
                <div class="menu-item-left">
                    <i class="fas fa-concierge-bell"></i>
                    <span>Mode Tampilan</span>
                </div>
                {{-- SEKARANG SUDAH ADA id="theme-icon" DI BAWAH INI --}}
                <i class="fas fa-moon" id="theme-icon"></i>
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
