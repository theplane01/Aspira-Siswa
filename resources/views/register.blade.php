<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Siswa — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --success: #10b981;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .register-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
        }
        
        .register-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .register-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, #667eea 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
        }
        
        .register-card h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .register-card > p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .alert-success {
            background: #dbeafe;
            border: 2px solid #93c5fd;
            color: #1e40af;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: flex;
            gap: 0.75rem;
            font-size: 0.9rem;
        }
        
        .alert-error {
            background: #fee2e2;
            border: 2px solid #fecaca;
            color: #991b1b;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .alert-error ul {
            margin: 0.5rem 0 0 1.5rem;
            padding: 0;
        }
        
        .alert-error li {
            margin: 0.25rem 0;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s;
            background: white;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        
        .form-control::placeholder {
            color: var(--text-secondary);
        }
        
        .form-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        
        .form-divider::before,
        .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }
        
        .btn-register {
            width: 100%;
            padding: 0.85rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-register:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
        }
        
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.85rem;
        }
        
        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        .form-footer a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 640px) {
            .register-card {
                padding: 1.5rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .register-card h2 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <div class="register-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <h2>Daftar Akun Baru</h2>
                <p>Pendaftaran untuk pelajar. Akun Anda akan diverifikasi oleh admin sebelum dapat login.</p>
            </div>

            @if(session('success'))
                <div class="alert-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/register" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">NIS</label>
                        <div class="input-wrapper">
                            <i class="input-icon bi bi-card-text"></i>
                            <input type="text" name="nis" value="{{ old('nis') }}" class="form-control" placeholder="Nomor Induk Siswa" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tingkat & Rombel</label>
                        <div class="input-wrapper">
                            <i class="input-icon bi bi-door-open"></i>
                            <input type="text" name="kelas" value="{{ old('kelas') }}" class="form-control" placeholder="Contoh: 12A" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama Panjang</label>
                    <div class="input-wrapper">
                        <i class="input-icon bi bi-person"></i>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" placeholder="Nama lengkap Anda" required>
                    </div>
                </div>

                <div class="form-divider"><span>Atur Sandi Akun</span></div>

                <div class="form-group">
                    <label class="form-label">Sandi</label>
                    <div class="input-wrapper">
                        <i class="input-icon bi bi-lock"></i>
                        <input type="password" name="password" class="form-control" placeholder="Buat sandi yang aman" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Sandi</label>
                    <div class="input-wrapper">
                        <i class="input-icon bi bi-lock-check"></i>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi sandi Anda" required>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="bi bi-star-fill"></i> Buat Akun
                </button>
            </form>

            <div class="form-footer">
                Sudah memiliki akun? <a href="/login">Masuk ke sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses Mendaftar!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Lanjut ke Login'
            }).then(() => {
                window.location.href = '/login';
            });
        @endif
    </script>
</body>
</html>