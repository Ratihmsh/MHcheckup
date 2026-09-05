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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_biro');
            $table->text('alamat')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            
            // Konten Landing Page
            $table->string('headline')->nullable();
            $table->string('sub_headline')->nullable();
            $table->text('deskripsi')->nullable();
            
            // Aset Gambar/Berkas
            $table->string('logo')->nullable();
            $table->string('ttd_psikolog')->nullable();
            $table->string('stempel')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
