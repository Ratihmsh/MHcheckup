@extends('layouts.app')

@section('title', 'Hasil Tes DASS — Ariva Consulta')

@section('styles')
<style>
    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 32px;
    }
    .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .step-circle {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.9rem;
        border: 2px solid #e2e8f0; background: #fff; color: #94a3b8;
    }
    .step.done .step-circle { background: #d1fae5; border-color: #10b981; color: #065f46; }
    .step-label { font-size: 0.75rem; font-weight: 600; color: #94a3b8; }
    .step.done .step-label { color: #10b981; }
    .step-line { flex: 1; height: 2px; background: #10b981; margin: 0 8px; margin-bottom: 22px; }

    .skor-card {
        border-radius: 16px;
        padding: 24px;
        text-align: center;
        border: none;
        transition: transform 0.2s;
    }
    .skor-card:hover { transform: translateY(-3px); }
    .skor-card.depresi   { background: linear-gradient(135deg, #eff6ff, #dbeafe); }
    .skor-card.kecemasan { background: linear-gradient(135deg, #fdf4ff, #f3e8ff); }
    .skor-card.stres     { background: linear-gradient(135deg, #fff7ed, #ffedd5); }

    .skor-icon { font-size: 2.2rem; margin-bottom: 8px; display: block; }
    .skor-label { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
    .skor-card.depresi   .skor-label { color: #1e40af; }
    .skor-card.kecemasan .skor-label { color: #7e22ce; }
    .skor-card.stres     .skor-label { color: #c2410c; }

    .skor-angka { font-size: 3rem; font-weight: 800; line-height: 1; margin-bottom: 8px; }
    .skor-card.depresi   .skor-angka { color: #1a56db; }
    .skor-card.kecemasan .skor-angka { color: #9333ea; }
    .skor-card.stres     .skor-angka { color: #ea580c; }

    .badge-kategori { padding: 6px 16px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; display: inline-block; }
    .badge-Normal       { background: #d1fae5; color: #065f46; }
    .badge-Ringan       { background: #fef9c3; color: #713f12; }
    .badge-Sedang       { background: #fed7aa; color: #7c2d12; }
    .badge-Tinggi        { background: #fecaca; color: #7f1d1d; }
    .badge-Sangat-Tinggi { background: #f3e8ff; color: #4a044e; }

    .gauge-bar { height: 8px; border-radius: 8px; background: #e2e8f0; margin-top: 12px; overflow: hidden; }
    .gauge-fill { height: 100%; border-radius: 8px; transition: width 1s ease; }
    .depresi .gauge-fill   { background: linear-gradient(90deg, #60a5fa, #1a56db); }
    .kecemasan .gauge-fill { background: linear-gradient(90deg, #c084fc, #9333ea); }
    .stres .gauge-fill     { background: linear-gradient(90deg, #fb923c, #ea580c); }

    .tabel-kategori th { background: #f8fafc; font-size: 0.82rem; }
    .tabel-kategori td { font-size: 0.85rem; vertical-align: middle; }

    .section-title {
        font-size: 0.8rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: 0.08em; color: #1a56db;
        border-bottom: 2px solid #e0e7ff; padding-bottom: 8px; margin-bottom: 20px;
    }

    /* WA BUTTON BESAR */
    .btn-wa-besar {
        background: linear-gradient(135deg, #25d366, #128c7e);
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 16px 32px;
        font-size: 1.05rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 16px rgba(37,211,102,0.3);
        transition: all 0.2s;
        text-decoration: none;
        width: 100%;
    }
    .btn-wa-besar:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37,211,102,0.4);
        color: #fff;
    }
    .btn-wa-besar i { font-size: 1.4rem; }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 720px;">

    {{-- STEP INDICATOR --}}
    <div class="step-indicator">
        <div class="step done">
            <div class="step-circle"><i class="bi bi-check-lg"></i></div>
            <span class="step-label">Biodata</span>
        </div>
        <div class="step-line"></div>
        <div class="step done">
            <div class="step-circle"><i class="bi bi-check-lg"></i></div>
            <span class="step-label">Tes DASS</span>
        </div>
        <div class="step-line"></div>
        <div class="step done">
            <div class="step-circle"><i class="bi bi-check-lg"></i></div>
            <span class="step-label">Hasil</span>
        </div>
    </div>

    {{-- HEADER --}}
    <div class="card mb-4">
        <div class="card-header-blue">
            <h5 class="text-white fw-bold mb-1">
                <i class="bi bi-clipboard2-pulse-fill me-2"></i>Hasil Tes DASS
            </h5>
            <p class="text-white-50 small mb-0">
                {{ $peserta->nama }} &mdash; {{ \Carbon\Carbon::parse($peserta->tanggal_pemeriksaan)->translatedFormat('d F Y') }}
            </p>
        </div>
        <div class="card-body px-4 py-3">
            <div class="row g-2 text-secondary small">
                <div class="col-6 col-md-3">
                    <i class="bi bi-person me-1"></i>{{ $peserta->jenis_kelamin }}
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-calendar me-1"></i>{{ $peserta->usia }} tahun
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-briefcase me-1"></i>{{ $peserta->pekerjaan ?? '-' }}
                </div>
                <div class="col-6 col-md-3">
                    <i class="bi bi-mortarboard me-1"></i>{{ $peserta->pendidikan ?? '-' }}
                </div>
            </div>
        </div>
    </div>

    {{-- 3 SKOR CARD --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="skor-card depresi h-100">
                <span class="skor-icon">😔</span>
                <div class="skor-label">Depresi</div>
                {{-- <div class="skor-angka">{{ $hasil->skor_depresi }}</div> --}}
                <span class="badge-kategori badge-{{ str_replace(' ', '-', $hasil->kategori_depresi) }}">
                    {{ $hasil->kategori_depresi }}
                </span>
                <div class="gauge-bar">
                    <div class="gauge-fill" style="width: {{ min(round(($hasil->skor_depresi / 42) * 100), 100) }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="skor-card kecemasan h-100">
                <span class="skor-icon">😰</span>
                <div class="skor-label">Kecemasan</div>
                {{-- <div class="skor-angka">{{ $hasil->skor_kecemasan }}</div> --}}
                <span class="badge-kategori badge-{{ str_replace(' ', '-', $hasil->kategori_kecemasan) }}">
                    {{ $hasil->kategori_kecemasan }}
                </span>
                <div class="gauge-bar">
                    <div class="gauge-fill" style="width: {{ min(round(($hasil->skor_kecemasan / 42) * 100), 100) }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="skor-card stres h-100">
                <span class="skor-icon">😤</span>
                <div class="skor-label">Stres</div>
                {{-- <div class="skor-angka">{{ $hasil->skor_stres }}</div> --}}
                <span class="badge-kategori badge-{{ str_replace(' ', '-', $hasil->kategori_stres) }}">
                    {{ $hasil->kategori_stres }}
                </span>
                <div class="gauge-bar">
                    <div class="gauge-fill" style="width: {{ min(round(($hasil->skor_stres / 42) * 100), 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL PANDUAN KATEGORI --}}
    {{-- <div class="card mb-4">
        <div class="card-body p-4">
            <div class="section-title">Panduan Kategori Skor</div>
            <div class="table-responsive">
                <table class="table table-bordered tabel-kategori mb-0">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th class="text-center">Depresi</th>
                            <th class="text-center">Kecemasan</th>
                            <th class="text-center">Stres</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach([
                            ['Normal',       '0 – 9',  '0 – 7',  '0 – 14', 'badge-Normal'],
                            ['Ringan',       '10 – 13','8 – 9',  '15 – 18','badge-Ringan'],
                            ['Sedang',       '14 – 20','10 – 14','19 – 25','badge-Sedang'],
                            ['Tinggi',        '21 – 27','15 – 19','26 – 33','badge-Tinggi'],
                            ['Sangat Tinggi', '≥ 28',   '≥ 20',   '≥ 34',  'badge-Sangat-Tinggi'],
                        ] as [$kat, $dep, $kec, $str, $badge])
                        <tr>
                            <td><span class="badge-kategori {{ $badge }}">{{ $kat }}</span></td>
                            <td class="text-center">{{ $dep }}</td>
                            <td class="text-center">{{ $kec }}</td>
                            <td class="text-center">{{ $str }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    {{-- HUBUNGI PSIKOLOG VIA WA --}}
    <div class="card mb-4" style="border: 2px solid #d1fae5; border-radius: 16px;">
        <div class="card-body p-4 text-center">
            <div class="mb-3">
                <span style="font-size:2.5rem;">👩‍⚕️</span>
            </div>
            <h6 class="fw-bold text-dark mb-1">Ingin Tahu Hasil Lengkap?</h6>
            <p class="text-secondary small mb-4">
                Dapatkan laporan psikologis lengkap beserta analisis mendalam dan rekomendasi
                dari psikolog kami. Hubungi kami langsung melalui WhatsApp.
            </p>

            @php
                $pesan = "Halo Ariva Consulta, saya *{$peserta->nama}* baru saja mengikuti tes DASS dan ingin mengetahui hasil lengkap saya.\n\n"
                       . "Hasil tes saya:\n"
                       . "• Depresi: {$hasil->skor_depresi} ({$hasil->kategori_depresi})\n"
                       . "• Kecemasan: {$hasil->skor_kecemasan} ({$hasil->kategori_kecemasan})\n"
                       . "• Stres: {$hasil->skor_stres} ({$hasil->kategori_stres})\n\n"
                       . "Mohon bantuannya. Terima kasih 🙏";
                $pesanEncoded = urlencode($pesan);
                $nomorWa = '6285857176646'; // ← GANTI dengan nomor WA Ariva Consulta
            @endphp

            <a href="https://wa.me/{{ $nomorWa }}?text={{ $pesanEncoded }}"
                target="_blank" class="btn-wa-besar">
                <i class="bi bi-whatsapp"></i>
                Hubungi Psikolog via WhatsApp
            </a>

            <p class="text-secondary small mt-3 mb-0">
                <i class="bi bi-clock me-1"></i>
                Biro Psikologi Ariva Consulta Sidoarjo
            </p>
        </div>
    </div>

    {{-- TOMBOL TES ULANG --}}
    <div class="d-flex justify-content-center mb-4">
        <a href="{{ route('biodata') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-repeat me-2"></i>Tes Ulang dari Awal
        </a>
    </div>

    {{-- DISCLAIMER --}}
    <p class="text-center text-secondary small">
        <i class="bi bi-exclamation-circle me-1"></i>
        Hasil tes ini bukan merupakan diagnosis klinis. Konsultasikan dengan psikolog untuk penanganan lebih lanjut.
    </p>

</div>
@endsection

@section('scripts')
<script>
    window.addEventListener('load', function() {
        document.querySelectorAll('.gauge-fill').forEach(function(el) {
            const target = el.style.width;
            el.style.width = '0%';
            setTimeout(function() { el.style.width = target; }, 300);
        });
    });
</script>
@endsection
