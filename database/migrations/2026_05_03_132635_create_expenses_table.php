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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('expense_category_id')->constrained('expense_categories')->onDelete('cascade');
            $table->text('deskripsi')->nullable();
            $table->integer('nominal');
            $table->string('pengguna')->default('owner'); //Bisa diganti foreignId ke tabel users jika ingin mengaitkan dengan pengguna tertentu
            $table->string('lampiran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
