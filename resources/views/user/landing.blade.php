<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biro Psikologi Ariva Consulta — Tes Kesehatan Mental DASS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: #fff; overflow-x: hidden; }

        /* NAVBAR */
        .navbar-ariva { background: #fff; box-shadow: 0 2px 16px rgba(0,0,0,0.07); padding: 14px 0; position: sticky; top: 0; z-index: 999; transition: all 0.3s; }
        .navbar-ariva.scrolled { padding: 10px 0; box-shadow: 0 4px 24px rgba(0,0,0,0.1); }
        .navbar-brand { display: flex; align-items: center; gap: 5px; text-decoration: none; }

        .btn-mulai-nav {
            background: linear-gradient(135deg,#1a56db,#1e40af);
            color: #fff; border: none; border-radius: 10px;
            padding: 10px 24px; font-weight: 700; font-size: 0.9rem;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-mulai-nav:hover { opacity: 0.9; color: #fff; transform: translateY(-1px); }

        /* HERO */
        .hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #1a56db 60%, #6366f1 100%);
            padding: 90px 0 120px;
            position: relative;
            overflow: hidden;
        }
        .hero-blob-1 {
            position: absolute; top: -100px; right: -100px;
            width: 500px; height: 500px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            animation: floatBlob 8s ease-in-out infinite;
        }
        .hero-blob-2 {
            position: absolute; bottom: -150px; left: -80px;
            width: 400px; height: 400px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
            animation: floatBlob 10s ease-in-out infinite reverse;
        }
        @keyframes floatBlob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(20px, -20px) scale(1.05); }
            66% { transform: translate(-15px, 15px) scale(0.97); }
        }

        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px; padding: 6px 16px;
            color: #fff; font-size: 0.82rem; font-weight: 600; margin-bottom: 20px;
            animation: fadeInDown 0.8s ease;
        }
        .hero h1 {
            font-size: 2.8rem; font-weight: 800; color: #fff;
            line-height: 1.2; margin-bottom: 16px;
            animation: fadeInUp 0.8s ease 0.2s both;
        }
        .hero p {
            font-size: 1.05rem; color: rgba(255,255,255,0.85);
            line-height: 1.7; margin-bottom: 32px; max-width: 540px;
            animation: fadeInUp 0.8s ease 0.3s both;
        }

        @keyframes fadeInDown { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeInUp   { from { opacity:0; transform:translateY(20px);  } to { opacity:1; transform:translateY(0); } }
        @keyframes fadeIn     { from { opacity:0; } to { opacity:1; } }

        .btn-mulai {
            background: #fff; color: #1a56db; border: none; border-radius: 14px;
            padding: 16px 36px; font-size: 1.05rem; font-weight: 800;
            text-decoration: none; display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15); transition: all 0.2s;
            animation: fadeInUp 0.8s ease 0.4s both;
        }
        .btn-mulai:hover { transform: translateY(-3px); box-shadow: 0 16px 32px rgba(0,0,0,0.2); color: #1e40af; }

        .hero-stats { display: flex; gap: 32px; margin-top: 48px; animation: fadeInUp 0.8s ease 0.5s both; }
        .hero-stat .angka { font-size: 1.8rem; font-weight: 800; color: #fff; }
        .hero-stat .keterangan { font-size: 0.8rem; color: rgba(255,255,255,0.7); font-weight: 500; }

        /* HERO CARD */
        .hero-card {
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px; padding: 28px; backdrop-filter: blur(10px);
            animation: fadeIn 1s ease 0.6s both;
        }
        .hasil-item {
            background: rgba(255,255,255,0.15); border-radius: 12px;
            padding: 14px 16px; margin-bottom: 12px;
            display: flex; align-items: center; justify-content: space-between;
            transition: all 0.2s;
        }
        .hasil-item:hover { background: rgba(255,255,255,0.22); transform: translateX(4px); }
        .hasil-item:last-child { margin-bottom: 0; }
        .hasil-label { color: rgba(255,255,255,0.9); font-weight: 600; font-size: 0.9rem; }
        .hasil-badge { padding: 4px 14px; border-radius: 20px; font-weight: 700; font-size: 0.8rem; }
        .badge-normal-hero { background: #d1fae5; color: #065f46; }
        .badge-sedang-hero { background: #fed7aa; color: #7c2d12; }
        .badge-ringan-hero { background: #fef9c3; color: #713f12; }

        /* WAVE */
        .wave-divider { line-height: 0; overflow: hidden; }
        .wave-divider svg { display: block; width: 100%; }

        /* COUNTER SECTION */
        .section-counter { background: linear-gradient(135deg, #1a56db, #6366f1); padding: 60px 0; }
        .counter-item { text-align: center; padding: 20px; }
        .counter-angka { font-size: 3rem; font-weight: 800; color: #fff; line-height: 1; }
        .counter-label { font-size: 0.9rem; color: rgba(255,255,255,0.8); font-weight: 600; margin-top: 6px; }
        .counter-icon { font-size: 2rem; margin-bottom: 12px; display: block; }

        /* SECTION STYLES */
        .section-title-main { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #1a56db; margin-bottom: 10px; }
        .section-heading { font-size: 2rem; font-weight: 800; color: #1e293b; line-height: 1.3; margin-bottom: 16px; }
        .section-desc { color: #64748b; line-height: 1.8; font-size: 0.95rem; }

        /* TENTANG */
        .section-tentang { padding: 80px 0; background: #f8fafc; }
        .info-card {
            background: #fff; border-radius: 16px; padding: 28px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06); height: 100%;
            transition: all 0.3s; border: 2px solid transparent;
        }
        .info-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); border-color: #e0e7ff; }
        .info-card .icon-box {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin-bottom: 16px;
        }
        .info-card h6 { font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .info-card p  { font-size: 0.88rem; color: #64748b; margin: 0; line-height: 1.7; }

        /* KONTAK */
        .kontak-item { display: flex; align-items: flex-start; gap: 10px; color: #64748b; font-size: 0.88rem; margin-bottom: 12px; }
        .kontak-item i { color: #1a56db; margin-top: 2px; flex-shrink: 0; font-size: 1rem; }

        /* DASS */
        .section-dass { padding: 80px 0; }
        .dass-card { background: linear-gradient(135deg, #1e3a8a, #1a56db); border-radius: 24px; padding: 48px; }
        .dass-skala {
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);
            border-radius: 16px; padding: 24px; text-align: center;
            transition: all 0.3s;
        }
        .dass-skala:hover { background: rgba(255,255,255,0.18); transform: translateY(-4px); }
        .dass-skala .icon { font-size: 2.5rem; margin-bottom: 10px; display: block; }
        .dass-skala h6 { font-weight: 700; color: #fff; margin-bottom: 6px; font-size: 1rem; }
        .dass-skala p  { font-size: 0.82rem; color: rgba(255,255,255,0.75); margin: 0; line-height: 1.5; }

        /* ALUR */
        .section-alur { padding: 80px 0; background: #f8fafc; }
        .alur-step { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 28px; }
        .alur-step:last-child { margin-bottom: 0; }
        .alur-nomor {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #1a56db, #1e40af);
            border-radius: 14px; display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 1.2rem; flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(26,86,219,0.3);
        }
        .alur-konten h6 { font-weight: 700; color: #1e293b; margin-bottom: 4px; font-size: 1rem; }
        .alur-konten p  { font-size: 0.88rem; color: #64748b; margin: 0; line-height: 1.6; }

        /* TIPS MENTAL HEALTH */
        .section-tips { padding: 80px 0; }
        .tips-card {
            background: #fff; border-radius: 16px; padding: 28px 24px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06); text-align: center;
            transition: all 0.3s; height: 100%;
        }
        .tips-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); }
        .tips-emoji { font-size: 2.8rem; display: block; margin-bottom: 12px; }
        .tips-card h6 { font-weight: 700; color: #1e293b; margin-bottom: 8px; }
        .tips-card p  { font-size: 0.85rem; color: #64748b; margin: 0; line-height: 1.6; }

        /* QUOTE */
        .section-quote { padding: 80px 0; background: #f8fafc; }
        .quote-card {
            background: #fff; border-radius: 20px; padding: 36px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            border-left: 4px solid #1a56db;
        }
        .quote-text { font-size: 1.15rem; color: #1e293b; font-style: italic; line-height: 1.8; margin-bottom: 16px; font-weight: 500; }
        .quote-author { font-size: 0.85rem; color: #64748b; font-weight: 600; }

        /* CTA */
        .section-cta { padding: 90px 0; background: linear-gradient(135deg, #1e3a8a 0%, #1a56db 100%); text-align: center; position: relative; overflow: hidden; }
        .section-cta::before { content:''; position:absolute; top:-50%; left:-20%; width:500px; height:500px; background:rgba(255,255,255,0.04); border-radius:50%; }
        .section-cta h2 { font-size: 2.4rem; font-weight: 800; color: #fff; margin-bottom: 12px; }
        .section-cta p  { color: rgba(255,255,255,0.8); font-size: 1.05rem; margin-bottom: 36px; }

        /* FOOTER */
        .footer { background: #0f172a; padding: 48px 0 24px; }
        .footer-brand { color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 6px; }
        .footer-info  { color: #64748b; font-size: 0.85rem; line-height: 1.8; }
        .footer-divider { border-color: #1e293b; margin: 24px 0; }
        .footer-bottom { color: #475569; font-size: 0.82rem; text-align: center; }

        /* SCROLL ANIMATION */
        .reveal { opacity: 0; transform: translateY(30px); transition: all 0.7s ease; }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* PULSE DOT */
        .pulse-dot {
            display: inline-block; width: 8px; height: 8px;
            background: #10b981; border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
            margin-right: 6px;
        }
        @keyframes pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); } 50% { box-shadow: 0 0 0 6px rgba(16,185,129,0); } }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero { padding: 60px 0 80px; }
            .hero-stats { gap: 20px; flex-wrap: wrap; }
            .dass-card { padding: 28px; }
            .section-heading { font-size: 1.6rem; }
            .counter-angka { font-size: 2.2rem; }
            .section-cta h2 { font-size: 1.8rem; }
        }

        /* MOBILE HORIZONTAL SLIDER */
        @media (max-width: 767.98px) {
            .mobile-slider-row {
                display: flex !important;
                flex-wrap: nowrap !important;
                overflow-x: auto !important;
                scroll-snap-type: x mandatory !important;
                -webkit-overflow-scrolling: touch !important;
                padding-bottom: 20px !important;
                padding-left: 15px !important;
                padding-right: 15px !important;
                margin-left: -15px !important;
                margin-right: -15px !important;
            }
            .mobile-slider-row::-webkit-scrollbar {
                height: 5px;
            }
            .mobile-slider-row::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 10px;
            }
            .mobile-slider-row::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }
            .mobile-slider-col {
                flex: 0 0 85% !important;
                max-width: 85% !important;
                scroll-snap-align: start !important;
            }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar-ariva" id="navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="/" class="navbar-brand">
            <img src="{{ $settings && $settings->logo ? asset($settings->logo) : asset('images/logo.jpg') }}" alt="{{ $settings->nama_biro ?? 'Ariva Consulta' }}"
                style="height:50px; max-width:250px; object-fit:contain;">
        </a>
        <a href="{{ route('biodata') }}" class="btn-mulai-nav">
            Mulai Tes <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-blob-1"></div>
    <div class="hero-blob-2"></div>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hero-badge">
                    <span class="pulse-dot"></span>
                    Tes Terstandarisasi DASS
                </div>
                <h1>{{ $settings->headline ?? 'Kenali Kondisi Kesehatan Mentalmu' }}</h1>
                <p>
                    @if($settings && $settings->deskripsi)
                        {{ $settings->deskripsi }}
                    @else
                        Lakukan pemeriksaan psikologi secara mandiri menggunakan instrumen
                        <strong style="color:#fff;">Depression Anxiety Stress Scale (DASS)</strong>
                        yang telah terstandarisasi secara ilmiah dan diakui internasional.
                    @endif
                </p>
                <a href="{{ route('biodata') }}" class="btn-mulai">
                    <i class="bi bi-play-circle-fill"></i>
                    Mulai Tes Sekarang
                </a>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="angka">±42</div>
                        <div class="keterangan">Pernyataan</div>
                    </div>
                    <div class="hero-stat">
                        <div class="angka">3</div>
                        <div class="keterangan">Aspek Psikologis</div>
                    </div>
                    <div class="hero-stat">
                        <div class="angka">±5</div>
                        <div class="keterangan">Menit</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="hero-card">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-clipboard2-pulse-fill text-white fs-5"></i>
                        <span style="color:#fff; font-weight:700;">Contoh Hasil Tes DASS</span>
                    </div>
                    <div class="hasil-item">
                        <span class="hasil-label">😔 Depresi</span>
                        <span class="hasil-badge badge-normal-hero">Normal</span>
                    </div>
                    <div class="hasil-item">
                        <span class="hasil-label">😰 Kecemasan</span>
                        <span class="hasil-badge badge-sedang-hero">Sedang</span>
                    </div>
                    <div class="hasil-item">
                        <span class="hasil-label">😤 Stres</span>
                        <span class="hasil-badge badge-ringan-hero">Ringan</span>
                    </div>
                    <div style="margin-top:16px; padding-top:16px; border-top:1px solid rgba(255,255,255,0.2);">
                        <small style="color:rgba(255,255,255,0.7);">
                            <i class="bi bi-lock-fill me-1"></i>
                            Data Anda bersifat rahasia dan aman
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- WAVE --}}
<div class="wave-divider" style="background:linear-gradient(135deg,#1e3a8a,#6366f1);">
    <svg viewBox="0 0 1440 60" preserveAspectRatio="none" style="height:60px;">
        <path d="M0,40 C360,80 1080,0 1440,40 L1440,60 L0,60 Z" fill="#f8fafc"/>
    </svg>
</div>

{{-- COUNTER --}}
<section style="background:#f8fafc; padding: 60px 0;">
    <div class="container">
        <div class="row g-3 text-center reveal">
            <div class="col-6 col-md-3">
                <div style="background:#fff; border-radius:16px; padding:28px 20px; box-shadow:0 2px 16px rgba(0,0,0,0.06);">
                    <div style="font-size:2.5rem; margin-bottom:8px;">🧠</div>
                    <div class="counter-angka text-primary" data-target="42" style="font-size:2.2rem; font-weight:800; color:#1a56db;">0</div>
                    <div style="font-size:0.82rem; color:#64748b; font-weight:600; margin-top:4px;">Pernyataan DASS</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="background:#fff; border-radius:16px; padding:28px 20px; box-shadow:0 2px 16px rgba(0,0,0,0.06);">
                    <div style="font-size:2.5rem; margin-bottom:8px;">🎯</div>
                    <div class="counter-angka" data-target="3" style="font-size:2.2rem; font-weight:800; color:#9333ea;">0</div>
                    <div style="font-size:0.82rem; color:#64748b; font-weight:600; margin-top:4px;">Aspek Kesehatan Mental</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="background:#fff; border-radius:16px; padding:28px 20px; box-shadow:0 2px 16px rgba(0,0,0,0.06);">
                    <div style="font-size:2.5rem; margin-bottom:8px;">⏱️</div>
                    <div class="counter-angka" data-target="10" style="font-size:2.2rem; font-weight:800; color:#ea580c;">0</div>
                    <div style="font-size:0.82rem; color:#64748b; font-weight:600; margin-top:4px;">Menit Pengerjaan</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div style="background:#fff; border-radius:16px; padding:28px 20px; box-shadow:0 2px 16px rgba(0,0,0,0.06);">
                    <div style="font-size:2.5rem; margin-bottom:8px;">🔒</div>
                    <div class="counter-angka" data-target="100" style="font-size:2.2rem; font-weight:800; color:#10b981;">0</div>
                    <div style="font-size:0.82rem; color:#64748b; font-weight:600; margin-top:4px;">% Data Aman & Rahasia</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG --}}
<section class="section-tentang">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 reveal">
                <div class="section-title-main">Tentang Kami</div>
                <h2 class="section-heading">PT. Ariva Konsultama Indonesia</h2>
                <p class="section-desc mb-3">
                    Biro Psikologi Ariva Consulta adalah lembaga psikologi profesional yang berkomitmen
                    memberikan layanan pemeriksaan dan konsultasi psikologi berkualitas tinggi.
                </p>
                <div class="legal-section p-4 border-start border-primary border-4 bg-light">
                    <h4 class="mb-3">Terdaftar Resmi:</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-patch-check-fill text-success mr-2"></i>
                            <strong>SK KEMENKUMHAM:</strong> AHU-051596.AH.01.30.2024
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-patch-check-fill text-success mr-2"></i>
                            <strong>STR HIMPSI:</strong> STR20250481-2026-0239
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-patch-check-fill text-success mr-2"></i>
                            <strong>SILP Kemdikti Saintek:</strong> SILP-3ABDF6343263
                        </li>
                    </ul>
                    <hr>
                    <p class="mb-2 text-muted">
                        Kami hadir untuk membantu Anda memahami kondisi kesehatan mental secara ilmiah dan profesional.
                    </p>
                </div>
                <div class="kontak-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Jl. H. Syukur V RT 25 RW XI No.5 Sedati – Sidoarjo</span>
                </div>
                <div class="kontak-item">
                    <i class="bi bi-telephone-fill"></i>
                    <a href="tel:085857176646" style="color:#64748b; text-decoration:none;">085857176646</a>
                </div>
                <div class="kontak-item">
                    <i class="bi bi-envelope-fill"></i>
                    <a href="mailto:arivaconsulta@gmail.com" style="color:#64748b; text-decoration:none;">arivaconsulta@gmail.com</a>
                </div>
                <div class="kontak-item">
                    <i class="bi bi-whatsapp" style="color:#25d366;"></i>
                    <a href="https://wa.me/6285857176646" target="_blank" style="color:#64748b; text-decoration:none;">Chat via WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-7 reveal">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon-box" style="background:#eff6ff;">
                                <i class="bi bi-award-fill" style="color:#1a56db; font-size:1.4rem;"></i>
                            </div>
                            <h6>Terdaftar Resmi</h6>
                            <p>Lembaga resmi terdaftar di Kemenkumham dengan SK AHU-051596.AH.01.30.2024.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon-box" style="background:#fdf4ff;">
                                <i class="bi bi-person-badge-fill" style="color:#9333ea; font-size:1.4rem;"></i>
                            </div>
                            <h6>Psikolog Berlisensi</h6>
                            <p>Ditangani langsung oleh psikolog berlisensi dengan pengalaman profesional.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon-box" style="background:#d1fae5;">
                                <i class="bi bi-shield-lock-fill" style="color:#10b981; font-size:1.4rem;"></i>
                            </div>
                            <h6>Data 100% Rahasia</h6>
                            <p>Semua data pemeriksaan bersifat rahasia dan hanya diakses oleh pihak berwenang.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-card">
                            <div class="icon-box" style="background:#fff7ed;">
                                <i class="bi bi-graph-up-arrow" style="color:#ea580c; font-size:1.4rem;"></i>
                            </div>
                            <h6>Instrumen Terstandar</h6>
                            <p>DASS telah tervalidasi secara ilmiah dan diakui di tingkat internasional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SEKSI BERITA & KEGIATAN --}}
@if(isset($berita) && $berita->count() > 0)
<section class="section-berita" style="padding: 80px 0; background: #fff;">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-title-main">Informasi & Kegiatan</div>
            <h2 class="section-heading">Berita & Kegiatan Terbaru</h2>
            <p class="section-desc" style="max-width:560px; margin:0 auto;">
                Ikuti perkembangan kegiatan sosial, seminar, dan tips menarik dari {{ $settings->nama_biro ?? 'Biro Psikologi Ariva Consulta' }}.
            </p>
        </div>
        <div class="row g-4 reveal mobile-slider-row">
            @foreach($berita as $item)
            <div class="col-md-6 col-lg-4 mobile-slider-col">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; transition: all 0.3s; cursor: pointer; box-shadow: 0 4px 18px rgba(0,0,0,0.05);" 
                     data-judul="{{ $item->judul }}"
                     data-gambar="{{ asset($item->gambar) }}"
                     data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}"
                     data-konten="{{ $item->konten }}"
                     onclick="openNewsModal(this)">
                    <div style="height: 200px; overflow: hidden; position: relative;">
                        <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="w-100 h-100" style="object-fit: cover; transition: transform 0.5s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <span class="position-absolute top-0 start-0 m-3 badge bg-primary" style="border-radius: 8px; font-weight: 600; font-size: 0.78rem;">
                            {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d M Y') }}
                        </span>
                    </div>
                    <div class="card-body p-4" style="background:#fff;">
                        <h5 class="card-title fw-bold text-dark mb-2" style="font-size: 1.1rem; line-height: 1.4;">{{ $item->judul }}</h5>
                        <p class="card-text text-secondary mb-0" style="font-size: 0.88rem; line-height: 1.6;">
                            {{ Str::limit(strip_tags($item->konten), 100) }}
                        </p>
                        <div class="mt-3 text-primary fw-bold" style="font-size: 0.85rem;">
                            Baca Selengkapnya <i class="bi bi-chevron-right ms-1"></i>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- TIPS MENTAL HEALTH --}}
<section class="section-tips">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <div class="section-title-main">Tips Kesehatan Mental</div>
            <h2 class="section-heading">Jaga Kesehatan Mentalmu Setiap Hari</h2>
            <p class="section-desc" style="max-width:560px; margin:0 auto;">
                Kesehatan mental sama pentingnya dengan kesehatan fisik. Berikut beberapa tips sederhana yang bisa kamu lakukan.
            </p>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-4 col-lg-2 reveal">
                <div class="tips-card">
                    <span class="tips-emoji">😴</span>
                    <h6>Tidur Cukup</h6>
                    <p>7-9 jam per malam untuk pemulihan optimal</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 reveal">
                <div class="tips-card">
                    <span class="tips-emoji">🏃</span>
                    <h6>Aktif Bergerak</h6>
                    <p>Olahraga 30 menit sehari meningkatkan mood</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 reveal">
                <div class="tips-card">
                    <span class="tips-emoji">🧘</span>
                    <h6>Meditasi</h6>
                    <p>Latihan pernapasan untuk menenangkan pikiran</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 reveal">
                <div class="tips-card">
                    <span class="tips-emoji">💬</span>
                    <h6>Cerita ke Orang</h6>
                    <p>Berbagi perasaan dengan orang yang dipercaya</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 reveal">
                <div class="tips-card">
                    <span class="tips-emoji">🌿</span>
                    <h6>Alam Terbuka</h6>
                    <p>Habiskan waktu di luar untuk menyegarkan pikiran</p>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2 reveal">
                <div class="tips-card">
                    <span class="tips-emoji">👨‍⚕️</span>
                    <h6>Konsultasi Ahli</h6>
                    <p>Jangan ragu hubungi psikolog profesional</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- DASS --}}
<section class="section-dass" style="background:#f8fafc;">
    <div class="container">
        <div class="dass-card reveal">
            <div class="row g-4 align-items-center">
                <div class="col-lg-5">
                    <div class="section-title-main" style="color:rgba(255,255,255,0.7);">Instrumen Tes</div>
                    <h2 style="font-size:1.8rem; font-weight:800; color:#fff; margin-bottom:12px;">
                        Depression Anxiety Stress Scale (DASS)
                    </h2>
                    <p style="color:rgba(255,255,255,0.85); line-height:1.8; font-size:0.95rem; margin-bottom:20px;">
                        DASS adalah instrumen psikologis yang mengukur 3 kondisi emosional negatif
                        melalui beberapa pernyataan. Setiap pernyataan dinilai berdasarkan pengalaman Anda selama seminggu terakhir.
                    </p>
                    <div style="background:rgba(255,255,255,0.1); border-radius:12px; padding:16px 20px;">
                        <div style="color:rgba(255,255,255,0.9); font-size:0.88rem; line-height:1.8;">
                            <div class="mb-1"><i class="bi bi-check-circle-fill me-2" style="color:#6ee7b7;"></i>Dikembangkan oleh Lovibond & Lovibond (1995)</div>
                            <div class="mb-1"><i class="bi bi-check-circle-fill me-2" style="color:#6ee7b7;"></i>Digunakan secara luas di seluruh dunia</div>
                            <div><i class="bi bi-check-circle-fill me-2" style="color:#6ee7b7;"></i>Telah divalidasi dalam Bahasa Indonesia</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="dass-skala">
                                <div class="icon">😔</div>
                                <h6>Depresi</h6>
                                <p>Mengukur perasaan sedih, putus asa, dan kehilangan semangat hidup.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dass-skala">
                                <div class="icon">😰</div>
                                <h6>Kecemasan</h6>
                                <p>Mengukur ketakutan, kegelisahan, dan gejala fisik akibat kecemasan.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dass-skala">
                                <div class="icon">😤</div>
                                <h6>Stres</h6>
                                <p>Mengukur ketegangan, mudah marah, dan kesulitan untuk bersantai.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- QUOTE --}}
<section class="section-quote">
    <div class="container">
        <div class="row g-4 reveal mobile-slider-row">
            <div class="col-md-4 mobile-slider-col">
                <div class="quote-card h-100">
                    <div class="quote-text">"Kesehatan mental bukan kemewahan — itu adalah kebutuhan dasar setiap manusia."</div>
                    <div class="quote-author"><i class="bi bi-quote me-1 text-primary"></i>WHO, World Health Organization</div>
                </div>
            </div>
            <div class="col-md-4 mobile-slider-col">
                <div class="quote-card h-100" style="border-left-color:#9333ea;">
                    <div class="quote-text">"{{ $quote }}"</div>
                    <div class="quote-author"><i class="bi bi-stars me-1" style="color:#9333ea;"></i>Kutipan Hari Ini (AI Generated)</div>
                </div>
            </div>
            <div class="col-md-4 mobile-slider-col">
                <div class="quote-card h-100" style="border-left-color:#10b981;">
                    <div class="quote-text">"Memberi ruang untuk diri sendiri dan memahami emosi adalah langkah awal yang berarti untuk merawat kesehatan mental."</div>
                    <div class="quote-author"><i class="bi bi-quote me-1" style="color:#10b981;"></i>M. Ulul Albab. S.Psi., Psikolog., CH., CFHA., CPHRM</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ALUR --}}
<section class="section-alur">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5 reveal">
                <div class="section-title-main">Cara Kerja</div>
                <h2 class="section-heading">Mudah, Cepat, dan Akurat</h2>
                <p class="section-desc mb-4">
                    Proses pemeriksaan DASS dirancang sesederhana mungkin agar Anda bisa
                    menyelesaikannya dalam waktu singkat tanpa perlu registrasi akun.
                </p>
                <a href="{{ route('biodata') }}" class="btn-mulai-nav" style="font-size:1rem; padding:14px 28px;">
                    Coba Sekarang <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="col-lg-7 reveal">
                <div class="alur-step">
                    <div class="alur-nomor">1</div>
                    <div class="alur-konten">
                        <h6>Isi Biodata</h6>
                        <p>Lengkapi data diri termasuk nama, usia, dan informasi dasar. Tidak perlu membuat akun.</p>
                    </div>
                </div>
                <div class="alur-step">
                    <div class="alur-nomor">2</div>
                    <div class="alur-konten">
                        <h6>Isi Pernyataan</h6>
                        <p>Jawab beberapa pernyataan DASS sesuai kondisi Anda selama seminggu terakhir (5 soal per halaman).</p>
                    </div>
                </div>
                <div class="alur-step">
                    <div class="alur-nomor">3</div>
                    <div class="alur-konten">
                        <h6>Lihat Hasil Skoring</h6>
                        <p>Hasil 3 skala (Depresi, Kecemasan, Stres) ditampilkan langsung setelah tes selesai.</p>
                    </div>
                </div>
                <div class="alur-step">
                    <div class="alur-nomor">4</div>
                    <div class="alur-konten">
                        <h6>Konsultasi dengan Psikolog</h6>
                        <p>Untuk laporan lengkap dan rekomendasi profesional, hubungi psikolog Ariva Consulta via WhatsApp.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="section-cta">
    <div class="container position-relative">
        <div class="reveal">
            <div style="font-size:3rem; margin-bottom:16px;">🧠✨</div>
            <h2>Siap Mengenal Dirimu Lebih Baik?</h2>
            <p>Mulai tes DASS sekarang — gratis, mudah, dan hanya butuh ±5 menit.<br>Tidak perlu daftar akun.</p>
            <a href="{{ route('biodata') }}" class="btn-mulai" style="margin: 0 auto;">
                <i class="bi bi-play-circle-fill"></i>
                Mulai Tes Sekarang
            </a>
            <div class="mt-4" style="color:rgba(255,255,255,0.6); font-size:0.85rem;">
                <i class="bi bi-shield-lock me-1"></i> Data Anda aman & terlindungi
                &nbsp;•&nbsp;
                <i class="bi bi-clock me-1"></i> Selesai dalam ±5 menit
                &nbsp;•&nbsp;
                <i class="bi bi-person-check me-1"></i> Tanpa registrasi
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="mb-3">
                    <img src="{{ $settings && $settings->logo ? asset($settings->logo) : asset('images/logo.jpg') }}" alt="{{ $settings->nama_biro ?? 'Ariva Consulta' }}"
                        style="height:50px; object-fit:contain; background:#fff; border-radius:8px; padding:4px 8px;">
                </div>
                <p class="footer-info">
                    {{ $settings->nama_biro ?? 'Biro Psikologi Ariva Consulta' }}<br>
                    PT. Ariva Konsultama Indonesia<br>
                    SK KEMENKUMHAM: AHU-051596.AH.01.30.2024
                </p>
            </div>
            <div class="col-lg-4">
                <div class="footer-brand mb-3">Kontak Kami</div>
                <div class="kontak-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{{ $settings->alamat ?? 'Jl. H. Syukur V RT 25 RW XI No.5 Sedati – Sidoarjo' }}</span>
                </div>
                <div class="kontak-item">
                    <i class="bi bi-telephone-fill"></i>
                    <a href="tel:{{ $settings->no_telp ?? '085857176646' }}" style="color:#64748b; text-decoration:none;">{{ $settings->no_telp ?? '085857176646' }}</a>
                </div>
                <div class="kontak-item">
                    <i class="bi bi-envelope-fill"></i>
                    <a href="mailto:{{ $settings->email ?? 'arivaconsulta@gmail.com' }}" style="color:#64748b; text-decoration:none;">{{ $settings->email ?? 'arivaconsulta@gmail.com' }}</a>
                </div>
                <div class="kontak-item">
                    <i class="bi bi-whatsapp" style="color:#25d366;"></i>
                    @php
                        $rawPhone = $settings->no_telp ?? '085857176646';
                        $waPhone = substr($rawPhone, 0, 1) === '0' ? '62' . substr($rawPhone, 1) : $rawPhone;
                        $waPhone = preg_replace('/[^0-9]/', '', $waPhone);
                    @endphp
                    <a href="https://wa.me/{{ $waPhone }}" target="_blank" style="color:#64748b; text-decoration:none;">Chat via WhatsApp</a>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="footer-brand mb-3">Tautan</div>
                <div class="footer-info">
                    <a href="{{ route('biodata') }}" style="color:#64748b; text-decoration:none; display:block; margin-bottom:8px;">
                        <i class="bi bi-arrow-right me-1"></i>Mulai Tes DASS
                    </a>
                    <a href="{{ route('admin.login') }}" style="color:#64748b; text-decoration:none; display:block;">
                        <i class="bi bi-shield-lock me-1"></i>Login Admin
                    </a>
                </div>
            </div>
        </div>
        <hr class="footer-divider">
        <div class="footer-bottom">
            © {{ date('Y') }} PT. Ariva Konsultama Indonesia — {{ $settings->nama_biro ?? 'Biro Psikologi Ariva Consulta Sidoarjo' }}.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// NAVBAR SCROLL EFFECT
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 50) navbar.classList.add('scrolled');
    else navbar.classList.remove('scrolled');
});

// SCROLL REVEAL
const reveals = document.querySelectorAll('.reveal');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });
reveals.forEach(el => observer.observe(el));

// COUNTER ANIMATION
function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-target'));
    const duration = 1500;
    const step = target / (duration / 16);
    let current = 0;
    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        el.textContent = Math.floor(current) + (target === 100 ? '%' : '');
    }, 16);
}

const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounter(entry.target);
            counterObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
document.querySelectorAll('.counter-angka').forEach(el => counterObserver.observe(el));
</script>

{{-- MODAL DETAIL BERITA --}}
<div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header border-0 pb-0" style="position: absolute; right: 0; top: 0; z-index: 1050; padding: 1rem;">
                <button type="button" class="btn-close bg-white rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close" style="opacity: 0.8; box-shadow: 0 2px 10px rgba(0,0,0,0.15);"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <div class="col-md-5">
                        <img id="modalGambar" src="" class="w-100" style="object-fit: cover; height: 100%; min-height: 350px;">
                    </div>
                    <div class="col-md-7">
                        <div class="p-4 p-md-5">
                            <span id="modalTanggal" class="badge bg-primary-subtle text-primary mb-3" style="border-radius: 8px; font-weight: 600; font-size: 0.8rem;"></span>
                            <h4 id="modalJudul" class="fw-bold text-dark mb-4" style="line-height: 1.3; font-size: 1.4rem;"></h4>
                            <div id="modalKonten" class="text-secondary" style="font-size: 0.95rem; line-height: 1.8; max-height: 250px; overflow-y: auto; white-space: pre-line;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openNewsModal(element) {
    document.getElementById('modalJudul').textContent = element.getAttribute('data-judul');
    document.getElementById('modalGambar').src = element.getAttribute('data-gambar');
    document.getElementById('modalTanggal').textContent = element.getAttribute('data-tanggal');
    document.getElementById('modalKonten').textContent = element.getAttribute('data-konten');
    
    const modal = new bootstrap.Modal(document.getElementById('newsModal'));
    modal.show();
}

// AUTO SLIDER MOBILE FOR NEWS & QUOTES
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.mobile-slider-row');
    
    sliders.forEach(slider => {
        let isUserInteracting = false;
        let intervalId = null;
        
        function autoSlide() {
            if (isUserInteracting) return;
            
            const maxScroll = slider.scrollWidth - slider.clientWidth;
            if (slider.scrollLeft >= maxScroll - 10) {
                // Kembali ke awal secara smooth
                slider.scrollTo({
                    left: 0,
                    behavior: 'smooth'
                });
            } else {
                // Geser ke kanan selebar kartu + gap
                const firstCol = slider.querySelector('.mobile-slider-col');
                const colWidth = firstCol ? firstCol.clientWidth + 16 : 300;
                slider.scrollBy({
                    left: colWidth,
                    behavior: 'smooth'
                });
            }
        }
        
        function startAutoPlay() {
            if (!intervalId) {
                intervalId = setInterval(autoSlide, 4500); // Geser otomatis setiap 4.5 detik
            }
        }
        
        function stopAutoPlay() {
            if (intervalId) {
                clearInterval(intervalId);
                intervalId = null;
            }
        }
        
        // Deteksi interaksi sentuh manual (HP)
        slider.addEventListener('touchstart', () => {
            isUserInteracting = true;
            stopAutoPlay();
        }, { passive: true });
        
        slider.addEventListener('touchend', () => {
            setTimeout(() => {
                isUserInteracting = false;
                if (window.innerWidth < 768) startAutoPlay();
            }, 3000);
        });
        
        // Deteksi interaksi mouse (klik/drag)
        slider.addEventListener('mousedown', () => {
            isUserInteracting = true;
            stopAutoPlay();
        });
        
        slider.addEventListener('mouseup', () => {
            setTimeout(() => {
                isUserInteracting = false;
                if (window.innerWidth < 768) startAutoPlay();
            }, 3000);
        });

        // Hanya jalankan jika di layar mobile
        if (window.innerWidth < 768) {
            startAutoPlay();
        }
        
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                stopAutoPlay();
            } else {
                startAutoPlay();
            }
        });
    });
});
</script>

