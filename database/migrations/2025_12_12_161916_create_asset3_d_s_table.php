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
        Schema::create('assets_3d', function (Blueprint $table) {
            $table->id('id_aset');
            $table->foreignId('id_developer')->constrained('users')->onDelete('cascade');
            $table->string('nama_aset');
            $table->text('deskripsi');
            $table->decimal('harga', 15, 2);
            $table->string('file_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_3d');
    }
};
