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


<div class="sidebar">
    <div class="sidebar-brand">
        <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Ariva" style="height:50px; object-fit:contain; background:#fff; border-radius:6px; padding:2px 4px;">
        <div style="color:rgba(255,255,255,0.5); font-size:0.75rem; margin-top:6px;">Panel Admin DASS-42</div>
    </div>
    <div class="sidebar-menu">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-item">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <a href="<?php echo e(route('admin.peserta.list')); ?>" class="sidebar-item">
            <i class="bi bi-people-fill"></i> Data Peserta
        </a>
        <a href="<?php echo e(route('admin.berita.index')); ?>" class="sidebar-item">
            <i class="bi bi-newspaper"></i> Berita & Kegiatan
        </a>
        <a href="<?php echo e(route('admin.pengaturan.edit')); ?>" class="sidebar-item active">
            <i class="bi bi-gear-fill"></i> Pengaturan Web
        </a>
    </div>
    <div class="sidebar-logout">
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit" class="sidebar-item w-100 border-0 bg-transparent text-start" style="color:rgba(255,255,255,0.6);">
                <i class="bi bi-box-arrow-left"></i> Keluar
            </button>
        </form>
    </div>
</div>


<div class="main-content">

    
    <div class="topbar">
        <div>
            <h5 class="fw-bold mb-0 text-dark">Pengaturan Web</h5>
            <small class="text-secondary">Kelola profil biro dan konten landing page</small>
        </div>
        <div class="text-secondary small">
            <i class="bi bi-calendar3 me-1"></i><?php echo e(now()->translatedFormat('d F Y')); ?>

        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.pengaturan.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="section-title">Informasi Biro & Kontak</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Biro Psikologi</label>
                            <input type="text" name="nama_biro" class="form-control <?php $__errorArgs = ['nama_biro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('nama_biro', $settings->nama_biro ?? '')); ?>">
                            <?php $__errorArgs = ['nama_biro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Kantor</label>
                            <textarea name="alamat" rows="3" class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('alamat', $settings->alamat ?? '')); ?></textarea>
                            <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor WhatsApp/Telepon</label>
                                <input type="text" name="no_telp" class="form-control <?php $__errorArgs = ['no_telp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('no_telp', $settings->no_telp ?? '')); ?>">
                                <?php $__errorArgs = ['no_telp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email', $settings->email ?? '')); ?>">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username Instagram (Tanpa @)</label>
                            <input type="text" name="instagram" class="form-control <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('instagram', $settings->instagram ?? '')); ?>">
                            <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="section-title mt-4">Konten Landing Page</div>

                        <div class="mb-3">
                            <label class="form-label">Headline (Judul Utama)</label>
                            <input type="text" name="headline" class="form-control <?php $__errorArgs = ['headline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('headline', $settings->headline ?? '')); ?>">
                            <?php $__errorArgs = ['headline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sub-headline (Judul Pendukung)</label>
                            <input type="text" name="sub_headline" class="form-control <?php $__errorArgs = ['sub_headline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('sub_headline', $settings->sub_headline ?? '')); ?>">
                            <?php $__errorArgs = ['sub_headline'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="4" class="form-control <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('deskripsi', $settings->deskripsi ?? '')); ?></textarea>
                            <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="section-title">Logo & Lampiran Laporan (Maks 10MB)</div>

                        <!-- LOGO BIRO -->
                        <div class="mb-4">
                            <label class="form-label d-block">Logo Kiri Kop Surat</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <?php if($settings && $settings->logo): ?>
                                    <img src="<?php echo e(asset($settings->logo)); ?>" class="preview-asset" id="previewLogo">
                                <?php else: ?>
                                    <div class="preview-asset bg-light d-flex align-items-center justify-content-center text-secondary" id="previewLogo" style="width:100px; height:100px;">
                                        <i class="bi bi-image fs-4"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <input type="file" name="logo" class="form-control form-control-sm <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" onchange="previewImage(this, 'previewLogo')">
                                    <?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted d-block mt-1">Gunakan gambar rasio persegi atau horizontal.</small>
                                </div>
                            </div>
                        </div>

                        <!-- TANDA TANGAN PSIKOLOG -->
                        <div class="mb-4">
                            <label class="form-label d-block">Tanda Tangan Psikolog</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <?php if($settings && $settings->ttd_psikolog): ?>
                                    <img src="<?php echo e(asset($settings->ttd_psikolog)); ?>" class="preview-asset" id="previewTtd">
                                <?php else: ?>
                                    <div class="preview-asset bg-light d-flex align-items-center justify-content-center text-secondary" id="previewTtd" style="width:100px; height:100px;">
                                        <i class="bi bi-pen fs-4"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <input type="file" name="ttd_psikolog" class="form-control form-control-sm <?php $__errorArgs = ['ttd_psikolog'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" onchange="previewImage(this, 'previewTtd')">
                                    <?php $__errorArgs = ['ttd_psikolog'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted d-block mt-1">Saran: gunakan background transparan (PNG).</small>
                                </div>
                            </div>
                        </div>

                        <!-- STEMPEL BIRO -->
                        <div class="mb-4">
                            <label class="form-label d-block">Stempel Biro (Watermark & Laporan)</label>
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <?php if($settings && $settings->stempel): ?>
                                    <img src="<?php echo e(asset($settings->stempel)); ?>" class="preview-asset" id="previewStempel">
                                <?php else: ?>
                                    <div class="preview-asset bg-light d-flex align-items-center justify-content-center text-secondary" id="previewStempel" style="width:100px; height:100px;">
                                        <i class="bi bi-patch-check fs-4"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-grow-1">
                                    <input type="file" name="stempel" class="form-control form-control-sm <?php $__errorArgs = ['stempel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/*" onchange="previewImage(this, 'previewStempel')">
                                    <?php $__errorArgs = ['stempel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php /**PATH C:\laragon\www\dass-app\resources\views/admin/pengaturan.blade.php ENDPATH**/ ?>