<!-- Floating Chatbot Widget -->
<div class="chatbot-container" id="chatbotContainer">
    <!-- Chat Button -->
    <button class="chatbot-btn" id="chatbotBtn" onclick="toggleChatbot()">
        <i class="bi bi-chat-dots-fill text-white fs-3"></i>
        <span class="chatbot-notification" id="chatbotNotif" style="display: none;">1</span>
    </button>

    <!-- Chat Box -->
    <div class="chatbot-box" id="chatbotBox" style="display: none;">
        <!-- Header -->
        <div class="chatbot-header">
            <div class="d-flex align-items-center gap-2">
                <div class="chatbot-avatar bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:36px; height:36px;">
                    <i class="bi bi-robot fs-5"></i>
                </div>
                <div>
                    <h6 class="text-white fw-bold mb-0" style="font-size:0.9rem;">Dr. Ariva (AI Assistant)</h6>
                    <small style="color: rgba(255,255,255,0.7); font-size: 0.72rem;"><span class="chatbot-status-dot"></span>Online</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm text-white p-0 border-0" onclick="resetChatbot()" title="Mulai Ulang Chat" style="font-size: 1.1rem;">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </button>
                <button class="btn btn-sm text-white p-0 border-0" onclick="toggleChatbot()" title="Tutup Chat" style="font-size: 1.1rem;">
                    <i class="bi bi-dash-lg"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="chatbot-messages" id="chatbotMessages">
            <div class="chat-message bot">
                <div class="message-bubble">
                    Halo! Saya Dr. Ariva, asisten psikologis virtual Ariva Consulta Sidoarjo. Ada yang sedang ingin kamu ceritakan atau keluhkan hari ini? Saya di sini untuk mendengarkan.
                </div>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div class="chatbot-typing" id="chatbotTyping" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <!-- Input Area -->
        <div class="chatbot-input-area">
            <input type="text" id="chatbotInput" placeholder="Ceritakan yang kamu rasakan..." onkeypress="handleChatEnter(event)">
            <button id="chatbotSendBtn" onclick="sendChatbotMessage()">
                <i class="bi bi-send-fill text-primary fs-5"></i>
            </button>
        </div>
    </div>
