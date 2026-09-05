<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita — Ariva Consulta</title>
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

        .card { border: none; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
        .section-title { font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #1a56db; border-bottom: 2px solid #e0e7ff; padding-bottom: 8px; margin-bottom: 20px; }

        .form-control { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 0.95rem; }
        .form-control:focus { border-color: #1a56db; box-shadow: 0 0 0 3px rgba(26,86,219,0.1); outline: none; }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #374151; margin-bottom: 6px; }

        .btn-simpan { background: linear-gradient(135deg, #1a56db, #1e40af); color: #fff; border: none; border-radius: 10px; padding: 10px 24px; font-weight: 700; font-size: 0.9rem; transition: all 0.2s; }
        .btn-simpan:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

        .btn-batal { background: #f1f5f9; color: #475569; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; transition: all 0.2s; }
        .btn-batal:hover { background: #e2e8f0; color: #334155; }

        #previewGambar { max-width: 100%; max-height: 250px; border-radius: 10px; border: 1px solid #e2e8f0; display: none; object-fit: cover; }
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
        <a href="{{ route('admin.berita.index') }}" class="sidebar-item active">
            <i class="bi bi-newspaper"></i> Berita & Kegiatan
        </a>
        <a href="{{ route('admin.pengaturan.edit') }}" class="sidebar-item">
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
            <h5 class="fw-bold mb-0 text-dark">Tambah Berita / Kegiatan</h5>
            <small class="text-secondary">Publikasikan informasi baru ke halaman depan user</small>
        </div>
        <a href="{{ route('admin.berita.index') }}" class="btn-batal">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    {{-- INPUT UTAMA --}}
                    <div class="col-lg-8">
                        <div class="mb-3">
                            <label class="form-label">Judul Berita / Kegiatan</label>
                            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" placeholder="Tuliskan judul berita...">
                            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Publish</label>
                            <input type="date" name="tanggal_publish" class="form-control @error('tanggal_publish') is-invalid @enderror" value="{{ old('tanggal_publish', date('Y-m-d')) }}">
                            @error('tanggal_publish')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Isi Berita / Caption Foto</label>
                            <textarea name="konten" rows="8" class="form-control @error('konten') is-invalid @enderror" placeholder="Tuliskan cerita, caption, atau informasi lengkap di sini...">{{ old('konten') }}</textarea>
                            @error('konten')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- FILE UPLOAD --}}
                    <div class="col-lg-4">
                        <div class="mb-4">
                            <label class="form-label">Upload Foto Berita (Maks 10MB)</label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" onchange="previewImage(this)">
                            @error('gambar')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-2">Dukungan format: JPG, PNG, GIF, WebP. Maksimal 10MB.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Preview Foto</label>
                            <div class="p-2 border rounded text-center bg-light" style="min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image fs-1 text-secondary" id="previewPlaceholder"></i>
                                <img id="previewGambar">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-top pt-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.berita.index') }}" class="btn-batal">Batal</a>
                    <button type="submit" class="btn-simpan">
                        <i class="bi bi-send-fill me-2"></i>Publikasikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function previewImage(input) {
        const preview = document.getElementById('previewGambar');
        const placeholder = document.getElementById('previewPlaceholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
            placeholder.style.display = 'block';
        }
    }
</script>
</body>
</html>
