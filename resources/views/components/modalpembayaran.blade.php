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
                <button class="m-btn active"><i class="fas fa-money-bill-wave"></i> Tunai</button>
                <button class="m-btn"><i class="fas fa-qrcode"></i> QRIS</button>
                <button class="m-btn"><i class="far fa-credit-card"></i> Debit</button>
            </div>

            <h4 class="section-title">Pembayaran</h4>
            <div class="calc-row">
                <span class="label">Tunai</span>
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
            {{-- Tambahkan event onclick ke fungsi prosesPembayaranDB --}}
            <button class="btn-print" id="btn-simpan-cetak" onclick="prosesPembayaranDB(true)"><i class="fas fa-print"></i> Simpan & Cetak resi</button>
            <button class="btn-no-print" id="btn-simpan" onclick="prosesPembayaranDB(false)">Simpan tanpa cetak resi</button>
        </div>

    </div>
</div>

<script>
    window.closePaymentModal = function() {
        const modal = document.getElementById('modalPembayaran');
        if (modal) modal.style.display = 'none';
    };

    // Fungsi Utama Pembayaran
    window.prosesPembayaranDB = function(cetakResi) {
        // Ambil nilai dari inputan
        const inputBayarVal = document.getElementById('input-jumlah-bayar') ? document.getElementById('input-jumlah-bayar').value : "0";
        const uangDiterima = parseInt(inputBayarVal.replace(/[^0-9]/g, '')) || 0;
        const inputNama = document.getElementById('input-nama-pelanggan') ? document.getElementById('input-nama-pelanggan').value : "";

        // Hitung total dari keranjang
        let totalBelanja = 0;
        let totalItem = 0;
        cart.forEach(item => {
            totalBelanja += (item.price * item.qty);
            totalItem += item.qty;
        });

        if (uangDiterima < totalBelanja) {
            alert('Uang pelanggan kurang!');
            return;
        }

        // Disable tombol biar gak di-klik 2 kali
        document.getElementById('btn-simpan-cetak').disabled = true;
        document.getElementById('btn-simpan').disabled = true;

        // Ambil CSRF Token (cukup deklarasi 1 kali saja)
        const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';

        // Siapkan data yang mau dikirim
        const payload = {
            cart: cart,
            total_item: totalItem,
            total_pembayaran: totalBelanja,
            uang_diterima: uangDiterima,
            uang_kembali: uangDiterima - totalBelanja,
            metode_pembayaran: 'Tunai',
            nama_pelanggan: inputNama || 'Pelanggan Umum',
            _token: csrfToken
        };

        // Kirim data ke backend
        fetch('/transaksi/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // Token disisipkan di sini
            },
            body: JSON.stringify(payload) // Data payload dimasukkan ke sini
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Transaksi Berhasil!');

                if (cetakResi) {
                    alert('Simulasi Cetak Resi ID: ' + data.transaksi_id);
                }

                // Reset keranjang & tutup modal
                cart = [];
                renderCart();
                closePaymentModal();
                if(document.getElementById('input-jumlah-bayar')) document.getElementById('input-jumlah-bayar').value = '';
                if(document.getElementById('input-nama-pelanggan')) document.getElementById('input-nama-pelanggan').value = '';

                // Refresh halaman untuk update stok produk
                location.reload();
            } else {
                alert('Gagal: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan pada server. Coba lagi.');
        })
        .finally(() => {
            // Kembalikan tombol seperti semula jika selesai
            document.getElementById('btn-simpan-cetak').disabled = false;
            document.getElementById('btn-simpan').disabled = false;
        });
    };

    // Tutup modal jika diklik di area luar modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalPembayaran');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closePaymentModal();
            });
        }
    });
</script>