</div>

<style>
    /* Chatbot Container */
    .chatbot-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1000;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Floating Button */
    .chatbot-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
        border: none;
        box-shadow: 0 4px 16px rgba(26,86,219,0.3);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        position: relative;
    }
    .chatbot-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(26,86,219,0.4);
    }
    
    .chatbot-notification {
        position: absolute;
        top: -2px;
        right: -2px;
        background: #ef4444;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
    }

    /* Chat Box */
    .chatbot-box {
        width: 350px;
        height: 480px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        position: absolute;
        bottom: 75px;
        right: 0;
        border: 1px solid #f1f5f9;
        animation: chatBoxFadeIn 0.3s ease-out;
    }
    
    @keyframes chatBoxFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header */
    .chatbot-header {
        background: linear-gradient(135deg, #1a56db 0%, #1e40af 100%);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #fff;
    }
    .chatbot-status-dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        background: #10b981;
        border-radius: 50%;
        margin-right: 4px;
    }

    /* Messages Area */
    .chatbot-messages {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .chat-message {
        display: flex;
        max-width: 85%;
    }
    .chat-message.bot {
        align-self: flex-start;
    }
    .chat-message.user {
        align-self: flex-end;
    }
    .message-bubble {
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 0.85rem;
        line-height: 1.5;
        white-space: pre-line;
    }
    .chat-message.bot .message-bubble {
        background: #fff;
        color: #1e293b;
        border-top-left-radius: 2px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }
    .chat-message.user .message-bubble {
        background: #1a56db;
        color: #fff;
        border-top-right-radius: 2px;
    }

    /* Input Area */
    .chatbot-input-area {
        padding: 12px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
    }
    .chatbot-input-area input {
        flex: 1;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 8px 14px;
        font-size: 0.85rem;
        outline: none;
    }
    .chatbot-input-area input:focus {
        border-color: #1a56db;
    }
    .chatbot-input-area button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Typing Indicator Animation */
    .chatbot-typing {
        align-self: flex-start;
        background: #fff;
        border: 1px solid #f1f5f9;
        padding: 10px 18px;
        border-radius: 16px;
        border-top-left-radius: 2px;
        display: flex;
        gap: 4px;
        margin-left: 16px;
        margin-bottom: 12px;
        width: fit-content;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    }
    .chatbot-typing span {
        width: 6px;
        height: 6px;
        background: #94a3b8;
        border-radius: 50%;
        animation: typing 1.4s infinite ease-in-out;
    }
    .chatbot-typing span:nth-child(2) { animation-delay: 0.2s; }
    .chatbot-typing span:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typing {
        0%, 100%, 80% { transform: scale(0.6); opacity: 0.4; }
        40% { transform: scale(1); opacity: 1; }
    }

    /* Responsive Mobile */
    @media (max-width: 480px) {
        .chatbot-container { bottom: 16px; right: 16px; }
        .chatbot-box { width: 310px; height: 420px; bottom: 70px; }
        .chatbot-btn { width: 52px; height: 52px; }
    }
</style>

<script>
    function toggleChatbot() {
        const box = document.getElementById('chatbotBox');
        const notif = document.getElementById('chatbotNotif');
        if (box.style.display === 'none') {
            box.style.display = 'flex';
            notif.style.display = 'none';
            const messages = document.getElementById('chatbotMessages');
            messages.scrollTop = messages.scrollHeight;
            setTimeout(() => document.getElementById('chatbotInput').focus(), 100);
        } else {
            box.style.display = 'none';
        }
    }

    function handleChatEnter(event) {
        if (event.key === 'Enter') {
            sendChatbotMessage();
        }
    }

    function sendChatbotMessage() {
        const input = document.getElementById('chatbotInput');
        const message = input.value.trim();
        if (message === '') return;

        input.value = '';
        appendMessage('user', message);

        const typing = document.getElementById('chatbotTyping');
        const messagesArea = document.getElementById('chatbotMessages');
        typing.style.display = 'flex';
        messagesArea.appendChild(typing);
        messagesArea.scrollTop = messagesArea.scrollHeight;

        const csrfToken = document.querySelector('meta[name="csrf-token"]') 
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            : '{{ csrf_token() }}';

        fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => {
            if (!res.ok) throw new Error('Network response error');
            return res.json();
        })
        .then(data => {
            typing.style.display = 'none';
            appendMessage('bot', data.reply);
        })
        .catch(err => {
            typing.style.display = 'none';
            appendMessage('bot', 'Maaf, sepertinya ada gangguan koneksi. Mari coba mengobrol beberapa saat lagi.');
            console.error(err);
        });
    }

    function appendMessage(sender, text) {
        const messagesArea = document.getElementById('chatbotMessages');
        const wrapper = document.createElement('div');
        wrapper.className = `chat-message ${sender}`;
        
        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        bubble.textContent = text;
        
        wrapper.appendChild(bubble);
        messagesArea.appendChild(wrapper);
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }

    function resetChatbot() {
        if (!confirm('Apakah kamu ingin memulai obrolan baru dan menghapus riwayat obrolan ini?')) return;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            : '{{ csrf_token() }}';
        
        fetch('{{ route("chatbot.reset") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const messagesArea = document.getElementById('chatbotMessages');
                messagesArea.innerHTML = `
                    <div class="chat-message bot">
                        <div class="message-bubble">
                            Halo! Obrolan telah di-reset. Saya Dr. Ariva, asisten psikologis virtual Ariva Consulta Sidoarjo. Ada yang sedang ingin kamu ceritakan atau keluhkan hari ini? Saya di sini untuk mendengarkan.
                        </div>
                    </div>
                `;
            }
        })
        .catch(err => console.error(err));
    }
</script>
</body>
</html>
