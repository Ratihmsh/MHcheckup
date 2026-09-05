<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // ==========================================
    // Dashboard — daftar semua peserta
    // ==========================================
    public function dashboard(Request $request)
    {
        $search = $request->input('search');

        $peserta = DB::table('peserta')
            ->leftJoin('hasil', 'peserta.id', '=', 'hasil.peserta_id')
            ->select(
                'peserta.id',
                'peserta.nama',
                'peserta.jenis_kelamin',
                'peserta.usia',
                'peserta.tanggal_pemeriksaan',
                'hasil.skor_depresi',
                'hasil.skor_kecemasan',
                'hasil.skor_stres',
                'hasil.kategori_depresi',
                'hasil.kategori_kecemasan',
                'hasil.kategori_stres'
            )
            ->when($search, function ($query, $search) {
            $query->where('peserta.nama', 'like', "%{$search}%");
        })
        ->when(request('tanggal'), function ($query, $tanggal) {
            $query->whereDate('peserta.tanggal_pemeriksaan', $tanggal);
        })
        ->orderByDesc('peserta.tanggal_pemeriksaan')
        ->paginate(10);

        return view('admin.dashboard', compact('peserta', 'search'));
    }

    // ==========================================
    // Detail peserta — lihat lengkap + laporan
    // ==========================================
    public function detail($id)
    {
        $peserta = DB::table('peserta')->find($id);
        $hasil   = DB::table('hasil')->where('peserta_id', $id)->first();
        $jawaban = DB::table('jawaban')->where('peserta_id', $id)->first();

        if (!$peserta || !$hasil) {
            return redirect()->route('admin.dashboard')->with('error', 'Data peserta tidak ditemukan.');
        }

        $soal = $this->getDaftarSoal();

        return view('admin.detail', compact('peserta', 'hasil', 'jawaban', 'soal'));
    }

    // ==========================================
    // Update laporan (dinamika & saran) dari admin
    // ==========================================
public function updateLaporan(Request $request, $id)
{
    $request->validate([
        'dinamika' => 'required|array',
        'dinamika.depression' => 'nullable|string',
        'dinamika.anxiety'    => 'nullable|string',
        'dinamika.stress'     => 'nullable|string',
        'saran' => 'required|array',
        'saran.depression'    => 'nullable|string',
        'saran.anxiety'       => 'nullable|string',
        'saran.stress'        => 'nullable|string',
    ]);

    // Ambil array dari input
    $dinamikaArray = $request->input('dinamika'); // ['depression' => '...', 'anxiety' => '...', 'stress' => '...']
    $saranArray    = $request->input('saran');

    // Susun JSON (sama persis dengan format saat simpan)
    $dinamikaJson = json_encode([
        'depression' => $dinamikaArray['depression'] ?? '',
        'anxiety'    => $dinamikaArray['anxiety'] ?? '',
        'stress'     => $dinamikaArray['stress'] ?? '',
    ], JSON_UNESCAPED_UNICODE);

    $saranJson = json_encode([
        'depression' => $saranArray['depression'] ?? '',
        'anxiety'    => $saranArray['anxiety'] ?? '',
        'stress'     => $saranArray['stress'] ?? '',
    ], JSON_UNESCAPED_UNICODE);

    // Update ke tabel hasil
    DB::table('hasil')
        ->where('peserta_id', $id)
        ->update([
            'dinamika_psikologis' => $dinamikaJson,
            'saran_rekomendasi'   => $saranJson,
            'updated_at'          => now(),
        ]);

    return back()->with('success', 'Laporan berhasil diperbarui.');
}

    // ==========================================
    // Cetak laporan PDF
    // ==========================================
    public function cetak($id)
    {
        $peserta = DB::table('peserta')->find($id);
        $hasil   = DB::table('hasil')->where('peserta_id', $id)->first();

        if (!$peserta || !$hasil) {
            return redirect()->route('admin.dashboard')->with('error', 'Data tidak ditemukan.');
        }

        $settings = DB::table('settings')->first();

        // Data logo & ttd (opsional, fallback ke default asset jika kosong)
        $logo_kiri    = ($settings && $settings->logo) ? asset($settings->logo) : asset('storage/logo/logo_kiri.jpg');
        $ttd_psikolog = ($settings && $settings->ttd_psikolog) ? asset($settings->ttd_psikolog) : asset('storage/ttd/ulul_albab.jpg');
        $stempel      = ($settings && $settings->stempel) ? asset($settings->stempel) : asset('storage/ttd/stempel.jpg');

        return view('admin.cetak', compact('peserta', 'hasil', 'logo_kiri', 'ttd_psikolog', 'stempel', 'settings'));
    }

    // ==========================================
    // Hapus peserta beserta data terkait
    // ==========================================
    public function hapus($id)
    {
        DB::table('jawaban')->where('peserta_id', $id)->delete();
        DB::table('hasil')->where('peserta_id', $id)->delete();
        DB::table('peserta')->where('id', $id)->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data peserta berhasil dihapus.');
    }


    // ==========================================
