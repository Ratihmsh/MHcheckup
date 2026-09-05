<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AiController extends Controller
{
    // ==========================================
    // Generate laporan AI berdasarkan hasil DASS
    // ==========================================
    public function generate($id)
    {
        $peserta = DB::table('peserta')->find($id);
        $hasil   = DB::table('hasil')->where('peserta_id', $id)->first();

        if (!$peserta || !$hasil) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        // Susun prompt
        $prompt = $this->buildPrompt($peserta, $hasil);

        // Ambil API key Gemini dari .env
        $apiKey = config('services.gemini.key');

        // Kirim ke Gemini API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature'     => 0.7,
                'maxOutputTokens' => 1500,
            ]
        ]);

        if (!$response->successful()) {
            return response()->json([
                'error'  => 'Gagal menghubungi Gemini AI. Coba lagi.',
                'detail' => $response->body()
            ], 500);
        }

        $data = $response->json();

        // Format response Gemini
        $teks = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        if (empty($teks)) {
            return response()->json(['error' => 'Gemini tidak menghasilkan teks. Coba lagi.'], 500);
        }

        // Parse JSON dari teks AI
        $parsed = $this->parseHasilAi($teks);

        // Simpan ke database
        DB::table('hasil')
            ->where('peserta_id', $id)
            ->update([
                'dinamika_psikologis' => $parsed['dinamika_psikologis'],
                'saran_rekomendasi'   => $parsed['saran_rekomendasi'],
                'updated_at'          => now(),
            ]);

        return response()->json([
            'success'             => true,
            'dinamika_psikologis' => $parsed['dinamika_psikologis'],
            'saran_rekomendasi'   => $parsed['saran_rekomendasi'],
        ]);
    }

    // ==========================================
    // HELPER: Bangun prompt untuk Gemini
    // ==========================================
    private function buildPrompt($peserta, $hasil): string
    {
        $permasalahan  = $peserta->permasalahan   ?? '-';
        $yangDirasakan = $peserta->yang_dirasakan  ?? '-';
        $harapan       = $peserta->harapan         ?? '-';

        return <<<PROMPT
Kamu adalah psikolog profesional dari Biro Psikologi Ariva Consulta Sidoarjo.
Tugas kamu adalah membuat laporan psikologis berdasarkan hasil tes DASS-42 berikut.

DATA PESERTA:
- Nama          : {$peserta->nama}
- Usia          : {$peserta->usia} tahun
- Jenis Kelamin : {$peserta->jenis_kelamin}
- Pekerjaan     : {$peserta->pekerjaan}
- Permasalahan  : {$permasalahan}
- Yang Dirasakan: {$yangDirasakan}
- Harapan       : {$harapan}

HASIL TES DASS-42:
- Depresi   : Skor {$hasil->skor_depresi}  → Kategori {$hasil->kategori_depresi}
- Kecemasan : Skor {$hasil->skor_kecemasan} → Kategori {$hasil->kategori_kecemasan}
- Stres     : Skor {$hasil->skor_stres}    → Kategori {$hasil->kategori_stres}

Buatkan laporan dalam format JSON murni (TANPA markdown, TANPA backtick, TANPA komentar apapun).
Output harus persis seperti ini dan langsung bisa di-parse sebagai JSON:
{"dinamika_psikologis":"isi narasi di sini","saran_rekomendasi":"isi saran di sini"}

Ketentuan penulisan:
1. "dinamika_psikologis": Narasi 3-4 kalimat dalam bahasa Indonesia yang formal dan profesional. Jelaskan kondisi psikologis peserta berdasarkan kombinasi ketiga skor, kaitkan dengan permasalahan dan yang dirasakan peserta.
2. "saran_rekomendasi": Berikan 3-4 saran konkret dan spesifik sesuai tingkat keparahan masing-masing skala. Jika ada kategori Sedang, Parah, atau Sangat Parah, sarankan untuk berkonsultasi langsung dengan psikolog atau tenaga ahli.
3. Gunakan bahasa formal, empatik, dan tidak menghakimi.
4. Jangan sertakan angka skor dalam narasi, cukup sebutkan tingkatannya.
5. Pastikan tidak ada karakter newline di dalam nilai JSON, gunakan spasi biasa sebagai pemisah kalimat.
PROMPT;
    }

    // ==========================================
    // HELPER: Parse JSON dari respons Gemini
    // ==========================================
    private function parseHasilAi(string $teks): array
    {
        // Bersihkan markdown code block kalau ada
        $teks = preg_replace('/```json|```/i', '', $teks);
        $teks = trim($teks);

        // Coba parse langsung sebagai JSON
        $decoded = json_decode($teks, true);
        if (json_last_error() === JSON_ERROR_NONE && isset($decoded['dinamika_psikologis'])) {
            return $decoded;
        }

        // Coba ekstrak JSON dari dalam teks
        preg_match('/\{.*\}/s', $teks, $matches);
        if (!empty($matches[0])) {
            $decoded = json_decode($matches[0], true);
            if (json_last_error() === JSON_ERROR_NONE && isset($decoded['dinamika_psikologis'])) {
                return $decoded;
            }
        }

        // Fallback terakhir: kembalikan teks mentah
        return [
            'dinamika_psikologis' => $teks,
            'saran_rekomendasi'   => '',
        ];
    }
}
