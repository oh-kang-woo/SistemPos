@extends('layouts.app')

@section('content')

<style>
    /* Mengunci layar utama agar tidak bisa di-scroll secara keseluruhan */
    .main-content {
        overflow: hidden !important;
        display: flex;
        flex-direction: column;
    }
</style>

<div style="display: flex; gap: 24px; height: 100%; overflow: hidden;">

    <div class="products-area">

        {{-- <div class="products-header-group">
            <h2 class="products-title">Kasir</h2>
            <p class="products-subtitle">Cafe simpang MI</p>
        </div> --}}

        <div class="products-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Cari produk">
        </div>

        <div class="products-filters">
            <button class="filter-btn active">Semua produk</button>
            <button class="filter-btn">Makanan</button>
            <button class="filter-btn">Minuman</button>
        </div>

        <div class="products-grid">

            <div class="product-card">
                <span class="product-category-badge">Makanan</span>
                <div class="product-image-container">
                    <img src="https://lh3.googleusercontent.com/pw/AJFCJaVvL8q7wT5f_C2F4Zc" alt="Mie Goreng Telur" class="product-image">
                </div>
                <div class="product-info">
                    <span class="product-name">Mie Goreng Telur</span>
                    <span class="product-code">BRG-OS1</span>
                </div>
                <div class="product-card-footer">
                    <div class="price-stock-group">
                        <span class="product-price">Rp 12.000</span>
                        <span class="product-stock">Stok: 120</span>
                    </div>
                    <button class="add-product-btn">+</button>
                </div>
            </div>

            <div class="product-card">
                <span class="product-category-badge">Makanan</span>
                <div class="product-image-container">
                    <img src="https://lh3.googleusercontent.com/pw/AJFCJaVVgC-Pz4p_YJj8B9f" alt="Mie Goreng Spesial" class="product-image">
                </div>
                <div class="product-info">
                    <span class="product-name">Mie Goreng Spesial</span>
                    <span class="product-code">BRG-OS2</span>
                </div>
                <div class="product-card-footer">
                    <div class="price-stock-group">
                        <span class="product-price">Rp 18.000</span>
                        <span class="product-stock">Stok: 33</span>
                    </div>
                    <button class="add-product-btn">+</button>
                </div>
            </div>

            <div class="product-card">
                <span class="product-category-badge">Minuman</span>
                <div class="product-image-container">
                    <img src="https://lh3.googleusercontent.com/pw/AJFCJaWwXFw-C0E8D9-X9yS" alt="Es Teh Jumbo" class="product-image">
                </div>
                <div class="product-info">
                    <span class="product-name">Es Teh Jumbo</span>
                    <span class="product-code">BRG-002</span>
                </div>
                <div class="product-card-footer">
                    <div class="price-stock-group">
                        <span class="product-price">Rp 8.000</span>
                        <span class="product-stock">Stok: 81</span>
                    </div>
                    <button class="add-product-btn">+</button>
                </div>
            </div>

            <div class="product-card">
                <span class="product-category-badge">Minuman</span>
                <div class="product-image-container">
                    <img src="https://lh3.googleusercontent.com/pw/AJFCJaV4jA7R4oD8W8C_E8U" alt="Ocha 500ml" class="product-image">
                </div>
                <div class="product-info">
                    <span class="product-name">Ocha 500ml</span>
                    <span class="product-code">BRG-003</span>
                </div>
                <div class="product-card-footer">
                    <div class="price-stock-group">
                        <span class="product-price">Rp 8.000</span>
                        <span class="product-stock">Stok: 32</span>
                    </div>
                    <button class="add-product-btn">+</button>
                </div>
            </div>

        </div> </div> <x-cart />

</div>
@endsection
