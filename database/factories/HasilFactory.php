<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class HasilFactory extends Factory
{
    public function definition(): array
    {
        // 1. Buat skor acak untuk tiga skala
        $skorDepresi   = $this->faker->numberBetween(0, 42);
        $skorKecemasan = $this->faker->numberBetween(0, 42);
        $skorStres     = $this->faker->numberBetween(0, 42);

        // 2. Konversi skor ke level (sama dengan di controller Anda)
        $kategoriDepresi   = $this->getKategori($skorDepresi);
        $kategoriKecemasan = $this->getKategori($skorKecemasan);
        $kategoriStres     = $this->getKategori($skorStres);

        // 3. Ambil teks dinamika dari tabel `dinamika_psikologi`
        // $dinamikaDepresi = $this->getDinamika('depression', $kategoriDepresi);
        // $dinamikaKecemasan = $this->getDinamika('anxiety', $kategoriKecemasan);
        // $dinamikaStres   = $this->getDinamika('stress', $kategoriStres);

        // // 4. Ambil teks saran dari tabel `saran_rekomendasi`
        // $saranDepresi   = $this->getSaran('depression', $kategoriDepresi);
        // $saranKecemasan = $this->getSaran('anxiety', $kategoriKecemasan);
        // $saranStres     = $this->getSaran('stress', $kategoriStres);

        // // 5. Buat JSON yang rapi (tanpa pretty print agar tidak ada newline, atau dengan pretty print)
        // $dinamikaJson = json_encode([
        //     'depression' => $dinamikaDepresi,
        //     'anxiety'    => $dinamikaKecemasan,
        //     'stress'     => $dinamikaStres,
        // ], JSON_UNESCAPED_UNICODE); // tanpa JSON_PRETTY_PRINT agar tidak ada \n di dalam string

        // $saranJson = json_encode([
        //     'depression' => $saranDepresi,
        //     'anxiety'    => $saranKecemasan,
        //     'stress'     => $saranStres,
        // ], JSON_UNESCAPED_UNICODE);

        return [
            'skor_depresi'         => $skorDepresi,
            'skor_kecemasan'       => $skorKecemasan,
            'skor_stres'           => $skorStres,
            'kategori_depresi'     => $kategoriDepresi,
            'kategori_kecemasan'   => $kategoriKecemasan,
            'kategori_stres'       => $kategoriStres,
            // 'dinamika_psikologis'  => $dinamikaJson,
            // 'saran_rekomendasi'    => $saranJson,
            'created_at'           => now(),
            'updated_at'           => now(),
        ];
    }

    /**
     * Konversi skor DASS-42 ke level/kategori.
     * Rentang yang umum dipakai:
     * Depresi   : 0-9 Normal, 10-13 Ringan, 14-20 Sedang, 21-27 Tinggi, 28+ Sangat Tinggi
     * Cemas/Stres juga sama.
     */
    private function getKategori($skor): string
    {
        if ($skor <= 9) return 'Normal';
        if ($skor <= 13) return 'Ringan';
        if ($skor <= 20) return 'Sedang';
        if ($skor <= 27) return 'Tinggi';
        return 'Sangat Tinggi';
    }

    /**
     * Ambil dinamika psikologis dari tabel `dinamika_psikologi`.
     * Level di database menggunakan huruf kecil (normal, ringan, sedang, tinggi, sangat tinggi).
     * Kita konversi dulu.
     */
    private function getDinamika($type, $level): string
    {
        $levelMap = [
            'Normal'        => 'normal',
            'Ringan'        => 'ringan',
            'Sedang'        => 'sedang',
            'Tinggi'        => 'tinggi',
            'Sangat Tinggi' => 'sangat tinggi',
        ];
        $dbLevel = $levelMap[$level] ?? strtolower($level);

        $record = DB::table('dinamika_psikologi')
            ->where('type', $type)
            ->where('level', $dbLevel)
            ->first();

        if (!$record) {
            // Fallback jika data tidak ditemukan (misal seeder belum dijalankan)
            return "Dinamika untuk $type level $dbLevel belum tersedia.";
        }

        return $record->dinamika_psikologis;
    }

    /**
     * Ambil saran rekomendasi dari tabel `saran_rekomendasi`.
     */
    private function getSaran($type, $level): string
    {
        $levelMap = [
            'Normal'        => 'normal',
            'Ringan'        => 'ringan',
            'Sedang'        => 'sedang',
            'Tinggi'        => 'tinggi',
            'Sangat Tinggi' => 'sangat tinggi',
        ];
        $dbLevel = $levelMap[$level] ?? strtolower($level);

        $record = DB::table('saran_rekomendasi')
            ->where('type', $type)
            ->where('level', $dbLevel)
            ->first();

        if (!$record) {
            return "Saran untuk $type level $dbLevel belum tersedia.";
        }

        return $record->saran_rekomendasi;
    }
}
