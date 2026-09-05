@extends('layouts.app')

@section('title', 'Tes DASS — Ariva Consulta')

@section('styles')
<style>
    .step-indicator {
        display: flex; align-items: center; justify-content: center;
        gap: 0; margin-bottom: 32px;
    }
    .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
    .step-circle {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; font-size: 0.9rem;
        border: 2px solid #e2e8f0; background: #fff; color: #94a3b8;
    }
    .step.active .step-circle { background: linear-gradient(135deg, #1a56db, #1e40af); border-color: #1a56db; color: #fff; }
    .step.done .step-circle  { background: #d1fae5; border-color: #10b981; color: #065f46; }
    .step-label { font-size: 0.75rem; font-weight: 600; color: #94a3b8; }
    .step.active .step-label { color: #1a56db; }
    .step.done .step-label   { color: #10b981; }
    .step-line { flex: 1; height: 2px; background: #e2e8f0; margin: 0 8px; margin-bottom: 22px; }

    /* PROGRESS */
    .progress { height: 10px; border-radius: 10px; background: #e2e8f0; }
    .progress-bar { background: linear-gradient(90deg, #1a56db, #6366f1); border-radius: 10px; transition: width 0.4s ease; }

    /* HALAMAN SOAL */
    .halaman-soal { display: none; animation: fadeIn 0.3s ease; }
    .halaman-soal.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

    /* SOAL ITEM */
    .soal-item { margin-bottom: 28px; padding-bottom: 28px; border-bottom: 1.5px solid #f1f5f9; }
    .soal-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

    .soal-nomor {
        font-size: 0.75rem; font-weight: 700; color: #1a56db;
        text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px;
    }
    .soal-teks {
        font-size: 1rem; font-weight: 600; color: #1e293b;
        line-height: 1.6; margin-bottom: 14px;
    }

    /* PILIHAN JAWABAN */
    .pilihan-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; }

    @media (max-width: 600px) {
        .pilihan-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .pilihan-label {
        cursor: pointer; border: 2px solid #e2e8f0; border-radius: 10px;
        padding: 10px 8px; text-align: center; transition: all 0.2s;
        background: #fff; position: relative;
    }
    .pilihan-label:hover { border-color: #1a56db; background: #eff6ff; }
    .pilihan-label input[type="radio"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
        margin: 0;
    }
    .pilihan-label.selected {
        border-color: #1a56db;
        background: linear-gradient(135deg, #eff6ff, #e0e7ff);
        box-shadow: 0 2px 10px rgba(26,86,219,0.15);
    }
    .pilihan-skor { font-size: 1.3rem; font-weight: 800; color: #1a56db; display: block; margin-bottom: 2px; }
    .pilihan-teks { font-size: 0.75rem; font-weight: 600; color: #64748b; line-height: 1.3; }
    .pilihan-label.selected .pilihan-teks { color: #1e40af; }

    /* WARNING */
    .soal-warning { display: none; color: #dc2626; font-size: 0.82rem; font-weight: 600; margin-top: 8px; }
    .soal-warning.show { display: block; }

    /* NAV */
    .btn-nav { border-radius: 10px; font-weight: 600; padding: 10px 24px; border: none; }
    .btn-prev { background: #f1f5f9; color: #475569; }
    .btn-prev:hover { background: #e2e8f0; }
    .btn-next { background: linear-gradient(135deg, #1a56db, #1e40af); color: #fff; }
    .btn-next:hover { opacity: 0.9; transform: translateY(-1px); }
    .btn-submit { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
    .btn-submit:hover { opacity: 0.9; }

    .petunjuk-box {
        background: #eff6ff; border: 1.5px solid #bfdbfe;
        border-radius: 12px; padding: 14px 18px; margin-bottom: 24px;
    }

    /* HALAMAN INDICATOR */
    .page-dots { display: flex; gap: 6px; justify-content: center; margin-bottom: 16px; }
    .page-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #e2e8f0; transition: all 0.3s;
    }
    .page-dot.active { background: #1a56db; width: 20px; border-radius: 4px; }
    .page-dot.done   { background: #10b981; }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 700px;">

    {{-- STEP INDICATOR --}}
    <div class="step-indicator">
        <div class="step done">
            <div class="step-circle"><i class="bi bi-check-lg"></i></div>
            <span class="step-label">Biodata</span>
        </div>
        <div class="step-line"></div>
        <div class="step active">
            <div class="step-circle">2</div>
            <span class="step-label">Tes DASS</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <span class="step-label">Hasil</span>
        </div>
    </div>

    {{-- PETUNJUK --}}
    <div class="petunjuk-box">
        <div class="d-flex align-items-start gap-2">
            <i class="bi bi-info-circle-fill text-primary mt-1 flex-shrink-0"></i>
            <div>
                <strong class="text-primary">Petunjuk Pengisian</strong><br>
                <small class="text-secondary">
                    Pilih jawaban yang paling sesuai kondisi Anda <strong>selama seminggu terakhir</strong>.
                    Tidak ada jawaban benar atau salah. Setiap halaman berisi 5 pernyataan.
                </small>
            </div>
        </div>
    </div>

    {{-- PROGRESS --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
        <small class="fw-bold text-secondary">Halaman <span id="halamanInfo">1</span> dari <span id="totalHalaman">9</span></small>
        <small class="fw-bold text-primary" id="persenTeks">0%</small>
    </div>
    <div class="progress mb-3">
        <div class="progress-bar" id="progressBar" style="width: 0%"></div>
    </div>

    {{-- PAGE DOTS --}}
    <div class="page-dots" id="pageDots"></div>

    {{-- FORM TES --}}
    <form action="{{ route('tes.simpan') }}" method="POST" id="formTes">
        @csrf
        <input type="hidden" name="peserta_id" value="{{ $peserta->id }}">

        <div class="card">
            <div class="card-body p-4">

                @php
                    $soalPerHalaman = 5;
                    $totalSoal = count($soal);
                    $totalHalaman = ceil($totalSoal / $soalPerHalaman);
                    $soalArray = array_values(array_map(null, array_keys($soal), array_values($soal)));
                @endphp

                @for($h = 0; $h < $totalHalaman; $h++)
                <div class="halaman-soal {{ $h === 0 ? 'active' : '' }}" id="halaman-{{ $h }}">

                    @for($s = 0; $s < $soalPerHalaman; $s++)
                        @php
                            $idx = $h * $soalPerHalaman + $s;
                            if ($idx >= $totalSoal) break;
                            $no = $soalArray[$idx][0];
                            $pertanyaan = $soalArray[$idx][1];
                        @endphp

                        <div class="soal-item">
                            <div class="soal-nomor">Pernyataan {{ $no }}</div>
                            <div class="soal-teks">{{ $pertanyaan }}</div>
                            <div class="pilihan-grid">
                                @foreach([0 => 'Tidak Pernah', 1 => 'Kadang-kadang', 2 => 'Sering', 3 => 'Hampir Selalu'] as $nilai => $label)
                                <label class="pilihan-label" id="label-{{ $no }}-{{ $nilai }}">
                                    <input type="radio" name="soal_{{ $no }}" value="{{ $nilai }}"
                                        onchange="pilihanDipilih({{ $no }}, this)">
                                   <span class="pilihan-teks" style="font-size:0.88rem;">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                            <div class="soal-warning" id="warning-{{ $no }}">
                                <i class="bi bi-exclamation-triangle me-1"></i>Wajib dijawab sebelum lanjut.
                            </div>
                        </div>

                    @endfor
                </div>
                @endfor

            </div>

            {{-- NAVIGASI --}}
            <div class="card-footer bg-white border-0 px-4 pb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-nav btn-prev d-none" id="btnPrev" onclick="prevHalaman()">
                        <i class="bi bi-arrow-left me-2"></i>Sebelumnya
                    </button>
                    <div></div>
                    <button type="button" class="btn btn-nav btn-next" id="btnNext" onclick="nextHalaman()">
                        Selanjutnya <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                    <button type="submit" class="btn btn-nav btn-submit d-none" id="btnSubmit">
                        <i class="bi bi-check-circle me-2"></i>Selesai & Lihat Hasil
                    </button>
                </div>
            </div>
        </div>

    </form>

    <p class="text-center text-secondary small mt-3">
        <i class="bi bi-person me-1"></i>{{ $peserta->nama }}
    </p>

</div>
@endsection

@section('scripts')
<script>
    const SOAL_PER_HALAMAN = 5;
    const TOTAL_SOAL = {{ count($soal) }};
    const TOTAL_HALAMAN = Math.ceil(TOTAL_SOAL / SOAL_PER_HALAMAN);

    // Mapping halaman ke nomor soal
    @php
        $halamanSoal = [];
        $soalKeys = array_keys($soal);
        $totalHalamanPHP = ceil(count($soalKeys) / 5);
        for($h = 0; $h < $totalHalamanPHP; $h++) {
            $halamanSoal[$h] = array_slice($soalKeys, $h * 5, 5);
        }
    @endphp
    const halamanSoal = @json($halamanSoal);

    let currentHalaman = 0;
    const jawaban = {};

    // Init page dots
    function initDots() {
        const container = document.getElementById('pageDots');
        document.getElementById('totalHalaman').textContent = TOTAL_HALAMAN;
        for (let i = 0; i < TOTAL_HALAMAN; i++) {
            const dot = document.createElement('div');
            dot.className = 'page-dot' + (i === 0 ? ' active' : '');
            dot.id = 'dot-' + i;
            container.appendChild(dot);
        }
    }

    function updateDots() {
        for (let i = 0; i < TOTAL_HALAMAN; i++) {
            const dot = document.getElementById('dot-' + i);
            dot.className = 'page-dot';
            if (i < currentHalaman) dot.classList.add('done');
            else if (i === currentHalaman) dot.classList.add('active');
        }
    }

    function updateProgress() {
        const soalSelesai = currentHalaman * SOAL_PER_HALAMAN;
        const persen = Math.round((soalSelesai / TOTAL_SOAL) * 100);
        document.getElementById('progressBar').style.width = persen + '%';
        document.getElementById('persenTeks').textContent = persen + '%';
        document.getElementById('halamanInfo').textContent = currentHalaman + 1;
    }

    function pilihanDipilih(no, input) {
        for (let i = 0; i <= 3; i++) {
            const el = document.getElementById('label-' + no + '-' + i);
            if (el) el.classList.remove('selected');
        }
        input.closest('.pilihan-label').classList.add('selected');
        jawaban[no] = input.value;
        document.getElementById('warning-' + no).classList.remove('show');
    }

    function validasiHalaman(h) {
        const soalHalaman = halamanSoal[h];
        let valid = true;
        soalHalaman.forEach(no => {
            if (jawaban[no] === undefined) {
                document.getElementById('warning-' + no).classList.add('show');
                valid = false;
            }
        });
        return valid;
    }

    function nextHalaman() {
        if (!validasiHalaman(currentHalaman)) {
            // Scroll ke warning pertama
            const firstWarning = document.querySelector('.soal-warning.show');
            if (firstWarning) firstWarning.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        document.getElementById('halaman-' + currentHalaman).classList.remove('active');
        currentHalaman++;
        document.getElementById('halaman-' + currentHalaman).classList.add('active');
        updateProgress();
        updateDots();
        updateButtons();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function prevHalaman() {
        document.getElementById('halaman-' + currentHalaman).classList.remove('active');
        currentHalaman--;
        document.getElementById('halaman-' + currentHalaman).classList.add('active');
        updateProgress();
        updateDots();
        updateButtons();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateButtons() {
        const btnPrev   = document.getElementById('btnPrev');
        const btnNext   = document.getElementById('btnNext');
        const btnSubmit = document.getElementById('btnSubmit');

        currentHalaman > 0 ? btnPrev.classList.remove('d-none') : btnPrev.classList.add('d-none');

        if (currentHalaman === TOTAL_HALAMAN - 1) {
            btnNext.classList.add('d-none');
            btnSubmit.classList.remove('d-none');
        } else {
            btnNext.classList.remove('d-none');
            btnSubmit.classList.add('d-none');
        }
    }

    // Validasi sebelum submit
    document.getElementById('formTes').addEventListener('submit', function(e) {
        if (!validasiHalaman(currentHalaman)) {
            e.preventDefault();
            const firstWarning = document.querySelector('.soal-warning.show');
            if (firstWarning) firstWarning.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            // Menonaktifkan tombol untuk mencegah double click dan menampilkan loading spinner
            const btnSubmit = document.getElementById('btnSubmit');
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sedang Memproses...';
            
            // Menonaktifkan tombol sebelumnya juga agar user tidak berpindah halaman saat proses
            const btnPrev = document.getElementById('btnPrev');
            if (btnPrev) btnPrev.disabled = true;
        }
    });

    // Init
    initDots();
    updateProgress();
    updateButtons();
</script>
@endsection
