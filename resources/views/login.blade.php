<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun — Aspira Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #3b82f6;
            --secondary: #059669;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(50px);
        }
        
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            filter: blur(40px);
        }
        
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 900px;
            margin: 1.5rem;
        }
        
        .login-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            background: white;
            min-height: 500px;
        }
        
        .login-left {
            background: linear-gradient(135deg, var(--primary) 0%, #667eea 100%);
            color: white;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
        }
        
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .login-brand {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        
        .login-brand i {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            backdrop-filter: blur(10px);
        }
        
        .login-message {
            position: relative;
            z-index: 1;
        }
        
        .login-message h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        
        .login-message p {
            font-size: 0.95rem;
            line-height: 1.6;
            opacity: 0.95;
        }
        
        .login-dots {
            display: flex;
            gap: 0.6rem;
            margin-top: 2rem;
        }
        
        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transition: all 0.3s;
        }
        
        .dot.active {
            background: white;
            width: 20px;
            border-radius: 4px;
        }
        
        .login-right {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-right h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .login-right p {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }
        
        .tabs {
            display: flex;
            gap: 0;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--border);
        }
        
        .tab-btn {
            flex: 1;
            padding: 0.75rem 1rem;
            background: none;
            border: none;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
            position: relative;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }
        
        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
            animation: slideIn 0.3s;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(10px); }
            to { opacity: 1; transform: translateX(0); }
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
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
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

        .password-field {
            position: relative;
        }

        .password-field .form-control {
            padding-right: 2.75rem;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            color: var(--text-secondary);
            padding: 0.2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: var(--primary);
        }
        
        .alert-error {
            background: #fee2e2;
            border: 2px solid #fecaca;
            color: #991b1b;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            display: flex;
            gap: 0.75rem;
            align-items: flex-start;
            font-size: 0.9rem;
        }
        
        .btn-login {
            width: 100%;
            padding: 0.85rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-login:hover {
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
        
        @media (max-width: 768px) {
            .login-card {
                grid-template-columns: 1fr;
                min-height: auto;
            }
            
            .login-left {
                padding: 2rem;
                display: none;
            }
            
            .login-right {
                padding: 2rem 1.5rem;
            }
            
            .login-container {
                margin: 1rem;
            }
            
            .login-right h3 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Left Panel -->
            <div class="login-left">
                <div class="login-brand">
                    <i class="bi bi-star-fill"></i>
                    <span>Aspira Siswa</span>
                </div>
                <div class="login-message">
                    <h2>Sampaikan Suara Anda</h2>
                    <p>Platform aman untuk mengajukan keluhan, saran, dan aspirasi sekolah dengan sistem transparansi penuh.</p>
                    <div class="login-dots">
                        <div class="dot active"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            </div>
            
            <!-- Right Panel -->
            <div class="login-right">
                <h3>Masuk Akun</h3>
                <p>Pilih tipe akun dan masukkan data login Anda</p>
                
                @if(session('error'))
                    <div class="alert-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                
                <div class="tabs">
                    <button class="tab-btn active" onclick="switchTab('siswa', this)">
                        <i class="bi bi-mortarboard"></i> Murid
                    </button>
                    <button class="tab-btn" onclick="switchTab('admin', this)">
                        <i class="bi bi-shield-check"></i> Pengelola
                    </button>
                </div>
                
                <!-- Tab Siswa -->
                <div class="tab-content active" id="pane-siswa">
                    <form action="/login-siswa" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">NIS (Nomor Induk Siswa)</label>
                            <input type="text" name="nis" class="form-control" placeholder="Tuliskan NIS Anda (8 digit)" inputmode="numeric" pattern="\d{8}" minlength="8" maxlength="8" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sandi</label>
                            <div class="password-field">
                                <input type="password" name="password" class="form-control" placeholder="Tuliskan sandi" required>
                                <button type="button" class="password-toggle" aria-label="Tampilkan sandi" onclick="togglePassword(this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn-login">
                            <i class="bi bi-box-arrow-in-right"></i> Lanjut Sebagai Murid
                        </button>
                    </form>
                    <div class="form-footer">
                        Tidak punya akun? <a href="/register">Daftar sekarang</a>
                    </div>
                </div>
                
                <!-- Tab Admin -->
                <div class="tab-content" id="pane-admin">
                    <form action="/login" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Akun Pengelola</label>
                            <input type="text" name="username" class="form-control" placeholder="Tuliskan akun" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sandi Pengelola</label>
                            <div class="password-field">
                                <input type="password" name="password" class="form-control" placeholder="Tuliskan sandi" required>
                                <button type="button" class="password-toggle" aria-label="Tampilkan sandi" onclick="togglePassword(this)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn-login">
                            <i class="bi bi-shield-lock"></i> Lanjut Sebagai Pengelola
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword(button) {
            const input = button.previousElementSibling;
            const icon = button.querySelector('i');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isHidden);
            icon.classList.toggle('bi-eye-slash', isHidden);
            button.setAttribute('aria-label', isHidden ? 'Sembunyikan sandi' : 'Tampilkan sandi');
        }

        function switchTab(tabName, element) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab and set button as active
            document.getElementById('pane-' + tabName).classList.add('active');
            element.classList.add('active');
        }
        
        // Show success/error alerts with SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sukses!'
                text: '{{ session('success') }}',
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Oke'
            });
        @endif
    </script>
</body>
</html>