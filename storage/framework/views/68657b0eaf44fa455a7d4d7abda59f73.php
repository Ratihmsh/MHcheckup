<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita & Kegiatan — Ariva Consulta</title>
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
        
        .btn-tambah {
            background: linear-gradient(135deg, #1a56db, #1e40af);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 20px; font-weight: 700; font-size: 0.9rem;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-tambah:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

        .btn-edit { color: #1e3a8a; background: #eff6ff; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; text-decoration: none; }
        .btn-edit:hover { background: #dbeafe; }
        
        .btn-hapus { color: #dc2626; background: #fef2f2; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; }
        .btn-hapus:hover { background: #fee2e2; }

        .berita-thumb { width: 70px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid #e2e8f0; }
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
        <a href="<?php echo e(route('admin.berita.index')); ?>" class="sidebar-item active">
            <i class="bi bi-newspaper"></i> Berita & Kegiatan
        </a>
        <a href="<?php echo e(route('admin.pengaturan.edit')); ?>" class="sidebar-item">
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
            <h5 class="fw-bold mb-0 text-dark">Berita & Kegiatan Biro</h5>
            <small class="text-secondary">Kelola daftar berita yang ditampilkan pada landing page user</small>
        </div>
        <a href="<?php echo e(route('admin.berita.create')); ?>" class="btn-tambah">
            <i class="bi bi-plus-lg"></i> Tambah Berita
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0" style="font-size: 0.9rem;">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 80px;">Foto</th>
                            <th>Judul Berita</th>
                            <th>Tanggal Terbit</th>
                            <th>Cuplikan Isi/Caption</th>
                            <th class="text-end pe-4" style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $berita; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <?php if($b->gambar): ?>
                                    <img src="<?php echo e(asset($b->gambar)); ?>" class="berita-thumb">
                                <?php else: ?>
                                    <div class="berita-thumb bg-light d-flex align-items-center justify-content-center text-secondary">
                                        <i class="bi bi-image"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold text-dark"><?php echo e($b->judul); ?></td>
                            <td><?php echo e(\Carbon\Carbon::parse($b->tanggal_publish)->translatedFormat('d/m/Y')); ?></td>
                            <td class="text-secondary">
                                <?php echo e(Str::limit(strip_tags($b->konten), 80)); ?>

                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="<?php echo e(route('admin.berita.edit', $b->id)); ?>" class="btn-edit">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <form action="<?php echo e(route('admin.berita.destroy', $b->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn-hapus">
                                            <i class="bi bi-trash3-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-secondary">
                                <i class="bi bi-newspaper fs-2 d-block mb-3"></i>
                                Belum ada berita atau kegiatan yang ditambahkan.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if($berita->hasPages()): ?>
    <div class="mt-4">
        <?php echo e($berita->links()); ?>

    </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\dass-app\resources\views/admin/berita/index.blade.php ENDPATH**/ ?>