$sidebarbodyCSS = @"
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            margin-left: 260px;
            transition: margin-left 0.3s;
        }
"@

$sidebarHTML = @"
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
            @if(session('admin_id'))
            <li class="sidebar-item">
                <a href="/aspirasi" class="sidebar-link {{ request()->path() == 'aspirasi' ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Laporan</span>
                </a>
            </li>
            @endif
            @if(session('siswa_nis'))
            <li class="sidebar-item">
                <a href="/profile" class="sidebar-link {{ request()->path() == 'profile' ? 'active' : '' }}">
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
        @endif
    </aside>
"@

$sidebarCSS = @"
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
        .sidebar-link:hover { color: var(--primary); background: rgba(37,99,235,0.08); }
        .sidebar-link.active { color: var(--primary); background: rgba(37,99,235,0.12); font-weight: 600; }
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
"@

$sidebarMediaQuery = @"
        @media (max-width: 768px) {
            body { margin-left: 0; }
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
"@

$sidebarJS = @"
        // Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('mobile-open');
                    }
                });
            });
        }
"@

Write-Host "Sidebar conversion utilities prepared. Ready to apply to files."
