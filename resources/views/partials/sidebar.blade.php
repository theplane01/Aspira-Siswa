<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-star-fill text-white" style="font-size: 0.78rem;"></i></div>
        Aspira Siswa
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="/" class="sidebar-link {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i>
                <span>Beranda</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="/aspirasi-publik" class="sidebar-link {{ request()->is('aspirasi-publik') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i>
                <span>Aspirasi Kita</span>
            </a>
        </li>

        @if(session('admin_id'))
        <li class="sidebar-item">
            <a href="/admin" class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="/admin/kategori" class="sidebar-link {{ request()->is('admin/kategori') ? 'active' : '' }}">
                <i class="bi bi-tag"></i>
                <span>Manajemen Kategori</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="/admin/siswa" class="sidebar-link {{ request()->is('admin/siswa') || request()->is('admin/approvals') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Student Management</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="/admin/profile" class="sidebar-link {{ request()->is('admin/profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profil Admin</span>
            </a>
        </li>
        @endif

        @if(session('siswa_nis'))
        <li class="sidebar-item">
            <a href="/laporan-saya" class="sidebar-link {{ request()->is('laporan-saya') ? 'active' : '' }}">
                <i class="bi bi-collection"></i>
                <span>Laporan Saya</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="/notifications" class="sidebar-link {{ request()->is('notifications') ? 'active' : '' }}">
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
            <a href="/audit-log" class="sidebar-link {{ request()->is('audit-log') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat Aktivitas</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="/profile" class="sidebar-link {{ request()->is('profile') ? 'active' : '' }}">
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
