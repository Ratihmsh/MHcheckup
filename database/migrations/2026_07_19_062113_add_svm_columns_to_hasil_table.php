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
        Schema::table('hasil', function (Blueprint $table) {
            $table->enum('svm_depresi', ['Normal', 'Ringan', 'Sedang', 'Parah', 'Sangat Parah'])->nullable()->after('kategori_stres');
            $table->enum('svm_kecemasan', ['Normal', 'Ringan', 'Sedang', 'Parah', 'Sangat Parah'])->nullable()->after('svm_depresi');
            $table->enum('svm_stres', ['Normal', 'Ringan', 'Sedang', 'Parah', 'Sangat Parah'])->nullable()->after('svm_kecemasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil', function (Blueprint $table) {
            $table->dropColumn(['svm_depresi', 'svm_kecemasan', 'svm_stres']);
        });
    }
};
