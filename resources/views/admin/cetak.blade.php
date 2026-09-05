<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan DASS — {{ $peserta->nama }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background: #e2e8f0;
            line-height: 1.4;
        }

        .page {
            position: relative;
            width: 210mm;
            min-height: 297mm;
            margin: 20px auto;
            padding: 15mm 20mm;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* WATERMARK STEMPEL - TAMPIL DI LAYAR (hanya di halaman pertama) */
        .watermark-stempel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-25deg);
            z-index: -1;
            opacity: 0.12;
            pointer-events: none;
            width: 500px;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .watermark-stempel img {
            max-width: 500px;
            max-height: 500px;
            width: auto;
            height: auto;
            object-fit: contain;
        }
        .watermark-stempel .placeholder-watermark {
            width: 350px;
            height: 350px;
            border-radius: 50%;
            border: 5px solid #c41e3a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28pt;
            font-weight: bold;
            color: #c41e3a;
            background: rgba(196, 30, 58, 0.05);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        /* KOP SURAT - Dibuat lebih stabil */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .kop-logo {
            flex: 0 0 120px;
            text-align: left;
        }

        .kop-logo img {
            width: 200px;
            height: auto;
        }

        .kop-detail {
            flex: 1;
            text-align: center;
        }

        .nama-pt { font-size: 15pt; font-weight: bold; margin: 0; }
        .sk-kemkumham { font-size: 9pt; margin: 2px 0; }
        .nama-biro { font-size: 12pt; font-weight: bold; margin: 2px 0; letter-spacing: 0.5px;}
        .alamat-kontak { font-size: 8.5pt; line-height: 1.3; margin: 0; }

        /* LABEL RAHASIA - Tidak absolute lagi supaya tidak menimpa content */
        .label-rahasia-container {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }
        .label-rahasia {
            border: 2px solid #c41e3a;
            padding: 3px 25px;
            font-size: 12pt;
            font-weight: bold;
            letter-spacing: 5px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #c41e3a;
            background: #fff;
        }

        /* SECTION HEADERS */
        .section-header {
            font-weight: bold;
            font-size: 12pt;
            text-transform: uppercase;
            margin: 15px 0 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
        }

        /* TABEL BIODATA - Dibuat Fixed supaya rapi */
        .tabel-biodata {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            table-layout: fixed; /* Menjaga lebar kolom konstan */
        }
        .tabel-biodata td {
            padding: 3px 4px;
            vertical-align: top;
            font-size: 10.5pt;
        }
        .col-label { width: 22%; }
        .col-titik { width: 3%; }
        .col-value { width: 25%; }

        /* TABEL HASIL */
        .tabel-hasil {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .tabel-hasil th, .tabel-hasil td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        .tabel-hasil th { background: #f8fafc; font-weight: bold; }
        .tabel-hasil td.label { text-align: center; font-weight: bold; padding-left: 15px; }

        /* WARNA KATEGORI */
        /* .kategori-normal { color: #15803d; }
        .kategori-ringan { color: #b45309; }
        .kategori-sedang { color: #ca8a04; }
        .kategori-tinggi { color: #dc2626; }
        .kategori-sangat-tinggi { color: #991b1b; } */
        .kategori-normal { color: #000000; }
        .kategori-ringan { color: #000000; }
        .kategori-sedang { color: #000000; }
        .kategori-tinggi { color: #000000; }
        .kategori-sangat-tinggi { color: #000000; }

        .tabel-norma {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10pt;
            background: #fff;
        }
        .tabel-norma th, .tabel-norma td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: center;
        }
        .tabel-norma th {
            background: #f1f5f9;
            font-weight: bold;
        }

        /* NARASI */
        .narasi-box p {
            text-align: justify;
            text-indent: 30px;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        /* TANDA TANGAN */
        .ttd-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }
        .ttd-box {
            text-align: center;
            min-width: 250px;
            width: auto;
            margin-bottom: 20px;
        }
        .ttd-image {
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 5px 0;
        }
        .ttd-image img { max-height: 70px; }
        .nama-psikolog { font-weight: bold; white-space: nowrap; text-decoration: underline; padding-top: 5px; }

        .print-actions {
            position: fixed;
            bottom: 24px;
            right: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            z-index: 999;
        }
        .btn-print {
            background: #0f3b5c;
            color: #fff;
            border: none;
            border-radius: 40px;
            padding: 12px 28px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 4px 12px rgba(15,59,92,0.3);
            transition: 0.2s;
        }
        .btn-print:hover { background: #1e5a7d; transform: scale(1.02);}
        .btn-back {
            background: #f1f5f9;
            color: #1e293b;
            border: none;
            border-radius: 40px;
            padding: 12px 28px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none;
            text-align: center;
            transition: 0.2s;
        }
        .btn-back:hover { background: #e2e8f0; }

        /* SAAT PRINT: WATERMARK MUNCUL DI SETIAP HALAMAN */
        @media print {
            .print-actions { display: none !important; }
            body { background: #fff; margin:0; padding:0; }
            .page {
                margin: 0;
                /* padding: 10mm 10mm; */
                width: 100%;
                box-shadow: none;
                border-radius: 0;
                page-break-after: avoid;
                break-inside: avoid;
            }

            /* WATERMARK AKAN MUNCUL DI SETIAP HALAMAN */
            .watermark-stempel {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-25deg);
                z-index: 999;
                opacity: 0.12;
                pointer-events: none;
                width: 500px;
                height: 500px;
                display: flex;
                align-items: center;
                justify-content: center;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

    </style>

    {{-- <script>
        (function() {
            let namaPeserta = "{{ $peserta->nama }}";
            let cleanNama = namaPeserta.replace(/[\/\\:*?"<>|]/g, '').trim();
            let judulFile = `Laporan_DASS_${cleanNama}`;
            function setPrintTitle() { document.title = judulFile; }
            setPrintTitle();
            window.addEventListener('beforeprint', function() { document.title = judulFile; });
            window.addEventListener('afterprint', function() {
                document.title = "Laporan DASS — {{ $peserta->nama }}";
            });
        })(); --}}
    {{-- </script> --}}
</head>

<body>
{{-- <div class="page-header-nama" style="display: none;">
    Laporan DASS — {{ $peserta->nama }}
</div> --}}

{{-- <div class="watermark-stempel">
    @if(isset($stempel) && $stempel)
        <img src="{{ $stempel }}" alt="Watermark">
    @else
        <div style="font-size: 80pt; color: #ccc; font-weight: bold; font-family: sans-serif;">ARIVA</div>
    @endif
</div> --}}

<div class="print-actions">
    <button class="btn-print" onclick="window.print()">
        🖨️ Cetak / Simpan PDF
    </button>
    <a href="{{ route('admin.peserta.detail', $peserta->id) }}" class="btn-back">
        ← Kembali
    </a>
</div>


<div class="page">
    <!-- WATERMARK STEMPEL -->
    <div class="watermark-stempel">
        @if(isset($stempel) && $stempel)
            <img src="{{ $stempel }}" alt="Stempel Watermark">
        @else
            <div class="placeholder-watermark">⦿</div>
        @endif
    </div>

    <div class="content">
        <div class="kop-surat">
            <div class="kop-logo">
                @if(isset($logo_kiri) && $logo_kiri)
                    <img src="{{ $logo_kiri }}" alt="Logo">
                @endif
            </div>
            <div class="kop-detail">
                <div class="nama-pt">{{ $settings->nama_biro ?? 'PT. ARIVA KONSULTAMA INDONESIA' }}</div>
                <div class="sk-kemkumham">SK KEMENKUMHAM: AHU-051596.AH.01.30.2024</div>
                <div class="nama-biro">BIRO PSIKOLOGI {{ $settings->nama_biro ?? 'ARIVA CONSULTA' }}</div>
                <div class="alamat-kontak">
                    {{ $settings->alamat ?? 'Jl. H. Syukur V RT 25 RW XI No.5 Sedati – Sidoarjo' }}<br>
                    Telp : {{ $settings->no_telp ?? '085857176646' }} - Email: {{ $settings->email ?? 'arivaconsulta@gmail.com' }}
                </div>
            </div>
        </div>

        <div class="label-rahasia-container">
            <div class="label-rahasia">R A H A S I A</div>
        </div>

        <div style="text-align: center; margin: 12px 0 15px 0;">
            <div style="font-size: 14pt; font-weight: bold; font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.4;">
                LAPORAN HASIL PEMERIKSAAN PSIKOLOGIS<br>
                <i style="font-weight: bold;">MENTAL HEALTH CHECK UP</i>
            </div>

            {{-- Bagian Nama Peserta --}}
            {{-- <div style="font-size: 13pt; font-weight: 500; margin-top: 6px;">
                a.n. {{ $peserta->nama }}
            </div> --}}

            {{-- Garis Pemisah (Opsional, aktifkan jika ingin tampilan lebih formal) --}}
            <div style="height: 2px; width: 100px; background: #000; margin: 8px auto;"></div>
        </div>

        <div class="section-header">I. Identitas</div>
        <table class="tabel-biodata">
            <tr>
                <td class="col-label">Nama</td><td class="col-titik">:</td><td class="col-value">{{ $peserta->nama }}</td>
                <td class="col-label">Status</td><td class="col-titik">:</td><td class="col-value">{{ $peserta->status_perkawinan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td><td>:</td><td>{{ $peserta->jenis_kelamin }}</td>
                <td>Pekerjaan</td><td>:</td><td>{{ $peserta->pekerjaan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td><td>:</td><td>{{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                <td>Pendidikan</td><td>:</td><td>{{ $peserta->pendidikan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Usia</td><td>:</td><td>{{ $peserta->usia }} </td>
                <td>No. Telepon</td><td>:</td><td>{{ $peserta->no_telp ?? '-' }}</td>
            </tr>
            <tr>
                <td>Alamat</td><td>:</td><td colspan="4">{{ $peserta->alamat ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-header">II. Tujuan Konsultasi</div>
        <table class="tabel-biodata">
            <tr><td style="width: 22%;">Tujuan Konsultasi</td><td style="width: 3%;">:</td><td>{{ $peserta->tujuan_konsultasi ?? '-' }}</td></tr>
            <tr><td>Yang Dirasakan</td><td>:</td><td>{{ $peserta->yang_dirasakan ?? '-' }}</td></tr>
            <tr><td>Permasalahan</td><td>:</td><td>{{ $peserta->permasalahan ?? '-' }}</td></tr>
        </table>

        <div class="section-header">III. Hasil Tes DASS</div>
        <table class="tabel-hasil">
            <thead>
                <tr><th style="width:50%;">Aspek</th> <th>Kategori</th></tr>
            </thead>
            <tbody>
                @php
                    $kategoris = [
                        'depresi' => $hasil->kategori_depresi ?? 'Normal',
                        'kecemasan' => $hasil->kategori_kecemasan ?? 'Normal',
                        'stres' => $hasil->kategori_stres ?? 'Normal'
                    ];
                    function getWarna($kat) {
                        return match($kat) {
                            'Ringan' => 'kategori-ringan',
                            'Sedang' => 'kategori-sedang',
                            'Tinggi' => 'kategori-tinggi',
                            'Sangat Tinggi' => 'kategori-sangat-tinggi',
                            default => 'kategori-normal'
                        };
                    }
                @endphp
                <tr><td class="label">Depresi</td><td class="{{ getWarna($kategoris['depresi']) }}">{{ $kategoris['depresi'] }}</td></tr>
                <tr><td class="label">Kecemasan</td><td class="{{ getWarna($kategoris['kecemasan']) }}">{{ $kategoris['kecemasan'] }}</td></tr>
                <tr><td class="label">Stres</td><td class="{{ getWarna($kategoris['stres']) }}">{{ $kategoris['stres'] }}</td></tr>
            </tbody>
        </table>

        {{-- <p style="font-size:10pt; margin-bottom:6px;"><strong>Tabel Norma Kategorisasi DASS:</strong></p>
        <table class="tabel-norma">
            <thead>
                <tr><th>Kategori</th><th>Depresi</th><th>Kecemasan</th><th>Stres</th></tr>
            </thead>
            <tbody>
                <tr><td>Normal</td><td>0 – 9</td><td>0 – 7</td><td>0 – 14</td></tr>
                <tr><td>Ringan</td><td>10 – 13</td><td>8 – 9</td><td>15 – 18</td></tr>
                <tr><td>Sedang</td><td>14 – 20</td><td>10 – 14</td><td>19 – 25</td></tr>
                <tr><td>Tinggi</td><td>21 – 27</td><td>15 – 19</td><td>26 – 33</td></tr>
                <tr><td>Sangat Tinggi</td><td>≥ 28</td><td>≥ 20</td><td>≥ 34</td></tr>
            </tbody>
        </table> --}}

        <!-- SECTION IV. DINAMIKA PSIKOLOGIS -->
        <div class="section-header">IV. Dinamika Psikologis</div>
        <div class="narasi-box">
            @if(!empty($hasil->dinamika_psikologis))
                @php
                    // Decode JSON menjadi array
                    $dinamikaData = json_decode($hasil->dinamika_psikologis, true);
                @endphp

                @if(is_array($dinamikaData))
                    @foreach($dinamikaData as $key => $text)
                        @if(!empty($text))
                            <p>{{ $text }}</p>
                        @endif
                    @endforeach
                @else
                    {{-- Fallback jika ternyata data bukan JSON (plain text) --}}
                    @foreach(explode("\n", $hasil->dinamika_psikologis) as $para)
                        @if(trim($para)) <p>{{ trim($para) }}</p> @endif
                    @endforeach
                @endif
            @else
                <p style="text-align:center;"><em>— Data belum tersedia —</em></p>
            @endif
        </div>

        <!-- SECTION V. SARAN & REKOMENDASI -->
        <div class="section-header">V. Saran & Rekomendasi</div>
        <div class="narasi-box">
            @if(!empty($hasil->saran_rekomendasi))
                @php
                    $saranData = json_decode($hasil->saran_rekomendasi, true);
                @endphp

                @if(is_array($saranData))
                    @foreach($saranData as $scale => $text)
                        @if(!empty($text))
                            <p>{{ $text }}</p>
                        @endif
                    @endforeach
                @else
                    {{-- Fallback jika plain text --}}
                    @foreach(explode("\n", $hasil->saran_rekomendasi) as $para)
                        @if(trim($para)) <p>{{ trim($para) }}</p> @endif
                    @endforeach
                @endif
            @else
                <p style="text-align:center;"><em>— Data belum tersedia —</em></p>
            @endif
        </div>

        <div class="ttd-wrapper">
            <div class="ttd-box">
                <div style="margin-bottom: 5px;">Sidoarjo, {{ \Carbon\Carbon::parse($peserta->tanggal_pemeriksaan)->translatedFormat('d F Y') }}</div>
                <div style="margin-bottom: 5px; font-weight: 500; font-weight: bold;">Psikolog Pemeriksa,</div>
                <div class="ttd-image">
                    @if(isset($ttd_psikolog) && $ttd_psikolog)
                        <img src="{{ $ttd_psikolog }}" alt="Tanda Tangan">
                    @endif
                </div>
                <div class="nama-psikolog">M. Ulul Albab. S.Psi., Psikolog., CH., CFHA., CPHRM.</div>
                <div style="font-size: 9pt;">SILP 3ABDF6343263</div>
            </div>
        </div>

        <!-- FOOTER -->
        {{-- <div class="garis-tebal" style="margin-top: 30px;"></div> --}}
        <div style="text-align:center; font-size:9pt; color:#4b5563; margin-top: 8px;">
            Dokumen ini bersifat RAHASIA dan hanya diperuntukkan bagi yang bersangkutan.<br>
            Biro Psikologi Ariva Consulta — Sidoarjo
        </div>
    </div>
</div>

</body>
</html>
