<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\TesController;

class SvmSyncSeeder extends Seeder
{
    /**
     * Run the database seeds to sync existing data with SVM predictions.
     */
    public function run(): void
    {
        $hasilList = DB::table('hasil')->whereNull('svm_depresi')->get();
        
        $this->command->info("Menemukan " . $hasilList->count() . " data hasil yang membutuhkan sinkronisasi SVM.");
        
        $tesController = new TesController();

        foreach ($hasilList as $hasil) {
            $jawaban = DB::table('jawaban')->where('peserta_id', $hasil->peserta_id)->first();
            
            if (!$jawaban) {
                $this->command->warn("Jawaban untuk Peserta ID {$hasil->peserta_id} tidak ditemukan. Skip.");
                continue;
            }
            
            // Kumpulkan 42 jawaban
            $answers = [];
            for ($i = 1; $i <= 42; $i++) {
                $col = "soal_$i";
                $answers[] = (int) $jawaban->$col;
            }
            
            // Jalankan prediksi
            $predictions = $tesController->predictSvm($answers);
            
            if ($predictions) {
                DB::table('hasil')
                    ->where('id', $hasil->id)
                    ->update([
                        'svm_depresi'   => $predictions['Depresi'] ?? null,
                        'svm_kecemasan' => $predictions['Kecemasan'] ?? null,
                        'svm_stres'     => $predictions['Stres'] ?? null,
                        'updated_at'    => now(),
                    ]);
                $this->command->info("Peserta ID {$hasil->peserta_id} ({$hasil->id}) berhasil disinkronkan. Hasil SVM: D=" . ($predictions['Depresi'] ?? '-') . ", K=" . ($predictions['Kecemasan'] ?? '-') . ", S=" . ($predictions['Stres'] ?? '-'));
            } else {
                $this->command->error("Gagal melakukan prediksi SVM untuk Peserta ID {$hasil->peserta_id}.");
            }
        }
        
        $this->command->info("Proses sinkronisasi selesai.");
    }
}
