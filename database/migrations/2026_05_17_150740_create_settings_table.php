<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // Profil Toko
            $table->string('nama_toko')->default('SwiftBill POS');
            $table->text('alamat_lengkap')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('nomor_whatsapp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('logo_toko')->nullable();

            // Struk & Pajak
            $table->string('format_nomor_transaksi')->default('TRX-YYYY-MM-DD-++++');
            $table->string('reset_nomor_urut')->default('setiap bulan');
            $table->string('ukuran_kertas')->default('Thermal 88mm');
            $table->integer('margin')->default(5);
            $table->boolean('cetak_otomatis')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
