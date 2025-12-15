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
            $table->foreignId('id_proyek')->constrained('projects', 'id_proyek')->onDelete('cascade');
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_developer')->constrained('users')->onDelete('cascade');
            $table->decimal('total_bayar', 15, 2);
            $table->enum('status_pembayaran', ['pending', 'lunas', 'batal'])->default('pending');
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
