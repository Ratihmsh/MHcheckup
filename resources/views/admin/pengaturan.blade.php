<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Web — Ariva Consulta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f0f4f8; }

        .sidebar { width: 240px; min-height: 100vh; background: linear-gradient(180deg, #1e3a8a 0%, #1a56db 100%); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 24px 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-menu { padding: 16px 0; }
        .sidebar-item { display: flex; align-items: center; gap: 12px; padding: 12px 20px; color: rgba(255,255,255,0.7); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; }
        .sidebar-item:hover, .sidebar-item.active { background: rgba(255,255,255,0.15); color: #fff; }
        .sidebar-item i { font-size: 1.1rem; }
        .sidebar-logout { position: absolute; bottom: 0; left: 0; right: 0; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1); }

        .main-content { margin-left: 240px; padding: 28px; min-height: 100vh; }
        .topbar { background: #fff; border-radius: 14px; padding: 16px 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }

        .card { border: none; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); margin-bottom: 24px; }
        .section-title { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #1a56db; border-bottom: 2px solid #e0e7ff; padding-bottom: 8px; margin-bottom: 20px; }

        .form-control, .form-select { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.95rem; }
        .form-control:focus, .form-select:focus { border-color: #1a56db; box-shadow: 0 0 0 3px rgba(26,86,219,0.1); outline: none; }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 6px; }

        .btn-simpan { background: linear-gradient(135deg, #1a56db, #1e40af); color: #fff; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 700; font-size: 0.9rem; transition: all 0.2s; }
        .btn-simpan:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

        .preview-asset { max-height: 100px; max-width: 150px; border-radius: 8px; border: 1px solid #e2e8f0; padding: 4px; background: #fff; object-fit: contain; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('images/logo.jpg') }}" alt="Ariva" style="height:50px; object-fit:contain; background:#fff; border-radius:6px; padding:2px 4px;">
        <div style="color:rgba(255,255,255,0.5); font-size:0.75rem; margin-top:6px;">Panel Admin DASS-42</div>
    </div>
    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <a href="{{ route('admin.peserta.list') }}" class="sidebar-item">
            <i class="bi bi-people-fill"></i> Data Peserta
        </a>
        <a href="{{ route('admin.berita.index') }}" class="sidebar-item">
            <i class="bi bi-newspaper"></i> Berita & Kegiatan
        </a>
        <a href="{{ route('admin.pengaturan.edit') }}" class="sidebar-item active">
            <i class="bi bi-gear-fill"></i> Pengaturan Web
        </a>
    </div>
    <div class="sidebar-logout">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-item w-100 border-0 bg-transparent text-start" style="color:rgba(255,255,255,0.6);">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </div>
</div>

{{-- MAIN --}}
<div class="main-content">

    {{-- TOPBAR --}}
    <div class="topbar">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Pengaturan Web</h5>
            <small class="text-secondary">Kelola profil biro dan konten landing page</small>
        </div>
        <div class="text-secondary small">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- KOLOM KIRI: PROFIL BIRO --}}
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="section-title">Informasi Biro & Kontak</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Biro Psikologi</label>
                            <input type="text" name="nama_biro" class="form-control @error('nama_biro') is-invalid @enderror" value="{{ old('nama_biro', $settings->nama_biro ?? '') }}">
                            @error('nama_biro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Kantor</label>
                            <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $settings->alamat ?? '') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor WhatsApp/Telepon</label>
                                <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $settings->no_telp ?? '') }}">
                                @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings->email ?? '') }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username Instagram (Tanpa @)</label>
                            <input type="text" name="instagram" class="form-control @error('instagram') is-invalid @enderror" value="{{ old('instagram', $settings->instagram ?? '') }}">
                            @error('instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="section-title mt-4">Konten Landing Page</div>

                        <div class="mb-3">
                            <label class="form-label">Headline (Judul Utama)</label>
                            <input type="text" name="headline" class="form-control @error('headline') is-invalid @enderror" value="{{ old('headline', $settings->headline ?? '') }}">
                            @error('headline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub-headline (Judul Pendukung)</label>
                            <input type="text" name="sub_headline" class="form-control @error('sub_headline') is-invalid @enderror" value="{{ old('sub_headline', $settings->sub_headline ?? '') }}">
                            @error('sub_headline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $settings->deskripsi ?? '') }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: ASET MEDIA & TANDA TANGAN --}}
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="section-title">Logo & Lampiran Laporan (Maks 10MB)</div>

                        <!-- LOGO BIRO -->
                        <div class="mb-4">
                            <label class="form-label d-block">Logo Kiri Kop Surat</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($settings && $settings->logo)
                                    <img src="{{ asset($settings->logo) }}" class="preview-asset" id="previewLogo">
                                @else
                                    <div class="preview-asset bg-light d-flex align-items-center justify-content-center text-secondary" id="previewLogo" style="width:100px; height:100px;">
                                        <i class="bi bi-image fs-4"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control form-control-sm @error('logo') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'previewLogo')">
                                    @error('logo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    <small class="text-muted d-block mt-1">Gunakan gambar rasio persegi atau horizontal.</small>
                                </div>
                            </div>
                        </div>

                        <!-- TANDA TANGAN PSIKOLOG -->
                        <div class="mb-4">
                            <label class="form-label d-block">Tanda Tangan Psikolog</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($settings && $settings->ttd_psikolog)
                                    <img src="{{ asset($settings->ttd_psikolog) }}" class="preview-asset" id="previewTtd">
                                @else
                                    <div class="preview-asset bg-light d-flex align-items-center justify-content-center text-secondary" id="previewTtd" style="width:100px; height:100px;">
                                        <i class="bi bi-pen fs-4"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="ttd_psikolog" class="form-control form-control-sm @error('ttd_psikolog') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'previewTtd')">
                                    @error('ttd_psikolog')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    <small class="text-muted d-block mt-1">Saran: gunakan background transparan (PNG).</small>
                                </div>
                            </div>
                        </div>

                        <!-- STEMPEL BIRO -->
                        <div class="mb-4">
                            <label class="form-label d-block">Stempel Biro (Watermark & Laporan)</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                @if($settings && $settings->stempel)
                                    <img src="{{ asset($settings->stempel) }}" class="preview-asset" id="previewStempel">
                                @else
                                    <div class="preview-asset bg-light d-flex align-items-center justify-content-center text-secondary" id="previewStempel" style="width:100px; height:100px;">
                                        <i class="bi bi-patch-check fs-4"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="stempel" class="form-control form-control-sm @error('stempel') is-invalid @enderror" accept="image/*" onchange="previewImage(this, 'previewStempel')">
                                    @error('stempel')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    <small class="text-muted d-block mt-1">Saran: gunakan format warna stempel merah/biru transparan.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-simpan w-100 py-3">
                    <i class="bi bi-floppy-fill me-2"></i>Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    // Jika sebelumnya placeholder div, ubah menjadi image tag
                    const img = document.createElement('img');
                    img.id = previewId;
                    img.className = 'preview-asset';
                    img.src = e.target.result;
                    preview.replaceWith(img);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>
