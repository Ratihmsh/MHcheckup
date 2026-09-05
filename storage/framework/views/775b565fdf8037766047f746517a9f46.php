<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Detail Peserta — <?php echo e($peserta->nama); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #f0f4f8; }

        .sidebar {
            width: 240px; min-height: 100vh;
            background: linear-gradient(180deg, #1e3a8a 0%, #1a56db 100%);
            position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-brand { padding: 24px 20px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-brand h6 { color: #fff; font-weight: 700; font-size: 1rem; margin: 0; }
        .sidebar-brand small { color: rgba(255,255,255,0.5); font-size: 0.75rem; }
        .sidebar-menu { padding: 16px 0; }
        .sidebar-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 20px; color: rgba(255,255,255,0.7);
            text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: all 0.2s;
        }
        .sidebar-item:hover, .sidebar-item.active { background: rgba(255,255,255,0.15); color: #fff; }
        .sidebar-logout { position: absolute; bottom: 0; left: 0; right: 0; padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.1); }

        .main-content { margin-left: 240px; padding: 28px; min-height: 100vh; }

        .card { border: none; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }

        .section-title {
            font-size: 0.78rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.08em; color: #1a56db;
            border-bottom: 2px solid #e0e7ff; padding-bottom: 8px; margin-bottom: 16px;
        }

        .info-row { display: flex; padding: 8px 0; border-bottom: 1px solid #f1f5f9; font-size: 0.88rem; }
        .info-row:last-child { border-bottom: none; }
        .info-label { width: 160px; color: #64748b; font-weight: 600; flex-shrink: 0; }
        .info-value { color: #1e293b; flex: 1; }

        .skor-mini {
            border-radius: 12px; padding: 16px; text-align: center;
        }
        .skor-mini.dep  { background: linear-gradient(135deg, #eff6ff, #dbeafe); }
        .skor-mini.kec  { background: linear-gradient(135deg, #fdf4ff, #f3e8ff); }
        .skor-mini.str  { background: linear-gradient(135deg, #fff7ed, #ffedd5); }
        .skor-mini .angka { font-size: 2rem; font-weight: 800; }
        .skor-mini.dep .angka { color: #1a56db; }
        .skor-mini.kec .angka { color: #9333ea; }
        .skor-mini.str .angka { color: #ea580c; }
        .skor-mini .label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 4px; }
        .skor-mini.dep .label { color: #1e40af; }
        .skor-mini.kec .label { color: #7e22ce; }
        .skor-mini.str .label { color: #c2410c; }

        .badge-kategori { padding: 4px 12px; border-radius: 20px; font-weight: 700; font-size: 0.78rem; display: inline-block; }
        .badge-Normal       { background: #d1fae5; color: #065f46; }
        .badge-Ringan       { background: #fef9c3; color: #713f12; }
        .badge-Sedang       { background: #fed7aa; color: #7c2d12; }
        .badge-Tinggi        { background: #fecaca; color: #7f1d1d; }
        .badge-Sangat-Tinggi { background: #f3e8ff; color: #4a044e; }

     .textarea-laporan {
    border-radius: 10px; border: 1.5px solid #e2e8f0;
    padding: 12px 14px; font-size: 0.95rem; resize: vertical; min-height: 200px;
    line-height: 1.8; width: 100%;
}
        .textarea-laporan:focus { border-color: #1a56db; box-shadow: 0 0 0 3px rgba(26,86,219,0.1); outline: none; }

        .btn-ai {
            background: linear-gradient(135deg, #7c3aed, #6366f1);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 20px; font-weight: 700; font-size: 0.9rem;
            transition: all 0.2s;
        }
        .btn-ai:hover { opacity: 0.9; transform: translateY(-1px); color: #fff; }
        .btn-ai:disabled { opacity: 0.6; cursor: not-allowed; }

        .btn-simpan {
            background: linear-gradient(135deg, #1a56db, #1e40af);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 20px; font-weight: 700; font-size: 0.9rem;
        }
        .btn-simpan:hover { opacity: 0.9; color: #fff; }

        .btn-cetak {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 20px; font-weight: 700; font-size: 0.9rem;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-cetak:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

        .btn-hapus {
            background: #fee2e2; color: #dc2626;
            border: none; border-radius: 10px;
            padding: 10px 20px; font-weight: 700; font-size: 0.9rem;
        }
        .btn-hapus:hover { background: #dc2626; color: #fff; }

        /* TABEL JAWABAN */
        .tabel-jawaban th { background: #f8fafc; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; color: #64748b; padding: 10px 14px; }
        .tabel-jawaban td { font-size: 0.85rem; padding: 10px 14px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
        .tabel-jawaban tr:last-child td { border-bottom: none; }

        .skala-dep { background: #eff6ff; color: #1e40af; padding: 2px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; }
        .skala-kec { background: #fdf4ff; color: #7e22ce; padding: 2px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; }
        .skala-str { background: #fff7ed; color: #c2410c; padding: 2px 8px; border-radius: 6px; font-size: 0.72rem; font-weight: 700; }

        /* AI LOADING */
        .ai-loading {
            display: none;
            align-items: center;
            gap: 10px;
            color: #7c3aed;
            font-size: 0.88rem;
            font-weight: 600;
        }
        .spinner-ai {
            width: 20px; height: 20px;
            border: 3px solid #e9d5ff;
            border-top-color: #7c3aed;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .alert { border-radius: 12px; border: none; }
    </style>
</head>
<body>


<div class="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2 mb-1">
            <i class="bi bi-heart-pulse-fill text-white fs-5"></i>
            <h6>Ariva Consulta</h6>
        </div>
        <small>Panel Admin DASS-42</small>
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

    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-secondary text-decoration-none small">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Dashboard
            </a>
            <h5 class="fw-bold mb-0 mt-1">Detail Peserta</h5>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.peserta.cetak', $peserta->id)); ?>" target="_blank" class="btn-cetak">
                <i class="bi bi-printer-fill"></i> Cetak Laporan
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success mb-4">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <div class="row g-4">

        
        <div class="col-lg-5">

            
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Data Pribadi</div>
                    <div class="info-row"><span class="info-label">Nama</span><span class="info-value fw-bold"><?php echo e($peserta->nama); ?></span></div>
                    <div class="info-row"><span class="info-label">Jenis Kelamin</span><span class="info-value"><?php echo e($peserta->jenis_kelamin); ?></span></div>
                    <div class="info-row"><span class="info-label">Tanggal Lahir</span><span class="info-value"><?php echo e(\Carbon\Carbon::parse($peserta->tanggal_lahir)->format('d/m/Y')); ?></span></div>
                    <div class="info-row"><span class="info-label">Usia</span><span class="info-value"><?php echo e($peserta->usia); ?></span></div>
                    <div class="info-row"><span class="info-label">Pendidikan</span><span class="info-value"><?php echo e($peserta->pendidikan ?? '-'); ?></span></div>
                    <div class="info-row"><span class="info-label">Pekerjaan</span><span class="info-value"><?php echo e($peserta->pekerjaan ?? '-'); ?></span></div>
                    <div class="info-row"><span class="info-label">Status Kawin</span><span class="info-value"><?php echo e($peserta->status_perkawinan ?? '-'); ?></span></div>
                    <div class="info-row"><span class="info-label">No. Telepon</span><span class="info-value"><?php echo e($peserta->no_telp ?? '-'); ?></span></div>
                    <div class="info-row"><span class="info-label">Alamat</span><span class="info-value"><?php echo e($peserta->alamat ?? '-'); ?></span></div>
                    <div class="info-row"><span class="info-label">Tgl Pemeriksaan</span><span class="info-value"><?php echo e(\Carbon\Carbon::parse($peserta->tanggal_pemeriksaan)->format('d/m/Y')); ?></span></div>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="section-title">Tujuan Konsultasi</div>
                    <div class="mb-3">
                        <div class="info-label mb-1">Permasalahan</div>
                        <div class="text-dark" style="font-size:0.88rem; line-height:1.6;"><?php echo e($peserta->permasalahan ?? '-'); ?></div>
                    </div>
                    <div class="mb-3">
                        <div class="info-label mb-1">Yang Dirasakan</div>
                        <div class="text-dark" style="font-size:0.88rem; line-height:1.6;"><?php echo e($peserta->yang_dirasakan ?? '-'); ?></div>
                    </div>
                    <div>
                        <div class="info-label mb-1">Harapan</div>
                        <div class="text-dark" style="font-size:0.88rem; line-height:1.6;"><?php echo e($peserta->harapan ?? '-'); ?></div>
                    </div>
                </div>
            </div>

            
            <div class="card">
                <div class="card-body p-4">
                    <div class="section-title">Hasil Skor DASS-42</div>
                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <div class="skor-mini dep">
                                <div class="label">Depresi</div>
                                <div class="angka"><?php echo e($hasil->skor_depresi); ?></div>
                                <span class="badge-kategori badge-<?php echo e(str_replace(' ','-',$hasil->kategori_depresi)); ?> mt-1">
                                    <?php echo e($hasil->kategori_depresi); ?>

                                </span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="skor-mini kec">
                                <div class="label">Cemas</div>
                                <div class="angka"><?php echo e($hasil->skor_kecemasan); ?></div>
                                <span class="badge-kategori badge-<?php echo e(str_replace(' ','-',$hasil->kategori_kecemasan)); ?> mt-1">
                                    <?php echo e($hasil->kategori_kecemasan); ?>

                                </span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="skor-mini str">
                                <div class="label">Stres</div>
                                <div class="angka"><?php echo e($hasil->skor_stres); ?></div>
                                <span class="badge-kategori badge-<?php echo e(str_replace(' ','-',$hasil->kategori_stres)); ?> mt-1">
                                    <?php echo e($hasil->kategori_stres); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    
                    <form action="<?php echo e(route('admin.peserta.hapus', $peserta->id)); ?>" method="POST"
                        onsubmit="return confirm('Yakin hapus data <?php echo e($peserta->nama); ?>? Data tidak bisa dikembalikan.')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn-hapus w-100 mt-2">
                            <i class="bi bi-trash3 me-2"></i>Hapus Data Peserta
                        </button>
                    </form>
                </div>
            </div>

        </div>

        
        <div class="col-lg-7">

            
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="section-title mb-0">Laporan Psikologis</div>
                        <button type="button" class="btn-ai" id="btnGenerateAi" onclick="generateAi()">
                            <i class="bi bi-stars me-2"></i>Generate AI
                        </button>
                    </div>

                    <!-- AI LOADING -->
                    <div class="ai-loading mb-3" id="aiLoading">
                        <div class="spinner-ai"></div>
                        <span>Dr. Ariva sedang membuat laporan...</span>
                    </div>

                    <form action="<?php echo e(route('admin.peserta.update-laporan', $peserta->id)); ?>" method="POST" id="formLaporan">

                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <?php
                            $dinamika = json_decode($hasil->dinamika_psikologis, true) ?? [];
                            $saran = json_decode($hasil->saran_rekomendasi, true) ?? [];
                            $fields = ['depression' => 'Depresi', 'anxiety' => 'Kecemasan', 'stress' => 'Stres'];
                        ?>

                        <div class="laporan-rapi">
                            <h5 class="mb-3">Dinamika Psikologis</h5>
                            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3">
                                    <label class="form-label"><strong><?php echo e($label); ?></strong></label>
                                    <textarea
                                        id="dinamika_<?php echo e($key); ?>"
                                        name="dinamika[<?php echo e($key); ?>]"
                                        class="form-control"
                                        rows="3"
                                        placeholder="Masukkan dinamika <?php echo e(strtolower($label)); ?>..."><?php echo e($dinamika[$key] ?? ''); ?></textarea>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <h5 class="mt-4 mb-3">Saran & Rekomendasi</h5>
                            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3">
                                    <label class="form-label"><strong><?php echo e($label); ?></strong></label>
                                    <textarea
                                        id="saran_<?php echo e($key); ?>"
                                        name="saran[<?php echo e($key); ?>]"
                                        class="form-control"
                                        rows="3"
                                        placeholder="Masukkan saran <?php echo e(strtolower($label)); ?>..."><?php echo e($saran[$key] ?? ''); ?></textarea>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-simpan">
                                <i class="bi bi-floppy-fill me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="card">
                <div class="card-body p-4">
                    <div class="section-title">Detail Jawaban 42 Soal</div>

                    <?php
                        $soalDepresi   = [3,5,10,13,16,17,21,24,26,31,34,37,38,42];
                        $soalKecemasan = [2,4,7,9,15,19,20,23,25,28,30,36,40,41];
                        $soalStres     = [1,6,8,11,12,14,18,22,27,29,32,33,35,39];

                        $labelJawaban = [0 => 'Tidak Pernah', 1 => 'Kadang-kadang', 2 => 'Sering', 3 => 'Hampir Selalu'];
                    ?>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table tabel-jawaban mb-0">
                            <thead style="position: sticky; top: 0;">
                                <tr>
                                    <th style="width:40px;">#</th>
                                    <th>Pernyataan</th>
                                    <th style="width:60px;" class="text-center">Skala</th>
                                    <th style="width:80px;" class="text-center">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $soal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $no => $pertanyaan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $nilaiJawaban = $jawaban ? $jawaban->{"soal_$no"} : '-';
                                    if (in_array($no, $soalDepresi))        $skala = 'dep';
                                    elseif (in_array($no, $soalKecemasan))  $skala = 'kec';
                                    else                                     $skala = 'str';
                                ?>
                                <tr>
                                    <td class="text-secondary"><?php echo e($no); ?></td>
                                    <td><?php echo e($pertanyaan); ?></td>
                                    <td class="text-center">
                                        <?php if($skala === 'dep'): ?>
                                            <span class="skala-dep">D</span>
                                        <?php elseif($skala === 'kec'): ?>
                                            <span class="skala-kec">K</span>
                                        <?php else: ?>
                                            <span class="skala-str">S</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center fw-bold"><?php echo e($nilaiJawaban); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <span class="skala-dep">D</span><small class="text-secondary me-2">= Depresi</small>
                        <span class="skala-kec">K</span><small class="text-secondary me-2">= Kecemasan</small>
                        <span class="skala-str">S</span><small class="text-secondary">= Stres</small>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function generateAi() {
        const btn     = document.getElementById('btnGenerateAi');
        const loading = document.getElementById('aiLoading');

        btn.disabled = true;
        loading.style.display = 'flex';

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('<?php echo e(route("admin.generate.ai", $peserta->id)); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            loading.style.display = 'none';
            btn.disabled = false;

            if (data.success) {
                document.getElementById('dinamika_depression').value = data.dinamika_psikologis.depression || '';
                document.getElementById('dinamika_anxiety').value    = data.dinamika_psikologis.anxiety || '';
                document.getElementById('dinamika_stress').value     = data.dinamika_psikologis.stress || '';

                document.getElementById('saran_depression').value    = data.saran_rekomendasi.depression || '';
                document.getElementById('saran_anxiety').value       = data.saran_rekomendasi.anxiety || '';
                document.getElementById('saran_stress').value        = data.saran_rekomendasi.stress || '';

                const notif = document.createElement('div');
                notif.className = 'alert alert-success mt-3';
                notif.innerHTML = '<i class="bi bi-stars me-2"></i>Berhasil! Silakan review dan simpan.';
                document.getElementById('formLaporan').prepend(notif);
                setTimeout(() => notif.remove(), 5000);
            } else {
                alert('Gagal: ' + (data.error || 'Terjadi kesalahan.') + '\n\nDetail: ' + (data.detail || ''));
            }
        })
        .catch(err => {
            loading.style.display = 'none';
            btn.disabled = false;
            alert('Error koneksi: ' + err.message);
        });
    }
</script>
</body>
</html>
<?php /**PATH C:\laragon\www\dass-app\resources\views/admin/detail.blade.php ENDPATH**/ ?>