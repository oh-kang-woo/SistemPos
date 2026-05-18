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
        // 1. BUAT TABEL BISNIS/TOKO TERLEBIH DAHULU
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 2. BUAT TABEL KATEGORI (Diposisikan di sini agar siap dipakai oleh tabel produk nanti)
        Schema::create('categories', function (Blueprint $table) {
            $table->id('id_kategori'); // Menggunakan id_kategori sesuai kebutuhan tokomu
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->string('nama_kategori');
            $table->text('deskripsi')->nullable();
            $table->string('gambar_kategori')->nullable();
            $table->timestamps();
        });

        // 3. BUAT TABEL USERS
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->nullable()->constrained('businesses')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('role')->default('karyawan');
            $table->string('phone_number')->nullable();
            $table->string('profile_photo')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 4. TABEL BAWAAN LARAVEL
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('businesses');
    }
};
