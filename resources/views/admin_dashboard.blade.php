<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Kontrol Admin — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* ── STATS ── */
        .stats-row { display: flex; gap: 1rem; flex-wrap: wrap; align-items: stretch; }
        .stat-chip {
            background: white; border: 1px solid var(--border);
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
        .card-head {
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
        }
        .card-title {
            font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 1.05rem;
            color: var(--text); display: flex; align-items: center; gap: 0.55rem; margin: 0;
        }
        .card-title i { color: var(--primary); }
        .card-subtitle { color: var(--text-dim); font-size: 0.82rem; margin-top: 0.2rem; }

        /* ── SEARCH & FILTER ── */
        .search-filter {
            background: var(--surface); border: 1px solid var(--border);
            border-radius: 12px; padding: 1.25rem; margin-bottom: 1.5rem;
        }
        .form-control {
            background: white; border: 1px solid var(--border);
            border-radius: 8px; color: var(--text);
            padding: 0.75rem 1rem; font-size: 0.9rem;
            font-family: 'Poppins', sans-serif; outline: none;
            transition: all 0.2s;
        }
        .form-control::placeholder { color: var(--text-dim); }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .form-select {
            background: white; border: 1px solid var(--border);
            border-radius: 8px; color: var(--text);
            padding: 0.75rem 1rem; font-size: 0.9rem;
            font-family: 'Poppins', sans-serif; outline: none;
        }
        .form-select:focus { 
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

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
            padding: 0.3rem 0.8rem; font-size: 0.75rem; font-weight: 700;
        }
        .badge-dot { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }

        /* ── BUTTONS ── */
        .btn-primary-pill {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.7rem 1.5rem; border-radius: 10px;
            background: var(--primary);
            color: white; font-weight: 600; font-size: 0.88rem;
            border: none; text-decoration: none;
            box-shadow: 0 4px 12px rgba(37,99,235,0.3);
            transition: all 0.25s; cursor: pointer;
        }
        .btn-primary-pill:hover {
            background: var(--primary-dark);
            box-shadow: 0 6px 16px rgba(37,99,235,0.4);
            transform: translateY(-1px);
        }
        .btn-outline-new {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.6rem 1.25rem; border-radius: 8px;
            background: rgba(37,99,235,0.1);
            border: 1px solid rgba(37,99,235,0.2);
            color: var(--primary); font-weight: 600; font-size: 0.85rem;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-outline-new:hover { background: rgba(37,99,235,0.16); color: var(--primary-dark); }
        .btn-danger-pill {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.7rem 1.5rem; border-radius: 10px;
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);
            color: var(--danger); font-weight: 600; font-size: 0.88rem;
            cursor: pointer; transition: all 0.25s;
        }
        .btn-danger-pill:hover { background: rgba(239,68,68,0.2); }

        .modal-soft .modal-content {
            background: white;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.12);
        }
        .modal-soft .modal-header {
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, rgba(37,99,235,0.06) 0%, rgba(14,165,233,0.05) 100%);
            padding: 1rem 1.25rem;
        }
        .modal-soft .modal-body {
            padding: 1.25rem;
        }
        .modal-soft .modal-footer {
            border-top: 1px solid var(--border);
            padding: 1rem 1.25rem;
            background: rgba(248, 250, 252, 0.7);
        }
        .feedback-form-card {
            background: linear-gradient(180deg, rgba(248,250,252,0.9) 0%, rgba(255,255,255,1) 100%);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1rem;
        }
        .feedback-form-head {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            margin-bottom: 1rem;
        }
        .feedback-form-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(37,99,235,0.12), rgba(14,165,233,0.12));
            color: var(--primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
        }
        .feedback-form-title {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.2rem;
        }
        .feedback-form-subtitle {
            color: var(--text-dim);
            font-size: 0.8rem;
            margin: 0;
        }
        .feedback-label {
            color: var(--text);
            font-weight: 600;
            font-size: 0.84rem;
            margin-bottom: 0.45rem;
        }
        .feedback-select,
        .feedback-textarea {
            background: white;
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-size: 0.9rem;
            padding: 0.75rem 0.95rem;
            box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.03);
        }
        .feedback-select:focus,
        .feedback-textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }
        .feedback-help {
            color: var(--text-dim);
            font-size: 0.77rem;
            margin-top: 0.45rem;
        }
        .btn-soft-cancel {
            background: white;
            color: var(--text-soft);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.7rem 1.1rem;
            font-weight: 600;
        }
        .btn-soft-submit {
            background: linear-gradient(135deg, var(--primary), var(--info));
            color: white;
            border: none;
            border-radius: 10px;
            padding: 0.7rem 1.1rem;
            font-weight: 700;
            box-shadow: 0 8px 16px rgba(37,99,235,0.18);
        }

        /* ── CHART ── */
        .chart-container { position: relative; height: 300px; margin-bottom: 2rem; }

        /* ── FOOTER ── */
        footer {
            position: relative; z-index: 1;
            border-top: 1px solid var(--border);
            padding: 1.5rem 0; text-align: center;
            color: var(--text-dim); font-size: 0.83rem;
            background: white;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 992px) {
            .dashboard-summary .col-sm-6 { flex: 0 0 100%; max-width: 100%; }
            .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .stats-row { flex-direction: column; }
            .card-head { flex-direction: column; align-items: stretch; gap: 1rem; }
        }

        @media (max-width: 768px) {
            body { margin-left: 0; }
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .table tbody td { padding: 0.75rem; font-size: 0.82rem; }
            .d-flex.justify-content-between { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
            .btn-outline-secondary { width: 100%; margin-top: 0.75rem; }
            .orb { display: none; }
            .page-wrap { padding: 1.5rem 0 3rem; }
            .page-hero { padding: 1.75rem; }
            .content-card { padding: 1.5rem; }
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
                        <i class="bi bi-speedometer2"></i>
                    </div>
                </div>
                <div class="hero-label"><i class="bi bi-shield-check me-1"></i> Pengelola Dashboard</div>
                <h1>Pusat Kontrol Pengelola</h1>
                <p>Kelola semua laporan siswa dengan fitur lengkap dan pemantauan waktu nyata.</p>
            </div>

            <!-- STATS SUMMARY -->
            <div class="stats-row mb-4" id="stats-row">
                <div class="stat-chip">
                    <div class="num" id="total-laporan">{{ count($aspirasis) }}</div>
                    <small>Total Laporan</small>
                </div>
                <div class="stat-chip">
                    <div class="num" id="menunggu">{{ $aspirasis->where('status', 'Menunggu')->count() }}</div>
                    <small>Menunggu Verifikasi</small>
                </div>
                <div class="stat-chip">
                    <div class="num" id="proses">{{ $aspirasis->where('status', 'Proses')->count() }}</div>
                    <small>Sedang Diproses</small>
                </div>
                <div class="stat-chip">
                    <div class="num" id="selesai">{{ $aspirasis->where('status', 'Selesai')->count() }}</div>
                    <small>Telah Selesai</small>
                </div>
            </div>

            <!-- SEARCH & FILTER -->
            <div class="search-filter">
                <form method="GET" action="/admin" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="judul" class="form-control" placeholder="Filter per judul aspirasi..." value="{{ request('judul') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Belum Diproses</option>
                            <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="siswa" class="form-control" placeholder="Filter siswa (Nama / NIS)..." value="{{ request('siswa') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->ket_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn-primary-pill w-100"><i class="bi bi-funnel"></i> Terapkan</button>
                    </div>
                    <div class="col-md-2">
                        <a href="/admin" class="btn-outline-new w-100"><i class="bi bi-x-circle"></i> Hapus Filter</a>
                    </div>
                </form>
            </div>

            <!-- ASPIRASI TABLE -->
            <div class="content-card">
                <div class="card-head">
                    <div>
                        <h4 class="card-title"><i class="bi bi-table"></i> Daftar Aspirasi</h4>
                        <p class="card-subtitle">Kelola laporan siswa dengan fitur bulk actions</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn-outline-new" onclick="exportData('csv')"><i class="bi bi-file-earmark-spreadsheet"></i> Export CSV</button>
                        <button class="btn-outline-new" onclick="exportData('pdf')"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                    </div>
                </div>

                <!-- BULK ACTIONS -->
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <div class="d-flex gap-2 align-items-center">
                        <input type="checkbox" id="select-all" class="form-check-input">
                        <label for="select-all" class="form-check-label text-sm">Pilih Semua</label>
                        <span class="text-dim">|</span>
                        <button class="btn-danger-pill btn-sm" id="bulk-delete" disabled onclick="bulkDelete()"><i class="bi bi-trash"></i> Hapus Terpilih</button>
                        <button class="btn-primary-pill btn-sm" id="bulk-status" disabled onclick="bulkStatusChange('Proses')"><i class="bi bi-play"></i> Ubah ke Proses</button>
                    </div>
                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">Total {{ $aspirasis->count() }} laporan</span>
                </div>

                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all-header"></th>
                                <th>NIS</th><th>Kategori</th><th>Isi Laporan</th><th>Status</th><th>Foto</th><th>Feedback</th><th>Tanggal</th><th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aspirasis as $aspi)
                            <tr>
                                <td><input type="checkbox" class="row-checkbox" value="{{ $aspi->id_pelaporan }}"></td>
                                <td>
                                    <div class="fw-bold">{{ $aspi->nis }}</div>
                                    <div class="text-dim" style="font-size: 0.78rem;">{{ $aspi->siswa->nama ?? '-' }}</div>
                                </td>
                                <td>{{ $aspi->kategori->ket_kategori ?? '-' }}</td>
                                <td>
                                    <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">
                                        {{ strlen($aspi->ket) > 50 ? substr($aspi->ket, 0, 47) . '...' : $aspi->ket }}
                                    </div>
                                </td>
                                <td>
                                    @if($aspi->status == 'Selesai')
                                        <span class="badge-done"><span class="badge-dot"></span> Selesai</span>
                                    @elseif($aspi->status == 'Proses')
                                        <span class="badge-proc"><span class="badge-dot"></span> Proses</span>
                                    @else
                                        <span class="badge-wait"><span class="badge-dot"></span> Menunggu</span>
                                    @endif
                                </td>
                                <td>
                                    @if($aspi->foto)
                                        <button type="button" class="btn-outline-new btn-sm" data-bs-toggle="modal" data-bs-target="#modalFoto{{ $aspi->id_pelaporan }}">Lihat</button>
                                    @else <span class="text-dim">-</span> @endif
                                </td>
                                <td>
                                    <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $aspi->feedback ? (strlen($aspi->feedback) > 30 ? substr($aspi->feedback, 0, 27) . '...' : $aspi->feedback) : '-' }}
                                    </div>
                                </td>
                                <td class="text-dim">{{ $aspi->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <button class="btn-primary-pill btn-sm" data-bs-toggle="modal" data-bs-target="#modalTanggapan{{ $aspi->id_pelaporan }}"><i class="bi bi-pencil"></i></button>
                                        <form action="/admin/hapus/{{ $aspi->id_pelaporan }}" method="POST" class="d-inline form-hapus">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn-danger-pill btn-sm btn-hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: var(--text-dim);"></i>
                                    <h5 class="mt-3 text-muted">Tidak ada laporan ditemukan</h5>
                                    <p class="text-muted">Coba ubah filter pencarian atau tunggu laporan baru.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                @if($aspirasis->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $aspirasis->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <footer>
        <div class="container">© 2026 Aspira Siswa — Panel admin untuk manajemen aspirasi siswa. | Dirancang oleh Vourel Oktofit Avin</div>
    </footer>

    <!-- MODALS -->
    @foreach($aspirasis as $aspi)
    <!-- Modal Foto -->
    <div class="modal fade modal-soft" id="modalFoto{{ $aspi->id_pelaporan }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: var(--text);">Foto Bukti - NIS {{ $aspi->nis }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset($aspi->foto) }}" class="img-fluid rounded" style="max-height: 70vh;">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tanggapan -->
    <div class="modal fade modal-soft" id="modalTanggapan{{ $aspi->id_pelaporan }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/feedback/{{ $aspi->id_pelaporan }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" style="color: var(--text);">Umpan Balik Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="feedback-form-card">
                            <div class="feedback-form-head">
                                <div class="feedback-form-icon">
                                    <i class="bi bi-chat-left-text"></i>
                                </div>
                                <div>
                                    <div class="feedback-form-title">Kelola Tindak Lanjut Laporan</div>
                                    <p class="feedback-form-subtitle">Perbarui status laporan dan berikan tanggapan yang jelas untuk siswa.</p>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="feedback-label">Status Laporan</label>
                                <select name="status" class="form-select feedback-select">
                                    @foreach(['Menunggu','Proses','Selesai'] as $s)
                                        <option value="{{ $s }}" {{ $aspi->status == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <div class="feedback-help">Pilih status terbaru agar siswa dapat memantau progres penanganan.</div>
                            </div>

                            <div class="mb-0">
                                <label class="feedback-label">Pesan Umpan Balik</label>
                                <textarea name="feedback" class="form-control feedback-textarea" rows="4" placeholder="Tulis tanggapan, arahan, atau hasil tindak lanjut laporan ini..." required>{{ $aspi->feedback }}</textarea>
                                <div class="feedback-help">Gunakan bahasa yang singkat, jelas, dan mudah dipahami oleh siswa.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-soft-cancel" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-soft-submit"><i class="bi bi-send-check me-1"></i> Simpan Umpan Balik</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

<script>
    // Bulk actions
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateBulkButtons();
    });

    document.getElementById('select-all-header').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        document.getElementById('select-all').checked = this.checked;
        updateBulkButtons();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateBulkButtons();
        }
    });

    function updateBulkButtons() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        const bulkDelete = document.getElementById('bulk-delete');
        const bulkStatus = document.getElementById('bulk-status');

        bulkDelete.disabled = checkedBoxes.length === 0;
        bulkStatus.disabled = checkedBoxes.length === 0;
    }

    function bulkDelete() {
        const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: 'Hapus Laporan Terpilih?',
            text: `Yakin mau hapus ${selectedIds.length} laporan?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/admin/bulk-delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: selectedIds })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Terhapus!', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                });
            }
        });
    }

    function bulkStatusChange(status) {
        const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: `Ubah Status ke ${status}?`,
            text: `Ubah status ${selectedIds.length} laporan terpilih ke ${status}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#6574f8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('/admin/bulk-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ids: selectedIds, status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                });
            }
        });
    }

    // Export functions
    function exportData(format) {
        const url = `/admin/export/${format}?${new URLSearchParams(window.location.search).toString()}`;
        window.open(url, '_blank');
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Single delete handlers
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                let form = this.closest('.form-hapus');
                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Laporan ini bakal hilang selamanya!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        @if(session('success'))
            Swal.fire('Berhasil!', "{{ session('success') }}", 'success');
        @endif
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
</script>
</body>
</html>