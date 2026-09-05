<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');

            // Skor mentah per skala (jumlah nilai jawaban soal terkait)
            $table->integer('skor_depresi')->default(0);
            $table->integer('skor_kecemasan')->default(0);
            $table->integer('skor_stres')->default(0);

            // Kategori hasil per skala
            $table->enum('kategori_depresi', ['Normal', 'Ringan', 'Sedang', 'Tinggi', 'Sangat Tinggi'])->default('Normal');
            $table->enum('kategori_kecemasan', ['Normal', 'Ringan', 'Sedang', 'Tinggi', 'Sangat Tinggi'])->default('Normal');
            $table->enum('kategori_stres', ['Normal', 'Ringan', 'Sedang', 'Tinggi', 'Sangat Tinggi'])->default('Normal');

            // Teks laporan — diisi AI, bisa diedit admin sebelum cetak
            $table->text('dinamika_psikologis')->nullable();
            $table->text('saran_rekomendasi')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil');
    }
};
