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
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .verification-container {
            max-width: 550px;
            width: 100%;
        }

        .verification-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 3rem 2.5rem;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: #dbeafe;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .verification-card h2 {
            color: #1f2937;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .verification-card .subtitle {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .status-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .status-label {
            color: #92400e;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: white;
            color: #92400e;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .info-section {
            border-top: 1px solid #e5e7eb;
            padding-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: start;
            gap: 0.875rem;
            margin-bottom: 1rem;
        }

        .info-item:last-child {
            margin-bottom: 0;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            background: #dbeafe;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-text {
            flex: 1;
        }

        .info-text strong {
            display: block;
            color: #1f2937;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .info-text small {
            color: #6b7280;
            line-height: 1.5;
            font-size: 0.813rem;
        }

        .btn-logout {
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            color: #374151;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 100%;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-logout:hover {
            background: #e5e7eb;
            color: #1f2937;
        }

        .footer-text {
            text-align: center;
            color: #9ca3af;
            font-size: 0.813rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        @media (max-width: 576px) {
            .verification-card {
                padding: 2rem 1.5rem;
            }

            .verification-card h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="verification-card">
            <!-- Icon with Animation -->
            <div class="icon-container">
                <i data-lucide="clock" style="width: 56px; height: 56px; color: #3b82f6;"></i>
            </div>

            <!-- Main Heading -->
            <h2 class="text-center">Menunggu Verifikasi</h2>

            <!-- Subtitle -->
            <p class="subtitle text-center">
                Terima kasih telah mendaftar di <strong>Sistem Pendataan Penduduk Desa Naisau</strong>.
                Akun Anda saat ini sedang dalam proses verifikasi oleh admin kami.
            </p>

            <!-- Status Box -->
            <div class="status-box text-center">
                <div class="status-label">Status Akun Saat Ini</div>
                <div class="status-badge">
                    <i data-lucide="loader-2" style="width: 18px; height: 18px;"></i>
                    Menunggu Persetujuan Admin
                </div>
            </div>

            <!-- Information Section -->
            <div class="info-section">
                <div class="info-item">
                    <div class="info-icon">
                        <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #3b82f6;"></i>
                    </div>
                    <div class="info-text">
                        <strong>Pendaftaran Berhasil</strong>
                        <small>Data Anda telah tersimpan dengan aman di sistem kami.</small>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i data-lucide="shield-check" style="width: 20px; height: 20px; color: #3b82f6;"></i>
                    </div>
                    <div class="info-text">
                        <strong>Proses Verifikasi</strong>
                        <small>Admin sedang memverifikasi data kependudukan Anda untuk memastikan keakuratan informasi.</small>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i data-lucide="bell" style="width: 20px; height: 20px; color: #3b82f6;"></i>
                    </div>
                    <div class="info-text">
                        <strong>Pemberitahuan</strong>
                        <small>Anda akan menerima notifikasi melalui email setelah akun Anda disetujui.</small>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">
                        <i data-lucide="clock" style="width: 20px; height: 20px; color: #3b82f6;"></i>
                    </div>
                    <div class="info-text">
                        <strong>Estimasi Waktu</strong>
                        <small>Proses verifikasi biasanya memerlukan waktu 1-3 hari kerja.</small>
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <a class="btn-logout" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i data-lucide="log-out" style="width: 18px; height: 18px; vertical-align: text-bottom; margin-right: 0.5rem;"></i>
                Keluar dari Akun
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            <!-- Footer Text -->
            <div class="footer-text">
                Jika Anda memiliki pertanyaan, silakan hubungi administrator.
            </div>
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
