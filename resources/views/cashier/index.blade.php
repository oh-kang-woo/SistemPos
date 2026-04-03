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
        <div class="products-search">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" placeholder="Cari produk">
        </div>

        {{-- Looping Data Kategori untuk Tombol Filter --}}
        <div class="products-filters">
            <button class="filter-btn active" data-filter="all">Semua produk</button>
            @foreach($categories as $category)
                <button class="filter-btn" data-filter="{{ $category->id_kategori }}">
                    {{ $category->nama_kategori }}
                </button>
            @endforeach
        </div>

        {{-- Looping Data Produk --}}
        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card" data-category="{{ $product->kategori_id }}">
                    {{-- Nama Kategori (ambil dari relasi) --}}
                    <span class="product-category-badge">
                        {{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}
                    </span>

                    <div class="product-image-container">
                        {{-- Cek apakah gambar ada, jika tidak pakai gambar default --}}
                        <img src="{{ $product->gambar_produk ? asset('storage/' . $product->gambar_produk) : asset('images/default-product.png') }}"
                             alt="{{ $product->nama_produk }}"
                             class="product-image">
                    </div>

                    <div class="product-info">
                        <span class="product-name">{{ $product->nama_produk }}</span>
                        <span class="product-code">{{ $product->kode_produk }}</span>
                    </div>

                    <div class="product-card-footer">
                        <div class="price-stock-group">
                            {{-- Format harga menjadi Rupiah (Rp) --}}
                            <span class="product-price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                            <span class="product-stock">Stok: {{ $product->jumlah_stok }} {{ $product->satuan }}</span>
                        </div>
                        {{-- Tambahkan data-id agar saat tombol '+' diklik, kamu tahu produk mana yang dipilih untuk Cart --}}
                        <button class="add-product-btn" data-id="{{ $product->id_produk }}">+</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <x-cart />

</div>
@endsection
