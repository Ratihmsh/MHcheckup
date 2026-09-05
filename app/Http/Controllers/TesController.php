<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
USE App\Models\DinamikaPsikologis;
USE App\Models\SaranRekomendasi;

class TesController extends Controller
{

    public function landing()
    {
        $settings = DB::table('settings')->first();
        
        // Ambil 6 berita terbaru
        $berita = DB::table('berita')
            ->orderByDesc('tanggal_publish')
            ->orderByDesc('id')
            ->limit(6)
            ->get();

        // Ambil atau generate Quote harian via AI
        $quote = AiController::getOrGenerateQuote();

        return view('user.landing', compact('settings', 'berita', 'quote'));
    }
    // ==========================================
    // Tampilkan halaman biodata
    // ==========================================
    public function biodata()
    {
        return view('user.biodata');
    }

    // ==========================================
    // Simpan biodata ke database
    // ==========================================
    public function simpanBiodata(Request $request)
    {
        $request->validate([
            'nama'              => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'     => 'required|date',
            'usia'              => 'required|string|max:255',
            'pendidikan'        => 'nullable|string|max:255',
            'pekerjaan'         => 'nullable|string|max:255',
            'status_perkawinan' => 'nullable|in:Belum Menikah,Menikah,Cerai',
            'no_telp'           => 'nullable|string|max:20',
            'alamat'            => 'nullable|string',
            'tujuan_konsultasi' => 'nullable|string|max:255',
            'permasalahan'      => 'nullable|string',
            'yang_dirasakan'    => 'nullable|string',
            'harapan'           => 'nullable|string',
        ]);

        $pesertaId = DB::table('peserta')->insertGetId([
            'nama'              => $request->nama,
            'jenis_kelamin'     => $request->jenis_kelamin,
            'tanggal_lahir'     => $request->tanggal_lahir,
            'usia'              => $request->usia,
            'pendidikan'        => $request->pendidikan,
            'pekerjaan'         => $request->pekerjaan,
            'status_perkawinan' => $request->status_perkawinan,
            'no_telp'           => $request->no_telp,
            'alamat'            => $request->alamat,
            'tujuan_konsultasi' => $request->tujuan_konsultasi,
            'permasalahan'      => $request->permasalahan,
            'yang_dirasakan'    => $request->yang_dirasakan,
            'harapan'           => $request->harapan,
            'tanggal_pemeriksaan' => now()->toDateString(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('tes', ['peserta_id' => $pesertaId]);
    }

    // ==========================================
    // Tampilkan halaman 42 soal DASS
    // ==========================================
    public function tes($peserta_id)
    {
        $peserta = DB::table('peserta')->find($peserta_id);

        if (!$peserta) {
            return redirect()->route('biodata')->with('error', 'Data tidak ditemukan.');
        }

        $soal = $this->getDaftarSoal();

        return view('user.tes', compact('peserta', 'soal'));
    }

    // ==========================================
    // Simpan jawaban & hitung skor
    // ==========================================
    public function simpanTes(Request $request)
    {
        $pesertaId = $request->peserta_id;

        // Validasi semua 42 soal wajib dijawab
        $rules = ['peserta_id' => 'required|integer'];
        for ($i = 1; $i <= 42; $i++) {
            $rules["soal_$i"] = 'required|integer|min:0|max:3';
        }
        $request->validate($rules);

        // Simpan semua jawaban
        $jawaban = ['peserta_id' => $pesertaId, 'created_at' => now(), 'updated_at' => now()];
        for ($i = 1; $i <= 42; $i++) {
            $jawaban["soal_$i"] = $request->input("soal_$i");
        }
        DB::table('jawaban')->insert($jawaban);

        // ==========================================
        // Hitung skor per skala
        // Depresi    : soal 3,5,10,13,16,17,21,24,26,31,34,37,38,42
        // Kecemasan  : soal 2,4,7,9,15,19,20,23,25,28,30,36,40,41
        // Stres      : soal 1,6,8,11,12,14,18,22,27,29,32,33,35,39
        // ==========================================
        $soalDepresi   = [3,5,10,13,16,17,21,24,26,31,34,37,38,42];
        $soalKecemasan = [2,4,7,9,15,19,20,23,25,28,30,36,40,41];
        $soalStres     = [1,6,8,11,12,14,18,22,27,29,32,33,35,39];

        $skorDepresi   = $this->hitungSkor($request, $soalDepresi);
        $skorKecemasan = $this->hitungSkor($request, $soalKecemasan);
        $skorStres     = $this->hitungSkor($request, $soalStres);

        $kategoriDepresi   = $this->kategoriDepresi($skorDepresi);
        $kategoriKecemasan = $this->kategoriKecemasan($skorKecemasan);
        $kategoriStres     = $this->kategoriStres($skorStres);

        $levelMap = [
            'Normal'        => 'normal',
            'Ringan'        => 'ringan',
            'Sedang'        => 'sedang',
            'Tinggi'         => 'tinggi',
            'Sangat Tinggi'  => 'sangat tinggi'
        ];

        $depresiLevel   = $levelMap[$kategoriDepresi];
        $kecemasanLevel = $levelMap[$kategoriKecemasan];
        $stresLevel     = $levelMap[$kategoriStres];

        $dinamikaDepresi = DinamikaPsikologis::where('type', 'depression')
                    ->where('level', $depresiLevel)
                    ->value('dinamika_psikologis') ?? '';

        $dinamikaKecemasan = DinamikaPsikologis::where('type', 'anxiety')
                    ->where('level', $kecemasanLevel)
                    ->value('dinamika_psikologis') ?? '';

        $dinamikaStres = DinamikaPsikologis::where('type', 'stress')
                    ->where('level', $stresLevel)
                    ->value('dinamika_psikologis') ?? '';

        $saranDepresi = SaranRekomendasi::where('type', 'depression')
                    ->where('level', $depresiLevel)
                    ->value('saran_rekomendasi') ?? '';

        $saranKecemasan = SaranRekomendasi::where('type', 'anxiety')
                    ->where('level', $kecemasanLevel)
                    ->value('saran_rekomendasi') ?? '';

        $saranStres = SaranRekomendasi::where('type', 'stress')
                    ->where('level', $stresLevel)
                    ->value('saran_rekomendasi') ?? '';

        $dinamikaJson = json_encode([
            'depression' => $dinamikaDepresi,
            'anxiety'    => $dinamikaKecemasan,
            'stress'     => $dinamikaStres,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $saranJson = json_encode([
            'depression' => $saranDepresi,
            'anxiety'    => $saranKecemasan,
            'stress'     => $saranStres,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // Kumpulkan 42 jawaban untuk diumpankan ke model SVM Python
        $jawabanSvm = [];
        for ($i = 1; $i <= 42; $i++) {
            $jawabanSvm[] = (int) $request->input("soal_$i");
        }
        $svmResult = $this->predictSvm($jawabanSvm);

        // Simpan hasil
        DB::table('hasil')->insert([
            'peserta_id'        => $pesertaId,
            'skor_depresi'      => $skorDepresi,
            'skor_kecemasan'    => $skorKecemasan,
            'skor_stres'        => $skorStres,
            'kategori_depresi'  => $kategoriDepresi,
            'kategori_kecemasan'=> $kategoriKecemasan,
            'kategori_stres'    => $kategoriStres,
            'svm_depresi'       => $svmResult['Depresi'] ?? null,
            'svm_kecemasan'     => $svmResult['Kecemasan'] ?? null,
            'svm_stres'         => $svmResult['Stres'] ?? null,
            'dinamika_psikologis' => $dinamikaJson,
            'saran_rekomendasi'  => $saranJson,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('hasil', ['peserta_id' => $pesertaId]);
    }

    // ==========================================
    // Tampilkan halaman hasil (ringkas untuk user)
    // ==========================================
    public function hasil($peserta_id)
    {
        $peserta = DB::table('peserta')->find($peserta_id);
        $hasil   = DB::table('hasil')->where('peserta_id', $peserta_id)->first();

        if (!$peserta || !$hasil) {
            return redirect()->route('biodata')->with('error', 'Data tidak ditemukan.');
        }

        return view('user.hasil', compact('peserta', 'hasil'));
    }

    // ==========================================
    // HELPER: Hitung total skor dari nomor soal
    // ==========================================
    private function hitungSkor(Request $request, array $nomorSoal): int
    {
        $total = 0;
        foreach ($nomorSoal as $no) {
            $total += (int) $request->input("soal_$no", 0);
        }
        return $total;
    }

    // ==========================================
    // HELPER: Kategori Depresi
    // Normal 0-9 | Ringan 10-13 | Sedang 14-20 | Tinggi 21-27 | Sangat Tinggi >=28
    // ==========================================
    private function kategoriDepresi(int $skor): string
    {
        if ($skor <= 9)  return 'Normal';
        if ($skor <= 13) return 'Ringan';
        if ($skor <= 20) return 'Sedang';
        if ($skor <= 27) return 'Tinggi';
        return 'Sangat Tinggi';
    }

    // ==========================================
    // HELPER: Kategori Kecemasan
    // Normal 0-7 | Ringan 8-9 | Sedang 10-14 | Tinggi 15-19 | Sangat Tinggi >=20
    // ==========================================
    private function kategoriKecemasan(int $skor): string
    {
        if ($skor <= 7)  return 'Normal';
        if ($skor <= 9)  return 'Ringan';
        if ($skor <= 14) return 'Sedang';
        if ($skor <= 19) return 'Tinggi';
        return 'Sangat Tinggi';
    }

    // ==========================================
    // HELPER: Kategori Stres
    // Normal 0-14 | Ringan 15-18 | Sedang 19-25 | Tinggi 26-33 | Sangat Tinggi >=34
    // ==========================================
    private function kategoriStres(int $skor): string
    {
        if ($skor <= 14) return 'Normal';
        if ($skor <= 18) return 'Ringan';
        if ($skor <= 25) return 'Sedang';
        if ($skor <= 33) return 'Tinggi';
        return 'Sangat Tinggi';
    }

    // ==========================================
    // HELPER: Daftar 42 soal DASS
    // ==========================================
    private function getDaftarSoal(): array
    {
        return [
            1  => 'Menjadi marah karena hal-hal kecil / sepele',
            2  => 'Mulut terasa kering',
            3  => 'Tidak dapat melihat hal yang positif dari suatu kejadian',
            4  => 'Merasakan gangguan dalam bernapas',
            5  => 'Merasa seperti tidak kuat lagi untuk melakukan suatu kegiatan',
            6  => 'Cenderung bereaksi berlebihan pada situasi',
            7  => 'Kelemahan pada anggota tubuh',
            8  => 'Kesulitan untuk bersantai',
            9  => 'Cemas yang berlebihan dalam suatu situasi namun bisa lega jika hal itu berakhir',
            10 => 'Pesimis',
            11 => 'Mudah merasa kesal',
            12 => 'Merasa banyak menghabiskan energi karena cemas',
            13 => 'Merasa sedih dan depresi',
            14 => 'Tidak sabaran dalam melakukan sesuatu',
            15 => 'Sering merasa lelah',
            16 => 'Kehilangan minat dalam banyak hal',
            17 => 'Merasa tidak layak',
            18 => 'Mudah tersinggung',
            19 => 'Berkeringat (misal: tangan berkeringat) tanpa stimulasi oleh cuaca atau latihan fisik',
            20 => 'Ketakutan tanpa alasan yang jelas',
            21 => 'Merasa hidup tidak berharga',
            22 => 'Sulit untuk beristirahat',
            23 => 'Kesulitan dalam menelan',
            24 => 'Tidak dapat menikmati hal-hal yang saya lakukan',
            25 => 'Jantung berdebar-debar tanpa stimulasi oleh latihan fisik',
            26 => 'Merasa hilang harapan / putus asa',
            27 => 'Mudah marah',
            28 => 'Mudah panik',
            29 => 'Kurang dapat tenang',
            30 => 'Takut diri / takut dihukum',
            31 => 'Sulit dalam antusias dalam banyak hal',
            32 => 'Sulit mentoleransi gangguan-gangguan terhadap hal yang sedang dilakukan',
            33 => 'Berada pada keadaan tegang',
            34 => 'Merasa tidak berharga',
            35 => 'Tidak dapat memaklumi keadaan atau situasi tertentu',
            36 => 'Ketakutan',
            37 => 'Tidak ada harapan untuk masa depan',
            38 => 'Merasa hidup kurang berarti',
            39 => 'Mudah gelisah',
            40 => 'Khawatir dengan situasi tertentu yang dapat menimbulkan panik dan mempermalukan diri sendiri',
            41 => 'Gemetar',
            42 => 'Sulit untuk meningkatkan inisiatif dalam melakukan sesuatu',
        ];
    }

    /**
     * Helper: Panggil program Python SVM untuk prediksi tingkat emosi
     */
    public function predictSvm(array $answers): ?array
    {
        $answersCsv = implode(',', $answers);
        $pythonPath = config('services.python.path', 'python');
        $scriptPath = base_path('python/predict.py');
        
        // Jalankan command Python di Windows shell dengan penanganan spasi
        $command = escapeshellarg($pythonPath) . ' ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($answersCsv);
        $output = shell_exec($command);
        
        if (empty($output)) {
            return null;
        }
        
        $decoded = json_decode($output, true);
        if (json_last_error() === JSON_ERROR_NONE && !isset($decoded['error'])) {
            return $decoded;
        }
        
        return null;
    }
}
