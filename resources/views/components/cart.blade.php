<div class="cart-area" style="width: 350px; background: white; padding: 20px; border-radius: 12px; display: flex; flex-direction: column;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0; font-size: 18px; font-weight: bold;">Ringkasan Pembayaran</h3>
        <span id="cart-total-items" style="background: #f1f5f9; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">0 Item</span>
    </div>

    <div class="no-scrollbar" style="flex: 1; overflow-y: auto;">
        <p style="font-size: 14px; font-weight: bold; margin-bottom: 10px;">Item Dipilih</p>

        {{-- Tempat Item Keranjang akan Muncul --}}
        <div id="cart-items-container" style="min-height: 100px;">
            <p style="text-align: center; color: #94a3b8; font-size: 12px; margin-top: 20px;">Belum ada item dipilih</p>
        </div>

        <div style="display: flex; justify-content: space-between; margin-top: 20px; font-size: 14px;">
            <span>Sub total</span>
            <span id="cart-subtotal" style="font-weight: bold;">Rp 0</span>
        </div>

        <div style="margin-top: 15px;">
            <p style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">Diskon</p>
            <div style="display: flex; gap: 10px;">
                <select style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;"><option>%</option></select>
                <input type="number" value="0" style="flex: 1; padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>
        </div>

        <div style="margin-top: 20px;">
            <p style="font-size: 14px; color: #64748b; margin-bottom: 4px;">Total pembayaran</p>
            <h2 id="cart-grand-total" style="margin: 0; font-size: 24px; font-weight: 800;">Rp 0</h2>
        </div>
    </div>

    {{-- Area Bawah (Checkout dll) --}}
    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">

        {{-- Box Metode Pembayaran --}}
        <div style="background: #eef2f6; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
            <p style="font-size: 14px; color: #475569; margin-top: 0; margin-bottom: 10px;">Metode pembayaran:</p>
            <div style="display: flex; gap: 10px;">
                <button style="flex: 1; padding: 8px; border: 1px solid #2563eb; background: white; border-radius: 6px; font-weight: bold; color: #2563eb; font-size: 13px;">
                    <i class="fas fa-money-bill-wave" style="margin-right: 4px;"></i> Tunai
                </button>
                <button style="flex: 1; padding: 8px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; font-weight: bold; color: #64748b; font-size: 13px;">
                    <i class="fas fa-qrcode" style="margin-right: 4px;"></i> QRIS
                </button>
                <button style="flex: 1; padding: 8px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; font-weight: bold; color: #64748b; font-size: 13px;">
                    <i class="fas fa-credit-card" style="margin-right: 4px;"></i> Debit
                </button>
            </div>
        </div>

        {{-- Input Jumlah Bayar --}}
        <div style="margin-bottom: 15px;">
            <p style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">Jumlah bayar</p>
            <input type="text" id="input-jumlah-bayar" placeholder="Rp 0" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 14px; color: #0f172a;">
        </div>

        {{-- Nama Pelanggan --}}
        <div style="margin-bottom: 15px;">
            <p style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">Nama Pelanggan</p>
            <input type="text" id="input-nama-pelanggan" placeholder="Contoh: arip" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; font-size: 14px;">
        </div>


       {{-- Tombol Aksi Bawah --}}
        <div style="margin-bottom: 10px; display: flex; flex-direction: column; gap: 10px;">
            <button id="btn-bayar-modal" style="width: 100%; padding: 14px; border: none; background: #1e293b; color: white; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 16px;">
                Bayar Sekarang
            </button>

            {{-- Tombol Hapus Keranjang Baru --}}
            <button onclick="clearCart()" style="width: 100%; padding: 12px; border: 1px solid #ef4444; background: #fef2f2; color: #ef4444; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px;">
                <i class="fas fa-trash-alt" style="margin-right: 6px;"></i> Hapus Keranjang
            </button>
        </div>
    </div>
</div>

