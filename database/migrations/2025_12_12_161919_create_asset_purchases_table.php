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
        Schema::create('asset_purchases', function (Blueprint $table) {
            $table->id('id_pembelian');
            $table->foreignId('id_aset')->constrained('assets_3d', 'id_aset')->onDelete('cascade');
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->decimal('total_bayar', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_purchases');
    }
};
