<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Saya — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg: #ffffff;
            --bg-light: #f8fafc;
            --surface: #f1f5f9;
            --surface-2: #e2e8f0;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-soft: #64748b;
            --text-dim: #94a3b8;
            --primary: #2563eb;
            --info: #0ea5e9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        *, *::before, *::after { box-sizing: border-box; }
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
        .orb { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; opacity: 0.3; }
        .orb-1 { width: 500px; height: 500px; top: -100px; right: -80px; background: radial-gradient(circle, rgba(37,99,235,0.2), transparent 70%); }
        .orb-2 { width: 350px; height: 350px; bottom: -60px; left: -60px; background: radial-gradient(circle, rgba(168,85,247,0.15), transparent 70%); }

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
        .sidebar-menu { list-style: none; margin: 0; padding: 0; }
        .sidebar-item { margin: 0.3rem 0.75rem; position: relative; }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            color: var(--text-soft); text-decoration: none;
            padding: 0.75rem 1rem; border-radius: 8px;
            font-weight: 500; font-size: 0.9rem; transition: all 0.2s;
        }
        .sidebar-link:hover { color: var(--primary); background: rgba(37,99,235,0.08); }
        .sidebar-link.active { color: var(--primary); background: rgba(37,99,235,0.12); font-weight: 600; }
        .sidebar-link i { width: 1.2rem; text-align: center; }
        .sidebar-user { padding: 1rem 1.25rem; margin-top: auto; border-top: 1px solid var(--border); }
        .sidebar-btn {
            width: 100%; padding: 0.5rem; border: 1px solid rgba(239,68,68,0.2);
            border-radius: 6px; background: rgba(239,68,68,0.06);
            color: var(--danger); font-size: 0.8rem; font-weight: 600;
            text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.3rem;
        }
        .sidebar-toggle {
            display: none; position: fixed; top: 1rem; right: 1rem; z-index: 1001;
            background: white; border: 1px solid var(--border); border-radius: 8px;
            padding: 0.5rem; cursor: pointer; transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .page-wrap { position: relative; z-index: 1; padding: 2.5rem 0 5rem; }
        .page-hero {
            background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(168,85,247,0.08) 100%);
            border: 1px solid rgba(37,99,235,0.15);
            border-radius: 16px; padding: 2rem; margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }
        .hero-label {
            display: inline-flex; align-items: center; gap: 0.45rem;
            background: rgba(37,99,235,0.15); border: 1px solid rgba(37,99,235,0.25);
            color: var(--primary); border-radius: 8px;
            padding: 0.4rem 1rem; font-size: 0.75rem; font-weight: 700;
            letter-spacing: 0.04em; margin-bottom: 0.9rem;
        }
        .page-hero h1 { font-weight: 800; font-size: clamp(1.6rem, 3vw, 2.2rem); margin-bottom: 0.4rem; }
        .page-hero p { color: var(--text-soft); margin-bottom: 0; font-size: 0.92rem; }
        .btn-hero {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .72rem 1.3rem; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            color: #fff; text-decoration: none; font-weight: 700; font-size: .88rem;
            border: none;
        }

        .content-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.6rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .card-title {
            font-weight: 700; font-size: 1.05rem;
            display: flex; align-items: center; gap: .55rem;
            margin-bottom: 1.1rem;
        }
        .report-table { width: 100%; border-collapse: separate; border-spacing: 0 .55rem; }
        .report-table thead th {
            color: var(--text-dim); font-size: .7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            padding: 0 1rem .75rem; border-bottom: 2px solid var(--surface);
        }
        .report-table tbody tr { background: #fff; border: 1px solid var(--border); }
        .report-table tbody td { padding: .95rem; border: none; vertical-align: middle; font-size: .86rem; }
        .report-table tbody td:first-child { border-radius: 8px 0 0 8px; }
        .report-table tbody td:last-child { border-radius: 0 8px 8px 0; }

        .badge-done, .badge-proc, .badge-wait {
            display: inline-flex; align-items: center; gap: .3rem;
            border-radius: 6px; padding: .3rem .8rem; font-size: .75rem; font-weight: 700;
        }
        .badge-done { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25); color: var(--success); }
        .badge-proc { background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.25); color: var(--warning); }
        .badge-wait { background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.25); color: var(--danger); }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

        .btn-edit {
            border: 1px solid rgba(37,99,235,0.25); color: var(--primary); background: rgba(37,99,235,0.08);
            border-radius: 8px; padding: .36rem .65rem; font-size: .78rem; font-weight: 600; text-decoration: none;
        }
        .btn-del {
            border: 1px solid rgba(239,68,68,0.25); color: var(--danger); background: rgba(239,68,68,0.08);
            border-radius: 8px; padding: .36rem .65rem; font-size: .78rem; font-weight: 600;
        }
        .btn-lock {
            border: 1px solid var(--border); color: var(--text-dim); background: var(--surface);
            border-radius: 8px; padding: .36rem .65rem; font-size: .78rem; font-weight: 600;
        }
        .empty-state { text-align: center; padding: 3rem 1rem; color: var(--text-soft); }
        .empty-state i { font-size: 1.5rem; color: var(--text-dim); display: inline-block; margin-bottom: .5rem; }

        @media (max-width: 768px) {
            body { margin-left: 0; }
            .sidebar { transform: translateX(-100%); width: 280px; }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .orb { display: none; }
            .page-wrap { padding: 1.3rem 0 3rem; }
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="bi bi-list" style="font-size: 1.2rem;"></i>
    </button>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-star-fill text-white" style="font-size: 0.78rem;"></i></div>
            Aspira Siswa
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="/" class="sidebar-link {{ request()->path() == '/' ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i><span>Beranda</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/aspirasi-publik" class="sidebar-link {{ request()->path() == 'aspirasi-publik' ? 'active' : '' }}">
                    <i class="bi bi-chat-dots"></i><span>Aspirasi Kita</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/laporan-saya" class="sidebar-link {{ request()->path() == 'laporan-saya' ? 'active' : '' }}">
                    <i class="bi bi-collection"></i><span>Laporan Saya</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/notifications" class="sidebar-link {{ request()->path() == 'notifications' ? 'active' : '' }}">
                    <i class="bi bi-bell"></i><span>Pemberitahuan</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/audit-log" class="sidebar-link {{ request()->path() == 'audit-log' ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i><span>Riwayat Aktivitas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="/profile" class="sidebar-link {{ request()->path() == 'profile' ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i><span>Profil Saya</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-user">
            <a href="/logout" class="sidebar-btn"><i class="bi bi-box-arrow-right"></i><span>Keluar</span></a>
        </div>
    </aside>

    <div class="page-wrap">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="page-hero d-flex justify-content-between align-items-start gap-4 flex-wrap">
                <div>
                    <div class="hero-label"><i class="bi bi-collection me-1"></i> Kelola Data Laporan</div>
                    <h1>Laporan Saya</h1>
                    <p>Lihat seluruh data yang pernah Anda kirim beserta statusnya. Laporan berstatus belum diproses masih dapat diubah atau dihapus.</p>
                </div>
                <a href="/aspirasi" class="btn-hero"><i class="bi bi-plus-circle"></i> Buat Laporan</a>
            </div>

            <div class="content-card">
                <div class="card-title"><i class="bi bi-card-list"></i> Daftar Laporan Terunggah</div>

                @if($laporan_saya->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <div>Belum ada laporan yang Anda kirim.</div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Data Upload</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporan_saya as $laporan)
                                    @php($canModify = $laporan->status === 'Menunggu')
                                    <tr>
                                        <td style="white-space: nowrap; color: var(--text-dim);">{{ $laporan->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <div style="font-weight: 600;">{{ $laporan->kategori?->ket_kategori ?? 'Tanpa kategori' }}</div>
                                            <div style="color: var(--text-soft); font-size: .82rem;">Lokasi: {{ $laporan->lokasi }}</div>
                                            <div style="margin-top: .25rem;">{{ $laporan->ket }}</div>
                                            @if($laporan->foto)
                                                <a href="{{ asset($laporan->foto) }}" target="_blank" class="d-inline-block mt-2">
                                                    <img src="{{ asset($laporan->foto) }}" alt="Lampiran laporan" style="width: 95px; height: 62px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($laporan->status === 'Selesai')
                                                <span class="badge-done"><span class="badge-dot"></span> Selesai</span>
                                            @elseif($laporan->status === 'Proses')
                                                <span class="badge-proc"><span class="badge-dot"></span> Diproses</span>
                                            @else
                                                <span class="badge-wait"><span class="badge-dot"></span> Belum Diproses</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($canModify)
                                                <div class="d-flex gap-2">
                                                    <a href="/laporan-saya/{{ $laporan->id_pelaporan }}/edit" class="btn-edit"><i class="bi bi-pencil-square"></i> Edit</a>
                                                    <form action="/laporan-saya/{{ $laporan->id_pelaporan }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-del"><i class="bi bi-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            @else
                                                <button type="button" class="btn-lock" disabled title="Laporan sudah diproses, data tidak bisa diubah">
                                                    <i class="bi bi-lock"></i> Tidak dapat diubah
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('mobile-open'));
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) sidebar.classList.remove('mobile-open');
                });
            });
        }
    </script>
</body>
</html>
