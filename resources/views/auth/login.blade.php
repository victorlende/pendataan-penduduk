<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pendataan Penduduk') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .split-container {
            display: flex;
            min-height: 100vh;
        }

        /* Left Side - Info Section */
        .info-section {
            flex: 1;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .info-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .info-section::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .info-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
            margin: 0 auto;
        }

        .info-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .info-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .info-section p {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 2rem;
        }

        .feature-list {
            list-style: none;
            padding: 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .feature-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(10px);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* Right Side - Login Form */
        .login-section {
            flex: 1;
            background: white;
            padding: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 450px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .custom-input-group {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
            overflow: hidden;
        }

        .custom-input-group:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .custom-input-group .input-group-text {
            border: none;
            background: #f9fafb;
            color: #6b7280;
        }

        .custom-input-group .form-control {
            border: none;
            padding: 0.75rem 1rem;
        }

        .custom-input-group .form-control:focus {
            box-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            border: none;
            padding: 0.875rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
            color: #9ca3af;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .split-container {
                flex-direction: column;
            }

            .info-section {
                min-height: 40vh;
                padding: 2rem;
            }

            .info-section h1 {
                font-size: 2rem;
            }

            .login-section {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="split-container">
        <!-- Left Side - Info Section -->
        <div class="info-section">
            <div class="info-content">
                <div class="info-logo">
                    <i data-lucide="building-2" width="40" height="40"></i>
                </div>

                <h1>Sistem Informasi Pendataan Penduduk</h1>
                <p>Website resmi pendataan penduduk Desa Naisau untuk memudahkan pengelolaan data kependudukan secara digital dan terintegrasi.</p>

                <ul class="feature-list">
                    <!-- <li class="feature-item">
                        <div class="feature-icon">
                            <i data-lucide="users" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-semibold">Data Penduduk Terintegrasi</h6>
                            <p class="mb-0 small opacity-90">Kelola data penduduk dengan sistem yang terpadu</p>
                        </div>
                    </li> -->
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i data-lucide="file-text" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-semibold">Pengajuan Surat Online</h6>
                            <p class="mb-0 small opacity-90">Ajukan berbagai surat keterangan secara online</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i data-lucide="shield-check" width="24" height="24"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 fw-semibold">Aman & Terpercaya</h6>
                            <p class="mb-0 small opacity-90">Data Anda terlindungi dengan sistem keamanan terbaik</p>
                        </div>
                    </li>
                </ul>

                <div class="mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.2);">
                    <p class="small mb-0 opacity-75">&copy; {{ date('Y') }} Desa Naisau.</p>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-section">
            <div class="login-container">
                <div class="login-header">
                    <h2>Selamat Datang</h2>
                    <p>Silakan masuk untuk mengakses sistem</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group custom-input-group">
                            <span class="input-group-text">
                                <i data-lucide="mail" width="18" height="18"></i>
                            </span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                   placeholder="nama@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group custom-input-group">
                            <span class="input-group-text">
                                <i data-lucide="lock" width="18" height="18"></i>
                            </span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password" placeholder="Masukkan password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small" for="remember">
                                Ingat saya
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-decoration-none small" href="{{ route('password.request') }}" style="color: #3b82f6;">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mb-3" id="loginBtn">
                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="loginSpinner"></span>
                        <span id="loginText">Masuk</span>
                    </button>

                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <div class="text-center">
                        <p class="small text-secondary mb-0">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none fw-semibold" style="color: #3b82f6;">Daftar Sekarang</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const spinner = document.getElementById('loginSpinner');
            const text = document.getElementById('loginText');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Loading...';
        });
    </script>
</body>
</html>
