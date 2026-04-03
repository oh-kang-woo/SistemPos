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

    {{-- Tombol Bawah (Checkout dll) --}}
    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
            <button style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; font-weight: bold; color: #334155;">Tunai</button>
            <button style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; font-weight: bold; color: #334155;">QRIS</button>
            <button style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; font-weight: bold; color: #334155;">Debit</button>
        </div>

        <div style="margin-bottom: 15px;">
            <p style="font-size: 14px; font-weight: bold; margin-bottom: 8px;">Nama Pelanggan</p>
            <input type="text" placeholder="Contoh: arip" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="display: flex; gap: 10px; margin-bottom: 10px;">
            <button style="flex: 1; padding: 12px; border: 1px solid #bfdbfe; background: #eff6ff; color: #2563eb; border-radius: 6px; font-weight: bold;">Simpan resi</button>
            <button style="flex: 1; padding: 12px; border: none; background: #1e293b; color: white; border-radius: 6px; font-weight: bold;">Bayar</button>
        </div>
        <button style="width: 100%; padding: 12px; border: 1px solid #fecaca; background: white; color: #ef4444; border-radius: 6px; font-weight: bold;">Hapus keranjang</button>
    </div>
</div>
