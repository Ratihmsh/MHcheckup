<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('berita')->insert([
            [
                'judul' => 'Seminar Edukasi Kesehatan Mental di Sidoarjo',
                'gambar' => 'uploads/berita/kegiatan_seminar.jpg',
                'konten' => "Biro Psikologi Ariva Consulta sukses menyelenggarakan seminar edukasi kesehatan mental untuk remaja dan orang tua di Sidoarjo. \n\nSeminar ini membahas pentingnya deteksi dini kecemasan dan stres pada anak usia remaja agar dapat ditangani secara tepat oleh keluarga maupun tenaga profesional psikolog klinis. Peserta tampak sangat antusias bertanya mengenai cara membedakan stres belajar biasa dengan stres klinis.",
                'tanggal_publish' => '2026-07-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Layanan Konsultasi Pribadi yang Aman & Rahasia',
                'gambar' => 'uploads/berita/konsultasi_pribadi.jpg',
                'konten' => "Ariva Consulta menyediakan layanan konseling pribadi secara tatap muka (offline) maupun online. \n\nKonseling dilakukan langsung oleh psikolog klinis berlisensi dengan jaminan kerahasiaan penuh. Layanan ini dirancang khusus untuk membantu Anda mengurai benang kusut masalah emosional seperti kecemasan berlebih, depresi ringan, trauma masa lalu, hingga tekanan stres dalam karir dan hubungan keluarga.",
                'tanggal_publish' => '2026-07-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => '5 Tips Sederhana Mengatasi Stres & Kecemasan Harian',
                'gambar' => 'uploads/berita/tips_meditasi.jpg',
                'konten' => "Mengalami ketegangan akibat beban aktivitas sehari-hari? \n\nBerikut 5 tips sederhana dari psikolog Ariva Consulta yang bisa Anda coba:\n1. Luangkan 10-15 menit untuk meditasi pernapasan teratur di luar ruangan.\n2. Lakukan teknik grounding 5-4-3-2-1 untuk menarik kesadaran Anda ke momen saat ini.\n3. Batasi asupan kafein dan sosial media saat pikiran mulai terasa cemas.\n4. Tulis jurnal perasaan (journaling) sebelum tidur.\n5. Berbagilah cerita dengan orang terdekat yang Anda percayai.",
                'tanggal_publish' => '2026-07-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
