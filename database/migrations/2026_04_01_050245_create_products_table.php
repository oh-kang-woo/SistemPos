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
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_produk');
            $table->foreignId('kategori_id')->constrained('categories', 'id_kategori')->onDelete('cascade');
            $table->string('kode_produk')->unique();
            $table->string('nama_produk');
            $table->string('satuan')->default('pcs');
            $table->integer('harga_beli');
            $table->integer('harga_jual');
            $table->integer('jumlah_stok');
            $table->integer('min_stok')->default(10);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('gambar_produk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
