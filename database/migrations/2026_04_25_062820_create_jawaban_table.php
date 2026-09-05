<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade');

            // 42 soal DASS, masing-masing nilai 0-3
            $table->tinyInteger('soal_1')->default(0);
            $table->tinyInteger('soal_2')->default(0);
            $table->tinyInteger('soal_3')->default(0);
            $table->tinyInteger('soal_4')->default(0);
            $table->tinyInteger('soal_5')->default(0);
            $table->tinyInteger('soal_6')->default(0);
            $table->tinyInteger('soal_7')->default(0);
            $table->tinyInteger('soal_8')->default(0);
            $table->tinyInteger('soal_9')->default(0);
            $table->tinyInteger('soal_10')->default(0);
            $table->tinyInteger('soal_11')->default(0);
            $table->tinyInteger('soal_12')->default(0);
            $table->tinyInteger('soal_13')->default(0);
            $table->tinyInteger('soal_14')->default(0);
            $table->tinyInteger('soal_15')->default(0);
            $table->tinyInteger('soal_16')->default(0);
            $table->tinyInteger('soal_17')->default(0);
            $table->tinyInteger('soal_18')->default(0);
            $table->tinyInteger('soal_19')->default(0);
            $table->tinyInteger('soal_20')->default(0);
            $table->tinyInteger('soal_21')->default(0);
            $table->tinyInteger('soal_22')->default(0);
            $table->tinyInteger('soal_23')->default(0);
            $table->tinyInteger('soal_24')->default(0);
            $table->tinyInteger('soal_25')->default(0);
            $table->tinyInteger('soal_26')->default(0);
            $table->tinyInteger('soal_27')->default(0);
            $table->tinyInteger('soal_28')->default(0);
            $table->tinyInteger('soal_29')->default(0);
            $table->tinyInteger('soal_30')->default(0);
            $table->tinyInteger('soal_31')->default(0);
            $table->tinyInteger('soal_32')->default(0);
            $table->tinyInteger('soal_33')->default(0);
            $table->tinyInteger('soal_34')->default(0);
            $table->tinyInteger('soal_35')->default(0);
            $table->tinyInteger('soal_36')->default(0);
            $table->tinyInteger('soal_37')->default(0);
            $table->tinyInteger('soal_38')->default(0);
            $table->tinyInteger('soal_39')->default(0);
            $table->tinyInteger('soal_40')->default(0);
            $table->tinyInteger('soal_41')->default(0);
            $table->tinyInteger('soal_42')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
