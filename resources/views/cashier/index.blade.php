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
                <div class="product-card" data-category="{{ $product->kategori_id }}">
                    <span class="product-category-badge">
                        {{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}
                    </span>

                    <div class="product-image-container">
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
                            <span class="product-price">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</span>
                            <span class="product-stock">Stok: {{ $product->jumlah_stok }} {{ $product->satuan }}</span>
                        </div>

                        {{-- PERHATIKAN BAGIAN INI: Tambahkan data-name, data-price, data-stock --}}
                        <button class="add-product-btn"
                                data-id="{{ $product->id_produk }}"
                                data-name="{{ $product->nama_produk }}"
                                data-price="{{ $product->harga_jual }}"
                                data-stock="{{ $product->jumlah_stok }}">
                            +
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Panggil Komponen Cart --}}
    <x-cart />

</div>

{{-- SCRIPT UNTUK FUNGSI CART --}}
<script>
    let cart = [];

    // Tangkap semua tombol tambah produk
    document.querySelectorAll('.add-product-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const price = parseFloat(this.getAttribute('data-price'));
            const stock = parseInt(this.getAttribute('data-stock'));

            addToCart(id, name, price, stock);
        });
    });

    function addToCart(id, name, price, stock) {
        let existingItem = cart.find(item => item.id === id);

        if (existingItem) {
            if (existingItem.qty < stock) {
                existingItem.qty += 1;
            } else {
                alert('Stok tidak mencukupi!');
                return;
            }
        } else {
            if (stock > 0) {
                cart.push({ id: id, name: name, price: price, qty: 1 });
            } else {
                alert('Stok barang habis!');
                return;
            }
        }
        updateCartUI();
    }

    function updateCartUI() {
        let subtotal = 0;
        let totalItems = 0;
        const cartContainer = document.getElementById('cart-items-container');

        if (cartContainer) {
            cartContainer.innerHTML = ''; // Bersihkan list

            cart.forEach((item, index) => {
                subtotal += (item.price * item.qty);
                totalItems += item.qty;

                // Render HTML untuk setiap item di keranjang
                cartContainer.innerHTML += `
                    <div class="cart-item">
                        <div class="cart-item-info">
                            <h6>${item.name}</h6>
                            <p>Rp ${item.price.toLocaleString('id-ID')} x ${item.qty}</p>
                        </div>
                        <div class="cart-item-price">
                            Rp ${(item.price * item.qty).toLocaleString('id-ID')}
                        </div>
                    </div>
                `;
            });
        }

        // Update Text di komponen Cart
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalItemsEl = document.getElementById('cart-total-items');
        const grandTotalEl = document.getElementById('cart-grand-total');

        if (subtotalEl) subtotalEl.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        if (totalItemsEl) totalItemsEl.innerText = totalItems + ' Item';
        if (grandTotalEl) grandTotalEl.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    }
</script>
@endsection
