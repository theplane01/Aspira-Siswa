<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Management — Aspira Siswa</title>
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

        /* ── STATS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem; margin-bottom: 1.5rem;
        }
        .stat-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
        }
        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--info));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .stat-label {
            font-size: 0.85rem;
            color: var(--text-dim);
            font-weight: 600;
            margin-top: 0.25rem;
        }

        /* ── TABLE ── */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
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

        /* ── STATUS BADGE ── */
        .badge-approved {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25);
            color: var(--success); border-radius: 6px;
            padding: 0.3rem 0.8rem; font-size: 0.75rem; font-weight: 700;
        }
        .badge-pending {
            display: inline-flex; align-items: center; gap: 0.3rem;
            background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.25);
            color: var(--warning); border-radius: 6px;
            padding: 0.3rem 0.8rem; font-size: 0.75rem; font-weight: 700;
        }
        .badge-rejected {
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
        .btn-danger-pill {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.7rem 1.5rem; border-radius: 10px;
            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);
            color: var(--danger); font-weight: 600; font-size: 0.88rem;
            cursor: pointer; transition: all 0.25s;
        }
        .btn-danger-pill:hover { background: rgba(239,68,68,0.2); }
        .btn-edit {
            padding: 0.5rem 1rem; background: rgba(37,99,235,0.1);
            border: 1px solid rgba(37,99,235,0.2); color: var(--primary);
            border-radius: 6px; font-size: 0.85rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-edit:hover { background: rgba(37,99,235,0.2); }
        .action-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem;
        }
        .btn-approve-mini,
        .btn-reject-mini {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.5rem 0.8rem; border-radius: 6px;
            font-size: 0.8rem; font-weight: 600; border: 1px solid transparent;
            cursor: pointer; transition: all 0.2s;
        }
        .btn-approve-mini {
            color: #059669;
            background: rgba(16,185,129,0.12);
            border-color: rgba(16,185,129,0.25);
        }
        .btn-approve-mini:hover { background: rgba(16,185,129,0.2); }
        .btn-reject-mini {
            color: var(--danger);
            background: rgba(239,68,68,0.12);
            border-color: rgba(239,68,68,0.25);
        }
        .btn-reject-mini:hover { background: rgba(239,68,68,0.2); }

        /* ── REPORT COUNT BADGE ── */
        .count-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.45rem 0.9rem; border-radius: 20px;
            font-size: 0.82rem; font-weight: 700;
        }
        .count-badge.none {
            background: var(--surface); color: var(--text-dim);
            border: 1px solid var(--border);
        }
        .count-badge.low {
            background: rgba(16,185,129,0.12); color: #059669;
            border: 1px solid rgba(16,185,129,0.25);
        }
        .count-badge.mid {
            background: rgba(245,158,11,0.12); color: #d97706;
            border: 1px solid rgba(245,158,11,0.25);
        }
        .count-badge.high {
            background: rgba(239,68,68,0.12); color: #dc2626;
            border: 1px solid rgba(239,68,68,0.25);
        }

        /* ── MODAL ── */
        .modal-content {
            background: white; border: 1px solid var(--border);
            border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .modal-header {
            border-bottom: 1px solid var(--border); padding: 1.5rem;
        }
        .modal-title { font-weight: 700; color: var(--text); }
        .modal-body { padding: 1.5rem; }
        .form-control, .form-select {
            background: white; border: 1px solid var(--border);
            border-radius: 8px; color: var(--text);
            padding: 0.75rem 1rem; font-size: 0.9rem;
            font-family: 'Poppins', sans-serif; outline: none;
            transition: all 0.2s;
        }
        .form-control::placeholder { color: var(--text-dim); }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
        }

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
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .page-wrap { padding: 1.5rem 0 3rem; }
            .content-card { padding: 1.5rem; }
            .card-head { flex-direction: column; align-items: stretch; }
            .stats-grid { grid-template-columns: 1fr; }
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
                <div class="hero-label"><i class="bi bi-people me-1"></i> Pengaturan</div>
                <h1>Student Management</h1>
                <p>Kelola data siswa dan approval registrasi dalam satu halaman terpadu.</p>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-number">{{ $siswas->count() }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">{{ $siswas->where('status', 'approved')->count() }}</div>
                    <div class="stat-label">Terverifikasi</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">{{ $siswas->where('status', 'pending')->count() }}</div>
                    <div class="stat-label">Menunggu Verifikasi</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">{{ $siswas->where('status', 'rejected')->count() }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
            </div>

            <div class="content-card">
                <div class="card-head">
                    <h4 class="card-title"><i class="bi bi-people"></i> Daftar Siswa</h4>
                </div>

                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Status</th>
                                <th>Laporan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $siswa)
                            <tr>
                                <td class="fw-bold">{{ $siswa->nis }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->kelas }}</td>
                                <td>
                                    @if($siswa->status == 'approved')
                                        <span class="badge-approved"><span class="badge-dot"></span> Terverifikasi</span>
                                    @elseif($siswa->status == 'pending')
                                        <span class="badge-pending"><span class="badge-dot"></span> Menunggu</span>
                                    @else
                                        <span class="badge-rejected"><span class="badge-dot"></span> Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $laporan_count = $siswa->aspirasis_count ?? 0;
                                        $badgeClass = $laporan_count === 0 ? 'none' : ($laporan_count <= 5 ? 'low' : ($laporan_count <= 20 ? 'mid' : 'high'));
                                        $badgeIcon  = $laporan_count === 0 ? 'bi-dash-circle' : ($laporan_count <= 5 ? 'bi-file-earmark-text' : ($laporan_count <= 20 ? 'bi-files' : 'bi-stack'));
                                    @endphp
                                    <span class="count-badge {{ $badgeClass }}">
                                        <i class="bi {{ $badgeIcon }}"></i>
                                        {{ $laporan_count }} laporan
                                    </span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        @if($siswa->status === 'pending')
                                            <button type="button" class="btn-approve-mini btn-status-action" data-url="/admin/approve/{{ $siswa->nis }}" data-action="setujui" data-name="{{ $siswa->nama }}">
                                                <i class="bi bi-check-circle"></i> Setujui
                                            </button>
                                            <button type="button" class="btn-reject-mini btn-status-action" data-url="/admin/reject/{{ $siswa->nis }}" data-action="tolak" data-name="{{ $siswa->nama }}">
                                                <i class="bi bi-x-circle"></i> Tolak
                                            </button>
                                        @endif
                                        <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditSiswa{{ $siswa->nis }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <form action="/admin/siswa/{{ $siswa->nis }}" method="POST" class="d-inline form-hapus">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn-danger-pill btn-hapus">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: var(--text-dim);"></i>
                                    <h5 class="mt-3 text-muted">Belum ada siswa terdaftar</h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    @foreach($siswas as $siswa)
    <div class="modal fade" id="modalEditSiswa{{ $siswa->nis }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/siswa/{{ $siswa->nis }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Siswa - {{ $siswa->nis }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="{{ $siswa->kelas }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $siswa->status == 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="approved" {{ $siswa->status == 'approved' ? 'selected' : '' }}>Terverifikasi</option>
                                <option value="rejected" {{ $siswa->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-primary-pill">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <footer>
        <div class="container">© 2026 Aspira Siswa — Panel admin untuk manajemen aspirasi siswa. | Dirancang oleh Vourel Oktofit Avin</div>
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

        // Delete confirmation
        document.querySelectorAll('.btn-hapus').forEach(btn => {
            btn.addEventListener('click', function() {
                let form = this.closest('.form-hapus');
                Swal.fire({
                    title: 'Yakin mau hapus?',
                    text: "Data siswa ini bakal hilang selamanya!",
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

        document.querySelectorAll('.btn-status-action').forEach((btn) => {
            btn.addEventListener('click', function () {
                const url = this.dataset.url;
                const actionLabel = this.dataset.action;
                const siswaName = this.dataset.name;
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

                Swal.fire({
                    title: `Yakin mau ${actionLabel} akun ini?`,
                    text: `Akun ${siswaName} akan diproses sekarang.`,
                    icon: actionLabel === 'setujui' ? 'question' : 'warning',
                    showCancelButton: true,
                    confirmButtonColor: actionLabel === 'setujui' ? '#10b981' : '#ef4444',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Ya, ${actionLabel}`,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (!result.isConfirmed) return;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                        .then((res) => res.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload());
                                return;
                            }

                            Swal.fire('Gagal!', data.error || 'Terjadi kesalahan saat memproses data.', 'error');
                        })
                        .catch(() => {
                            Swal.fire('Error!', 'Terjadi kesalahan jaringan.', 'error');
                        });
                });
            });
        });

        @if(session('success'))
            Swal.fire('Berhasil!', "{{ session('success') }}", 'success');
        @endif
    </script>
</body>
</html>