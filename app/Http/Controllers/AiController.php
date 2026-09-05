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

        // Ambil API key Groq dari .env
        $apiKey = config('services.groq.key');

        // Kirim ke Groq API
        $response = Http::retry(3, 2000)->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type'  => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model'       => 'llama-3.3-70b-versatile',
            'messages'    => [
                [
                    'role'    => 'system',
                    'content' => 'Kamu adalah Dr. Ariva, seorang psikolog klinis profesional berpengalaman lebih dari 15 tahun dari Biro Psikologi Ariva Consulta Sidoarjo. Kamu dikenal karena kemampuanmu menganalisis kondisi psikologis secara mendalam, menyeluruh, dan menyampaikannya dengan bahasa yang hangat, empatik, serta mudah dipahami oleh orang awam sekalipun. Kamu HANYA menjawab dalam format JSON murni tanpa markdown, tanpa backtick, tanpa komentar, tanpa penjelasan tambahan apapun di luar JSON.'
                ],
                [
                    'role'    => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.8,
            'max_tokens'  => 3000,
        ]);

        if (!$response->successful()) {
            return response()->json([
                'error'  => 'Gagal menghubungi Groq AI. Coba lagi.',
                'detail' => $response->body()
            ], 500);
        }

        $data = $response->json();

        // Format response Groq
        $teks = $data['choices'][0]['message']['content'] ?? '';

        if (empty($teks)) {
            return response()->json(['error' => 'Groq tidak menghasilkan teks. Coba lagi.'], 500);
        }

        // Parse JSON dari teks AI
        $parsed = $this->parseHasilAi($teks);

        $dinamikaData = is_array($parsed['dinamika_psikologis']) ? $parsed['dinamika_psikologis'] : [
            'depression' => $parsed['dinamika_psikologis'],
            'anxiety' => '',
            'stress' => ''
        ];

        $saranData = is_array($parsed['saran_rekomendasi']) ? $parsed['saran_rekomendasi'] : [
            'depression' => $parsed['saran_rekomendasi'],
            'anxiety' => '',
            'stress' => ''
        ];

        $dinamikaJson = json_encode($dinamikaData, JSON_UNESCAPED_UNICODE);
        $saranJson = json_encode($saranData, JSON_UNESCAPED_UNICODE);

        // Simpan ke database
        DB::table('hasil')
            ->where('peserta_id', $id)
            ->update([
                'dinamika_psikologis' => $dinamikaJson,
                'saran_rekomendasi'   => $saranJson,
                'updated_at'          => now(),
            ]);

        return response()->json([
            'success'             => true,
            'dinamika_psikologis' => $dinamikaData,
            'saran_rekomendasi'   => $saranData,
        ]);
    }

    // ==========================================
    // HELPER: Bangun prompt untuk Groq
    // ==========================================
    private function buildPrompt($peserta, $hasil): string
    {
        $permasalahan  = $peserta->permasalahan   ?? '-';
        $yangDirasakan = $peserta->yang_dirasakan  ?? '-';
        $harapan       = $peserta->harapan         ?? '-';

        return <<<PROMPT
Berikut adalah data klien yang membutuhkan analisis psikologis mendalam dari kamu sebagai psikolog profesional:

DATA KLIEN:
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

Sebagai psikolog profesional, buatkan laporan psikologis lengkap dalam format JSON murni terstruktur.
Output harus persis seperti format JSON di bawah ini dan langsung bisa di-parse (Gunakan tanda kutip ganda untuk kunci dan nilai):
{
  "dinamika_psikologis": {
    "depression": "isi analisis depresi...",
    "anxiety": "isi analisis kecemasan...",
    "stress": "isi analisis stres..."
  },
  "saran_rekomendasi": {
    "depression": "isi saran depresi...",
    "anxiety": "isi saran kecemasan...",
    "stress": "isi saran stres..."
  }
}

===== PANDUAN PENULISAN DINAMIKA PSIKOLOGIS =====
Untuk masing-masing bidang (depression, anxiety, stress):
1. Tulis 2-3 kalimat analisis yang hangat, empatik, dan mengalir natural berkaitan dengan kondisi spesifik klien dan hasil skor kategori mereka.
2. Hubungkan secara konkret bagaimana kondisi emosional tersebut mempengaruhi produktivitas kerja/belajar, hubungan sosial, dan ketenangan pikiran klien sehari-hari berdasarkan permasalahan yang mereka alami.

===== PANDUAN PENULISAN SARAN REKOMENDASI =====
Untuk masing-masing bidang (depression, anxiety, stress):
1. Tulis 2-3 saran konkret, praktis, dan langsung dapat dipraktikkan oleh klien dalam bentuk kalimat/paragraf mengalir (prosa) yang hangat dan menenangkan (contoh: Budi disarankan untuk melatih pernapasan perut secara teratur guna menenangkan saraf yang tegang. Selain itu, penting juga bagi Budi untuk mulai menulis jurnal harian untuk menuangkan beban emosi sebelum tidur).
2. JANGAN menulis dalam bentuk daftar poin bernomor (seperti 1, 2, 3) atau bullet points. Tuliskan dalam bentuk kalimat narasi yang menyatu dan dinamis. Gunakan kata penghubung seperti "Pertama-tama...", "Di samping itu...", atau "Sebagai langkah praktis...".
3. Jika skor kategori di bidang tersebut bernilai Sedang, Parah, atau Sangat Parah, WAJIB tambahkan kalimat ajakan yang hangat di akhir paragraf untuk menemui psikolog klinis / profesional kesehatan jiwa untuk konseling lebih mendalam.

===== ATURAN FORMAT =====
- Gunakan bahasa Indonesia yang hangat, mudah dipahami, empatik, dan tidak menghakimi.
- Hindari istilah teknis psikologi yang sulit dipahami orang awam.
- Gunakan nama klien agar terasa personal.
- TANDA BACA & TATA BAHASA: Pastikan penggunaan tanda baca (titik, koma) sangat tertib dan benar secara EYD. Setiap kalimat wajib diawali huruf kapital dan diakhiri tanda titik (.) yang tegas.
- KATA BAKU KBBI: Pastikan seluruh kata yang ditulis adalah kata baku sesuai Kamus Besar Bahasa Indonesia (KBBI). Gunakan kata "stres" (bukan "stress"), "analisis" (bukan "analisa"), "aktivitas" (bukan "aktifitas"), "kualitas" (bukan "kwalitas"), "pernapasan" (bukan "pernafasan"), dan "mengubah" (bukan "merubah").
- HINDARI KUTIP GANDA INTERNAL: JANGAN pernah menggunakan tanda kutip ganda (") di dalam nilai teks (misal: "kondisi") karena akan mematahkan format JSON. Gunakan tanda kutip tunggal (\') jika ingin mengutip istilah.
- JANGAN gunakan karakter newline (\n atau \r) di dalam nilai string JSON. Semua paragraf ditulis dalam satu baris datar menggunakan spasi biasa.
- Pastikan JSON valid dan langsung bisa di-parse tanpa modifikasi apapun.
PROMPT;
    }

    // ==========================================
    // HELPER: Parse JSON dari respons Groq
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

        // Fallback terakhir
        return [
            'dinamika_psikologis' => [
                'depression' => $teks,
                'anxiety'    => '',
                'stress'     => '',
            ],
            'saran_rekomendasi' => [
                'depression' => '',
                'anxiety'    => '',
                'stress'     => '',
            ]
        ];
    }

    // ==========================================
    // HELPER: Generate atau ambil Quote Harian otomatis
    // ==========================================
    public static function getOrGenerateQuote()
    {
        $settings = DB::table('settings')->first();
        $today = now()->toDateString();

        if ($settings && $settings->quote_fetched_at === $today && !empty($settings->quote_of_the_day)) {
            return $settings->quote_of_the_day;
        }

        $apiKey = config('services.groq.key');
        if (empty($apiKey)) {
            return 'Jadikan hari ini langkah awal untuk lebih menghargai dirimu sendiri.';
        }

        try {
            $response = Http::retry(2, 1000)->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'       => 'llama-3.1-8b-instant',
                'messages'    => [
                    [
                        'role'    => 'system',
                        'content' => 'Kamu adalah penyedia kutipan kesehatan mental harian. Buatkan 1 kutipan motivasi yang hangat, puitis, mendalam, dan inspiratif tentang kehidupan, penerimaan diri, atau kekuatan mental dalam bahasa Indonesia. Kutipan harus pendek (1-2 kalimat). JANGAN gunakan tanda petik ganda di awal dan akhir teks. JANGAN sertakan penjelasan apa pun.'
                    ],
                    [
                        'role'    => 'user',
                        'content' => 'Buatkan 1 kutipan motivasi hari ini.'
                    ]
                ],
                'temperature' => 0.9,
                'max_tokens'  => 150,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $quote = trim($data['choices'][0]['message']['content'] ?? '');
                $quote = preg_replace('/^["\'`]|["\'`]$/', '', $quote);

                if ($settings) {
                    DB::table('settings')->where('id', $settings->id)->update([
                        'quote_of_the_day' => $quote,
                        'quote_fetched_at' => $today,
                        'updated_at' => now(),
                    ]);
                } else {
                    DB::table('settings')->insert([
                        'nama_biro' => 'Biro Psikologi Ariva Consulta',
                        'quote_of_the_day' => $quote,
                        'quote_fetched_at' => $today,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                return $quote;
            }
        } catch (\Exception $e) {
            // ignore
        }

        return 'Menghargai diri sendiri adalah awal dari kedamaian pikiran.';
    }

    // ==========================================
    // Chatbot: Kirim pesan curhat ke Groq AI
    // ==========================================
    public function chatbotSend(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        $apiKey = config('services.groq.key');

        if (empty($apiKey)) {
            return response()->json([
                'reply' => 'Maaf, layanan obrolan sedang tidak dapat diakses saat ini.'
            ]);
        }

        $history = session()->get('chatbot_history', []);

        $messages = [
            [
                'role' => 'system',
                'content' => 'Kamu adalah Dr. Ariva, asisten psikologis virtual dari Biro Psikologi Ariva Consulta Sidoarjo. Balas obrolan klien dengan bahasa Indonesia yang hangat, sangat empatik, menenangkan, bersahabat, dan tidak menghakimi. Jaga respons tetap ringkas (maksimal 3 kalimat) agar nyaman dibaca di widget chat kecil. Jika dirasa sangat relevan, sarankan klien untuk mencoba "Tes DASS-42" di website kami atau menghubungi admin via WhatsApp jika membutuhkan konseling lebih mendalam. Pastikan penulisan kata baku sesuai KBBI, seperti menggunakan kata "stres" (bukan "stress") dan "aktivitas" (bukan "aktifitas").'
            ]
        ];

        $limitedHistory = array_slice($history, -10);
        foreach ($limitedHistory as $chat) {
            $messages[] = [
                'role' => $chat['role'],
                'content' => $chat['content']
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $userMessage
        ];

        try {
            $response = Http::retry(2, 1000)->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama-3.1-8b-instant',
                'messages' => $messages,
                'temperature' => 0.7,
                'max_tokens' => 200,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = trim($data['choices'][0]['message']['content'] ?? '');

                $history[] = ['role' => 'user', 'content' => $userMessage];
                $history[] = ['role' => 'assistant', 'content' => $reply];
                session()->put('chatbot_history', $history);

                return response()->json([
                    'reply' => $reply
                ]);
            }
            
            return response()->json([
                'reply' => 'Maaf, saya sedang kesulitan memproses pesan Anda. Coba lagi nanti ya.'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Ada gangguan koneksi. Mari coba mengobrol beberapa saat lagi.'
            ], 500);
        }
    }

    // ==========================================
    // Chatbot: Reset riwayat chat session
    // ==========================================
    public function chatbotReset()
    {
        session()->forget('chatbot_history');
        return response()->json([
            'success' => true
        ]);
    }
}
