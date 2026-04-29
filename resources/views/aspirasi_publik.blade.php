<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aspirasi Publik — Aspira Siswa</title>
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
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light); color: var(--text); min-height: 100vh;
            margin-left: 260px; transition: margin-left 0.3s;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.03) 0%, rgba(168,85,247,0.03) 100%);
            pointer-events: none; z-index: 0;
        }
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; opacity: 0.3; }
        .orb-1 { width: 500px; height: 500px; top: -100px; right: -80px; background: radial-gradient(circle, rgba(37,99,235,0.2), transparent 70%); }
        .orb-2 { width: 350px; height: 350px; bottom: -60px; left: -60px; background: radial-gradient(circle, rgba(168,85,247,0.15), transparent 70%); }

        /* ── PAGE ── */
        .page-wrap { position: relative; z-index: 1; padding: 2.5rem 0 5rem; }

        /* ── HERO BANNER ── */
        .page-hero {
            background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(168,85,247,0.08) 100%);
            border: 1px solid rgba(37,99,235,0.15);
            border-radius: 16px; padding: 2.25rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
            position: relative; overflow: hidden;
        }
        .page-hero::after {
            content: ''; position: absolute; top: -60px; right: -60px;
            width: 250px; height: 250px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.1), transparent 70%);
        }
        .hero-label {
            display: inline-flex; align-items: center; gap: 0.45rem;
            background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.25);
            color: var(--primary); border-radius: 8px; padding: 0.4rem 1rem;
            font-size: 0.78rem; font-weight: 700; letter-spacing: 0.02em;
            margin-bottom: 1rem;
        }
        .hero-label .dot { width: 5px; height: 5px; border-radius: 50%; background: var(--primary); }
        .page-hero h1 {
            font-size: clamp(1.7rem, 3vw, 2.4rem); font-weight: 800;
            letter-spacing: -0.025em; margin-bottom: 0.75rem; color: var(--text);
        }
        .page-hero p {
            color: var(--text-soft); font-size: 1rem; margin: 0;
        }

        /* ── CARDS GRID ── */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.75rem;
            margin-bottom: 2rem;
        }
        .card-aspirasi {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        .card-aspirasi:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(37,99,235,0.15);
            border-color: rgba(37,99,235,0.3);
        }
        .card-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, rgba(37,99,235,0.1), rgba(168,85,247,0.08));
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .card-image img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .card-image-placeholder {
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem; color: rgba(37,99,235,0.2);
        }
        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .card-category {
            display: inline-block;
            background: rgba(37,99,235,0.12);
            border: 1px solid rgba(37,99,235,0.25);
            color: var(--primary);
            border-radius: 6px;
            padding: 0.2rem 0.7rem;
            font-size: 0.72rem;
            font-weight: 700;
            margin-bottom: 0.7rem;
            width: fit-content;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }
        .card-location {
            display: flex; align-items: center; gap: 0.4rem;
            color: var(--text-soft);
            font-size: 0.85rem;
            margin-bottom: 0.8rem;
        }
        .card-description {
            color: var(--text-soft);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.75rem;
            border-top: 1px solid var(--border);
        }
        .card-date {
            color: var(--text-dim);
            font-size: 0.78rem;
            display: flex; align-items: center; gap: 0.3rem;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border-radius: 6px;
            padding: 0.25rem 0.65rem;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .badge-status.menunggu {
            background: rgba(245,158,11,0.12);
            border: 1px solid rgba(245,158,11,0.25);
            color: var(--warning);
        }
        .badge-status.proses {
            background: rgba(59,130,246,0.12);
            border: 1px solid rgba(59,130,246,0.25);
            color: #3b82f6;
        }
        .badge-status.selesai {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.25);
            color: var(--success);
        }

        /* ── FEEDBACK SECTION ── */
        .card-feedback {
            background: linear-gradient(135deg, rgba(37,99,235,0.05), rgba(14,165,233,0.05));
            border: 1px solid rgba(37,99,235,0.15);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1rem;
        }
        .feedback-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 700;
            font-size: 0.85rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .feedback-text {
            color: var(--text-soft);
            font-size: 0.88rem;
            line-height: 1.6;
            margin: 0;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center; padding: 3rem 1.5rem;
        }
        .empty-icon { font-size: 4rem; color: var(--text-dim); margin-bottom: 1rem; }
        .empty-state h3 { color: var(--text); font-weight: 700; margin-bottom: 0.5rem; }
        .empty-state p { color: var(--text-soft); font-size: 0.95rem; }

        /* ── PAGINATION ── */
        .pagination {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }
        .page-link {
            background: white !important;
            border: 1px solid var(--border) !important;
            color: var(--primary) !important;
            border-radius: 8px;
            padding: 0.5rem 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
            font-size: 0.9rem;
        }
        .page-link:hover {
            background: rgba(37,99,235,0.08) !important;
            border-color: var(--primary) !important;
        }
        .page-link.active {
            background: var(--primary) !important;
            color: white !important;
            border-color: var(--primary) !important;
        }

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
            width: 32px; height: 32px; border-radius: 9px;
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
        .sidebar-divider { height: 1px; background: var(--border); margin: 0.75rem 0.5rem; }
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

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 1;
            border-top: 1px solid var(--border);
            padding: 1.5rem 0;
            text-align: center; color: var(--text-dim); font-size: 0.83rem;
            background: white;
        }

        @media (max-width: 768px) {
            body { margin-left: 0; }
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .page-wrap { padding: 1.5rem 0 3rem; }
            .page-hero { padding: 1.5rem; }
            .page-hero h1 { font-size: 1.4rem; }
            .cards-grid { grid-template-columns: 1fr; gap: 1.25rem; }
            .card-image { height: 150px; }
            .navbar .container { gap: 0.75rem; flex-wrap: wrap; }
            .navbar-nav { flex-direction: column; align-items: stretch; }
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
            <div class="brand-icon"><i class="bi bi-star-fill text-white" style="font-size: 0.78rem;"></i></div>
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

    <!-- PAGE CONTENT -->
    <div class="page-wrap">
        <div class="container">
            <!-- HERO BANNER -->
            <div class="page-hero">
                <div class="hero-label">
                    <span class="dot"></span>
                    Lihat dan Pelajari
                </div>
                <h1><i class="bi bi-chat-dots me-2"></i>Aspirasi Publik</h1>
                <p>Jelajahi semua laporan yang telah diajukan oleh siswa. Ikuti perkembangan setiap aspirasi dari tahap menunggu hingga selesai diperbaiki.</p>
            </div>

            <!-- CARDS CONTENT -->
            @if($aspirasis->count() > 0)
                <div class="cards-grid">
                    @foreach($aspirasis as $aspirasi)
                        <a href="/aspirasi/{{ $aspirasi->id_pelaporan }}" class="card-aspirasi" style="text-decoration: none; color: inherit;">
                            <!-- Image -->
                            <div class="card-image">
                                @if($aspirasi->foto)
                                    <img src="{{ asset($aspirasi->foto) }}" alt="{{ $aspirasi->ket }}">
                                @else
                                    <div class="card-image-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Body -->
                            <div class="card-body">
                                <span class="card-category">{{ $aspirasi->kategori->nama_kategori ?? 'Umum' }}</span>
                                <h3 class="card-title">{{ Str::limit($aspirasi->ket, 60) }}</h3>
                                <div class="card-location">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    <span>{{ $aspirasi->lokasi }}</span>
                                </div>
                                <p class="card-description">{{ Str::limit($aspirasi->ket, 120) }}</p>
                                
                                <!-- Feedback Section -->
                                @if($aspirasi->feedback)
                                    <div class="card-feedback">
                                        <div class="feedback-header">
                                            <i class="bi bi-chat-fill"></i>
                                            Respons Admin
                                        </div>
                                        <p class="feedback-text">{{ $aspirasi->feedback }}</p>
                                    </div>
                                @endif
                                
                                <!-- Footer -->
                                <div class="card-footer">
                                    <span class="card-date">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $aspirasi->created_at->format('d M Y') }}
                                    </span>
                                    <span class="badge-status {{ strtolower($aspirasi->status) }}">
                                        @if($aspirasi->status === 'Menunggu')
                                            <i class="bi bi-hourglass-split"></i>
                                        @elseif($aspirasi->status === 'Proses')
                                            <i class="bi bi-arrow-repeat"></i>
                                        @else
                                            <i class="bi bi-check-circle-fill"></i>
                                        @endif
                                        {{ $aspirasi->status }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- PAGINATION -->
                <div class="d-flex justify-content-center">
                    {{ $aspirasis->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                    <h3>Belum Ada Aspirasi</h3>
                    <p>Saat ini belum ada aspirasi yang diajukan. Mulai gunakan aplikasi ini untuk menyuarakan aspirasi Anda.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <p>&copy; 2026 Aspira Siswa — SMKN 7 Batam. Dibuat dengan <span>❤️</span> untuk komunitas siswa. | Dirancang oleh Vourel Oktofit Avin</p>
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
