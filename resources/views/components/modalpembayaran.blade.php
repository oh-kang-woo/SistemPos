<div id="modalPembayaran" class="modal-overlay" style="display: none; align-items: center; justify-content: center;">
    <div class="modal-content">

        <div class="modal-header">
            <h2 class="modal-title">Pembayaran</h2>
            <div class="modal-actions">
                <button class="btn-icon-modal" id="closeModalBtn" onclick="closePaymentModal()"><i class="fas fa-times"></i></button>
            </div>
        </div>

        <div class="modal-body">
            <h4 class="section-title">Item Transaksi</h4>
            <div id="modal-items-container"></div>

            <div class="modal-total-box" style="margin-top: 15px;">
                <span class="total-label">Total yang harus dibayar:</span>
                <span class="total-amount" id="modal-grand-total">Rp 0</span>
            </div>

            <h4 class="section-title">Metode pembayaran</h4>
            <div class="method-buttons-modal">
                <button class="m-btn active" id="m-btn-tunai"><i class="fas fa-money-bill-wave"></i> Tunai</button>
                <button class="m-btn" id="m-btn-qris"><i class="fas fa-qrcode"></i> QRIS</button>
                <button class="m-btn" id="m-btn-debit"><i class="far fa-credit-card"></i> Debit</button>
            </div>

            <h4 class="section-title">Pembayaran</h4>
            <div class="calc-row">
                <span class="label" id="modal-method-label">Tunai</span>
                <span class="val" id="modal-cash-given">Rp 0</span>
            </div>
            <div class="calc-row">
                <span class="label text-green">Kembalian</span>
                <span class="val text-green" id="modal-change">Rp 0</span>
            </div>

            <div class="customer-row">
                <span class="label">Nama Pelanggan</span>
                <span class="val" id="modal-customer-name">-</span>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-print" id="btn-simpan-cetak" onclick="prosesPembayaranDB(true)"><i class="fas fa-print"></i> Simpan & Cetak resi</button>
            <button class="btn-no-print" id="btn-simpan" onclick="prosesPembayaranDB(false)">Simpan tanpa cetak resi</button>
        </div>

    </div>
</div>

