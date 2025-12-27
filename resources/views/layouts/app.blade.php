<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pendataan Penduduk') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;550;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f5f7fa; /* Slightly off-white background for entire app */
            }
            .sidebar {
                width: 280px;
                min-height: calc(100vh - 65px); /* Adjusted for compact navbar */
                background-color: #ffffff;
                padding: 1rem;
                border-right: 1px solid #eaecf0;
            }
            .sidebar .nav-link {
                color: #475467;
                font-weight: 500;
                margin-bottom: 0.25rem;
                display: flex;
                align-items: center;
                border-radius: 8px;
                padding: 0.75rem 1rem;
            }
            .sidebar .nav-link svg {
                margin-right: 0.75rem; 
                width: 20px; 
                height: 20px;
                color: #667085;
            }
            .sidebar .nav-link:hover {
                background-color: #f9fafb;
                color: #101828;
            }
            .sidebar .nav-link:hover svg {
                color: #101828;
            }
            .sidebar .nav-link.active {
                background-color: #f5f5f5ff;
                color: #e45015ff; 
            }
            .sidebar .nav-link.active svg {
                color: #e45015ff;
            }
            .content {
                flex-grow: 1;
                padding: 2rem;
            }
            .navbar {
                border-bottom: 1px solid #eaecf0;
            }
            .navbar-brand {
                font-weight: 700;
                color: #101828 !important;
                font-size: 1.15rem;
            }
            .btn-icon-action {
                background-color: transparent;
                color: #667085;
                transition: all 0.2s ease-in-out;
                border-radius: 8px;
            }
            .btn-icon-action:hover {
                background-color: #f2f4f7;
                color: #101828;
            }
            .card {
                border: 1px solid #eaecf0;
                /* box-shadow: 0 1px 3px rgba(16, 24, 40, 0.1), 0 1px 2px rgba(16, 24, 40, 0.06); */
                border-radius: 12px;
            }
            .btn {
                border-radius: 8px;
                font-weight: 500;
            }
            .sidebar-heading {
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #98a2b3;
                font-weight: 600;
                padding: 0.75rem 1rem 0.5rem;
            }
            
            /* Professional Alert Styles */
            .alert {
                border: 0;
                /* border-left: 4px solid; */
                border-radius: 8px; 
                /* box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); */
                background-color: #ffffff;
                padding: 1rem 1.5rem;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                font-size: 0.95rem;
            }
            .alert-success {
                /* border-left-color: #10b981; */
                background-color: #ecfdf5; 
                color: #065f46; 
                
                position: relative;
                padding-left: 3.5rem; /* Space for icon */
            }
            .alert-success::before {
                content: '';
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                width: 24px;
                height: 24px;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23059669' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M22 11.08V12a10 10 0 1 1-5.93-9.14'%3E%3C/path%3E%3Cpolyline points='22 4 12 14.01 9 11.01'%3E%3C/polyline%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: center;
            }

            .alert-danger {
                /* border-left-color: #ef4444; */ 
                background-color: #fef2f2; 
                color: #991b1b; 
                position: relative;
                padding-left: 3.5rem; /* Space for icon */
            }
            .alert-danger::before {
                content: '';
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                width: 24px;
                height: 24px;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23b91c1c' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'%3E%3C/circle%3E%3Cline x1='12' y1='8' x2='12' y2='12'%3E%3C/line%3E%3Cline x1='12' y1='16' x2='12.01' y2='16'%3E%3C/line%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: center;
            }
            .alert .btn-close {
                padding: 1.25rem;
                margin-left: auto;
                opacity: 0.5;
            }

            /* Smooth Badges */
            .badge {
                font-weight: 600;
                padding: 0.5em 0.9em;
                border-radius: 8px;
                letter-spacing: 0.02em;
            }

            .badge.bg-primary {
                background: linear-gradient(135deg, #3352ffff 0%, #1f93ffff 100%) !important;
                color: #ffffff !important;
                border: none;
            }
            .badge.bg-success {
                background: linear-gradient(135deg, #34d399 0%, #10b981 100%) !important;
                color: #ffffff !important;
                border: none;
            }
            .badge.bg-danger {
                background: linear-gradient(135deg, #fb7185 0%, #f472b6 100%) !important;
                color: #ffffff !important;
                border: none;
            }
            .badge.bg-warning {
                background: linear-gradient(135deg, #fbbf24 0%, #fb923c 100%) !important;
                color: #ffffff !important;
                border: none;
            }
            .badge.bg-info {
                background: linear-gradient(135deg, #38bdf8 0%, #22d3ee 100%) !important;
                color: #ffffff !important;
                border: none;
            }
            .badge.bg-secondary {
                background: linear-gradient(135deg, #8b96faff 0%, #c4b5fd 100%) !important;
                color: #ffffff !important;
                border: none;
            }
            .badge.bg-dark {
                background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%) !important;
                color: #ffffff !important;
                border: none;
            }
            .alert .btn-close:hover {
                opacity: 1;
            }

            /* Global Modal Centering */
            .modal-dialog {
                display: flex;
                align-items: center;
                min-height: calc(100% - 1rem);
            }
            @media (min-width: 576px) {
                .modal-dialog {
                    min-height: calc(100% - 3.5rem);
                }
            }
            
            /* Professional Modal Styling */
            .modal-content {
                border: none;
                border-radius: 12px;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
            .modal-header {
                border-bottom: 1px solid #f3f4f6;
                padding: 1.5rem 1.5rem 1rem;
            }
            .modal-header .modal-title {
                font-weight: 600;
                color: #111827;
            }
            .modal-body {
                padding: 1rem 1.5rem;
                color: #4b5563;
            }
            .modal-footer {
                border-top: none;
                padding: 1rem 1.5rem 1.5rem;
                background-color: #f9fafb;
                border-bottom-left-radius: 12px;
                border-bottom-right-radius: 12px;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white py-2">
                <div class="container-fluid px-4">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div class="d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin-house-icon lucide-map-pin-house text-primary me-2"><path d="M15 22a1 1 0 0 1-1-1v-4a1 1 0 0 1 .445-.832l3-2a1 1 0 0 1 1.11 0l3 2A1 1 0 0 1 22 17v4a1 1 0 0 1-1 1z"/><path d="M18 10a8 8 0 0 0-16 0c0 4.993 5.539 10.193 7.399 11.799a1 1 0 0 0 .601.2"/><path d="M18 22v-3"/><circle cx="10" cy="10" r="3"/></svg>
                            {{ str_replace('_', ' ', config('app.name', 'Pendataan Penduduk Desa Naisau')) }}
                        </div>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <ul class="navbar-nav ms-auto">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border" style="width: 32px; height: 32px;">
                                            <i data-lucide="user" class="text-secondary" style="width: 18px; height: 18px;"></i>
                                        </div>
                                        <span class="fw-medium">{{ Auth::user()->name }}</span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg p-0 mt-2 rounded-3 overflow-hidden" aria-labelledby="navbarDropdown" style="min-width: 220px;">
                                        <div class="px-3 py-3 bg-light border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                                    <span class="fw-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                                </div>
                                                <div class="overflow-hidden">
                                                    <div class="fw-bold text-truncate" style="font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                                                    <div class="text-secondary small text-truncate">{{ Auth::user()->email }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="py-1">
                                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('profile.index') }}">
                                                <i data-lucide="user" class="text-secondary" style="width: 16px; height: 16px;"></i>
                                                <span>Profile Saya</span>
                                            </a>
                                            <div class="dropdown-divider my-1"></div>
                                            <a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2 text-danger" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
                                                <span class="fw-medium">{{ __('Logout') }}</span>
                                            </a>
                                        </div>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="d-flex">
                @auth
                <div class="sidebar">
                    <nav class="nav flex-column mt-4">
                        @if(auth()->user()->role !== 'masyarakat')
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i data-lucide="folder-cog"></i>
                            Dashboard
                        </a>
                        @endif

                        @if(auth()->user()->role == 'admin')
                            <div class="sidebar-heading">Main</div>
                            <a class="nav-link {{ request()->routeIs('kk.*') ? 'active' : '' }}" href="{{ route('kk.index') }}">
                                <i data-lucide="file-check"></i>
                                Kartu Keluarga
                            </a>
                            <a class="nav-link {{ request()->routeIs('penduduk.index') ? 'active' : '' }}" href="{{ route('penduduk.index') }}">
                                <i data-lucide="users"></i>
                                Data Penduduk
                            </a>
                            <a class="nav-link {{ request()->routeIs('mutasi.*') ? 'active' : '' }}" href="{{ route('mutasi.index') }}">
                                <i data-lucide="arrow-right-left"></i>
                                Mutasi Penduduk
                            </a>
                            <a class="nav-link {{ request()->routeIs('surat.index') ? 'active' : '' }}" href="{{ route('surat.index') }}">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <span>
                                        <i data-lucide="mail"></i>
                                        Permintaan Surat
                                    </span>
                                    @if(\App\Models\SuratKeterangan::where('status', 'pending')->count() > 0)
                                        <span class="badge bg-primary rounded-pill">{{ \App\Models\SuratKeterangan::where('status', 'pending')->count() }}</span>
                                    @endif
                                </div>
                            </a>
                            <a class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                                <i data-lucide="file-text"></i>
                                Data Laporan
                            </a>
                            <!-- <a class="nav-link {{ request()->routeIs('notifications.index') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
                                <i data-lucide="bell"></i>
                                Notifikasi
                            </a> -->
                            <a class="nav-link {{ request()->routeIs('verifikasi.index') ? 'active' : '' }}" href="{{ route('verifikasi.index') }}">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <span>
                                        <i data-lucide="shield-check"></i>
                                        Verifikasi Akun
                                    </span>
                                    @if(\App\Models\User::where('status', 'pending')->count() > 0)
                                        <span class="badge bg-danger rounded-pill">{{ \App\Models\User::where('status', 'pending')->count() }}</span>
                                    @endif
                                </div>
                            </a>

                            <div class="sidebar-heading mt-2">Setting</div>
                            <a class="nav-link {{ request()->routeIs('dusun.*') ? 'active' : '' }}" href="{{ route('dusun.index') }}">
                                <i data-lucide="map-pin"></i>
                                Dusun
                            </a>
                            <a class="nav-link {{ request()->routeIs('petugas.*') ? 'active' : '' }}" href="{{ route('petugas.index') }}">
                                <i data-lucide="user-check"></i>
                                Petugas Lapangan
                            </a>
                            <a class="nav-link {{ request()->routeIs('notifications.adminTelegramSetup') ? 'active' : '' }}" href="{{ route('notifications.adminTelegramSetup') }}">
                                <i data-lucide="settings"></i>
                                Setup Telegram
                            </a>
                        @elseif(auth()->user()->role == 'masyarakat')
                             <a class="nav-link {{ request()->routeIs('surat.my') ? 'active' : '' }}" href="{{ route('surat.my') }}">
                                <i data-lucide="mail-check"></i>
                                Surat Saya
                            </a>
                            <a class="nav-link {{ request()->routeIs('laporan.index') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
                                <i data-lucide="file-text"></i>
                                Laporan
                            </a>
                        @endif
                    </nav>
                </div>
                @endauth

                <main class="content py-4">
                    @yield('content')
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        @yield('scripts')
        <script src="https://unpkg.com/lucide@latest"></script>
        <script>
            lucide.createIcons();

            // Initialize Tooltips globally
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        </script>
    </body>
    </html>
