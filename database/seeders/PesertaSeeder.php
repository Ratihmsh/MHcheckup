<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data dummy lama jika ada untuk mencegah duplikasi
        DB::table('peserta')->whereIn('nama', ['Budi Santoso', 'Siti Aminah', 'Rian Hidayat'])->delete();

        // 1. Budi Santoso
        $budiId = DB::table('peserta')->insertGetId([
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1998-05-12',
            'usia' => '28',
            'pendidikan' => 'S1 Teknik Informatika',
            'pekerjaan' => 'Software Engineer / Karyawan Swasta',
            'status_perkawinan' => 'Belum Menikah',
            'no_telp' => '081234567890',
            'alamat' => 'Jl. Ahmad Yani No. 120, Sidoarjo',
            'tujuan_konsultasi' => 'Mengatasi stres kerja',
            'permasalahan' => 'Beban kerja menumpuk, tenggat waktu proyek yang sangat ketat, serta kurangnya apresiasi dari atasan membuat saya sangat lelah secara fisik dan pikiran.',
            'yang_dirasakan' => 'Sering sulit tidur, jantung berdebar kencang saat mendekati deadline, dan merasa cemas berlebihan akan kegagalan pekerjaan.',
            'harapan' => 'Ingin belajar mengelola stres kerja dan lebih tenang dalam menghadapi tekanan atasan.',
            'tanggal_pemeriksaan' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $budiJawaban = [];
        for ($i = 1; $i <= 42; $i++) {
            $budiJawaban["soal_$i"] = 1; // Default
        }
        // Atur agar stres parah, depresi ringan, kecemasan sedang
        // Soal Stres: 1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39
        foreach ([1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39] as $num) {
            $budiJawaban["soal_$num"] = 2; // total skor stres = 28 (Parah)
        }
        // Soal Depresi: 3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42
        foreach ([3, 5, 10, 13, 16] as $num) {
            $budiJawaban["soal_$num"] = 1; // total skor depresi = 12 (Ringan)
        }
        // Soal Kecemasan: 2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41
        foreach ([2, 4, 7, 9, 15, 19, 20, 23] as $num) {
            $budiJawaban["soal_$num"] = 2; // total skor kecemasan = 18 (Sedang)
        }

        $budiJawaban['peserta_id'] = $budiId;
        $budiJawaban['created_at'] = now();
        $budiJawaban['updated_at'] = now();
        DB::table('jawaban')->insert($budiJawaban);

        DB::table('hasil')->insert([
            'peserta_id' => $budiId,
            'skor_depresi' => 12,
            'skor_kecemasan' => 18,
            'skor_stres' => 28,
            'kategori_depresi' => 'Ringan',
            'kategori_kecemasan' => 'Sedang',
            'kategori_stres' => 'Parah',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Siti Aminah
        $sitiId = DB::table('peserta')->insertGetId([
            'nama' => 'Siti Aminah',
            'jenis_kelamin' => 'Perempuan',
            'tanggal_lahir' => '2005-09-21',
            'usia' => '21',
            'pendidikan' => 'D3 Akuntansi (Semester Akhir)',
            'pekerjaan' => 'Mahasiswa',
            'status_perkawinan' => 'Belum Menikah',
            'no_telp' => '087766554433',
            'alamat' => 'Perum Griya Indah Blok C-5, Sedati, Sidoarjo',
            'tujuan_konsultasi' => 'Mengatasi kecemasan skripsi',
            'permasalahan' => 'Cemas menghadapi sidang skripsi bulan depan, takut gagal lulus tepat waktu, dan belum mendapat kepastian magang/pekerjaan setelah lulus.',
            'yang_dirasakan' => 'Panik mendadak, tangan berkeringat dingin, sulit berkonsentrasi saat belajar, dan sering merasa sedih jika memikirkan masa depan.',
            'harapan' => 'Bisa mengendalikan kepanikan dan lebih percaya diri menghadapi dosen penguji skripsi.',
            'tanggal_pemeriksaan' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sitiJawaban = [];
        for ($i = 1; $i <= 42; $i++) {
            $sitiJawaban["soal_$i"] = 1;
        }
        // Kecemasan Sangat Parah (skor >= 20)
        foreach ([2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41] as $num) {
            $sitiJawaban["soal_$num"] = 3; // total skor kecemasan = 42 (Sangat Parah)
        }
        // Depresi Sedang (skor 14-20)
        foreach ([3, 5, 10, 13, 16, 17, 21, 24] as $num) {
            $sitiJawaban["soal_$num"] = 2; // total skor depresi = 18 (Sedang)
        }
        // Stres Sedang (skor 19-25)
        foreach ([1, 6, 8, 11, 12, 14, 18, 22, 27, 29] as $num) {
            $sitiJawaban["soal_$num"] = 2; // total skor stres = 21 (Sedang)
        }

        $sitiJawaban['peserta_id'] = $sitiId;
        $sitiJawaban['created_at'] = now();
        $sitiJawaban['updated_at'] = now();
        DB::table('jawaban')->insert($sitiJawaban);

        DB::table('hasil')->insert([
            'peserta_id' => $sitiId,
            'skor_depresi' => 18,
            'skor_kecemasan' => 42,
            'skor_stres' => 21,
            'kategori_depresi' => 'Sedang',
            'kategori_kecemasan' => 'Sangat Parah',
            'kategori_stres' => 'Sedang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Rian Hidayat
        $rianId = DB::table('peserta')->insertGetId([
            'nama' => 'Rian Hidayat',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1991-11-03',
            'usia' => '35',
            'pendidikan' => 'SMA / Sederajat',
            'pekerjaan' => 'Wirausaha',
            'status_perkawinan' => 'Menikah',
            'no_telp' => '085533221100',
            'alamat' => 'Perum Sedati Permai Blok F No. 8, Sidoarjo',
            'tujuan_konsultasi' => 'Mengatasi depresi akibat bisnis bangkrut',
            'permasalahan' => 'Bisnis kuliner yang baru dirintis mengalami kerugian besar dan terpaksa gulung tikar. Saya merasa bersalah kepada keluarga karena kehilangan tabungan hidup kami.',
            'yang_dirasakan' => 'Kehilangan minat pada hobi, merasa tidak berguna, putus asa tentang masa depan finansial, serta sering sedih dan menarik diri dari interaksi sosial.',
            'harapan' => 'Ingin memulihkan motivasi hidup dan keluar dari rasa bersalah yang berkepanjangan terhadap istri dan anak.',
            'tanggal_pemeriksaan' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $rianJawaban = [];
        for ($i = 1; $i <= 42; $i++) {
            $rianJawaban["soal_$i"] = 0;
        }
        // Depresi Sangat Parah (skor >= 28)
        foreach ([3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42] as $num) {
            $rianJawaban["soal_$num"] = 3; // total skor depresi = 42 (Sangat Parah)
        }
        // Stres Ringan (skor 15-18)
        foreach ([1, 6, 8, 11, 12, 14, 18, 22] as $num) {
            $rianJawaban["soal_$num"] = 2; // total skor stres = 16 (Ringan)
        }
        // Kecemasan Ringan (skor 8-9)
        foreach ([2, 4, 7, 9] as $num) {
            $rianJawaban["soal_$num"] = 2; // total skor kecemasan = 8 (Ringan)
        }

        $rianJawaban['peserta_id'] = $rianId;
        $rianJawaban['created_at'] = now();
        $rianJawaban['updated_at'] = now();
        DB::table('jawaban')->insert($rianJawaban);

        DB::table('hasil')->insert([
            'peserta_id' => $rianId,
            'skor_depresi' => 42,
            'skor_kecemasan' => 8,
            'skor_stres' => 16,
            'kategori_depresi' => 'Sangat Parah',
            'kategori_kecemasan' => 'Ringan',
            'kategori_stres' => 'Ringan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
