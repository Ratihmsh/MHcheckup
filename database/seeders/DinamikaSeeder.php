<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DinamikaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('dinamika_psikologi')->insert([
            [
                'type' => 'depression',
                'level' => 'normal',
                'dinamika_psikologis' => 'Saudara menunjukkan bahwa Saudara tidak mengindikasikan adanya gejala depresi yang bermakna secara klinis. Kondisi afektif Saudara berada dalam rentang adaptif, serta tidak ditemukan gangguan signifikan dalam fungsi sehari-hari.',
            ],
            [
                'type' => 'depression',
                'level' => 'ringan',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya indikasi gejala depresi dalam intensitas ringan, seperti munculnya perasaan sedih atau penurunan minat, namun gejala tersebut masih dalam batas yang relatif dapat dikendalikan dan belum mengganggu fungsi psikologis secara signifikan.',
            ],
            [
                'type' => 'depression',
                'level' => 'sedang',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala depresi dengan intensitas yang cukup nyata, ditandai dengan meningkatnya frekuensi perasaan sedih, penurunan motivasi, serta berkurangnya kemampuan untuk menikmati aktivitas. Kondisi ini mulai memberikan dampak terhadap fungsi sosial maupun aktivitas sehari-hari.',
            ],
            [
                'type' => 'depression',
                'level' => 'tinggi',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala depresi dengan intensitas tinggi, seperti perasaan putus asa, kehilangan minat yang signifikan, serta penurunan energi yang berdampak nyata pada terganggunya fungsi sosial, akademik, maupun pekerjaan.',
            ],
            [
                'type' => 'depression',
                'level' => 'sangat tinggi',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala depresi dengan intensitas yang sangat tinggi dan menetap, seperti perasaan tidak berharga, keputusasaan mendalam, serta kemungkinan munculnya ideasi negatif yang serius. Kondisi ini memerlukan perhatian khusus dan penanganan lebih lanjut secara profesional.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'normal',
                'dinamika_psikologis' => 'Saudara menunjukkan bahwa Saudara tidak mengindikasikan adanya gejala kecemasan yang bermakna secara klinis. Respons emosional Saudara terhadap situasi yang menekan masih berada dalam batas adaptif dan tidak mengganggu fungsi sehari-hari.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'ringan',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya indikasi gejala kecemasan dalam intensitas ringan, seperti perasaan khawatir, tegang, atau gelisah, namun masih dalam batas yang dapat dikendalikan serta belum memberikan dampak signifikan terhadap fungsi psikologis.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'sedang',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala kecemasan yang cukup nyata, seperti meningkatnya frekuensi kekhawatiran, ketegangan, serta kemungkinan munculnya gejala fisik (misalnya jantung berdebar atau sulit rileks). Kondisi ini mulai memengaruhi fungsi sosial maupun aktivitas sehari-hari.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'tinggi',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala kecemasan dengan intensitas tinggi, ditandai dengan perasaan cemas yang menetap, sulit dikendalikan, serta disertai gejala fisik yang lebih jelas. Kondisi ini berdampak signifikan terhadap fungsi sosial, akademik, maupun pekerjaan.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'sangat tinggi',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala kecemasan dengan intensitas yang sangat tinggi dan persisten, seperti perasaan takut berlebihan, ketegangan ekstrem, serta gangguan fisik yang menonjol. Kondisi ini sangat mengganggu fungsi sehari-hari dan memerlukan perhatian serta penanganan profesional lebih lanjut.',
            ],
            [
                'type' => 'stress',
                'level' => 'normal',
                'dinamika_psikologis' => 'Saudara menunjukkan bahwa Saudara tidak mengindikasikan adanya gejala stres yang bermakna secara klinis. Saudara mampu mengelola tekanan dan tuntutan lingkungan secara adaptif tanpa adanya gangguan signifikan dalam fungsi sehari-hari.',
            ],
            [
                'type' => 'stress',
                'level' => 'ringan',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya indikasi gejala stres dalam intensitas ringan, seperti mudah merasa tegang, kurang sabar, atau sensitif terhadap tekanan, namun masih dalam batas yang dapat dikendalikan dan belum berdampak signifikan terhadap fungsi psikologis.',
            ],
            [
                'type' => 'stress',
                'level' => 'sedang',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala stres dengan intensitas yang cukup nyata, seperti meningkatnya ketegangan, iritabilitas, kesulitan untuk rileks, serta kecenderungan mudah merasa terbebani. Kondisi ini mulai memberikan dampak terhadap fungsi sosial maupun aktivitas sehari-hari.',
            ],
            [
                'type' => 'stress',
                'level' => 'tinggi',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala stres dengan intensitas tinggi, ditandai dengan ketegangan yang menetap, kesulitan mengendalikan emosi, serta rendahnya toleransi terhadap frustrasi. Kondisi ini berdampak signifikan terhadap fungsi sosial, akademik, maupun pekerjaan.',
            ],
            [
                'type' => 'stress',
                'level' => 'sangat tinggi',
                'dinamika_psikologis' => 'Saudara menunjukkan adanya gejala stres dengan intensitas yang sangat tinggi dan persisten, seperti ketegangan ekstrem, reaktivitas emosional yang tinggi, serta kesulitan yang serius dalam mengelola tekanan. Kondisi ini sangat mengganggu fungsi sehari-hari dan memerlukan perhatian serta penanganan profesional lebih lanjut.',
            ]
        ]);
    }
}
