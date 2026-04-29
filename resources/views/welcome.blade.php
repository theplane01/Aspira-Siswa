<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg:        #ffffff;
            --bg-light:  #f8fafc;
            --surface:   #f1f5f9;
            --surface-2: #e2e8f0;
            --border:    #e2e8f0;
            --text:      #1e293b;
            --text-soft: #64748b;
            --text-dim:  #94a3b8;
            --primary:   #2563eb;
            --primary-dark: #1d4ed8;
            --info:      #0ea5e9;
            --success:   #10b981;
            --warning:   #f59e0b;
            --danger:    #ef4444;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            margin-left: 260px;
            transition: margin-left 0.3s;
        }
        /* ── BG GRADIENT ── */
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.03) 0%, rgba(168,85,247,0.03) 100%);
            pointer-events: none;
        }
        /* ── GLOW ORBS ── */
        .orb {
            position: fixed; border-radius: 50%;
            filter: blur(90px); opacity: 0.3; pointer-events: none; z-index: 0;
        }
        .orb-1 { width: 500px; height: 500px; top: -120px; right: -100px; background: radial-gradient(circle, rgba(37,99,235,0.2), transparent 70%); }
        .orb-2 { width: 400px; height: 400px; bottom: 80px; left: -80px; background: radial-gradient(circle, rgba(168,85,247,0.15), transparent 70%); }

        /* ── SIDEBAR ── */
        .sidebar {
            position: fixed; left: 0; top: 0; height: 100vh; width: 260px;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(18px);
            border-right: 1px solid var(--border); z-index: 1000;
            overflow-y: auto; padding: 1.5rem 0;
            box-shadow: 2px 0 8px rgba(0,0,0,0.04);
            transition: transform 0.3s, left 0.3s;
        }
        .sidebar.mobile-open { transform: translateX(0); }
        .sidebar-brand {
            display: flex; align-items: center; gap: 0.55rem;
            padding: 0 1.25rem; margin-bottom: 1.5rem;
            font-weight: 800; font-size: 1.1rem; color: var(--text);
        }
        .brand-icon {
            width: 34px; height: 34px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            display: flex; align-items: center; justify-content: center; font-size: 0.82rem; color: white;
            flex-shrink: 0;
        }
        .sidebar-menu {
            list-style: none; margin: 0; padding: 0;
        }
        .sidebar-item {
            margin: 0.3rem 0.75rem; position: relative;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            color: var(--text-soft); text-decoration: none;
            padding: 0.75rem 1rem; border-radius: 8px;
            font-weight: 500; font-size: 0.9rem; transition: all 0.2s;
        }
        .sidebar-link:hover {
            color: var(--primary);
            background: rgba(37,99,235,0.08);
        }
        .sidebar-link.active {
            color: var(--primary);
            background: rgba(37,99,235,0.12);
            font-weight: 600;
        }
        .sidebar-link i { width: 1.2rem; text-align: center; }
        .sidebar-user {
            padding: 1rem 1.25rem; margin-top: auto; border-top: 1px solid var(--border);
        }
        .user-info { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 0.9rem; flex-shrink: 0;
        }
        .user-details { flex: 1; min-width: 0; }
        .user-name { font-weight: 600; font-size: 0.85rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.75rem; color: var(--text-dim); }
        .sidebar-actions { display: flex; gap: 0.5rem; margin-top: 0.75rem; }
        .sidebar-btn {
            flex: 1; padding: 0.5rem; border: 1px solid var(--border);
            border-radius: 6px; background: var(--surface);
            color: var(--text-soft); font-size: 0.8rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.3rem;
        }
        .sidebar-btn:hover { background: var(--surface-2); color: var(--text); }
        .sidebar-btn.logout { color: var(--danger); border-color: rgba(239,68,68,0.2); }
        .sidebar-btn.logout:hover { background: rgba(239,68,68,0.08); }
        .sidebar-toggle {
            display: none; position: fixed; top: 1rem; right: 1rem; z-index: 1001;
            background: white; border: 1px solid var(--border); border-radius: 8px;
            padding: 0.5rem; cursor: pointer; transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .sidebar-toggle:hover { background: var(--surface); }
        .dropdown-toggle-pill {
            background: rgba(37,99,235,0.1) !important;
            color: var(--primary) !important;
            border-radius: 8px !important;
            padding: 0.45rem 1.1rem !important;
            font-weight: 500; border: 1px solid rgba(37,99,235,0.2) !important;
            box-shadow: none !important;
        }
        .dropdown-menu {
            background: white !important;
            backdrop-filter: blur(18px);
            border: 1px solid var(--border) !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            padding: 0.5rem !important;
            min-width: 190px;
        }
        .dropdown-item {
            color: var(--text-soft) !important; border-radius: 8px;
            padding: 0.6rem 1rem; font-size: 0.9rem; transition: all 0.2s;
        }
        .dropdown-item:hover { background: var(--surface) !important; color: var(--primary) !important; }
        .dropdown-divider { border-color: var(--border) !important; margin: 0.35rem 0.5rem; }

        /* ── HERO ── */
        .hero {
            position: relative; z-index: 1;
            padding: 6rem 0 4rem;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.5rem;
            background: rgba(37,99,235,0.15);
            border: 1px solid rgba(37,99,235,0.25);
            color: var(--primary);
            border-radius: 8px;
            padding: 0.4rem 1rem;
            font-size: 0.8rem; font-weight: 600;
            letter-spacing: 0.02em;
            margin-bottom: 1.75rem;
        }
        .hero-badge .dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--primary);
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(0.8); }
        }
        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 800; font-size: clamp(2.4rem, 5vw, 3.8rem);
            line-height: 1.1; letter-spacing: -0.03em;
            color: var(--text);
        }
        .hero h1 .accent {
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero p {
            color: var(--text-soft); font-size: 1.1rem; line-height: 1.7;
            max-width: 540px; margin-top: 1.25rem;
        }
        .hero-actions { margin-top: 2.25rem; display: flex; gap: 0.85rem; flex-wrap: wrap; }
        .btn-hero {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.8rem 1.8rem;
            border-radius: 10px; font-weight: 600; font-size: 0.95rem;
            text-decoration: none; transition: all 0.25s; border: none;
        }
        .btn-hero-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }
        .btn-hero-primary:hover {
            transform: translateY(-2px);
            background: var(--primary-dark);
            box-shadow: 0 6px 16px rgba(37,99,235,0.4);
            color: white;
        }
        .btn-hero-ghost {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }
        .btn-hero-ghost:hover {
            background: rgba(37,99,235,0.05);
            transform: translateY(-1px);
        }

        /* ── HERO VISUAL ── */
        .hero-visual {
            position: relative;
        }
        .hero-card-mock {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .mock-stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px; padding: 1rem 1.25rem;
            text-align: center;
        }
        .mock-stat .num {
            font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .mock-stat small { color: var(--text-dim); font-size: 0.75rem; display: block; margin-top: 0.2rem; }
        .mock-item {
            background: var(--bg-light); border: 1px solid var(--border);
            border-radius: 12px; padding: 0.85rem 1rem;
            display: flex; align-items: center; gap: 0.85rem;
        }
        .mock-item-icon {
            width: 36px; height: 36px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; flex-shrink: 0; color: var(--primary);
        }
        .mock-tag {
            display: inline-block; padding: 0.2rem 0.7rem;
            border-radius: 6px; font-size: 0.68rem; font-weight: 600;
            background: rgba(37,99,235,0.1); color: var(--primary);
        }

        /* ── HOW IT WORKS ── */
        .section { position: relative; z-index: 1; padding: 5rem 0; }
        .section-label {
            display: inline-flex; align-items: center; gap: 0.5rem;
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--primary);
            margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Poppins', sans-serif; font-weight: 800;
            font-size: clamp(1.7rem, 3vw, 2.4rem);
            letter-spacing: -0.025em; color: var(--text);
        }
        .step-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            position: relative; overflow: hidden;
            transition: all 0.3s;
        }
        .step-card::before {
            content: ''; position: absolute;
            inset: 0; border-radius: inherit;
            opacity: 0; transition: opacity 0.3s;
        }
        .step-card:hover { 
            transform: translateY(-6px); 
            box-shadow: 0 8px 20px rgba(37,99,235,0.15);
            border-color: rgba(37,99,235,0.3);
        }
        .step-num {
            font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 3.5rem;
            line-height: 1; letter-spacing: -0.04em;
            background: linear-gradient(135deg, rgba(37,99,235,0.15), rgba(37,99,235,0.05));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            position: absolute; top: 1.25rem; right: 1.5rem;
        }
        .step-icon {
            width: 52px; height: 52px; border-radius: var(--r);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; margin-bottom: 1.25rem;
        }
        .step-card h4 {
            font-family: 'Poppins', sans-serif; font-weight: 700;
            font-size: 1.1rem; color: var(--text); margin-bottom: 0.6rem;
        }
        .step-card p { color: var(--text-soft); font-size: 0.92rem; line-height: 1.65; margin: 0; }

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 1;
            border-top: 1px solid var(--border);
            background: white;
            padding: 2rem 0;
            color: var(--text-dim); text-align: center; font-size: 0.88rem;
        }
        footer span { color: var(--primary); }

        @media (max-width: 992px) {
            .hero { padding: 4rem 0 2.5rem; }
            .hero-actions { flex-direction: column; align-items: stretch; }
            .hero-card-mock { padding: 1.25rem; }
            .step-card { padding: 1.35rem; }
        }

        @media (max-width: 768px) {
            body { margin-left: 0; }
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .page-wrap { padding: 2rem 0; }
            .hero h1 { font-size: clamp(2.1rem, 7vw, 3rem); }
            .hero p { max-width: 100%; }
            .btn-hero, .btn-hero-primary, .btn-hero-ghost { width: 100%; justify-content: center; }
            .orb { display: none; }
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- SIDEBAR TOGGLE (Mobile) -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list" style="font-size: 1.2rem;"></i>
    </button>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-star-fill text-white"></i></div>
            Aspira Siswa
        </div>
        <ul class="sidebar-menu">
            <!-- COMMON ITEMS (EVERYONE) -->
            <li class="sidebar-item">
                <a href="/" class="sidebar-link {{ request()->path() == '/' ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Beranda</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/aspirasi-publik" class="sidebar-link {{ request()->path() == 'aspirasi-publik' ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Aspirasi Kita</span>
                </a>
            </li>
            
            <!-- ADMIN-ONLY ITEMS -->
            @if(session('admin_id'))
            <li class="sidebar-item">
                <a href="/admin" class="sidebar-link {{ request()->path() == 'admin' ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/aspirasi" class="sidebar-link {{ request()->path() == 'aspirasi' ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Semua Laporan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/admin/approvals" class="sidebar-link {{ request()->path() == 'admin/approvals' ? 'active' : '' }}">
                    <i class="bi bi-person-check-fill"></i>
                    <span>Approval Registrasi</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/admin/kategori" class="sidebar-link {{ request()->path() == 'admin/kategori' ? 'active' : '' }}">
                    <i class="bi bi-tag"></i>
                    <span>Manajemen Kategori</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/admin/siswa" class="sidebar-link {{ request()->path() == 'admin/siswa' ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Manajemen Siswa</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/admin/profile" class="sidebar-link {{ request()->path() == 'admin/profile' ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Admin</span>
                </a>
            </li>
            @endif
            
            <!-- USER-ONLY ITEMS -->
            @if(session('siswa_nis'))
            <li class="sidebar-item">
                <a href="/laporan-saya" class="sidebar-link {{ request()->path() == 'laporan-saya' ? 'active' : '' }}">
                    <i class="bi bi-collection"></i>
                    <span>Laporan Saya</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/notifications" class="sidebar-link {{ request()->path() == 'notifications' ? 'active' : '' }}">
                    <i class="bi bi-bell"></i>
                    <span>Pemberitahuan</span>
                    @php
                        $unreadCount = \App\Models\Notification::where('user_id', session('siswa_nis'))->whereNull('read_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge bg-danger ms-auto" style="font-size: 0.65rem;">{{ $unreadCount }}</span>
                    @endif
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/audit-log" class="sidebar-link {{ request()->path() == 'audit-log' ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat Aktivitas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/profile" class="sidebar-link {{ request()->path() == 'profile' ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            @endif
        </ul>
        
        @if(session('siswa_nis') || session('admin_id'))
        <div class="sidebar-user">
            <div class="user-info">
                <div class="user-avatar">
                    @if(session('admin_id'))
                        <i class="bi bi-shield-check"></i>
                    @else
                        {{ strtoupper(substr(session('siswa_nama'), 0, 1)) }}
                    @endif
                </div>
                <div class="user-details">
                    <div class="user-name">{{ session('admin_id') ? session('admin_nama') : session('siswa_nama') }}</div>
                    <div class="user-role">{{ session('admin_id') ? 'Admin' : 'Siswa' }}</div>
                </div>
            </div>
            <div class="sidebar-actions">
                <a href="/logout" class="sidebar-btn logout" title="Keluar">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
        @else
        <div class="sidebar-user">
            <a href="/login" class="sidebar-btn" style="justify-content: center; text-decoration: none; color: var(--primary);">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Masuk</span>
            </a>
        </div>
        @endif
    </aside>

    <!-- HERO -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-badge">
                        <span class="dot"></span>
                        Aspira Siswa
                    </div>
                    <h1>Ada Keluhan<br>di Sekolah?<br><span class="accent">Laporkan Di Sini,</span><br><span class="accent">Langsung!</span></h1>
                    <p>Jangan diam sendiri. Baik itu fasilitas rusak, lingkungan kurang bersih, atau ide kreatif — silakan laporkan. Semua data aman, dan masalah akan ditindaklanjuti!</p>
                    <div class="hero-actions">
                        @if(session('siswa_nis'))
                            <a href="/aspirasi" class="btn-hero btn-hero-primary"><i class="bi bi-pencil-square"></i> Buat Laporan</a>
                        @elseif(session('admin_id'))
                            <a href="/admin" class="btn-hero btn-hero-primary"><i class="bi bi-speedometer2"></i> Panel Pengelola</a>
                        @else
                            <a href="/login" class="btn-hero btn-hero-primary"><i class="bi bi-box-arrow-in-right"></i> Masuk & Laporkan</a>
                        @endif
                        <a href="#alur" class="btn-hero btn-hero-ghost"><i class="bi bi-arrow-down"></i> Lihat Caranya</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-visual">
                        <div class="hero-card-mock">
                            <div style="position: relative; overflow: hidden; border-radius: 12px; background: linear-gradient(135deg, rgba(37,99,235,0.08) 0%, rgba(168,85,247,0.08) 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
                                <!-- SVG Illustration -->
                                <svg viewBox="0 0 300 300" style="width: 100%; height: 100%; max-width: 320px;" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Background circle -->
                                    <circle cx="150" cy="150" r="145" fill="rgba(37, 99, 235, 0.05)" stroke="rgba(37, 99, 235, 0.15)" stroke-width="2"/>
                                    
                                    <!-- Person -->
                                    <circle cx="150" cy="80" r="18" fill="#2563eb"/>
                                    <path d="M 150 100 L 150 150 M 135 120 L 165 120 M 150 150 L 140 190 M 150 150 L 160 190" stroke="#2563eb" stroke-width="3" stroke-linecap="round" fill="none"/>
                                    
                                    <!-- Speech bubble -->
                                    <rect x="70" y="40" width="160" height="50" rx="12" fill="white" stroke="rgba(37, 99, 235, 0.2)" stroke-width="2"/>
                                    <path d="M 85 92 L 80 105 L 95 95 Z" fill="white"/>
                                    <text x="150" y="65" text-anchor="middle" font-family="Poppins" font-size="12" fill="#2563eb" font-weight="600">Laporkan Masalah</text>
                                    
                                    <!-- Documents -->
                                    <rect x="40" y="140" width="35" height="45" rx="3" fill="rgba(37, 99, 235, 0.2)" stroke="#2563eb" stroke-width="1.5"/>
                                    <line x1="45" y1="150" x2="70" y2="150" stroke="#2563eb" stroke-width="1"/>
                                    <line x1="45" y1="158" x2="70" y2="158" stroke="#2563eb" stroke-width="1"/>
                                    <line x1="45" y1="166" x2="65" y2="166" stroke="#2563eb" stroke-width="1"/>
                                    
                                    <rect x="95" y="140" width="35" height="45" rx="3" fill="rgba(37, 99, 235, 0.2)" stroke="#2563eb" stroke-width="1.5"/>
                                    <line x1="100" y1="150" x2="125" y2="150" stroke="#2563eb" stroke-width="1"/>
                                    <line x1="100" y1="158" x2="125" y2="158" stroke="#2563eb" stroke-width="1"/>
                                    <line x1="100" y1="166" x2="120" y2="166" stroke="#2563eb" stroke-width="1"/>
                                    
                                    <!-- Checkmark -->
                                    <circle cx="225" cy="162" r="22" fill="rgba(16, 185, 129, 0.2)" stroke="#10b981" stroke-width="2"/>
                                    <path d="M 218 162 L 222 167 L 232 157" stroke="#10b981" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                    
                                    <!-- Stars -->
                                    <circle cx="60" cy="50" r="3" fill="rgba(37, 99, 235, 0.5)"/>
                                    <circle cx="240" cy="70" r="2.5" fill="rgba(37, 99, 235, 0.4)"/>
                                    <circle cx="250" cy="180" r="2" fill="rgba(37, 99, 235, 0.3)"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT SCHOOL -->
    <section class="section" style="background: linear-gradient(135deg, rgba(37,99,235,0.08) 0%, rgba(168,85,247,0.08) 100%); margin: 0 -9999px; padding: 5rem 9999px;">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 d-flex align-items-center justify-content-center">
                    <!-- School Building Illustration -->
                    <svg viewBox="0 0 300 300" style="width: 100%; height: 100%; max-width: 320px;" xmlns="http://www.w3.org/2000/svg">
                        <!-- Sky -->
                        <rect width="300" height="120" fill="rgba(14, 165, 233, 0.1)"/>
                        
                        <!-- Sun -->
                        <circle cx="250" cy="30" r="20" fill="rgba(245, 158, 11, 0.8)"/>
                        
                        <!-- Building Main -->
                        <rect x="50" y="100" width="200" height="150" fill="rgba(37, 99, 235, 0.15)" stroke="rgba(37, 99, 235, 0.3)" stroke-width="2"/>
                        
                        <!-- Roof -->
                        <polygon points="50,100 150,40 250,100" fill="rgba(37, 99, 235, 0.25)" stroke="rgba(37, 99, 235, 0.4)" stroke-width="2"/>
                        
                        <!-- Flag on roof -->
                        <rect x="145" y="35" width="10" height="20" fill="rgba(37, 99, 235, 0.4)"/>
                        <polygon points="155,40 180,35 175,50" fill="rgba(245, 158, 11, 0.9)"/>
                        
                        <!-- Windows - Left Column -->
                        <rect x="70" y="120" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="80" y1="120" x2="80" y2="140" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="70" y1="130" x2="90" y2="130" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="70" y="155" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="80" y1="155" x2="80" y2="175" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="70" y1="165" x2="90" y2="165" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="70" y="190" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="80" y1="190" x2="80" y2="210" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="70" y1="200" x2="90" y2="200" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <!-- Windows - Middle Column -->
                        <rect x="110" y="120" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="120" y1="120" x2="120" y2="140" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="110" y1="130" x2="130" y2="130" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="110" y="155" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="120" y1="155" x2="120" y2="175" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="110" y1="165" x2="130" y2="165" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="110" y="190" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="120" y1="190" x2="120" y2="210" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="110" y1="200" x2="130" y2="200" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <!-- Windows - Right Column -->
                        <rect x="150" y="120" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="160" y1="120" x2="160" y2="140" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="150" y1="130" x2="170" y2="130" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="150" y="155" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="160" y1="155" x2="160" y2="175" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="150" y1="165" x2="170" y2="165" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="150" y="190" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="160" y1="190" x2="160" y2="210" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="150" y1="200" x2="170" y2="200" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <!-- Windows - Far Right Column -->
                        <rect x="190" y="120" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="200" y1="120" x2="200" y2="140" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="190" y1="130" x2="210" y2="130" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="190" y="155" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="200" y1="155" x2="200" y2="175" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="190" y1="165" x2="210" y2="165" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <rect x="190" y="190" width="20" height="20" fill="rgba(14, 165, 233, 0.3)" stroke="rgba(37, 99, 235, 0.5)" stroke-width="1"/>
                        <line x1="200" y1="190" x2="200" y2="210" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        <line x1="190" y1="200" x2="210" y2="200" stroke="rgba(37, 99, 235, 0.5)" stroke-width="0.5"/>
                        
                        <!-- Main Door -->
                        <rect x="130" y="220" width="40" height="30" fill="rgba(120, 113, 108, 0.3)" stroke="rgba(37, 99, 235, 0.4)" stroke-width="1.5"/>
                        <circle cx="165" cy="235" r="2" fill="rgba(37, 99, 235, 0.5)"/>
                        
                        <!-- Ground -->
                        <ellipse cx="150" cy="260" rx="100" ry="15" fill="rgba(34, 197, 94, 0.15)"/>
                    </svg>
                </div>
                <div class="col-lg-6">
                    <div class="section-label"><i class="bi bi-building"></i> Tentang Sekolah</div>
                    <h2 class="section-title">SMKN 7 Batam</h2>
                    <p style="color: var(--text-soft); font-size: 1rem; line-height: 1.8; margin-bottom: 1.5rem;">
                        SMK Negeri 7 Batam adalah sebuah institusi pendidikan kejuruan yang berkomitmen untuk mengembangkan keterampilan dan karakter siswa-siswanya. Dengan fasilitas lengkap dan pengajar berpengalaman, kami menciptakan lingkungan belajar yang kondusif dan inovatif.
                    </p>
                    <p style="color: var(--text-soft); font-size: 1rem; line-height: 1.8; margin-bottom: 1.5rem;">
                        Platform <strong style="color: var(--primary);">Aspira Siswa</strong> adalah bagian dari komitmen kami untuk meningkatkan partisipasi siswa dalam pengembangan sekolah. Kami percaya bahwa setiap suara siswa penting dan akan menjadi bahan evaluasi untuk perbaikan berkelanjutan.
                    </p>
                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                        <div>
                            <div style="font-weight: 700; color: var(--primary); font-size: 1.25rem;">1000+</div>
                            <div style="color: var(--text-soft); font-size: 0.9rem;">Siswa Aktif</div>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--primary); font-size: 1.25rem;">50+</div>
                            <div style="color: var(--text-soft); font-size: 0.9rem;">Pengajar Berdedikasi</div>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: var(--primary); font-size: 1.25rem;">15+</div>
                            <div style="color: var(--text-soft); font-size: 0.9rem;">Program Keahlian</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="alur" class="section">
        <div class="container">
            <div class="text-center mb-5">

                <h2 class="section-title">Bagaimana Prosesnya?</h2>
                <p style="color: var(--text-soft); max-width: 480px; margin: 0.85rem auto 0; font-size: 0.95rem;">Tiga tahap sederhana dari laporan hingga penyelesaian masalah.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card">
                        <span class="step-num">01</span>
                        <div class="step-icon" style="background: rgba(37,99,235,0.14);">
                            <i class="bi bi-pencil-square" style="color: var(--primary);"></i>
                        </div>
                        <h4>Buat Laporan</h4>
                        <p>Login dengan NIS Anda, kemudian jelaskan masalah atau masukan dengan detail dan akurat.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <span class="step-num">02</span>
                        <div class="step-icon" style="background: rgba(245,158,11,0.12);">
                            <i class="bi bi-gear-wide-connected" style="color: var(--warning);"></i>
                        </div>
                        <h4>Verifikasi Masalah</h4>
                        <p>Pengelola akan memeriksa laporan Anda. Status akan berubah menjadi 'Diproses' saat penanganan dimulai.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <span class="step-num">03</span>
                        <div class="step-icon" style="background: rgba(16,185,129,0.12);">
                            <i class="bi bi-check2-all" style="color: var(--success);"></i>
                        </div>
                        <h4>Terima Umpan Balik</h4>
                        <p>Setelah masalah teratasi, Anda akan menerima umpan balik langsung dari pengelola melalui aplikasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p>© 2026 <span>Aspira Siswa</span> — Proyek Pembelajaran UKK Terbaik | Dirancang oleh Vourel Oktofit Avin</p>
            <p style="margin-top: 0.35rem; font-size: 0.8rem;">Dikembangkan dengan dedikasi dan teknologi terkini.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
            // Close sidebar when clicking on a link
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('mobile-open');
                    }
                });
            });
        }
    </script>
</body>
</html>