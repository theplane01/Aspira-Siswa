<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifikasi — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f8fafc; --bg-light: #ffffff; --surface: #f1f5f9; --border: #e2e8f0;
            --text: #1e293b; --text-soft: #64748b; --text-dim: #94a3b8;
            --primary: #2563eb; --info: #0ea5e9; --success: #10b981; --warning: #f59e0b; --danger: #ef4444;
        }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh;
            margin-left: 260px; transition: margin-left 0.3s;
        }
        body::before {
            content: ''; position: fixed; inset: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.03) 0%, rgba(168,85,247,0.03) 100%);
            pointer-events: none; z-index: 0;
        }
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; }
        .orb-1 { width: 500px; height: 500px; top: -100px; right: -80px; background: radial-gradient(circle, rgba(101,116,248,0.35), transparent 70%); }
        .orb-2 { width: 350px; height: 350px; bottom: -60px; left: -60px; background: radial-gradient(circle, rgba(45,212,191,0.25), transparent 70%); }

        .navbar { position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,0.95); backdrop-filter: blur(18px); border-bottom: 1px solid var(--border); padding: 0.85rem 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .navbar-brand { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 1.2rem; color: var(--text) !important; display: flex; align-items: center; gap: 0.55rem; }
        .brand-icon { width: 32px; height: 32px; border-radius: 9px; background: linear-gradient(135deg, var(--primary), var(--info)); display: flex; align-items: center; justify-content: center; font-size: 0.82rem; color: white; }
        .nav-link { color: var(--text-soft) !important; font-weight: 500; padding: 0.45rem 1rem !important; border-radius: 8px; font-size: 0.9rem; transition: all 0.2s; }
        .nav-link:hover { color: var(--primary) !important; background: rgba(37,99,235,0.08); }
        .dropdown-toggle-pill { background: rgba(37,99,235,0.1) !important; color: var(--primary) !important; border-radius: 8px !important; padding: 0.45rem 1.1rem !important; font-weight: 500; border: 1px solid rgba(37,99,235,0.2) !important; box-shadow: none !important; }
        .dropdown-menu { background: white !important; backdrop-filter: blur(18px); border: 1px solid var(--border) !important; border-radius: 12px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; padding: 0.5rem !important; }
        .dropdown-item { color: var(--text-soft) !important; border-radius: 8px; padding: 0.6rem 1rem; font-size: 0.88rem; transition: all 0.2s; }
        .dropdown-item:hover { background: var(--surface) !important; color: var(--primary) !important; }

        .page-wrap { position: relative; z-index: 1; padding: 2.5rem 0 5rem; }
        .page-hero { background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(168,85,247,0.08) 100%); border: 1px solid rgba(37,99,235,0.15); border-radius: 16px; padding: 2.25rem; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.04); position: relative; overflow: hidden; }
        .page-hero::after { content: ''; position: absolute; top: -60px; right: -60px; width: 250px; height: 250px; border-radius: 50%; background: radial-gradient(circle, rgba(37,99,235,0.1), transparent 70%); }
        .hero-label { display: inline-flex; align-items: center; gap: 0.45rem; background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.25); color: var(--primary); border-radius: 8px; padding: 0.4rem 1rem; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.04em; margin-bottom: 1rem; }
        .page-hero h1 { font-family: 'Poppins', sans-serif; font-weight: 800; font-size: clamp(1.6rem, 3vw, 2.2rem); line-height: 1.2; color: var(--text); margin-bottom: 0.6rem; }
        .page-hero p { color: var(--text-soft); font-size: 0.9rem; margin-bottom: 0; }

        .content-card { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
        .card-title { font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.05rem; color: var(--text); display: flex; align-items: center; gap: 0.55rem; margin: 0; }
        .card-title i { color: var(--primary); }

        .notification-item { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem; transition: all 0.2s; cursor: pointer; }
        .notification-item:hover { background: var(--bg); box-shadow: 0 2px 8px rgba(37,99,235,0.1); }
        .notification-item.unread { border-left: 4px solid var(--primary); background: rgba(37,99,235,0.03); }
        .notification-title { font-weight: 600; color: var(--text); margin-bottom: 0.25rem; }
        .notification-message { color: var(--text-soft); font-size: 0.9rem; margin-bottom: 0.5rem; }
        .notification-time { color: var(--text-dim); font-size: 0.8rem; }
        .badge-unread { background: var(--primary); color: white; font-size: 0.7rem; padding: 0.2rem 0.5rem; border-radius: 999px; }

        .btn-mark-all { display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.6rem 1.25rem; border-radius: 8px; background: rgba(37,99,235,0.1); border: 1px solid rgba(37,99,235,0.2); color: var(--primary); font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.2s; }
        .btn-mark-all:hover { background: rgba(37,99,235,0.16); color: var(--primary); }

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

        footer { position: relative; z-index: 1; border-top: 1px solid var(--border); padding: 1.5rem 0; text-align: center; color: var(--text-dim); font-size: 0.83rem; background: white; }

        @media (max-width: 992px) {
            .page-hero { padding: 1.75rem; }
            .content-card { padding: 1.5rem; }
            .card-head { flex-direction: column; align-items: stretch; gap: 1rem; }
            .btn-mark-all { width: 100%; justify-content: center; }
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
            .notification-item { padding: 1rem; }
            .notification-message, .notification-time { font-size: 0.92rem; }
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
    @include('partials.sidebar')

    <div class="page-wrap">
        <div class="container">
            <!-- PAGE HERO -->
            <div class="page-hero">
                <div class="hero-logo">
                    <div class="logo-icon">
                        <i class="bi bi-bell-fill"></i>
                        <div class="logo-glow"></div>
                    </div>
                </div>
                <div class="hero-label"><i class="bi bi-bell-fill me-1"></i> Pemberitahuan</div>
                <br>
                <h1>Notifikasi Terkini</h1>
                <br>
                <p>Terima pembaruan dan informasi status laporan Anda secara langsung dan terpercaya.</p>
            </div>

            <!-- NOTIFICATIONS LIST -->
            <div class="content-card">
                <div class="card-head">
                    <h4 class="card-title"><i class="bi bi-bell"></i> Daftar Pemberitahuan</h4>
                    <button class="btn-mark-all" onclick="markAllAsRead()">Tanda Semua Sudah Dibaca</button>
                </div>

                <br>

                @forelse($notifications as $notif)
                <div class="notification-item {{ $notif->read_at ? '' : 'unread' }}" onclick="markAsRead({{ $notif->id }})">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="notification-title">{{ $notif->title }}</div>
                            <div class="notification-message">{{ $notif->message }}</div>
                            <div class="notification-time">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                        @if(!$notif->read_at)
                        <span class="badge-unread">Baru Saja</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-bell-slash" style="font-size: 3rem; color: var(--text-dim);"></i>
                    <h5 class="mt-3 text-muted">Belum Ada Pemberitahuan</h5>
                    <p class="text-muted">Pemberitahuan akan ditampilkan saat ada pembaruan atau umpan balik untuk laporan Anda.</p>
                </div>
                @endforelse

                {{ $notifications->links() }}
            </div>
        </div>
    </div>

    <footer>
        <div class="container">© 2026 <strong>Aspira Siswa</strong> — Dengarkan, tanggapi, berubah menjadi lebih baik. | Dirancang oleh Vourel Oktofit Avin</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        async function markAsRead(id) {
            try {
                const response = await fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                if (response.ok) {
                    location.reload(); // Perbarui untuk mengubah tampilan
                }
            } catch (error) {
                console.error('Error marking as read:', error);
            }
        }

        async function markAllAsRead() {
            try {
                const response = await fetch('/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                });
                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        }

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