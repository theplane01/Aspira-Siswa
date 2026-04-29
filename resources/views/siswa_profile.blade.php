<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — Aspira Siswa</title>
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
            background: var(--bg-light);
            color: var(--text); min-height: 100vh;
            margin-left: 260px;
            transition: margin-left 0.3s;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.03) 0%, rgba(168,85,247,0.03) 100%);
            pointer-events: none; z-index: 0;
        }
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; opacity: 0.3; }
        .orb-1 { width: 500px; height: 500px; top: -100px; right: -80px; background: radial-gradient(circle, rgba(37,99,235,0.2), transparent 70%); }

        /* ── PAGE LAYOUT ── */
        .page-wrap { position: relative; z-index: 1; padding: 2.5rem 0 5rem; }

        /* ── PROFILE HEADER ── */
        .profile-hero {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem 2.25rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            position: relative; overflow: hidden;
        }
        .profile-hero::before {
            content: ''; position: absolute; top: -40px; right: -40px;
            width: 200px; height: 200px; border-radius: 50%;
            background: radial-gradient(circle, rgba(37,99,235,0.1), transparent 70%);
        }
        .avatar-ring {
            width: 68px; height: 68px; border-radius: 12px;
            background: linear-gradient(135deg, rgba(37,99,235,0.15), rgba(14,165,233,0.1));
            border: 1px solid rgba(37,99,235,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.75rem; flex-shrink: 0; color: var(--primary);
        }
        .profile-name {
            font-family: 'Poppins', sans-serif; font-weight: 700;
            font-size: 1.35rem; color: var(--text); margin: 0 0 0.3rem;
        }
        .profile-meta { color: var(--text-soft); font-size: 0.88rem; }
        .profile-meta span { color: var(--text-dim); }
        .pill-active {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.25);
            color: var(--success);
            border-radius: 8px; padding: 0.35rem 0.9rem;
            font-size: 0.75rem; font-weight: 700; margin-top: 0.6rem;
        }
        .pill-active::before {
            content: ''; width: 6px; height: 6px; border-radius: 50%;
            background: var(--success);
        }

        /* ── STATS ── */
        .stats-row { display: flex; gap: 1rem; flex-wrap: wrap; align-items: stretch; }
        .stat-chip {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px; padding: 1rem;
            text-align: center; min-width: 100px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .stat-chip .num {
            font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .stat-chip small { display: block; color: var(--text-dim); font-size: 0.75rem; margin-top: 0.25rem; font-weight: 600; }

        /* ── CARD ── */
        .content-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .card-title {
            font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.05rem;
            color: var(--text); display: flex; align-items: center; gap: 0.6rem;
            margin-bottom: 1.5rem;
        }
        .card-title i { color: var(--primary); }

        /* ── TABLE ── */
        .report-table { width: 100%; border-collapse: separate; border-spacing: 0 0.55rem; }
        .report-table thead th {
            color: var(--text-dim); font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            padding: 0 1rem 0.75rem;
            border-bottom: 2px solid var(--surface);
        }
        .report-table tbody tr {
            background: white;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }
        .report-table tbody tr:hover {
            background: var(--bg-light);
            box-shadow: 0 2px 8px rgba(37,99,235,0.1);
        }
        .report-table tbody td {
            padding: 1rem;
            border: none; vertical-align: middle;
            font-size: 0.87rem;
        }
        .report-table tbody td:first-child { border-radius: 8px 0 0 8px; }
        .report-table tbody td:last-child  { border-radius: 0 8px 8px 0; }

        /* ── STATUS BADGES ── */
        .badge-done {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25);
            color: var(--success); border-radius: 6px;
            padding: 0.3rem 0.8rem; font-size: 0.75rem; font-weight: 700;
        }
        .badge-proc {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.25);
            color: var(--warning); border-radius: 6px;
            padding: 0.3rem 0.8rem; font-size: 0.75rem; font-weight: 700;
        }
        .badge-wait {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25);
            color: var(--danger); border-radius: 6px;
            padding: 0.25rem 0.75rem; font-size: 0.73rem; font-weight: 700;
        }
        .badge-dot {
            width: 5px; height: 5px; border-radius: 50%;
            background: currentColor;
        }

        /* ── EMPTY ── */
        .empty-state {
            text-align: center; padding: 3.5rem 1rem;
        }
        .empty-icon {
            width: 70px; height: 70px; border-radius: 1.2rem;
            background: rgba(99,130,255,0.08); border: 1px solid rgba(99,130,255,0.15);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.25rem; font-size: 1.75rem; color: var(--text-dim);
        }
        .empty-state h5 {
            font-family: 'Sora', sans-serif; font-weight: 700; font-size: 1rem;
            color: var(--text); margin-bottom: 0.5rem;
        }
        .empty-state p { color: var(--text-soft); font-size: 0.88rem; margin-bottom: 1.5rem; }
        .btn-primary-pill {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.7rem 1.5rem; border-radius: 999px;
            background: linear-gradient(135deg, var(--indigo), #7c3aed);
            color: #fff; font-weight: 600; font-size: 0.88rem;
            border: none; text-decoration: none;
            box-shadow: 0 6px 18px rgba(101,116,248,0.3);
            transition: all 0.25s; cursor: pointer;
        }
        .btn-primary-pill:hover {
            box-shadow: 0 8px 24px rgba(101,116,248,0.45);
            transform: translateY(-1px); color: #fff;
        }

        /* ── FEEDBACK ── */
        .feedback-bubble {
            background: rgba(101,116,248,0.08);
            border-left: 3px solid var(--indigo);
            border-radius: 0 0.6rem 0.6rem 0;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem; color: var(--text-soft);
            font-style: italic;
        }

        /* ── NOTIFICATION HISTORY ── */
        .notification-history { margin-bottom: 1rem; }
        .notification-item {
            background: rgba(99,130,255,0.06);
            border: 1px solid rgba(99,130,255,0.12);
            border-radius: 0.8rem;
            padding: 1rem;
            margin-bottom: 0.8rem;
            transition: all 0.2s;
        }
        .notification-item:hover {
            background: rgba(99,130,255,0.1);
            border-color: rgba(99,130,255,0.2);
        }
        .notification-item.unread {
            border-left: 3px solid var(--indigo);
            background: rgba(101,116,248,0.08);
        }
        .notification-title {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }
        .notification-message {
            color: var(--text-soft);
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
        }
        .notification-time {
            color: var(--text-dim);
            font-size: 0.75rem;
        }
        .badge-unread {
            background: var(--indigo);
            color: #fff;
            font-size: 0.65rem;
            padding: 0.15rem 0.45rem;
            border-radius: 999px;
            font-weight: 600;
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
            border-top: 1px solid rgba(99,130,255,0.08);
            padding: 1.5rem 0;
            text-align: center; color: var(--text-dim); font-size: 0.83rem;
        }

        @media (max-width: 992px) {
            .profile-hero { padding: 1.5rem 1.5rem; }
            .stats-row { flex-direction: column; }
            .card-head { flex-direction: column; align-items: stretch; gap: 1rem; }
            .content-card { padding: 1.5rem; }
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
            .report-table tbody td { padding: 0.8rem; font-size: 0.86rem; }
            .badge-unread { font-size: 0.72rem; padding: 0.2rem 0.5rem; }
            .navbar .container { gap: 0.75rem; flex-wrap: wrap; }
            .navbar-nav { flex-direction: column; align-items: stretch; }
            .orb { display: none; }
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>

    <!-- SIDEBAR TOGGLE (Mobile) -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list" style="font-size: 1.2rem;"></i>
    </button>

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <div class="page-wrap">
        <div class="container">

            <!-- PROFILE HERO -->
            <div class="profile-hero">
                <div class="d-flex align-items-start gap-4 flex-wrap">
                    <div class="avatar-ring">
                        <i class="bi bi-person-fill" style="color: var(--indigo);"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="profile-name">{{ $user->nama }}</h2>
                        <p class="profile-meta">
                            <i class="bi bi-card-text me-1"></i> NIS: {{ $user->nis }}
                            <span class="mx-2">·</span>
                            <i class="bi bi-door-open me-1"></i> Kelas {{ $user->kelas }}
                        </p>
                        <div class="pill-active">Pelajar Terdaftar</div>
                    </div>
                    <div class="stats-row">
                        <div class="stat-chip">
                            <div class="num">{{ $laporan_saya->count() }}</div>
                            <small>Total Laporan</small>
                        </div>
                        <div class="stat-chip">
                            <div class="num">{{ $laporan_saya->where('status','Selesai')->count() }}</div>
                            <small>Selesai</small>
                        </div>
                        <div class="stat-chip">
                            <div class="num">{{ $laporan_saya->where('status','Menunggu')->count() }}</div>
                            <small>Menunggu</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REPORT LIST -->
            <div class="content-card">
                <div class="card-title">
                    <i class="bi bi-clock-history"></i> Kronologi Laporan Saya
                </div>

                @if($laporan_saya->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon"><i class="bi bi-clipboard2-check"></i></div>
                        <h5>Belum Ada Laporan</h5>
                        <p>Sekolah kita sudah berjalan dengan baik? Jika ada keluhan, silakan laporkan sekarang!</p>
                        <a href="/aspirasi" class="btn-primary-pill"><i class="bi bi-pencil-square"></i> Ajukan Laporan Baru</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Kondisi</th>
                                    <th>Tanggapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan_saya as $laporan)
                                <tr>
                                    <td>
                                        <span style="color: var(--text-dim); font-size: 0.8rem; white-space: nowrap;">
                                            {{ $laporan->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; font-size: 0.88rem; color: var(--text);">
                                            {{ $laporan->kategori?->ket_kategori ?? 'N/A' }}
                                        </div>
                                        <div style="color: var(--text-soft); font-size: 0.82rem; margin-top: 0.2rem; max-width: 320px;">
                                            {{ $laporan->ket }}
                                        </div>
                                        @if($laporan->foto)
                                            <div class="mt-2">
                                                <a href="{{ asset($laporan->foto) }}" target="_blank">
                                                    <img src="{{ asset($laporan->foto) }}" alt="Foto"
                                                        style="width: 80px; height: 56px; object-fit: cover; border-radius: 0.6rem; border: 1px solid var(--gb);">
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($laporan->status == 'Selesai')
                                            <span class="badge-done"><span class="badge-dot"></span> Selesai</span>
                                        @elseif($laporan->status == 'Proses')
                                            <span class="badge-proc"><span class="badge-dot"></span> Proses</span>
                                        @else
                                            <span class="badge-wait"><span class="badge-dot"></span> Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($laporan->feedback)
                                            <div class="feedback-bubble">"{{ $laporan->feedback }}"</div>
                                        @else
                                            <span style="color: var(--text-dim); font-size: 0.8rem; font-style: italic;">
                                                <i class="bi bi-hourglass-split me-1"></i>Menanti tanggapan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- NOTIFICATION HISTORY -->
            <div class="content-card">
                <div class="card-title">
                    <i class="bi bi-bell"></i> Riwayat Notifikasi
                </div>

                @php
                    $recentNotifications = \App\Models\Notification::where('user_id', session('siswa_nis'))
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
                @endphp

                @if($recentNotifications->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon"><i class="bi bi-bell-slash"></i></div>
                        <h5>Belum Ada Notifikasi</h5>
                        <p>Notifikasi akan muncul saat ada update pada laporan kamu.</p>
                    </div>
                @else
                    <div class="notification-history">
                        @foreach($recentNotifications as $notif)
                        <div class="notification-item {{ $notif->read_at ? '' : 'unread' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="notification-title">{{ $notif->title }}</div>
                                    <div class="notification-message">{{ $notif->message }}</div>
                                    <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                                </div>
                                @if(!$notif->read_at)
                                <span class="badge-unread">Baru</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <a href="/notifications" class="btn-primary-pill"><i class="bi bi-bell"></i> Lihat Semua Notifikasi</a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <footer>
        <div class="container">
            © 2026 Aspira Siswa — Semua laporan aman dan terjaga. | Dirancang oleh Vourel Oktofit Avin
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