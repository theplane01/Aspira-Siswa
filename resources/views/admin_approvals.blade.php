<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Approval Registrasi — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1f2937;
            --light: #f9fafb;
            --border: #e5e7eb;
            --text: #111827;
            --text-secondary: #6b7280;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            color: var(--text);
            min-height: 100vh;
            margin-left: 260px;
            transition: margin-left 0.3s;
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
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), #667eea);
            display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: white; flex-shrink: 0;
        }
        .sidebar-menu {
            list-style: none; margin: 0; padding: 0;
        }
        .sidebar-item {
            margin: 0.3rem 0.75rem; position: relative;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            color: var(--text-secondary); text-decoration: none;
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
            background: linear-gradient(135deg, var(--primary), #667eea);
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
            color: var(--text-secondary); font-size: 0.8rem; font-weight: 600;
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
        
        .container-main {
            padding: 2rem;
        }
        
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-header h2 {
            font-weight: 800;
            font-size: 1.8rem;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .page-header p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }
        
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }
        
        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        
        .stat-card .stat-label {
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 500;
        }
        
        .table-container {
            background: white;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .table {
            margin: 0;
            font-size: 0.95rem;
        }
        
        .table thead {
            background: var(--light);
            border-bottom: 1px solid var(--border);
        }
        
        .table th {
            font-weight: 700;
            color: var(--text);
            padding: 1rem;
            border: none;
        }
        
        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .badge-pending {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-approved {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-rejected {
            background: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .btn-approve {
            background: var(--success);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn-approve:hover {
            background: #059669;
            transform: translateY(-1px);
        }
        
        .btn-reject {
            background: var(--danger);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s;
            margin-left: 0.5rem;
        }
        
        .btn-reject:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
        }
        
        .empty-state-icon {
            font-size: 3rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }
        
        .empty-state h4 {
            color: var(--text);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .empty-state p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
            transition: all 0.2s;
        }
        
        .btn-back:hover {
            color: var(--primary-dark);
            transform: translateX(-2px);
        }
        
        @media (max-width: 768px) {
            body { margin-left: 0; }
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar-toggle { display: flex; }
            .container-main {
                padding: 1rem;
            }
            
            .page-header h2 {
                font-size: 1.4rem;
            }
            
            .stats-row {
                grid-template-columns: 1fr;
            }
            
            .table {
                font-size: 0.85rem;
            }
            
            .table th, .table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
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
        </ul>
        
        <div class="sidebar-user">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="user-details">
                    <div class="user-name">{{ session('admin_nama') }}</div>
                    <div class="user-role">Admin</div>
                </div>
            </div>
            <div class="sidebar-actions">
                <a href="/logout" class="sidebar-btn logout" title="Keluar">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="container-main">
        <div class="container">
            <a href="/admin" class="btn-back"><i class="bi bi-chevron-left"></i> Kembali ke Dashboard</a>
            
            <div class="page-header">
                <h2><i class="bi bi-person-check-fill me-2" style="color: var(--primary);"></i>Approval Registrasi Siswa</h2>
                <p>Kelola dan setujui registrasi siswa baru yang menunggu persetujuan</p>
            </div>

            <!-- Stats -->
            <div class="stats-row">
                <div class="stat-card">
                    <div class="stat-number" style="color: var(--warning);">{{ count($pendingStudents) }}</div>
                    <div class="stat-label">Menunggu Approval</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color: var(--success);">{{ $approvedStudents }}</div>
                    <div class="stat-label">Sudah Disetujui</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" style="color: var(--danger);">{{ $rejectedStudents }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
            </div>

            <!-- Pending Students Table -->
            @if(count($pendingStudents) > 0)
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingStudents as $siswa)
                                <tr>
                                    <td><strong>{{ $siswa->nis }}</strong></td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>{{ $siswa->kelas }}</td>
                                    <td>{{ $siswa->created_at->format('d M Y, H:i') }}</td>
                                    <td><span class="badge-pending">{{ ucfirst($siswa->status) }}</span></td>
                                    <td>
                                        <button class="btn-approve" onclick="approveSiswa('{{ $siswa->nis }}', '{{ $siswa->nama }}')">
                                            <i class="bi bi-check-circle me-1"></i> Setuju
                                        </button>
                                        <button class="btn-reject" onclick="rejectSiswa('{{ $siswa->nis }}', '{{ $siswa->nama }}')">
                                            <i class="bi bi-x-circle me-1"></i> Tolak
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="table-container">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h4>Tidak Ada Registrasi Menunggu</h4>
                        <p>Semua registrasi siswa baru sudah diproses.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        function approveSiswa(nis, nama) {
            Swal.fire({
                title: 'Setujui Registrasi?',
                text: `Anda yakin akan menyetujui akun ${nama}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setuju',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/approve/${nis}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                confirmButtonColor: '#2563eb'
                            }).then(() => location.reload());
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error!', 'Terjadi kesalahan', 'error');
                    });
                }
            });
        }

        function rejectSiswa(nis, nama) {
            Swal.fire({
                title: 'Tolak Registrasi?',
                text: `Anda yakin akan menolak akun ${nama}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/reject/${nis}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Ditolak!',
                                text: data.message,
                                confirmButtonColor: '#2563eb'
                            }).then(() => location.reload());
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error!', 'Terjadi kesalahan', 'error');
                    });
                }
            });
        }
    </script>
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
