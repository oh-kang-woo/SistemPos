<div id="modalPembayaran" class="modal-overlay" style="display: none; align-items: center; justify-content: center;">
    <div class="modal-content">

        <div class="modal-header">
            <h2 class="modal-title">Pembayaran</h2>
            <div class="modal-actions">
                <button class="btn-icon-modal" id="closeModalBtn" onclick="closePaymentModal()"><i class="fas fa-times"></i></button>
                <button class="btn-icon-modal"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="modal-body">
            <h4 class="section-title">Item Transaksi</h4>

            {{-- Container kosong untuk diisi oleh JavaScript --}}
            <div id="modal-items-container">
                </div>

            <div class="modal-total-box" style="margin-top: 15px;">
                <span class="total-label">Total yang harus dibayar:</span>
                {{-- Tambahkan ID modal-grand-total --}}
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
                {{-- Tambahkan ID modal-cash-given --}}
                <span class="val" id="modal-cash-given">Rp 0</span>
            </div>
            <div class="calc-row">
                <span class="label text-green">Kembalian</span>
                {{-- Tambahkan ID modal-change --}}
                <span class="val text-green" id="modal-change">Rp 0</span>
            </div>

            <div class="customer-row">
                <span class="label">Nama Pelanggan</span>
                {{-- Tambahkan ID modal-customer-name --}}
                <span class="val" id="modal-customer-name">-</span>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn-print"><i class="fas fa-print"></i> Simpan & Cetak resi</button>
            <button class="btn-no-print" onclick="closePaymentModal()">Simpan tanpa cetak resi</button>
        </div>

    </div>
</div>

<script>
    window.closePaymentModal = function() {
        const modal = document.getElementById('modalPembayaran');
        if (modal) modal.style.display = 'none';
    };

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('modalPembayaran');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closePaymentModal();
            });
        }
    });
</script>
