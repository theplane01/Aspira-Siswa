<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Log & Aktivitas — Aspira Siswa</title>
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
        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.03) 0%, rgba(168,85,247,0.03) 100%);
            pointer-events: none;
        }
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
        .sidebar-brand { display: flex; align-items: center; gap: 0.55rem; padding: 0 1.25rem; margin-bottom: 1.5rem; font-weight: 800; font-size: 1.1rem; color: var(--text); }
        .brand-icon { width: 34px; height: 34px; border-radius: 10px; background: linear-gradient(135deg, var(--primary), var(--info)); display: flex; align-items: center; justify-content: center; font-size: 0.82rem; color: white; flex-shrink: 0; }
        .sidebar-menu { list-style: none; margin: 0; padding: 0; }
        .sidebar-item { margin: 0.3rem 0.75rem; position: relative; }
        .sidebar-link { display: flex; align-items: center; gap: 0.75rem; color: var(--text-soft); text-decoration: none; padding: 0.75rem 1rem; border-radius: 8px; font-weight: 500; font-size: 0.9rem; transition: all 0.2s; }
        .sidebar-link:hover { color: var(--primary); background: rgba(37,99,235,0.08); }
        .sidebar-link.active { color: var(--primary); background: rgba(37,99,235,0.12); font-weight: 600; }
        .sidebar-link i { width: 1.2rem; text-align: center; }
        .sidebar-user { padding: 1rem 1.25rem; margin-top: auto; border-top: 1px solid var(--border); }
        .user-info { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
        .user-avatar { width: 36px; height: 36px; border-radius: 8px; background: linear-gradient(135deg, var(--primary), var(--info)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.9rem; flex-shrink: 0; }
        .user-details { flex: 1; min-width: 0; }
        .user-name { font-weight: 600; font-size: 0.85rem; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 0.75rem; color: var(--text-dim); }
        .sidebar-actions { display: flex; gap: 0.5rem; margin-top: 0.75rem; }
        .sidebar-btn { flex: 1; padding: 0.5rem; border: 1px solid var(--border); border-radius: 6px; background: var(--surface); color: var(--text-soft); font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 0.3rem; }
        .sidebar-btn:hover { background: var(--surface-2); color: var(--text); }
        .sidebar-btn.logout { color: var(--danger); border-color: rgba(239,68,68,0.2); }
        .sidebar-btn.logout:hover { background: rgba(239,68,68,0.08); }
        .sidebar-toggle { display: none; position: fixed; top: 1rem; right: 1rem; z-index: 1001; background: white; border: 1px solid var(--border); border-radius: 8px; padding: 0.5rem; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .sidebar-toggle:hover { background: var(--surface); }

        /* ── PAGE ── */
        .page-wrap { position: relative; z-index: 1; padding: 2.5rem 0 5rem; }

        /* ── HERO BANNER ── */
        .page-hero {
            background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(168,85,247,0.08) 100%);
            border: 1px solid rgba(37,99,235,0.15);
            border-radius: 16px; padding: 2.25rem;
            margin-bottom: 2rem;
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
            color: var(--primary); border-radius: 8px;
            padding: 0.4rem 1rem; font-size: 0.75rem; font-weight: 700;
            letter-spacing: 0.04em; margin-bottom: 1rem;
        }
        .page-hero h1 {
            font-weight: 800; font-size: clamp(1.8rem, 3vw, 2.4rem);
            color: var(--text); margin-bottom: 0.6rem;
        }
        .page-hero p { color: var(--text-soft); font-size: 0.95rem; max-width: 520px; margin-bottom: 0; }

        /* ── CARD ── */
        .content-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            margin-bottom: 2rem;
        }
        .card-head {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
        }
        .card-title {
            font-weight: 700; font-size: 1.05rem;
            color: var(--text); display: flex; align-items: center; gap: 0.55rem; margin: 0;
        }
        .card-title i { color: var(--primary); }

        /* ── ACTIVITY TIMELINE ── */
        .activity-list { list-style: none; margin: 0; padding: 0; }
        .activity-item {
            padding: 1.5rem; margin-bottom: 1rem;
            background: var(--surface); border-radius: 10px;
            border-left: 4px solid var(--primary);
            position: relative;
        }
        .activity-item.pending { border-left-color: var(--warning); }
        .activity-item.proses { border-left-color: var(--info); }
        .activity-item.selesai { border-left-color: var(--success); }

        .activity-header {
            display: flex; justify-content: space-between; align-items: flex-start;
            gap: 1rem; margin-bottom: 0.75rem;
        }
        .activity-title {
            font-weight: 700; font-size: 0.95rem;
            color: var(--text); line-height: 1.4;
            flex: 1;
        }
        .activity-date {
            font-size: 0.75rem; color: var(--text-dim); font-weight: 600;
            white-space: nowrap;
        }

        .activity-meta {
            display: flex; gap: 1.5rem; flex-wrap: wrap;
            margin: 1rem 0 0.75rem;
            font-size: 0.85rem;
        }
        .meta-item {
            display: flex; align-items: center; gap: 0.4rem;
            color: var(--text-soft);
        }
        .meta-item i { color: var(--primary); }

        .activity-status {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.35rem 0.9rem; border-radius: 6px;
            font-size: 0.75rem; font-weight: 700;
        }
        .status-pending {
            background: rgba(245,158,11,0.12);
            border: 1px solid rgba(245,158,11,0.25);
            color: var(--warning);
        }
        .status-proses {
            background: rgba(14,165,233,0.12);
            border: 1px solid rgba(14,165,233,0.25);
            color: var(--info);
        }
        .status-selesai {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.25);
            color: var(--success);
        }

        .activity-feedback {
            background: rgba(37,99,235,0.05);
            border-left: 3px solid var(--primary);
            padding: 0.75rem 1rem;
            border-radius: 6px;
            margin-top: 0.75rem;
            font-size: 0.85rem;
            color: var(--text-soft);
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center; padding: 3rem 1.5rem;
        }
        .empty-icon { font-size: 4rem; color: var(--text-dim); margin-bottom: 1rem; }
        .empty-state h3 { color: var(--text); font-weight: 700; margin-bottom: 0.5rem; }
        .empty-state p { color: var(--text-soft); font-size: 0.95rem; }

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 1;
            border-top: 1px solid var(--border);
            padding: 1.5rem 0; text-align: center;
            color: var(--text-dim); font-size: 0.83rem;
            background: white;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            body { margin-left: 0; }
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .page-wrap { padding: 1.5rem 0 3rem; }
            .content-card { padding: 1.5rem; }
            .card-head { flex-direction: column; align-items: stretch; }
            .activity-header { flex-direction: column; }
            .activity-date { white-space: normal; }
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list" style="font-size: 1.2rem;"></i>
    </button>

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <div class="page-wrap">
        <div class="container">
            <div class="page-hero">
                <div class="hero-label"><i class="bi bi-clock-history me-1"></i> Riwayat</div>
                <h1>Audit Log & Aktivitas</h1>
                <p>Pantau riwayat semua laporan Anda dan tindakan admin terhadap laporan tersebut.</p>
            </div>

            <!-- Activity Log -->
            @if($activities->count() > 0)
            <div class="content-card">
                <div class="card-head">
                    <h4 class="card-title"><i class="bi bi-clock-history"></i> Riwayat Laporan & Aktivitas</h4>
                </div>

                <ul class="activity-list">
                    @foreach($activities as $activity)
                    <li class="activity-item {{ strtolower($activity['status']) }}">
                        <div class="activity-header">
                            <div class="activity-title">{{ $activity['title'] }}</div>
                            <div class="activity-date">
                                {{ $activity['updated_at']->format('d M Y, H:i') }}
                            </div>
                        </div>

                        <div class="activity-meta">
                            <div class="meta-item">
                                <i class="bi bi-tag"></i>
                                <span>{{ $activity['category'] }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bi bi-calendar"></i>
                                <span>Dibuat: {{ $activity['created_at']->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div>
                            @if(strtolower($activity['status']) == 'menunggu')
                                <span class="activity-status status-pending">
                                    <i class="bi bi-hourglass-split"></i> Menunggu Verifikasi
                                </span>
                            @elseif(strtolower($activity['status']) == 'proses')
                                <span class="activity-status status-proses">
                                    <i class="bi bi-arrow-repeat"></i> Sedang Diproses
                                </span>
                            @else
                                <span class="activity-status status-selesai">
                                    <i class="bi bi-check-circle"></i> Selesai
                                </span>
                            @endif
                        </div>

                        @if($activity['feedback'])
                        <div class="activity-feedback">
                            <strong>Feedback Admin:</strong>
                            <p style="margin-top: 0.5rem; margin-bottom: 0;">{{ $activity['feedback'] }}</p>
                        </div>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="content-card">
                <div class="empty-state">
                    <div class="empty-icon"><i class="bi bi-inbox"></i></div>
                    <h3>Belum Ada Aktivitas</h3>
                    <p>Anda belum membuat laporan apapun. Mulai dengan membuat laporan baru.</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <footer>
        <div class="container">© 2026 Aspira Siswa — Sistem Aspirasi & Aduan Siswa. | Dirancang oleh Vourel Oktofit Avin</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('mobile-open');
        });
        document.querySelectorAll('.sidebar-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    document.getElementById('sidebar').classList.remove('mobile-open');
                }
            });
        });
    </script>
</body>
</html>
