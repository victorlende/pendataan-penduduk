<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pendataan Penduduk') }} - Pendaftaran Warga</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            /* box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); */
            width: 100%;
            max-width: 500px; /* Slightly wider for register form */
            padding: 2.5rem;
        }
        .app-logo {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
        }
        .form-control:focus {
            box-shadow: none;
        }
        .btn-primary {
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
        }
        .custom-input-group {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
            overflow: hidden;
        }
        .custom-input-group:focus-within {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        }
        .custom-input-group .input-group-text {
            border: none;
            background: white;
        }
        .custom-input-group .form-control {
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card mx-auto">
            <div class="text-center mb-4">
                <!-- <div class="app-logo">
                    <i data-lucide="user-plus" width="28" height="28"></i>
                </div> -->
                <h4 class="fw-bold text-dark mb-1">Pendaftaran Warga</h4>
                <!-- <p class="text-secondary small">Lengkapi data diri Anda untuk mendaftar</p> -->
                <p class="text-secondary small">Website Pendataan Penduduk Desa Naisau</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="nik" class="form-label small fw-medium text-secondary">NIK (Sesuai KTP/KK)</label>
                    <div class="input-group custom-input-group">
                        <span class="input-group-text text-secondary ps-3 pe-2">
                            <i data-lucide="credit-card" width="18" height="18"></i>
                        </span>
                        <input id="nik" type="text" class="form-control ps-1 @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" required autocomplete="off" autofocus placeholder="Masukkan 16 digit NIK">
                    </div>
                     @error('nik')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_lahir" class="form-label small fw-medium text-secondary">Tanggal Lahir</label>
                    <div class="input-group custom-input-group">
                        <span class="input-group-text text-secondary ps-3 pe-2">
                            <i data-lucide="calendar" width="18" height="18"></i>
                        </span>
                        <input id="tanggal_lahir" type="date" class="form-control ps-1 @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                    @error('tanggal_lahir')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <hr class="my-4 border-light-subtle">

                <div class="mb-3">
                    <label for="name" class="form-label small fw-medium text-secondary">Nama Lengkap</label>
                    <div class="input-group custom-input-group">
                        <span class="input-group-text text-secondary ps-3 pe-2">
                            <i data-lucide="user" width="18" height="18"></i>
                        </span>
                        <input id="name" type="text" class="form-control ps-1 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Nama sesuai KTP">
                    </div>
                    @error('name')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label small fw-medium text-secondary">Alamat Email</label>
                    <div class="input-group custom-input-group">
                        <span class="input-group-text text-secondary ps-3 pe-2">
                            <i data-lucide="mail" width="18" height="18"></i>
                        </span>
                        <input id="email" type="email" class="form-control ps-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="contoh@email.com">
                    </div>
                    @error('email')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label small fw-medium text-secondary">Password</label>
                        <div class="input-group custom-input-group">
                            <span class="input-group-text text-secondary ps-3 pe-2">
                                <i data-lucide="lock" width="18" height="18"></i>
                            </span>
                            <input id="password" type="password" class="form-control ps-1 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter">
                        </div>
                         @error('password')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password-confirm" class="form-label small fw-medium text-secondary">Konfirmasi</label>
                        <div class="input-group custom-input-group">
                            <span class="input-group-text text-secondary ps-3 pe-2">
                                <i data-lucide="lock-check" width="18" height="18"></i>
                            </span>
                            <input id="password-confirm" type="password" class="form-control ps-1" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 mt-2" id="registerBtn">
                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="registerSpinner"></span>
                    <span id="registerText">Daftar Sekarang</span>
                </button>

                <div class="text-center">
                    <p class="small text-secondary mb-0">
                        Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-medium">Masuk disini</a>
                    </p>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-4 mb-4">
             <p class="small text-muted mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            const spinner = document.getElementById('registerSpinner');
            const text = document.getElementById('registerText');

            btn.disabled = true;
            spinner.classList.remove('d-none');
            text.textContent = 'Memproses Pendaftaran...';
        });
    </script>
</body>
</html>
