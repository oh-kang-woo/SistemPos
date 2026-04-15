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
            $table->string('no_transaksi')->unique();
            $table->string('nama_kasir');
            $table->integer('total_item');
            $table->integer('total_pembayaran');
            $table->integer('uang_diterima');
            $table->integer('uang_kembali');
            $table->string('metode_pembayaran');
            $table->string('status')->default('lunas');
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
