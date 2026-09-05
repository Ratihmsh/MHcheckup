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
        Schema::create('saran_rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['depression', 'anxiety', 'stress']);
            $table->enum('level', ['normal', 'ringan', 'sedang', 'tinggi', 'sangat tinggi']);
            $table->text('saran_rekomendasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saran_rekomendasi');
    }
};
