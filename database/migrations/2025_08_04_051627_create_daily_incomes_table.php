<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     * Ini akan membuat tabel 'daily_incomes'.
     */
    public function up(): void
    {
        Schema::create('daily_incomes', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel users
            $table->date('date'); // Kolom tanggal
            $table->unsignedInteger('amount'); // Jumlah pendapatan tunai (tidak negatif)
            $table->unsignedInteger('transfer_income')->default(0); // Jumlah pendapatan transfer (default 0)
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Balikkan migrasi.
     * Ini akan menghapus tabel 'daily_incomes' jika migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_incomes');
    }
};
