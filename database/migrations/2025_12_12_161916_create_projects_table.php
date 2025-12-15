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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('id_proyek');
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_developer')->constrained('users')->onDelete('cascade');
            $table->string('nama_proyek');
            $table->text('deskripsi');
            $table->decimal('harga_estimasi', 15, 2);
            $table->enum('status', ['pending', 'berjalan', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
