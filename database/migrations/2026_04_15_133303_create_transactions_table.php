<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id_transaksi');

            // --- MULTI-TENANT KEY ---
            // Mengunci seluruh nota penjualan agar terkelompok per toko
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID kasir yang bertugas
            $table->string('nomor_invoice')->unique();
            $table->string('nama_pelanggan')->default('Tanpa Nama'); // <-- TAMBAHAN BARU
            $table->integer('total_harga');
            $table->integer('bayar');
            $table->integer('kembali');
            $table->string('metode_pembayaran')->default('Tunai'); // <-- TAMBAHAN BARU
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
