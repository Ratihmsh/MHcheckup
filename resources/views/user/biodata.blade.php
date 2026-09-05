@extends('layouts.app')

@section('title', 'Isi Biodata — DASS Ariva Consulta')

@section('styles')
<style>
    .step-indicator {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 32px;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .step-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        border: 2px solid #e2e8f0;
        background: #fff;
        color: #94a3b8;
    }

    .step.active .step-circle {
        background: linear-gradient(135deg, #1a56db, #1e40af);
        border-color: #1a56db;
        color: #fff;
    }

    .step.done .step-circle {
        background: #d1fae5;
        border-color: #10b981;
        color: #065f46;
    }

    .step-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #94a3b8;
    }

    .step.active .step-label { color: #1a56db; }
    .step.done .step-label   { color: #10b981; }

    .step-line {
        flex: 1;
        height: 2px;
        background: #e2e8f0;
        margin: 0 8px;
        margin-bottom: 22px;
    }

    .section-title {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #1a56db;
        border-bottom: 2px solid #e0e7ff;
        padding-bottom: 8px;
        margin-bottom: 20px;
        margin-top: 8px;
    }

    .required-star {
        color: #ef4444;
        margin-left: 2px;
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 700px;">

    {{-- STEP INDICATOR --}}
    <div class="step-indicator">
        <div class="step active">
            <div class="step-circle">1</div>
            <span class="step-label">Biodata</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">2</div>
            <span class="step-label">Tes DASS</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-circle">3</div>
            <span class="step-label">Hasil</span>
        </div>
    </div>

    {{-- CARD UTAMA --}}
    <div class="card">
        <div class="card-header-blue">
            <h5 class="text-white fw-bold mb-1">
                <i class="bi bi-person-fill me-2"></i>Formulir Biodata
            </h5>
            <p class="text-white-50 small mb-0">Lengkapi data diri Anda sebelum memulai tes</p>
        </div>

        <div class="card-body p-4">

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Mohon periksa kembali:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('biodata.simpan') }}" method="POST">
                @csrf

                {{-- DATA PRIBADI --}}
                <div class="section-title">Data Pribadi</div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="required-star">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        placeholder="Masukkan nama lengkap" value="{{ old('nama') }}" required>
                    @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin <span class="required-star">*</span></label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir <span class="required-star">*</span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Usia <span class="required-star">*</span></label>
                        <input type="text" name="usia" id="usia"
                            class="form-control @error('usia') is-invalid @enderror"
                            placeholder="_Tahun _Bulan" value="{{ old('usia') }}" readonly required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Status Perkawinan</label>
                        <select name="status_perkawinan" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="Belum Menikah" {{ old('status_perkawinan') == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Menikah" {{ old('status_perkawinan') == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                            <option value="Cerai" {{ old('status_perkawinan') == 'Cerai' ? 'selected' : '' }}>Cerai</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir <span class="required-star">*</span></label>
                        <select name="pendidikan" class="form-select @error('pendidikan') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="SMP" {{ old('pendidikan') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('pendidikan') == 'SMA' ? 'selected' : '' }}>SMA</option>
                            <option value="D3" {{ old('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                        </select>
                        @error('pendidikan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pekerjaan</label>
                        <input type="text" name="pekerjaan" class="form-control"
                            placeholder="Contoh: Mahasiswa, Karyawan" value="{{ old('pekerjaan') }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="no_telp" class="form-control"
                            placeholder="Contoh: 081234567890" value="{{ old('no_telp') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tujuan Konsultasi</label>

                        <select name="tujuan_konsultasi" id="tujuan_konsultasi" class="form-select" onchange="handleLainnya(this)">
                            <option value="">-- Pilih Tujuan --</option>
                            <option value="Pasangan">Pasangan</option>
                            <option value="Perkuliahan">Perkuliahan</option>
                            <option value="Pertemanan">Pertemanan</option>
                            <option value="Keluarga">Keluarga</option>
                            <option value="Tumbuh Kembang">Tumbuh Kembang</option>
                            <option value="Masalah seksual">Masalah seksual</option>
                            <option value="Pribadi">Pribadi</option>
                            <option value="lainnya">Lain - lain</option>
                        </select>

                        <!-- Input tambahan -->
                        <input type="text" id="input_lainnya" class="form-control mt-2 d-none"
                            placeholder="Isi tujuan lainnya...">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"
                        placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                </div>

                {{-- TUJUAN KONSULTASI --}}
                <div class="section-title mt-4">Tujuan Konsultasi</div>

                <div class="mb-3">
                    <label class="form-label">Permasalahan yang Dihadapi</label>
                    <textarea name="permasalahan" class="form-control" rows="3"
                        placeholder="Ceritakan permasalahan yang sedang Anda hadapi...">{{ old('permasalahan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Yang Dirasakan Saat Ini</label>
                    <textarea name="yang_dirasakan" class="form-control" rows="3"
                        placeholder="Apa yang Anda rasakan saat ini?">{{ old('yang_dirasakan') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Harapan ke Depan</label>
                    <textarea name="harapan" class="form-control" rows="3"
                        placeholder="Apa harapan Anda setelah konsultasi ini?">{{ old('harapan') }}</textarea>
                </div>

                {{-- SUBMIT --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">
                        Lanjut ke Tes <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- INFO --}}
    <div class="alert alert-info mt-3 d-flex align-items-start gap-2">
        <i class="bi bi-shield-lock-fill mt-1 flex-shrink-0"></i>
        <div>
            <strong>Kerahasiaan Data</strong><br>
            <small>Data yang Anda isi bersifat rahasia dan hanya digunakan untuk keperluan pemeriksaan psikologis oleh tim Ariva Consulta.</small>
        </div>
    </div>

</div>

<script>
function handleLainnya(select) {
    const input = document.getElementById('input_lainnya');

    if (select.value === 'lainnya') {
        input.classList.remove('d-none');
        input.setAttribute('name', 'tujuan_konsultasi');
    } else {
        input.classList.add('d-none');
        input.removeAttribute('name');
    }
}
document.getElementById('tanggal_lahir').addEventListener('change', function () {
    const birthDate = new Date(this.value);
    const today = new Date();

    if (!this.value) return;

    let years = today.getFullYear() - birthDate.getFullYear();
    let months = today.getMonth() - birthDate.getMonth();

    if (months < 0) {
        years--;
        months += 12;
    }

    // kalau hari belum lewat, kurangi 1 bulan
    if (today.getDate() < birthDate.getDate()) {
        months--;
        if (months < 0) {
            years--;
            months += 12;
        }
    }

    document.getElementById('usia').value = `${years} Tahun ${months} Bulan`;
});
</script>
@endsection
