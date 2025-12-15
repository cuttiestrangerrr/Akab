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
        Schema::create('price_calculations', function (Blueprint $table) {
            $table->id('id_kalkulator');
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_developer')->constrained('users')->onDelete('cascade');
            $table->text('fitur_dipilih');
            $table->decimal('estimasi_harga', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_calculations');
    }
};
