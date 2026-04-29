<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Laporan — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg-light: #f8fafc;
            --border: #e2e8f0;
            --text: #1e293b;
            --text-soft: #64748b;
            --primary: #2563eb;
            --info: #0ea5e9;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text);
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, rgba(37,99,235,0.03) 0%, rgba(168,85,247,0.03) 100%);
            pointer-events: none;
            z-index: 0;
        }
        .page-wrap { position: relative; z-index: 1; padding: 2.5rem 0 4rem; }
        .content-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 1.6rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .page-head {
            background: linear-gradient(135deg, rgba(37,99,235,0.1) 0%, rgba(168,85,247,0.08) 100%);
            border: 1px solid rgba(37,99,235,0.15);
            border-radius: 16px;
            padding: 1.6rem;
            margin-bottom: 1rem;
        }
        .page-head h1 { font-weight: 800; font-size: 1.55rem; margin: 0 0 .35rem; }
        .page-head p { color: var(--text-soft); margin: 0; font-size: .9rem; }
        .form-label { font-weight: 600; font-size: .85rem; }
        .form-control, .form-select {
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .9rem;
            padding: .68rem .85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .btn-main {
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .65rem 1rem; border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            border: none; color: #fff; font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="page-wrap">
        <div class="container" style="max-width: 860px;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <a href="/laporan-saya" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>

            <div class="page-head">
                <h1>Edit Laporan</h1>
                <p>Perbarui isi laporan selama statusnya masih belum diproses.</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="content-card">
                <form action="/laporan-saya/{{ $laporan->id_pelaporan }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Kategori Laporan</label>
                        <select name="id_kategori" class="form-select" required>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id_kategori }}" {{ (int) old('id_kategori', $laporan->id_kategori) === (int) $kategori->id_kategori ? 'selected' : '' }}>
                                    {{ $kategori->ket_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $laporan->lokasi) }}" maxlength="50" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="ket" class="form-control" rows="4" required>{{ old('ket', $laporan->ket) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lampiran Baru (Opsional)</label>
                        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.gif">
                        @if($laporan->foto)
                            <div class="mt-2">
                                <small class="text-muted d-block mb-1">Lampiran saat ini:</small>
                                <a href="{{ asset($laporan->foto) }}" target="_blank">
                                    <img src="{{ asset($laporan->foto) }}" alt="Lampiran saat ini" style="width: 130px; height: 86px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border);">
                                </a>
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="btn-main"><i class="bi bi-check2-circle"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
