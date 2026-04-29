<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kategori — Aspira Siswa</title>
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
        .btn-locked {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.5rem 1rem; background: var(--surface);
            border: 1px solid var(--border); color: var(--text-dim);
            border-radius: 6px; font-size: 0.85rem; font-weight: 600;
            cursor: not-allowed;
        }
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
                <div class="hero-label"><i class="bi bi-tag me-1"></i> Pengaturan</div>
                <h1>Manajemen Kategori</h1>
                <p>Kelola kategori laporan yang tersedia di sistem Aspira Siswa.</p>
            </div>

            <div class="content-card">
                <div class="card-head">
                    <h4 class="card-title"><i class="bi bi-tag"></i> Daftar Kategori</h4>
                    <button class="btn-primary-pill" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
                        <i class="bi bi-plus-lg"></i> Tambah Kategori
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Jumlah Laporan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategoris as $key => $kat)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-bold">{{ $kat->ket_kategori }}</td>
                                <td>
                                    @php
                                        $count = \App\Models\Aspirasi::where('id_kategori', $kat->id_kategori)->count();
                                        $badgeClass = $count === 0 ? 'none' : ($count <= 5 ? 'low' : ($count <= 20 ? 'mid' : 'high'));
                                        $badgeIcon  = $count === 0 ? 'bi-dash-circle' : ($count <= 5 ? 'bi-file-earmark-text' : ($count <= 20 ? 'bi-files' : 'bi-stack'));
                                        $isUsed     = $count > 0;
                                    @endphp
                                    <span class="count-badge {{ $badgeClass }}">
                                        <i class="bi {{ $badgeIcon }}"></i>
                                        {{ $count }} laporan
                                    </span>
                                </td>
                                <td>
                                    @if($isUsed)
                                        {{-- Category is in use: lock edit & delete --}}
                                        <span class="btn-locked" title="Kategori sedang digunakan, tidak dapat diedit">
                                            <i class="bi bi-lock-fill"></i> Edit
                                        </span>
                                        <span class="btn-locked ms-1" title="Kategori sedang digunakan, tidak dapat dihapus">
                                            <i class="bi bi-lock-fill"></i> Hapus
                                        </span>
                                    @else
                                        {{-- Category not used: allow edit & delete --}}
                                        <button class="btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditKategori{{ $kat->id_kategori }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <form action="/admin/kategori/{{ $kat->id_kategori }}" method="POST" class="d-inline form-hapus">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn-danger-pill btn-hapus ms-1">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <i class="bi bi-inbox" style="font-size: 3rem; color: var(--text-dim);"></i>
                                    <h5 class="mt-3 text-muted">Belum ada kategori</h5>
                                    <p class="text-muted">Tambahkan kategori baru untuk memulai.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambahKategori" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/kategori" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="ket_kategori" class="form-control" placeholder="Cth: Fasilitas, Keamanan, dll" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-primary-pill">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    @foreach($kategoris as $kat)
    @php $modalCount = \App\Models\Aspirasi::where('id_kategori', $kat->id_kategori)->count(); @endphp
    @if($modalCount === 0)
    <div class="modal fade" id="modalEditKategori{{ $kat->id_kategori }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/kategori/{{ $kat->id_kategori }}" method="POST">
                    @csrf @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="ket_kategori" class="form-control" value="{{ $kat->ket_kategori }}" required>
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
    @endif
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
                    text: "Kategori ini bakal hilang selamanya!",
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
    </script>
</body>
</html>