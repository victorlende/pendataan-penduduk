<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Pendataan Penduduk') }} - Menunggu Verifikasi</title>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;550;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f7fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .verification-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            background: white;
            max-width: 500px;
            width: 90%;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="verification-card text-center">
        <div class="mb-4 text-warning d-flex justify-content-center">
            <i data-lucide="clock" style="width: 72px; height: 72px;"></i>
        </div>
        
        <h2 class="mb-3 fw-bold text-dark">Menunggu Verifikasi</h2>
        
        <p class="text-muted mb-4">
            Terima kasih telah mendaftar. Akun Anda saat ini sedang dalam status <strong>Pending</strong>.
            <br>
            Admin kami sedang memverifikasi data Anda. Mohon kesediaannya untuk menunggu.
        </p>

        <div class="alert alert-light border d-inline-block text-start" role="alert">
            <small class="text-muted d-block mb-1">Status Akun:</small>
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                <i data-lucide="loader-2" class="me-1" style="width: 14px; height: 14px; vertical-align: text-bottom;"></i>
                Menunggu Persetujuan Admin
            </span>
        </div>

        <div class="mt-5 border-top pt-4">
             <a class="btn btn-outline-secondary w-100" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 <i data-lucide="log-out" class="me-1"></i> Keluar
             </a>
             
             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