// Data Peserta — halaman tabel tersendiri
// ==========================================
public function peserta(Request $request)
{
    $search = $request->input('search');

    $peserta = DB::table('peserta')
        ->leftJoin('hasil', 'peserta.id', '=', 'hasil.peserta_id')
        ->select(
            'peserta.id',
            'peserta.nama',
            'peserta.jenis_kelamin',
            'peserta.usia',
            'peserta.tanggal_pemeriksaan',
            'hasil.skor_depresi',
            'hasil.skor_kecemasan',
            'hasil.skor_stres',
            'hasil.kategori_depresi',
            'hasil.kategori_kecemasan',
            'hasil.kategori_stres'
        )
        ->when(request('kategori'), function ($query, $kategori) {
    $query->where(function($q) use ($kategori) {
        $q->where('hasil.kategori_depresi',   $kategori)
          ->orWhere('hasil.kategori_kecemasan', $kategori)
          ->orWhere('hasil.kategori_stres',     $kategori);
    });
})
        ->when($search, function ($query, $search) {
            $query->where('peserta.nama', 'like', "%{$search}%");
        })
        ->when(request('tanggal'), function ($query, $tanggal) {
            $query->whereDate('peserta.tanggal_pemeriksaan', $tanggal);
        })
        ->orderByDesc('peserta.tanggal_pemeriksaan')
        ->paginate(15);

    return view('admin.peserta', compact('peserta', 'search'));
}

    // ==========================================
    // Tampilkan form pengaturan web
    // ==========================================
    public function editPengaturan()
    {
        $settings = DB::table('settings')->first();
        return view('admin.pengaturan', compact('settings'));
    }

    // ==========================================
    // Update pengaturan web beserta upload file
    // ==========================================
    public function updatePengaturan(Request $request)
    {
        $request->validate([
            'nama_biro' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|string|max:255',
            'headline' => 'nullable|string|max:255',
            'sub_headline' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|max:10240',
            'ttd_psikolog' => 'nullable|image|max:10240',
            'stempel' => 'nullable|image|max:10240',
        ]);

        $settings = DB::table('settings')->first();
        $updateData = [
            'nama_biro' => $request->nama_biro,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'headline' => $request->headline,
            'sub_headline' => $request->sub_headline,
            'deskripsi' => $request->deskripsi,
            'updated_at' => now(),
        ];

        // Helper upload
        $uploadFile = function($fieldName, $subFolder) use ($request, $settings, &$updateData) {
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/' . $subFolder);
                
                if (!\Illuminate\Support\Facades\File::isDirectory($destinationPath)) {
                    \Illuminate\Support\Facades\File::makeDirectory($destinationPath, 0755, true, true);
                }
                
                $file->move($destinationPath, $fileName);

                // Hapus berkas lama jika ada
                if ($settings && isset($settings->$fieldName) && $settings->$fieldName && \Illuminate\Support\Facades\File::exists(public_path($settings->$fieldName))) {
                    \Illuminate\Support\Facades\File::delete(public_path($settings->$fieldName));
                }

                $updateData[$fieldName] = 'uploads/' . $subFolder . '/' . $fileName;
            }
        };

        $uploadFile('logo', 'logo');
        $uploadFile('ttd_psikolog', 'ttd');
        $uploadFile('stempel', 'stempel');

        if ($settings) {
            DB::table('settings')->where('id', $settings->id)->update($updateData);
        } else {
            $updateData['created_at'] = now();
            DB::table('settings')->insert($updateData);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
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
}
