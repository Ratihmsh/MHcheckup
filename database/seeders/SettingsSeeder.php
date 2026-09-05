<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'nama_biro' => 'Biro Psikologi Ariva Consulta',
            'alamat' => 'Sidoarjo, Jawa Timur',
            'no_telp' => '08123456789',
            'email' => 'mhcu.arivaconsulta@gmail.com',
            'instagram' => 'arivaconsulta',
            
            // Konten Landing Page default
            'headline' => 'Ukur Kesehatan Mental Anda Secara Akurat',
            'sub_headline' => 'Metode Skrining DASS-42 (Depression Anxiety Stress Scales)',
            'deskripsi' => 'Kami membantu Anda mengenali kondisi depresi, kecemasan, dan tingkat stres secara ilmiah dan rahasia. Dapatkan analisis mendalam dan saran rekomendasi langsung dari psikolog klinis profesional.',
            
            // Aset default (relatif terhadap public/ atau public/storage/)
            'logo' => null,
            'ttd_psikolog' => null,
            'stempel' => null,
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