<script>
    // --- FUNGSI: Untuk Mengisi Data & Membuka Modal dari cart.blade.php ---
    window.showModalPembayaran = function() {
        const modal = document.getElementById('modalPembayaran');
        if (!modal) return;

        // 1. Hitung total belanjaan & generate list item untuk modal
        let totalBelanja = 0;
        let itemsHtml = '';

        // Pastikan variabel cart tersedia dari file induk (cart.blade.php)
        if (typeof cart !== 'undefined' && cart.length > 0) {
            cart.forEach(item => {
                const itemTotal = item.price * item.qty;
                totalBelanja += itemTotal;
                itemsHtml += `
                    <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 5px; color: #475569;">
                        <span>${item.name} (${item.qty}x)</span>
                        <span>Rp ${itemTotal.toLocaleString('id-ID')}</span>
                    </div>`;
            });
        }

        document.getElementById('modal-items-container').innerHTML = itemsHtml || '<p style="color:#94a3b8; font-size:12px;">Tidak ada item</p>';
        document.getElementById('modal-grand-total').innerText = 'Rp ' + totalBelanja.toLocaleString('id-ID');

        // 2. Ambil inputan dari area Kasir / Cart
        const inputBayarVal = document.getElementById('input-jumlah-bayar') ? document.getElementById('input-jumlah-bayar').value : "0";
        let uangDiterima = parseInt(inputBayarVal.replace(/[^0-9]/g, '')) || 0;
        const inputNama = document.getElementById('input-nama-pelanggan') ? document.getElementById('input-nama-pelanggan').value : "";

        // Jika metode QRIS/Debit, paksa uang diterima sama dengan total belanja
        if (typeof selectedPaymentMethod !== 'undefined' && selectedPaymentMethod !== 'Tunai') {
            uangDiterima = totalBelanja;
        }

        let uangKembali = uangDiterima - totalBelanja;
        if (uangKembali < 0) uangKembali = 0;

        // 3. Set text info ke dalam modal sesuai desain asli Anda
        document.getElementById('modal-cash-given').innerText = 'Rp ' + uangDiterima.toLocaleString('id-ID');
        document.getElementById('modal-change').innerText = 'Rp ' + uangKembali.toLocaleString('id-ID');
        document.getElementById('modal-customer-name').innerText = inputNama || 'Pelanggan Umum';

        // Seleraskan label & class aktif tombol metode pembayaran di modal tanpa merusak style CSS
        if (typeof selectedPaymentMethod !== 'undefined') {
            document.getElementById('modal-method-label').innerText = selectedPaymentMethod;

            // Reset class active bawaan Anda
            document.querySelectorAll('.method-buttons-modal .m-btn').forEach(btn => btn.classList.remove('active'));

            if (selectedPaymentMethod === 'Tunai') document.getElementById('m-btn-tunai').classList.add('active');
            if (selectedPaymentMethod === 'QRIS') document.getElementById('m-btn-qris').classList.add('active');
            if (selectedPaymentMethod === 'Debit') document.getElementById('m-btn-debit').classList.add('active');
        }

        // 4. Munculkan modal secara flex sesuai style inline CSS asli Anda
        modal.style.display = 'flex';
    };

    window.closePaymentModal = function() {
        const modal = document.getElementById('modalPembayaran');
        if (modal) modal.style.display = 'none';
    };

    // Fungsi Utama Pembayaran (Kirim ke Database)
    window.prosesPembayaranDB = function(cetakResi) {
        if (typeof cart === 'undefined' || cart.length === 0) {
            alert('Keranjang belanja kosong!');
            return;
        }

        const inputBayarVal = document.getElementById('input-jumlah-bayar') ? document.getElementById('input-jumlah-bayar').value : "0";
        let uangDiterima = parseInt(inputBayarVal.replace(/[^0-9]/g, '')) || 0;
        const inputNama = document.getElementById('input-nama-pelanggan') ? document.getElementById('input-nama-pelanggan').value : "";
        const metodeSekarang = typeof selectedPaymentMethod !== 'undefined' ? selectedPaymentMethod : 'Tunai';

        let totalBelanja = 0;
        let totalItem = 0;
        cart.forEach(item => {
            totalBelanja += (item.price * item.qty);
            totalItem += item.qty;
        });

        // Paksa uang pas jika non-tunai
        if (metodeSekarang !== 'Tunai') {
            uangDiterima = totalBelanja;
        }

        if (uangDiterima < totalBelanja) {
            alert('Uang pelanggan kurang!');
            return;
        }

        // Kunci tombol aksi agar tidak terkirim ganda
        document.getElementById('btn-simpan-cetak').disabled = true;
        document.getElementById('btn-simpan').disabled = true;

        const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

        // Susun payload terstandarisasi untuk Backend Laravel Anda
        const payload = {
            cart: cart,
            total_item: totalItem,
            total_pembayaran: totalBelanja,
            uang_diterima: uangDiterima,
            uang_kembali: uangDiterima - totalBelanja,
            metode_pembayaran: metodeSekarang,
            nama_pelanggan: inputNama || 'Pelanggan Umum',
            _token: csrfToken
        };

        fetch('/transaksi/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(payload)
        })
        .then(response => {
            if (!response.ok) throw new Error('Terjadi kegagalan komunikasi dengan database backend.');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Notifikasi Transaksi Sukses Berhasil Disimpan
                alert('Transaksi Berhasil Disimpan!');

                // RESET SEMUA STATE APLIKASI
                cart = [];
                if (typeof renderCart === 'function') renderCart();
                closePaymentModal();

                if(document.getElementById('input-jumlah-bayar')) document.getElementById('input-jumlah-bayar').value = '';
                if(document.getElementById('input-nama-pelanggan')) document.getElementById('input-nama-pelanggan').value = '';

                // Memuat ulang halaman agar tampilan dan stok tersinkronisasi total
                location.reload();
            } else {
                alert('Gagal memproses data: ' + data.message);
                document.getElementById('btn-simpan-cetak').disabled = false;
                document.getElementById('btn-simpan').disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal terhubung ke server. Pastikan database dan controller Laravel Anda merespons dengan benar.');
            document.getElementById('btn-simpan-cetak').disabled = false;
            document.getElementById('btn-simpan').disabled = false;
        });
    };

    // Deteksi penutupan modal dari klik area latar luar (overlay)
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalPembayaran');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closePaymentModal();
            });
        }
    });
</script>
