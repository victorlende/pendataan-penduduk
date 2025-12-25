<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pendataan Penduduk') }} - Login Administrator</title>
    
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
        }
        .login-card {
            background: white;
            border-radius: 16px;
            /* box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); */
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
        }
        .app-logo {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #198754 0%, #157347 100%); /* Green for Admin to differentiate */
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
        .btn-success { /* Changed to success/green for Admin */
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
        }
        .form-floating > label {
            padding-left: 1rem;
        }
        .custom-input-group {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
            overflow: hidden;
        }
        .custom-input-group:focus-within {
            border-color: #198754; /* Green focus for admin */
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
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
                <div class="app-logo">
                    <i data-lucide="shield-alert" width="28" height="28"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1">Login Administrator</h4>
                <p class="text-secondary small">Panel Admin Desa Naisau</p>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label small fw-medium text-secondary">Email Address</label>
                    <div class="input-group custom-input-group">
                        <span class="input-group-text text-secondary ps-3 pe-2">
                            <i data-lucide="mail" width="18" height="18"></i>
                        </span>
                        <input id="email" type="email" class="form-control ps-1 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="admin@example.com">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label small fw-medium text-secondary">Password</label>
                    <div class="input-group custom-input-group">
                        <span class="input-group-text text-secondary ps-3 pe-2">
                            <i data-lucide="lock" width="18" height="18"></i>
                        </span>
                        <input id="password" type="password" class="form-control ps-1 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter password">
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
                        <label class="form-check-label small text-secondary" for="remember">
                            Remember me
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 mb-3" id="loginBtn">
                    <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true" id="loginSpinner"></span>
                    <span id="loginText">Masuk Admin</span>
                </button>
            </form>
        </div>
        
        <div class="text-center mt-4">
            <p class="small text-muted mb-0">&copy; {{ date('Y') }} Website Desa Naisau</p>
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
            text.textContent = 'Verifying...';
        });
    </script>
</body>
</html>
