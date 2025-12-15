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
        Schema::create('community_likes', function (Blueprint $table) {
            $table->id('id_like');
            $table->foreignId('id_postingan')->constrained('community_posts', 'id_postingan')->onDelete('cascade');
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_likes');
    }
};
