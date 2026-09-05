<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta — Ariva Consulta</title>
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
        .table-card { background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); overflow: hidden; }
        .table-card .table { margin: 0; }
        .table thead th { background: #f8fafc; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; border-bottom: 1px solid #e2e8f0; padding: 14px 16px; }
        .table tbody td { padding: 12px 16px; vertical-align: middle; font-size: 0.88rem; border-bottom: 1px solid #f1f5f9; color: #374151; }
        .table tbody tr:hover { background: #f8fafc; }
        .table tbody tr:last-child td { border-bottom: none; }
        .badge-kategori { padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.78rem; }
        .badge-Normal       { background: #d1fae5; color: #065f46; }
        .badge-Ringan       { background: #fef9c3; color: #713f12; }
        .badge-Sedang       { background: #fed7aa; color: #7c2d12; }
        .badge-Tinggi        { background: #fecaca; color: #7f1d1d; }
        .badge-Sangat-Tinggi { background: #f3e8ff; color: #4a044e; }
        .search-box { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 9px 14px; font-size: 0.9rem; }
        .search-box:focus { border-color: #1a56db; box-shadow: 0 0 0 3px rgba(26,86,219,0.1); outline: none; }
        .filter-box { border-radius: 10px; border: 1.5px solid #e2e8f0; padding: 7px 12px; font-size: 0.88rem; }
        .filter-box:focus { border-color: #1a56db; outline: none; }
        .btn-detail { background: #eff6ff; color: #1a56db; border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.82rem; font-weight: 600; transition: all 0.2s; text-decoration: none; }
        .btn-detail:hover { background: #1a56db; color: #fff; }
        .btn-hapus-sm { background: #fee2e2; color: #dc2626; border: none; border-radius: 8px; padding: 6px 12px; font-size: 0.82rem; font-weight: 600; transition: all 0.2s; }
        .btn-hapus-sm:hover { background: #dc2626; color: #fff; }
        .summary-bar { background: #fff; border-radius: 14px; padding: 16px 24px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 24px; flex-wrap: wrap; }
        .summary-item { display: flex; align-items: center; gap: 8px; font-size: 0.88rem; }
        .summary-dot { width: 10px; height: 10px; border-radius: 50%; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Ariva" style="height:32px; object-fit:contain; background:#fff; border-radius:6px; padding:2px 4px;">
        <div style="color:rgba(255,255,255,0.5); font-size:0.75rem; margin-top:6px;">Panel Admin DASS-42</div>
    </div>
    <div class="sidebar-menu">
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-item">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <a href="<?php echo e(route('admin.peserta.list')); ?>" class="sidebar-item active">
            <i class="bi bi-people-fill"></i> Data Peserta
        </a>
        <a href="<?php echo e(route('admin.berita.index')); ?>" class="sidebar-item">
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
            <h5 class="fw-bold mb-0 text-dark">Data Peserta</h5>
            <small class="text-secondary">Daftar semua peserta tes DASS-42</small>
        </div>
        <div class="text-secondary small">
            <i class="bi bi-calendar3 me-1"></i><?php echo e(now()->translatedFormat('d F Y')); ?>

        </div>
    </div>

    <?php
        $totalSemua     = \Illuminate\Support\Facades\DB::table('peserta')->count();
        $totalNormal    = \Illuminate\Support\Facades\DB::table('hasil')->where('kategori_depresi','Normal')->where('kategori_kecemasan','Normal')->where('kategori_stres','Normal')->count();
        $totalPerhatian = \Illuminate\Support\Facades\DB::table('hasil')->where(function($q) {
            $q->whereIn('kategori_depresi',   ['Sedang','Tinggi','Sangat Tinggi'])
              ->orWhereIn('kategori_kecemasan',['Sedang','Tinggi','Sangat Tinggi'])
              ->orWhereIn('kategori_stres',    ['Sedang','Tinggi','Sangat Tinggi']);
        })->count();
    ?>

    <div class="summary-bar">
        <div class="summary-item">
            <div class="summary-dot" style="background:#1a56db;"></div>
            <span class="text-secondary">Total:</span>
            <strong><?php echo e($totalSemua); ?> peserta</strong>
        </div>
        <div class="summary-item">
            <div class="summary-dot" style="background:#10b981;"></div>
            <span class="text-secondary">Semua Normal:</span>
            <strong><?php echo e($totalNormal); ?></strong>
        </div>
        <div class="summary-item">
            <div class="summary-dot" style="background:#f59e0b;"></div>
            <span class="text-secondary">Perlu Perhatian:</span>
            <strong><?php echo e($totalPerhatian); ?></strong>
        </div>
        <div class="ms-auto">
            <small class="text-secondary">Menampilkan <?php echo e($peserta->total()); ?> hasil</small>
        </div>
    </div>

    <div class="table-card">
        <div class="d-flex align-items-center justify-content-between p-4 border-bottom flex-wrap gap-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-table me-2 text-primary"></i>Daftar Peserta</h6>
            <form action="<?php echo e(route('admin.peserta.list')); ?>" method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                <input type="text" name="search" class="search-box" placeholder="Cari nama..." value="<?php echo e($search); ?>" style="min-width:180px;">
                <input type="date" name="tanggal" class="filter-box" value="<?php echo e(request('tanggal')); ?>">
                <select name="kategori" class="filter-box">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = ['Normal','Ringan','Sedang','Tinggi','Sangat Tinggi']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($k); ?>" <?php echo e(request('kategori') == $k ? 'selected' : ''); ?>><?php echo e($k); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm px-3" style="border-radius:10px;">
                    <i class="bi bi-search"></i>
                </button>
                <?php if($search || request('tanggal') || request('kategori')): ?>
                <a href="<?php echo e(route('admin.peserta.list')); ?>" class="btn btn-outline-secondary btn-sm px-3" style="border-radius:10px;">
                    <i class="bi bi-x"></i> Reset
                </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Peserta</th>
                        <th>Tgl Pemeriksaan</th>
                        <th class="text-center">Depresi</th>
                        <th class="text-center">Kecemasan</th>
                        <th class="text-center">Stres</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $peserta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-secondary"><?php echo e($peserta->firstItem() + $index); ?></td>
                        <td>
                            <div class="fw-bold"><?php echo e($p->nama); ?></div>
                            <small class="text-secondary"><?php echo e($p->jenis_kelamin); ?>, <?php echo e($p->usia); ?> thn</small>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d/m/Y')); ?></td>
                        <td class="text-center">
                            <?php if($p->kategori_depresi): ?>
                                <span class="badge-kategori badge-<?php echo e(str_replace(' ','-',$p->kategori_depresi)); ?>"><?php echo e($p->kategori_depresi); ?></span>
                                <div class="text-secondary" style="font-size:0.75rem;"><?php echo e($p->skor_depresi); ?></div>
                            <?php else: ?> <span class="text-secondary">-</span> <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($p->kategori_kecemasan): ?>
                                <span class="badge-kategori badge-<?php echo e(str_replace(' ','-',$p->kategori_kecemasan)); ?>"><?php echo e($p->kategori_kecemasan); ?></span>
                                <div class="text-secondary" style="font-size:0.75rem;"><?php echo e($p->skor_kecemasan); ?></div>
                            <?php else: ?> <span class="text-secondary">-</span> <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($p->kategori_stres): ?>
                                <span class="badge-kategori badge-<?php echo e(str_replace(' ','-',$p->kategori_stres)); ?>"><?php echo e($p->kategori_stres); ?></span>
                                <div class="text-secondary" style="font-size:0.75rem;"><?php echo e($p->skor_stres); ?></div>
                            <?php else: ?> <span class="text-secondary">-</span> <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="<?php echo e(route('admin.peserta.detail', $p->id)); ?>" class="btn-detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="<?php echo e(route('admin.peserta.hapus', $p->id)); ?>" method="POST"
                                    onsubmit="return confirm('Yakin hapus data <?php echo e($p->nama); ?>?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn-hapus-sm">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                            <?php if($search || request('tanggal') || request('kategori')): ?>
                                Tidak ada data yang sesuai filter
                            <?php else: ?>
                                Belum ada data peserta
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($peserta->hasPages()): ?>
        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
            <small class="text-secondary">
                Menampilkan <?php echo e($peserta->firstItem()); ?>–<?php echo e($peserta->lastItem()); ?> dari <?php echo e($peserta->total()); ?> peserta
            </small>
            <?php echo e($peserta->appends(['search' => $search, 'tanggal' => request('tanggal'), 'kategori' => request('kategori')])->links('pagination::bootstrap-5')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\laragon\www\dass-app\resources\views/admin/peserta.blade.php ENDPATH**/ ?>