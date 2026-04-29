<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Str::limit($aspirasi->ket, 50) }} — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --bg: #ffffff;
            --bg-light: #f8fafc;
            --surface: #f1f5f9;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-soft: #64748b;
            --text-dim: #94a3b8;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --info: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text);
            min-height: 100vh;
            margin-left: 260px;
            transition: margin-left 0.3s;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.03) 0%, rgba(168,85,247,0.03) 100%);
            pointer-events: none;
            z-index: 0;
        }
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.3;
        }
        .orb-1 { width: 500px; height: 500px; top: -100px; right: -80px; background: radial-gradient(circle, rgba(37,99,235,0.2), transparent 70%); }
        .orb-2 { width: 350px; height: 350px; bottom: -60px; left: -60px; background: radial-gradient(circle, rgba(168,85,247,0.15), transparent 70%); }

        /* NAVBAR */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border);
            padding: 0.85rem 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .navbar-brand {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--text) !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: white;
        }
        .nav-link {
            color: var(--text-soft) !important;
            font-weight: 500;
            padding: 0.45rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.92rem;
        }
        .nav-link:hover { color: var(--primary) !important; background: rgba(37,99,235,0.08); }

        /* PAGE */
        .page-wrap {
            position: relative;
            z-index: 1;
            padding: 2.5rem 0 5rem;
        }

        /* DETAIL CARD */
        .detail-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .detail-image {
            width: 100%;
            height: 350px;
            background: linear-gradient(135deg, rgba(37,99,235,0.1), rgba(168,85,247,0.08));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .detail-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .detail-image-placeholder {
            font-size: 5rem;
            color: rgba(37,99,235,0.2);
        }
        .detail-header {
            margin-bottom: 2rem;
        }
        .detail-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--text);
        }
        .detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }
        .meta-label {
            color: var(--text-dim);
            font-size: 0.9rem;
            font-weight: 600;
        }
        .meta-value {
            color: var(--text);
            font-weight: 600;
        }
        .badge-cat {
            background: rgba(37,99,235,0.12);
            border: 1px solid rgba(37,99,235,0.25);
            color: var(--primary);
            border-radius: 6px;
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 700;
            display: inline-block;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border-radius: 6px;
            padding: 0.3rem 0.8rem;
            font-size: 0.8rem;
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
        .detail-content {
            background: rgba(37,99,235,0.04);
            border: 1px solid rgba(37,99,235,0.1);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            line-height: 1.7;
            color: var(--text-soft);
        }

        /* INTERACTIONS */
        .interactions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1rem;
            background: var(--surface);
            border-radius: 12px;
            border: 1px solid var(--border);
        }
        .btn-interact {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.2rem;
            border: 1px solid var(--border);
            background: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            color: var(--text-soft);
        }
        .btn-interact:hover {
            background: var(--surface);
            border-color: var(--primary);
            color: var(--primary);
        }
        .btn-interact.liked {
            background: rgba(239,68,68,0.1);
            color: var(--danger);
            border-color: var(--danger);
        }

        /* COMMENTS */
        .comments-section {
            margin-top: 2rem;
        }
        .comments-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: var(--text);
        }
        .comment-form {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .comment-textarea {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.8rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 80px;
        }
        .comment-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .btn-post-comment {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.7rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 0.8rem;
        }
        .btn-post-comment:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }

        /* COMMENTS LIST */
        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .comment-item {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.2s;
        }
        .comment-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .comment-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }
        .comment-author {
            font-weight: 700;
            color: var(--text);
        }
        .comment-date {
            font-size: 0.8rem;
            color: var(--text-dim);
        }
        .comment-text {
            color: var(--text-soft);
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 0.75rem;
        }
        .comment-action {
            font-size: 0.8rem;
        }
        .btn-delete-comment {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            font-weight: 600;
            text-decoration: underline;
            transition: all 0.2s;
        }
        .btn-delete-comment:hover {
            opacity: 0.7;
        }

        /* EMPTY STATE */
        .empty-comments {
            text-align: center;
            padding: 2rem;
            color: var(--text-dim);
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

        /* FOOTER */
        footer {
            position: relative;
            z-index: 1;
            border-top: 1px solid var(--border);
            padding: 1.5rem 0;
            text-align: center;
            color: var(--text-dim);
            font-size: 0.83rem;
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
            .detail-card { padding: 1.5rem; }
            .detail-image { height: 200px; }
            .detail-header h1 { font-size: 1.5rem; }
            .detail-meta { flex-direction: column; gap: 0.8rem; }
            .interactions { flex-direction: column; }
            .btn-interact { width: 100%; }
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
            <!-- DETAIL CARD -->
            <div class="detail-card">
                <!-- Image -->
                <div class="detail-image">
                    @if($aspirasi->foto)
                        <img src="{{ asset($aspirasi->foto) }}" alt="{{ $aspirasi->ket }}">
                    @else
                        <div class="detail-image-placeholder"><i class="bi bi-image"></i></div>
                    @endif
                </div>

                <!-- Content -->
                <div class="detail-header">
                    <h1>{{ $aspirasi->ket }}</h1>
                    <div class="detail-meta">
                        <div class="meta-item">
                            <span class="badge-cat">{{ $aspirasi->kategori->nama_kategori ?? 'Umum' }}</span>
                        </div>
                        <div class="meta-item">
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
                    <div class="detail-meta">
                        <div class="meta-item">
                            <span class="meta-label"><i class="bi bi-geo-alt-fill"></i> Lokasi:</span>
                            <span class="meta-value">{{ $aspirasi->lokasi }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label"><i class="bi bi-calendar3"></i> Tanggal:</span>
                            <span class="meta-value">{{ $aspirasi->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="detail-content">
                    {{ $aspirasi->ket }}
                </div>

                <!-- Feedback (jika ada) -->
                @if($aspirasi->feedback)
                    <div style="background: linear-gradient(135deg, rgba(37,99,235,0.05), rgba(14,165,233,0.05)); border: 1px solid rgba(37,99,235,0.15); border-radius: 10px; padding: 1rem; margin-bottom: 2rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 700; font-size: 0.85rem; color: var(--primary); margin-bottom: 0.5rem;">
                            <i class="bi bi-chat-fill"></i> Respons Admin
                        </div>
                        <p style="color: var(--text-soft); font-size: 0.88rem; line-height: 1.6; margin: 0;">{{ $aspirasi->feedback }}</p>
                    </div>
                @endif

                <!-- Interactions -->
                <div class="interactions">
                    <button class="btn-interact {{ $isLikedByUser ? 'liked' : '' }}" id="btn-like" onclick="toggleLike({{ $aspirasi->id_pelaporan }})">
                        <i class="bi {{ $isLikedByUser ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                        <span id="like-count">{{ $likesCount }}</span> Like
                    </button>
                    <div style="margin-left: auto; display: flex; align-items: center; gap: 0.5rem; color: var(--text-soft);">
                        <i class="bi bi-chat-dots"></i>
                        <span id="comment-count">{{ $commentsCount }}</span> Komentar
                    </div>
                </div>
            </div>

            <!-- COMMENTS SECTION -->
            <div class="comments-section">
                <h2 class="comments-title"><i class="bi bi-chat-dots me-2"></i>Komentar</h2>

                <!-- Comment Form (hanya jika login) -->
                @if(session('siswa_nis'))
                    <div class="comment-form">
                        <form onsubmit="addComment(event, {{ $aspirasi->id_pelaporan }})">
                            <textarea class="comment-textarea" id="comment-textarea" placeholder="Tulis komentarmu di sini..."></textarea>
                            <button type="submit" class="btn-post-comment"><i class="bi bi-send me-1"></i>Posting Komentar</button>
                        </form>
                    </div>
                @else
                    <div style="text-align: center; padding: 2rem; background: var(--surface); border-radius: 12px; border: 1px solid var(--border); margin-bottom: 2rem;">
                        <p style="margin-bottom: 1rem; color: var(--text-soft);">Silakan <a href="/login" style="color: var(--primary); font-weight: 600;">login</a> untuk menambahkan komentar.</p>
                    </div>
                @endif

                <!-- Comments List -->
                <div class="comments-list" id="comments-list">
                    @forelse($aspirasi->comments()->orderBy('created_at', 'desc')->get() as $comment)
                        <div class="comment-item">
                            <div class="comment-header">
                                <div>
                                    <div class="comment-author">{{ $comment->siswa->nama ?? 'User' }}</div>
                                    <div class="comment-date">{{ $comment->created_at->diffForHumans() }}</div>
                                </div>
                                @if(session('siswa_nis') === $comment->nis || session('admin_id'))
                                    <button class="btn-delete-comment" onclick="deleteComment({{ $comment->id_komentar }})">Hapus</button>
                                @endif
                            </div>
                            <div class="comment-text">{{ $comment->komentar }}</div>
                        </div>
                    @empty
                        <div class="empty-comments">
                            <i class="bi bi-chat-dots" style="font-size: 2rem; margin-bottom: 0.5rem; display: block;"></i>
                            <p>Belum ada komentar. Jadilah yang pertama untuk memberikan komentar!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="container">© 2026 Aspira Siswa — Platform aspirasi siswa SMKN 7 Batam. | Dirancang oleh Vourel Oktofit Avin</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleLike(id) {
            fetch(`/aspirasi/${id}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('like-count').textContent = data.likesCount;
                    const btn = document.getElementById('btn-like');
                    const icon = btn.querySelector('i');
                    const liked = data.action === 'liked';
                    btn.classList.toggle('liked', liked);
                    icon.classList.toggle('bi-heart-fill', liked);
                    icon.classList.toggle('bi-heart', !liked);
                    Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 2000, title: data.message, icon: 'success' });
                } else {
                    window.location.href = '/login';
                }
            });
        }

        function addComment(e, id) {
            e.preventDefault();
            const textarea = document.getElementById('comment-textarea');
            const komentar = textarea.value.trim();
            if (!komentar) {
                Swal.fire({ title: 'Komentar kosong', text: 'Silakan isi komentar terlebih dahulu.', icon: 'warning' });
                return;
            }
            fetch(`/aspirasi/${id}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ komentar })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    textarea.value = '';
                    if (typeof data.commentsCount !== 'undefined') {
                        document.getElementById('comment-count').textContent = data.commentsCount;
                    }
                    location.reload();
                } else if (data.error) {
                    Swal.fire({ title: 'Gagal', text: data.error, icon: 'error' });
                }
            })
            .catch(err => Swal.fire({ title: 'Error', text: err, icon: 'error' }));
        }

        function deleteComment(id) {
            Swal.fire({
                title: 'Hapus Komentar?',
                text: 'Komentar akan dihapus secara permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then(r => {
                if (r.isConfirmed) {
                    fetch(`/comments/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                    .then(() => location.reload());
                }
            });
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