{{-- Script Gabungan SUPER LENGKAP --}}
<script>
    // --- 1. Inisialisasi Data Keranjang (Global) ---
    let cart = [];

    // --- FUNGSI UPDATE: Menambahkan parameter ID ---
    window.addToCart = function(id, name, price) {
        // Membersihkan harga dari format string
        let cleanPrice = typeof price === 'string' ? parseInt(price.replace(/[^0-9]/g, '')) : price;
        if (isNaN(cleanPrice)) cleanPrice = 0;

        // Cek apakah item sudah ada di dalam keranjang BERDASARKAN ID
        const existingItemIndex = cart.findIndex(item => item.id === id);

        if (existingItemIndex !== -1) {
            cart[existingItemIndex].qty += 1; // Tambah jumlah jika sudah ada
        } else {
            // Jika belum ada, buat baris item baru dengan menyimpan ID-nya
            cart.push({
                id: id,
                name: name,
                price: cleanPrice,
                qty: 1
            });
        }
        renderCart(); // Perbarui tampilan
    };

    // --- 2. Fungsi Global Interaksi Keranjang ---
    window.updateQty = function(index, change) {
        cart[index].qty += change;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        renderCart();
    };

    window.removeItem = function(index) {
        cart.splice(index, 1);
        renderCart();
    };

    window.clearCart = function() {
        if(confirm("Apakah Anda yakin ingin mengosongkan keranjang?")) {
            cart = [];
            renderCart();
        }
    };

    window.renderCart = function() {
        const container = document.getElementById('cart-items-container');
        const subtotalEl = document.getElementById('cart-subtotal');
        const grandTotalEl = document.getElementById('cart-grand-total');
        const totalItemsBadge = document.getElementById('cart-total-items');

        if (!container) return;

        if (cart.length === 0) {
            container.innerHTML = '<p style="text-align: center; color: #94a3b8; font-size: 12px; margin-top: 20px;">Belum ada item dipilih</p>';
            if(subtotalEl) subtotalEl.innerText = 'Rp 0';
            if(grandTotalEl) grandTotalEl.innerText = 'Rp 0';
            if(totalItemsBadge) totalItemsBadge.innerText = '0 Item';
            return;
        }

        let html = '';
        let subtotal = 0;
        let totalItemsCount = 0;

        cart.forEach((item, index) => {
            const itemTotal = item.price * item.qty;
            subtotal += itemTotal;
            totalItemsCount += item.qty;

            html += `
            <div style="background: #e2e8f0; padding: 12px; border-radius: 8px; margin-bottom: 10px; display: flex; justify-content: space-between;">
                <div style="flex: 1;">
                    <div style="font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 4px;">${item.name}</div>
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 8px;">Rp ${item.price.toLocaleString('id-ID')} X ${item.qty}</div>
                    <div style="font-weight: 800; font-size: 14px; color: #0f172a;">Rp ${itemTotal.toLocaleString('id-ID')}</div>
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-end; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 12px; font-weight: bold; color: #0f172a;">
                        <button onclick="updateQty(${index}, -1)" style="border:none; background:white; width:24px; height:24px; border-radius:4px; cursor:pointer; font-size: 16px; display:flex; align-items:center; justify-content:center; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">-</button>
                        <span style="font-size: 14px;">${item.qty}</span>
                        <button onclick="updateQty(${index}, 1)" style="border:none; background:white; width:24px; height:24px; border-radius:4px; cursor:pointer; font-size: 14px; display:flex; align-items:center; justify-content:center; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">+</button>
                    </div>
                    <button onclick="removeItem(${index})" style="border:none; background:none; color: #ef4444; cursor:pointer; padding: 0; margin-top: 10px;">
                        <i class="fas fa-trash-alt" style="font-size: 14px;"></i>
                    </button>
                </div>
            </div>
            `;
        });

        container.innerHTML = html;
        if(subtotalEl) subtotalEl.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        if(grandTotalEl) grandTotalEl.innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        if(totalItemsBadge) totalItemsBadge.innerText = totalItemsCount + ' Item';
    };

    // --- 3. Event Listener Utama ---
    document.addEventListener('DOMContentLoaded', function() {
        renderCart();

        // 3A. Script Format Rupiah
        const inputBayar = document.getElementById('input-jumlah-bayar');
        if (inputBayar) {
            inputBayar.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value, 'Rp ');
            });
        }

        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
        }

        // 3B. Script Tampilkan Popup Modal
        const btnBayarModal = document.getElementById('btn-bayar-modal');
        if (btnBayarModal) {
            btnBayarModal.addEventListener('click', function(e) {
                e.preventDefault();

                // Cek apakah keranjang kosong
                if (typeof cart === 'undefined' || cart.length === 0) {
                    alert('Keranjang belanja masih kosong! Silakan pilih produk terlebih dahulu.');
                    return;
                }

                // Siapkan data untuk ditampilkan di modal
                prepareModalData();

                // Tampilkan modal
                const paymentModal = document.getElementById('modalPembayaran');
                if (paymentModal) paymentModal.style.display = 'flex';
            });
        }

        function prepareModalData() {
            const modalItemsContainer = document.getElementById('modal-items-container');
            const modalGrandTotal = document.getElementById('modal-grand-total');
            const modalCashGiven = document.getElementById('modal-cash-given');
            const modalChange = document.getElementById('modal-change');
            const modalCustomerName = document.getElementById('modal-customer-name');

            let totalBelanja = 0;
            let itemsHtml = '';

            cart.forEach(item => {
                const subtotalItem = item.price * item.qty;
                totalBelanja += subtotalItem;
                itemsHtml += `
                    <div class="t-item" style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px;">
                        <div>
                            <span class="t-name" style="font-weight: 600; display: block; color: #1e293b;">${item.name}</span>
                            <span class="t-calc" style="color: #64748b; font-size: 12px;">Rp ${item.price.toLocaleString('id-ID')} X ${item.qty}</span>
                        </div>
                        <span class="t-price" style="font-weight: bold; color: #1e293b;">Rp ${subtotalItem.toLocaleString('id-ID')}</span>
                    </div>
                `;
            });

            if (modalItemsContainer) modalItemsContainer.innerHTML = itemsHtml;
            if (modalGrandTotal) modalGrandTotal.innerText = 'Rp ' + totalBelanja.toLocaleString('id-ID');

            const inputBayarVal = document.getElementById('input-jumlah-bayar') ? document.getElementById('input-jumlah-bayar').value : "0";
            const cashGiven = parseInt(inputBayarVal.replace(/[^0-9]/g, '')) || 0;
            const kembalian = cashGiven - totalBelanja;

            if (modalCashGiven) modalCashGiven.innerText = 'Rp ' + cashGiven.toLocaleString('id-ID');
            if (modalChange) {
                if (kembalian >= 0) {
                    modalChange.innerText = 'Rp ' + kembalian.toLocaleString('id-ID');
                    modalChange.style.color = '#10b981';
                } else {
                    modalChange.innerText = 'Uang Kurang (Rp ' + Math.abs(kembalian).toLocaleString('id-ID') + ')';
                    modalChange.style.color = '#ef4444';
                }
            }

            const inputNama = document.getElementById('input-nama-pelanggan');
            const inputNamaVal = inputNama ? inputNama.value : "";
            if (modalCustomerName) modalCustomerName.innerText = inputNamaVal.trim() === '' ? 'Tanpa Nama' : inputNamaVal;
        }
    });
</script>
