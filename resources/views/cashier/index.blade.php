@extends('layouts.app')

@section('content')

<style>
    /* Mengunci layar utama agar tidak bisa di-scroll secara keseluruhan */
    .main-content {
        overflow: hidden !important;
        display: flex;
        flex-direction: column;
    }

    /* Styling tambahan untuk item di keranjang */
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px dashed #e2e8f0;
    }
    .cart-item-info h6 { margin: 0; font-size: 14px; font-weight: 600; color: #1e293b; }
    .cart-item-info p { margin: 0; font-size: 12px; color: #64748b; }
    .cart-item-price { font-weight: 700; color: #1e293b; font-size: 14px; }

    /* KODE BARU: Menyembunyikan scrollbar tapi tetap bisa di-scroll */
    .no-scrollbar::-webkit-scrollbar {
        display: none; /* Chrome, Safari, Opera */
    }
    .no-scrollbar {
        -ms-overflow-style: none;  /* IE & Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<div style="display: flex; gap: 24px; height: 100%; overflow: hidden;">

    <div class="products-area" style="flex: 1; overflow-y: auto;">
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
                {{-- PERHATIKAN: Aku menambahkan fungsi onclick di sini --}}
                <div class="product-card" data-category="{{ $product->kategori_id }}" onclick="addToCart('{{ $product->nama_produk }}', {{ $product->harga_jual }})" style="cursor: pointer;">
                    <span class="product-category-badge">
                        {{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}
                    </span>

                    <div class="product-image-container">
                        <img src="{{ $product->gambar_produk ? asset('images/' . $product->gambar_produk) : asset('images/default-product.png') }}"
                            alt="{{ $product->nama_produk }}"
                            class="product-image">
                    </div>

                    <div class="product-info">
                        <span class="product-name">{{ $product->nama_produk }}</span>
                        <span class="product-code">{{ $product->kode_produk }}</span>
                    </div>

                    <div class="product-card-footer">
                        <div class="price-stock-group">
                            <span class="product-price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                            <span class="product-stock">Stok: {{ $product->jumlah_stok }} {{ $product->satuan }}</span>
                        </div>

                        <button class="add-product-btn">
                            +
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Panggil Komponen Cart (Di sinilah script yang tadi kita buat berjalan) --}}
    <x-cart />

    {{-- PANGGIL KOMPONEN MODAL DI SINI --}}
    <x-modalpembayaran />

</div>

{{-- SCRIPT LAMA TELAH DIHAPUS --}}
{{-- Karena script keranjangnya sudah ada di dalam file <x-cart /> --}}

@endsection
