<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Laporan — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --bg:        #ffffff;
            --bg-light:  #f8fafc;
            --surface:   #f1f5f9;
            --surface-2: #e2e8f0;
            --border:    #e2e8f0;
            --gb:        #e2e8f0;
            --text:      #1e293b;
            --text-soft: #64748b;
            --text-dim:  #94a3b8;
            --primary:   #2563eb;
            --primary-dark: #1d4ed8;
            --indigo:    #2563eb;
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
        .dropdown-menu {
            background: white !important; backdrop-filter: blur(18px);
            border: 1px solid var(--border) !important; border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; padding: 0.5rem !important;
        }
        .dropdown-item {
            color: var(--text-soft) !important; border-radius: 8px;
            padding: 0.6rem 1rem; font-size: 0.88rem; transition: all 0.2s;
        }
        .dropdown-item:hover { background: var(--surface) !important; color: var(--primary) !important; }
        .dropdown-divider { border-color: var(--border) !important; margin: 0.35rem 0.5rem; }

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
            font-family: 'Poppins', sans-serif; font-weight: 800;
            font-size: clamp(1.8rem, 3vw, 2.4rem); line-height: 1.2;
            color: var(--text); margin-bottom: 0.6rem;
        }
        .page-hero p { color: var(--text-soft); font-size: 0.95rem; max-width: 520px; margin-bottom: 0; }
        .btn-hero-new {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1.6rem; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            color: white; font-weight: 700; font-size: 0.9rem;
            border: none; cursor: pointer;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
            transition: all 0.25s; white-space: nowrap; flex-shrink: 0;
        }
        .btn-hero-new:hover {
            box-shadow: 0 6px 20px rgba(37,99,235,0.4);
            transform: translateY(-2px); color: white;
        }

        /* ── STAT CHIPS ── */
        .stat-chip {
            background: white; border: 1px solid var(--border);
            border-radius: 12px; padding: 1rem;
            text-align: center; min-width: 100px; flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .stat-chip .num {
            font-family: 'Poppins', sans-serif; font-weight: 800; font-size: 1.8rem;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .stat-chip small { display: block; color: var(--text-dim); font-size: 0.75rem; margin-top: 0.25rem; font-weight: 600; }

        /* ── CONTENT CARD ── */
        .content-card {
            background: white;
            border: 1px solid var(--border); border-radius: 12px;
            padding: 2rem; box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .card-head {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
        }
        .card-title {
            font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.1rem;
            color: var(--text); display: flex; align-items: center; gap: 0.55rem; margin: 0;
        }
        .card-title i { color: var(--primary); }
        .card-subtitle { color: var(--text-dim); font-size: 0.82rem; margin-top: 0.2rem; }

        /* ── TABLE ── */
        .report-table { width: 100%; border-collapse: separate; border-spacing: 0 0.55rem; }
        .report-table thead th {
            color: var(--text-dim); font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            padding: 0 1rem 0.75rem;
            border-bottom: 2px solid var(--surface);
        }
        .report-table tbody tr {
            background: white; transition: all 0.2s; border: 1px solid var(--border);
        }
        .report-table tbody tr:hover { 
            background: var(--bg-light); 
            box-shadow: 0 2px 8px rgba(37,99,235,0.1);
        }
        .report-table tbody td {
            padding: 1rem; border: none;
            vertical-align: middle; font-size: 0.87rem;
        }
        .report-table tbody td:first-child { border-radius: 8px 0 0 8px; }
        .report-table tbody td:last-child  { border-radius: 0 8px 8px 0; }

        /* ── NIS PILL ── */
        .nis-pill {
            display: inline-block;
            background: rgba(37,99,235,0.12); border: 1px solid rgba(37,99,235,0.25);
            color: var(--primary); border-radius: 6px;
            padding: 0.25rem 0.75rem; font-size: 0.8rem; font-weight: 700;
            font-family: 'Poppins', sans-serif; letter-spacing: 0.02em;
        }

        /* ── STATUS ── */
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
            padding: 0.3rem 0.8rem; font-size: 0.75rem; font-weight: 700;
        }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

        /* ── CAT TAG ── */
        .cat-tag {
            display: inline-block;
            background: rgba(14,165,233,0.12); border: 1px solid rgba(14,165,233,0.25);
            color: var(--info); border-radius: 6px;
            padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: 600;
            margin-bottom: 0.3rem;
        }
        .filter-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.45rem 0.95rem;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: white;
            color: var(--text-soft);
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .filter-btn:hover {
            color: var(--primary);
            border-color: rgba(37,99,235,0.22);
            background: rgba(37,99,235,0.08);
        }
        .filter-btn.active {
            color: var(--primary);
            background: rgba(37,99,235,0.12);
            border-color: rgba(37,99,235,0.24);
        }
        .report-card {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(15,23,42,0.22);
        }
        .report-card h5 {
            color: #ffffff !important;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.25);
        }
        .report-card p {
            color: rgba(255,255,255,0.9) !important;
        }
        .admin-meta {
            color: rgba(255,255,255,0.75);
            font-size: 0.75rem;
            font-weight: 500;
        }
        .btn-view {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border: 1px solid rgba(255,255,255,0.28);
            background: rgba(255,255,255,0.14);
            color: white;
            border-radius: 8px;
            padding: 0.35rem 0.7rem;
            font-size: 0.78rem;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-view:hover {
            background: rgba(255,255,255,0.24);
            color: white;
        }
        .feedback-bubble {
            background: rgba(37,99,235,0.08);
            border-left: 3px solid var(--primary);
            border-radius: 0 0.6rem 0.6rem 0;
            padding: 0.45rem 0.65rem;
            font-size: 0.8rem;
            color: var(--text-soft);
            font-style: italic;
        }

        /* ── MODAL ── */
        .modal-content {
            border: 1px solid var(--border); border-radius: 12px;
            background: white;
        }
        .modal-header {
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, rgba(37,99,235,0.04) 0%, rgba(168,85,247,0.04) 100%);
        }
        .modal-label {
            color: var(--text); font-size: 0.85rem; font-weight: 600; margin-bottom: 0.5rem;
        }
        .modal-value {
            color: var(--text-soft); font-size: 0.9rem;
        }
        .form-label {
            color: var(--text); font-weight: 600; font-size: 0.85rem;
        }
        .form-control {
            border: 1px solid var(--border); border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .form-select {
            border: 1px solid var(--border); border-radius: 8px;
            font-family: 'Poppins', sans-serif;
        }
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .btn-modal-primary {
            background: var(--primary); color: white; border: none;
            border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600;
            transition: all 0.2s; cursor: pointer;
        }
        .btn-modal-primary:hover {
            background: var(--primary-dark);
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
        }
        .btn-modal-cancel {
            background: var(--surface); color: var(--text); border: 1px solid var(--border);
            border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 600;
            transition: all 0.2s; cursor: pointer;
        }
        .btn-modal-cancel:hover {
            background: var(--surface-2);
        }

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
            .report-table tbody td { padding: 0.8rem; font-size: 0.86rem; }
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
                <div class="d-flex justify-content-between align-items-start gap-4 flex-wrap">
                    <div>
                        <div class="hero-label"><i class="bi bi-chat-heart me-1"></i> Daftar Laporan</div>
                        <h1>Atur Laporan Siswa<br>dengan Teratur</h1>
                        <p>Pantau, verifikasi, dan beri tanggapan untuk setiap laporan serta masukan dari siswa secara terbuka.</p>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="stat-chip">
                            <div class="num" id="stat-total">{{ $stats['total'] ?? count($aspirasis) }}</div>
                            <small>Total Laporan</small>
                        </div>
                        <div class="stat-chip">
                            <div class="num" id="stat-menunggu">{{ $stats['menunggu'] ?? $aspirasis->where('status','Menunggu')->count() }}</div>
                            <small>Menunggu Proses</small>
                        </div>
                        <div class="stat-chip">
                            <div class="num" id="stat-proses">{{ $stats['proses'] ?? $aspirasis->where('status','Proses')->count() }}</div>
                            <small>Sedang Diproses</small>
                        </div>
                        <div class="stat-chip">
                            <div class="num" id="stat-selesai">{{ $stats['selesai'] ?? $aspirasis->where('status','Selesai')->count() }}</div>
                            <small>Telah Selesai</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- REPORT CONTENT -->
            <div class="content-card">
                <div class="card-head">
                    <div>
                        <h4 class="card-title"><i class="bi bi-journal-text"></i> {{ session('admin_id') ? 'Semua Laporan yang Masuk' : 'Data Laporan Saya' }}</h4>
                        <p class="card-subtitle">{{ session('admin_id') ? 'Kelola semua laporan dan saran yang dikirim oleh pelajar di sekolah.' : 'Daftar lengkap laporan yang telah Anda ajukan kepada pihak sekolah.' }}</p>
                    </div>
                    @if(!session('admin_id'))
                    <button type="button" class="btn-hero-new" data-bs-toggle="modal" data-bs-target="#modalBuatAspirasi">
                        <i class="bi bi-pencil-square"></i> Ajukan Laporan Baru
                    </button>
                    @endif
                </div>

                @if(session('admin_id'))
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                        <a href="/aspirasi" class="filter-btn {{ empty($status) ? 'active' : '' }}">Total</a>
                        <a href="/aspirasi?status=Menunggu" class="filter-btn {{ $status == 'Menunggu' ? 'active' : '' }}">Menunggu</a>
                        <a href="/aspirasi?status=Proses" class="filter-btn {{ $status == 'Proses' ? 'active' : '' }}">Proses</a>
                        <a href="/aspirasi?status=Selesai" class="filter-btn {{ $status == 'Selesai' ? 'active' : '' }}">Selesai</a>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @forelse($aspirasis as $aspi)
                        <div class="col">
                            <div class="report-card p-4 h-100">
                                <div class="d-flex justify-content-between gap-3 mb-3 align-items-start">
                                    <div>
                                        <span class="cat-tag">{{ $aspi->kategori->ket_kategori ?? 'Umum' }}</span>
                                        <h5 class="mb-2 text-white">{{ $aspi->nis }}</h5>
                                        @php
                                            $preview = \Illuminate\Support\Str::words($aspi->ket, 7, '...');
                                        @endphp
                                        <p class="mb-2 text-white-75">{{ $preview }}</p>
                                        <small class="admin-meta"><i class="bi bi-geo-alt me-1"></i>{{ $aspi->lokasi }}</small>
                                    </div>
                                    <div class="text-end">
                                        @if($aspi->status == 'Selesai')
                                            <span class="badge-done"><span class="badge-dot"></span>Selesai</span>
                                        @elseif($aspi->status == 'Proses')
                                            <span class="badge-proc"><span class="badge-dot"></span>Proses</span>
                                        @else
                                            <span class="badge-wait"><span class="badge-dot"></span>Menunggu</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-white border-opacity-10">
                                    <button type="button" class="btn-view" data-bs-toggle="modal" data-bs-target="#detailModal{{ $aspi->id_pelaporan }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                    <small class="admin-meta">{{ $aspi->created_at->format('d M Y H:i') }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="report-card p-4 text-center">
                                <p class="mb-0 text-muted">Tidak ada laporan yang diterima saat ini.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>NIS</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Respon</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aspirasis as $aspi)
                                <tr>
                                    <td><span class="nis-pill">{{ $aspi->nis }}</span></td>
                                    <td>
                                        <span class="cat-tag">{{ $aspi->kategori->ket_kategori ?? 'Umum' }}</span>
                                        <div style="font-weight: 600; font-size: 0.87rem; color: var(--text);">
                                            @php
                                                $words = preg_split('/\s+/', trim($aspi->ket));
                                                echo count($words) > 8 ? implode(' ', array_slice($words, 0, 8)) . '…' : $aspi->ket;
                                            @endphp
                                        </div>
                                        <small style="color: var(--text-dim);"><i class="bi bi-geo-alt me-1"></i>{{ $aspi->lokasi }}</small>
                                    </td>
                                    <td>
                                        @if($aspi->status == 'Selesai')
                                            <span class="badge-done"><span class="badge-dot"></span>Selesai</span>
                                        @elseif($aspi->status == 'Proses')
                                            <span class="badge-proc"><span class="badge-dot"></span>Proses</span>
                                        @else
                                            <span class="badge-wait"><span class="badge-dot"></span>Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($aspi->feedback)
                                            <div class="feedback-bubble">"{{ $aspi->feedback }}"</div>
                                        @else
                                            <span style="color: var(--text-dim); font-size: 0.8rem;"><i class="bi bi-hourglass-split me-1"></i>Menunggu respon...</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn-view" data-bs-toggle="modal" data-bs-target="#detailModal{{ $aspi->id_pelaporan }}">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
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

    <!-- MODAL BUAT ASPIRASI -->
    <div class="modal fade" id="modalBuatAspirasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square me-2" style="color: var(--primary);"></i>Form Kirim Laporan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="/lapor" method="POST" enctype="multipart/form-data" id="aspirasi-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">NIS (Nomor Induk Siswa)</label>
                            <input type="text" name="nis" class="form-control" value="{{ session('siswa_nis') }}" readonly required>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Jenis Laporan</label>
                                <select name="id_kategori" class="form-select" required>
                                    @foreach($kategoris as $k)
                                        <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lokasi Kejadian</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Kantin, Ruang Kelas" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Penjelasan Laporan</label>
                            <textarea name="ket" class="form-control" rows="4" placeholder="Jelaskan masalah atau masukan Anda dengan rinci dan jelas..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampirkan Foto <span style="color: var(--text-dim);">(Opsional)</span></label>
                            <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <div class="text-muted mt-1">Ukuran maksimal: 2MB. Format: JPG, PNG, GIF.</div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Hentikan</button>
                            <button type="submit" class="btn-modal-primary"><i class="bi bi-send"></i> Kirim Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAIL MODALS -->
    @foreach($aspirasis as $aspi)
    <div class="modal fade" id="detailModal{{ $aspi->id_pelaporan }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-file-text me-2" style="color: var(--indigo);"></i>Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="modal-label">Nomor Induk Siswa</div>
                            <div class="modal-value"><span class="nis-pill">{{ $aspi->nis }}</span></div>
                        </div>
                        <div class="col-md-4">
                            <div class="modal-label">Kategori Laporan</div>
                            <div class="modal-value"><span class="cat-tag">{{ $aspi->kategori->ket_kategori ?? 'Umum' }}</span></div>
                        </div>
                        <div class="col-md-4">
                            <div class="modal-label">Status Laporan</div>
                            <div class="modal-value">
                                @if($aspi->status == 'Selesai')<span class="badge-done"><span class="badge-dot"></span>Telah Selesai</span>
                                @elseif($aspi->status == 'Proses')<span class="badge-proc"><span class="badge-dot"></span>Sedang Diproses</span>
                                @else<span class="badge-wait"><span class="badge-dot"></span>Menunggu Diproses</span>@endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-label">Lokasi Kejadian</div>
                            <div class="modal-value"><i class="bi bi-geo-alt me-1" style="color: var(--text-dim);"></i>{{ $aspi->lokasi }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="modal-label">Tanggal Laporan</div>
                            <div class="modal-value modal-date"><i class="bi bi-calendar-event me-1" style="color: var(--text-dim);"></i>{{ $aspi->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <div class="col-12">
                            <div class="modal-label">Uraian Detail Laporan</div>
                            <div style="background: rgba(99,130,255,0.06); border: 1px solid rgba(99,130,255,0.12); border-radius: 0.85rem; padding: 1rem; color: var(--text-soft); font-size: 0.9rem; line-height: 1.65;">{{ $aspi->ket }}</div>
                        </div>
                        @if($aspi->foto)
                        <div class="col-12">
                            <div class="modal-label">Foto Bukti</div>
                            <div class="mt-1 text-center">
                                <img src="{{ asset($aspi->foto) }}" alt="Foto" class="img-fluid" style="max-height: 340px; border-radius: 1rem; border: 1px solid var(--gb);">
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="modal-label">Balasan dari Admin</div>
                            @if(session('admin_id'))
                                <form action="/admin/feedback/{{ $aspi->id_pelaporan }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="Menunggu" {{ $aspi->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="Proses" {{ $aspi->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Selesai" {{ $aspi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Ulasan / Feedback</label>
                                        <textarea name="feedback" class="form-control" rows="3" placeholder="Tulis feedback untuk siswa...">{{ $aspi->feedback }}</textarea>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn-modal-primary">Simpan Feedback</button>
                                    </div>
                                </form>
                            @else
                                @if($aspi->feedback)
                                    <div class="feedback-bubble">"{{ $aspi->feedback }}"</div>
                                @else
                                    <div style="color: var(--text-dim); font-size: 0.85rem; font-style: italic;"><i class="bi bi-hourglass-split me-1"></i>Belum ada feedback dari admin.</div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <footer>
        <div class="container">© 2026 Aspira Siswa — Suara siswa, perubahan nyata.</div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#111827'
            });
        @endif
        @if($errors->any())
            Swal.fire({
                title: 'Terjadi Kesalahan!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                icon: 'error',
                confirmButtonColor: '#2563eb',
                background: '#ffffff',
                color: '#111827'
            });
        @endif

        const statTotal = document.getElementById('stat-total');
        const statMenunggu = document.getElementById('stat-menunggu');
        const statProses = document.getElementById('stat-proses');
        const statSelesai = document.getElementById('stat-selesai');

        async function refreshAspirasiStats() {
            try {
                const response = await fetch('/aspirasi/stats');
                if (!response.ok) throw new Error('Fetch gagal');

                const data = await response.json();
                statTotal.textContent = data.total;
                statMenunggu.textContent = data.menunggu;
                statProses.textContent = data.proses;
                statSelesai.textContent = data.selesai;
            } catch (error) {
                console.warn('Gagal memuat statistik:', error);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            refreshAspirasiStats();
            setInterval(refreshAspirasiStats, 10000);

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
        });
    </script>
</body>
</html>