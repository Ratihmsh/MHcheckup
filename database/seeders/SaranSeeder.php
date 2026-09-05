<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaranSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('saran_rekomendasi')->insert([
            [
                'type' => 'depression',
                'level' => 'normal',
                'saran_rekomendasi' => 'Saudara disarankan untuk mempertahankan kondisi psikologis yang adaptif melalui penerapan pola hidup sehat yang konsisten, termasuk menjaga kualitas tidur, pola makan seimbang, serta aktivitas fisik yang teratur. Selain itu, Saudara diharapkan tetap mengembangkan strategi coping adaptif, seperti kemampuan regulasi emosi, problem solving, serta menjaga keseimbangan antara tuntutan aktivitas dan waktu istirahat. Upaya preventif juga dapat dilakukan dengan mempertahankan relasi sosial yang suportif serta melakukan aktivitas yang memberikan makna dan kepuasan pribadi.',
            ],
            [
                'type' => 'depression',
                'level' => 'ringan',
                'saran_rekomendasi' => 'Saudara disarankan untuk mulai meningkatkan kesadaran terhadap dinamika emosi yang dialami, khususnya terkait munculnya perasaan sedih atau penurunan minat. Intervensi preventif dapat dilakukan melalui penguatan strategi coping adaptif, seperti penjadwalan aktivitas harian (behavioral activation), keterlibatan dalam aktivitas yang menyenangkan atau bermakna, serta menjaga interaksi sosial yang positif. Saudara juga disarankan untuk mulai melakukan refleksi diri secara terarah guna mengidentifikasi faktor pemicu, serta melakukan pemantauan berkala terhadap kondisi emosional untuk mencegah eskalasi gejala.',
            ],
            [
                'type' => 'depression',
                'level' => 'sedang',
                'saran_rekomendasi' => 'Saudara disarankan untuk melakukan pengelolaan emosi secara lebih terstruktur dan terarah, antara lain melalui identifikasi dan modifikasi pola pikir negatif, peningkatan keterampilan regulasi emosi, serta penataan aktivitas harian yang lebih adaptif. Keterlibatan dalam aktivitas yang bersifat produktif dan bermakna perlu ditingkatkan untuk mengurangi kecenderungan menarik diri. Selain itu, Saudara disarankan untuk mempertimbangkan konsultasi dengan tenaga profesional (psikolog) guna memperoleh pendampingan psikologis, seperti psikoedukasi dan intervensi berbasis kognitif-perilaku. Dukungan sosial dari lingkungan terdekat juga perlu dioptimalkan.',
            ],
            [
                'type' => 'depression',
                'level' => 'tinggi',
                'saran_rekomendasi' => 'Saudara sangat disarankan untuk segera mendapatkan bantuan profesional dari psikolog atau tenaga kesehatan mental guna memperoleh penanganan yang komprehensif dan terstruktur. Intervensi yang diberikan dapat mencakup asesmen lanjutan, psikoedukasi, serta pendekatan intervensi yang sesuai dengan kebutuhan Saudara. Selain itu, penting bagi Saudara untuk memperoleh dukungan emosional yang konsisten dari keluarga atau lingkungan terdekat guna membantu stabilisasi kondisi psikologis. Pemantauan terhadap risiko penurunan fungsi sehari-hari perlu dilakukan secara berkala.',
            ],
            [
                'type' => 'depression',
                'level' => 'sangat tinggi',
                'saran_rekomendasi' => 'Saudara sangat memerlukan penanganan profesional secara intensif dan berkelanjutan, baik melalui layanan psikolog maupun psikiater. Diperlukan asesmen lanjutan yang lebih mendalam untuk memahami kondisi psikologis secara komprehensif, termasuk kemungkinan adanya risiko yang lebih serius. Intervensi yang diberikan perlu bersifat terstruktur, intensif, dan berkelanjutan. Selain itu, keterlibatan aktif dari keluarga atau sistem pendukung menjadi sangat penting dalam memberikan dukungan emosional, pengawasan, serta membantu memastikan keberlangsungan proses penanganan.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'normal',
                'saran_rekomendasi' => 'Saudara disarankan untuk mempertahankan kemampuan regulasi emosi yang adaptif dalam menghadapi situasi yang berpotensi menimbulkan kecemasan. Upaya preventif dapat dilakukan melalui penerapan gaya hidup sehat, termasuk menjaga kualitas tidur, aktivitas fisik yang teratur, serta keseimbangan antara tuntutan dan waktu istirahat. Selain itu, Saudara diharapkan terus mengembangkan keterampilan coping adaptif, seperti berpikir rasional, problem solving, serta mempertahankan relasi sosial yang suportif sebagai faktor protektif.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'ringan',
                'saran_rekomendasi' => 'Saudara disarankan untuk mulai meningkatkan kesadaran terhadap munculnya gejala kecemasan, seperti kekhawatiran atau ketegangan ringan. Intervensi preventif dapat dilakukan melalui penerapan teknik relaksasi sederhana (misalnya pernapasan dalam), pengelolaan pikiran yang lebih adaptif, serta pembatasan terhadap stimulus yang memicu kecemasan berlebih. Saudara juga dianjurkan untuk menjaga keseimbangan aktivitas serta memanfaatkan dukungan sosial sebagai sarana regulasi emosi dan berbagi pengalaman.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'sedang',
                'saran_rekomendasi' => 'Saudara disarankan untuk melakukan pengelolaan kecemasan secara lebih terstruktur, termasuk mengidentifikasi sumber kecemasan, mengevaluasi pola pikir yang tidak adaptif, serta mengembangkan strategi coping yang lebih efektif. Latihan teknik relaksasi yang lebih sistematis (misalnya deep breathing atau mindfulness) perlu dilakukan secara konsisten. Selain itu, Saudara dianjurkan untuk mempertimbangkan konsultasi dengan tenaga profesional (psikolog) guna memperoleh psikoedukasi serta pendampingan dalam mengelola kecemasan secara lebih optimal.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'tinggi',
                'saran_rekomendasi' => 'Saudara sangat disarankan untuk segera mendapatkan bantuan profesional dari psikolog atau tenaga kesehatan mental guna menangani kecemasan dengan intensitas tinggi yang telah mengganggu fungsi sehari-hari. Intervensi dapat mencakup asesmen lanjutan, pelatihan regulasi emosi, serta pendekatan intervensi berbasis psikologis yang sesuai. Dukungan dari lingkungan terdekat perlu dioptimalkan untuk membantu mengurangi beban psikologis dan memberikan rasa aman.',
            ],
            [
                'type' => 'anxiety',
                'level' => 'sangat tinggi',
                'saran_rekomendasi' => 'Saudara memerlukan penanganan profesional secara intensif dan berkelanjutan, mengingat kecemasan yang dialami bersifat sangat tinggi dan berpotensi mengganggu fungsi psikologis secara signifikan. Diperlukan asesmen komprehensif untuk memahami dinamika kecemasan secara menyeluruh, serta intervensi yang terstruktur dan berkelanjutan. Kolaborasi dengan tenaga medis (psikiater) dapat dipertimbangkan apabila diperlukan. Selain itu, keterlibatan aktif dari sistem pendukung menjadi sangat penting dalam memberikan stabilisasi emosional dan memastikan keberlangsungan proses penanganan.',
            ],
            [
                'type' => 'stress',
                'level' => 'normal',
                'saran_rekomendasi' => 'Saudara disarankan untuk mempertahankan kemampuan adaptasi terhadap tekanan melalui penerapan gaya hidup sehat dan seimbang, termasuk menjaga kualitas tidur, pola makan, serta aktivitas fisik yang teratur. Selain itu, penting bagi Saudara untuk terus mengembangkan keterampilan manajemen stres, seperti pengaturan waktu yang efektif, kemampuan problem solving, serta teknik relaksasi sederhana. Pemeliharaan relasi sosial yang suportif dan keterlibatan dalam aktivitas yang memberikan rasa makna juga menjadi faktor protektif yang perlu dipertahankan.',
            ],
            [
                'type' => 'stress',
                'level' => 'ringan',
                'saran_rekomendasi' => 'Saudara disarankan untuk mulai meningkatkan kesadaran terhadap sumber-sumber stres yang dialami serta respons yang muncul. Upaya preventif dapat dilakukan melalui pengelolaan aktivitas harian secara lebih terstruktur, penerapan teknik relaksasi (misalnya pernapasan dalam atau mindfulness sederhana), serta menjaga keseimbangan antara tuntutan dan waktu pemulihan. Saudara juga dianjurkan untuk menghindari akumulasi tekanan dengan melakukan penyesuaian beban aktivitas secara bertahap serta memanfaatkan dukungan sosial sebagai sarana berbagi dan regulasi emosi.',
            ],
            [
                'type' => 'stress',
                'level' => 'sedang',
                'saran_rekomendasi' => 'Saudara disarankan untuk melakukan pengelolaan stres secara lebih sistematis, termasuk mengidentifikasi faktor pemicu utama, mengevaluasi pola respons terhadap tekanan, serta mengembangkan strategi coping yang lebih adaptif. Penataan prioritas dan manajemen waktu menjadi penting untuk mengurangi perasaan kewalahan. Selain itu, Saudara dianjurkan untuk secara aktif melatih teknik relaksasi yang lebih terstruktur, serta meningkatkan keterlibatan dalam aktivitas yang bersifat restoratif. Konsultasi dengan tenaga profesional (psikolog) dapat dipertimbangkan guna memperoleh psikoedukasi dan pendampingan dalam pengelolaan stres.',
            ],
            [
                'type' => 'stress',
                'level' => 'tinggi',
                'saran_rekomendasi' => 'Saudara sangat disarankan untuk segera mendapatkan bantuan profesional guna menangani tingkat stres yang tinggi dan berdampak signifikan terhadap fungsi sehari-hari. Intervensi yang diberikan dapat mencakup asesmen lanjutan, pelatihan keterampilan manajemen stres, serta penguatan regulasi emosi. Selain itu, diperlukan penyesuaian terhadap tuntutan lingkungan (misalnya beban kerja atau akademik) untuk mencegah perburukan kondisi. Dukungan dari lingkungan terdekat (keluarga, teman, atau atasan) perlu dioptimalkan untuk membantu mengurangi tekanan yang dialami.',
            ],
            [
                'type' => 'stress',
                'level' => 'sangat tinggi',
                'saran_rekomendasi' => 'Saudara memerlukan penanganan profesional secara intensif dan berkelanjutan karena tingkat stres yang sangat tinggi berpotensi mengganggu fungsi psikologis secara signifikan. Diperlukan asesmen komprehensif untuk memahami dinamika stres secara menyeluruh serta merancang intervensi yang tepat. Intervensi dapat mencakup pendekatan psikologis yang terstruktur, penguatan keterampilan coping, serta kemungkinan kolaborasi dengan tenaga medis apabila diperlukan. Keterlibatan aktif dari sistem pendukung menjadi sangat penting untuk memberikan stabilisasi emosional, pengawasan, serta memastikan keberlangsungan proses penanganan.',
            ],
        ]);
    }
}
