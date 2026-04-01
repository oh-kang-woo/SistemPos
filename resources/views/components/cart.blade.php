<style>
/* ========================
   1. CONTAINER UTAMA (Bisa Di-scroll Keseluruhan)
   ======================== */
.cart-container {
    background: #ffffff;
    border-radius: 16px;
    display: flex;
    flex-direction: column;
    width: 380px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);

    /* Batasi tinggi keranjang agar tidak tembus ke bawah layar */
    max-height: calc(100vh - 120px);
    /* Buat KESELURUHAN keranjang bisa di-scroll */
    overflow-y: auto;
}

/* Sembunyikan garis scrollbar agar tetap rapi dan bersih */
.cart-container::-webkit-scrollbar { display: none; }
.cart-container { -ms-overflow-style: none; scrollbar-width: none; }

/* ========================
   2. HEADER & AREA ITEM
   ======================== */
.cart-header {
    display: flex; justify-content: space-between; align-items: center;
    padding: 20px; border-bottom: 1px solid #f0f0f0;
}
.cart-title { font-size: 18px; font-weight: 700; color: #1e293b; margin: 0; }
.cart-badge { background: #eff6ff; color: #1e293b; font-weight: 600; font-size: 13px; padding: 6px 12px; border-radius: 8px; }

/* Area item kita biarkan normal (mengalir ke bawah) */
.cart-items-section {
    padding: 20px; display: flex; flex-direction: column; gap: 12px;
}
.section-label { font-weight: 700; color: #1e293b; font-size: 15px; margin-bottom: 4px; }

.cart-item { background: #eef2f6; border-radius: 12px; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center; }
.item-details { display: flex; flex-direction: column; gap: 4px; }
.item-name { font-weight: 700; color: #1e293b; font-size: 14px; }
.item-price-calc { color: #94a3b8; font-size: 12px; }
.item-price-total { font-weight: 700; color: #1e293b; font-size: 14px; margin-top: 4px; }

.item-actions { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; }
.qty-controls { display: flex; align-items: center; gap: 12px; font-weight: 600; }
.qty-btn { background: none; border: none; font-size: 16px; cursor: pointer; color: #64748b; }
.delete-item-btn { background: none; border: none; color: #ef4444; cursor: pointer; padding: 4px; }

/* ========================
   3. RINGKASAN & PEMBAYARAN
   ======================== */
.cart-summary-section {
    padding: 20px; background: #ffffff;
    border-top: 1px solid #f0f0f0;
    border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;
}
.dashed-bottom { border-bottom: 2px dashed #e2e8f0; padding-bottom: 16px; margin-bottom: 16px; }
.summary-row { display: flex; justify-content: space-between; align-items: center; }
.summary-label { color: #64748b; font-weight: 600; font-size: 14px; }
.summary-value { font-weight: 700; color: #1e293b; font-size: 15px; }

.discount-group label { display: block; margin-bottom: 8px; color: #1e293b; font-weight: 700; }
.discount-inputs { display: flex; gap: 8px; }
.custom-select select { padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; background: white; outline: none; cursor: pointer; }
.discount-input { flex: 1; padding: 10px; border-radius: 8px; border: 1px solid #e2e8f0; outline: none; }

.total-group { display: flex; flex-direction: column; gap: 8px; }
.total-label { color: #64748b; font-size: 14px; font-weight: 600; }
.total-value { font-size: 24px; font-weight: 800; color: #2b3a4a; }

.payment-methods-box { background: #eef2f6; padding: 12px; border-radius: 12px; margin-bottom: 16px; }
.box-label { font-size: 13px; color: #64748b; font-weight: 600; display: block; margin-bottom: 8px; }
.method-buttons { display: flex; gap: 8px; }
.method-btn { flex: 1; padding: 8px; border-radius: 8px; border: 1px solid transparent; background: white; color: #64748b; font-size: 13px; font-weight: 600; cursor: pointer; display: flex; gap: 6px; align-items: center; justify-content: center; }
.method-btn.active { border-color: #2b3a4a; color: #2b3a4a; }

.customer-group { margin-bottom: 20px; }
.customer-group .box-label { color: #1e293b; font-size: 14px; font-weight: 700; }
.customer-input { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; outline: none; }

.cart-actions { display: flex; flex-direction: column; gap: 12px; }
.main-action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.btn-save, .btn-pay, .btn-clear { padding: 14px; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; gap: 8px; transition: 0.2s; }
.btn-save { background: #eff6ff; border: 1px solid #bfdbfe; color: #2563eb; }
.btn-save:hover { background: #dbeafe; }
.btn-pay { background: #2b3a4a; border: none; color: white; }
.btn-pay:hover { background: #1e293b; }
.btn-clear { background: white; border: 1px solid #fca5a5; color: #ef4444; }
.btn-clear:hover { background: #fef2f2; }
</style>

<div class="cart-container">
    <div class="cart-header">
        <h3 class="cart-title">Ringkasan Pembayaran</h3>
        <span class="cart-badge">2 Item</span>
    </div>

    <div class="cart-items-section">
        <div class="section-label">Item Dipilih</div>

        <div class="cart-item">
            <div class="item-details">
                <div class="item-name">Mie Goreng Special</div>
                <div class="item-price-calc">Rp 18.000 x 1</div>
                <div class="item-price-total">Rp 18.000</div>
            </div>
            <div class="item-actions">
                <div class="qty-controls">
                    <button class="qty-btn">-</button>
                    <span class="qty-number">1</span>
                    <button class="qty-btn">+</button>
                </div>
                <button class="delete-item-btn">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>

        <div class="cart-item">
            <div class="item-details">
                <div class="item-name">Ocha 500ml</div>
                <div class="item-price-calc">Rp 8.000 x 2</div>
                <div class="item-price-total">Rp 16.000</div>
            </div>
            <div class="item-actions">
                <div class="qty-controls">
                    <button class="qty-btn">-</button>
                    <span class="qty-number">2</span>
                    <button class="qty-btn">+</button>
                </div>
                <button class="delete-item-btn">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="cart-summary-section">
        <div class="summary-row dashed-bottom">
            <span class="summary-label">Sub total</span>
            <span class="summary-value">Rp 34.000</span>
        </div>

        <div class="discount-group dashed-bottom">
            <label class="summary-label">Diskon</label>
            <div class="discount-inputs">
                <div class="custom-select">
                    <select>
                        <option>%</option>
                        <option>Rp</option>
                    </select>
                </div>
                <input type="number" class="discount-input" value="0">
            </div>
        </div>

        <div class="total-group dashed-bottom">
            <span class="total-label">Total pembayaran</span>
            <span class="total-value">Rp 37.740</span>
        </div>

        <div class="payment-methods-box">
            <label class="box-label">Metode pembayaran:</label>
            <div class="method-buttons">
                <button class="method-btn active"><i class="fas fa-money-bill-wave"></i> Tunai</button>
                <button class="method-btn"><i class="fas fa-qrcode"></i> QRIS</button>
                <button class="method-btn"><i class="fas fa-credit-card"></i> Debit</button>
            </div>
        </div>

        <div class="customer-group">
            <label class="box-label">Nama Pelanggan</label>
            <input type="text" class="customer-input" placeholder="Contoh:arip">
        </div>

        <div class="cart-actions">
            <div class="main-action-grid">
                <button class="btn-save"><i class="fas fa-save"></i> Simpan resi</button>
                <button class="btn-pay">Bayar</button>
            </div>
            <button class="btn-clear"><i class="fas fa-trash-alt"></i> Hapus keranjang</button>
        </div>
    </div>
</div>
