@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1 text-dark fw-bold">Dashboard Overview</h3>
            <p class="text-secondary mb-0">Ringkasan data dan aktivitas desa</p>
        </div>
        <div>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>


    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0  h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3">
                            <i data-lucide="users" width="24" height="24"></i>
                        </div>
                        <div>
                            <p class="text-secondary mb-1 small fw-medium">Total Penduduk</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['total_penduduk'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card border-0  h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3">
                            <i data-lucide="home" width="24" height="24"></i>
                        </div>
                        <div>
                            <p class="text-secondary mb-1 small fw-medium">Kartu Keluarga</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['total_kk'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <div class="card border-0  h-100 position-relative overflow-hidden">
                @if($stats['surat_pending'] > 0)
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="badge bg-danger rounded-circle p-1" style="width: 10px; height: 10px;"></span>
                    </div>
                @endif
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3 me-3">
                            <i data-lucide="file-clock" width="24" height="24"></i>
                        </div>
                        <div>
                            <p class="text-secondary mb-1 small fw-medium">Surat Pending</p>
                            <h4 class="mb-0 fw-bold text-dark">{{ $stats['surat_pending'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 col-xl-3">
            <a href="{{ route('verifikasi.index') }}" class="text-decoration-none">
                <div class="card border-0  h-100 position-relative overflow-hidden hover-shadow transition-all">
                    @if($stats['user_pending'] > 0)
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-danger rounded-circle p-1" style="width: 10px; height: 10px;"></span>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-danger bg-opacity-10 text-danger p-3 rounded-3 me-3">
                                <i data-lucide="user-plus" width="24" height="24"></i>
                            </div>
                            <div>
                                <p class="text-secondary mb-1 small fw-medium">Verifikasi Akun</p>
                                <h4 class="mb-0 fw-bold text-dark">{{ $stats['user_pending'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0  h-100">

                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('penduduk.create') }}" class="btn border-0 text-start d-flex align-items-center p-3" style="background-color: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                            <div class="bg-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i data-lucide="user-plus" width="20" height="20"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Tambah Penduduk</div>
                                <div class="small opacity-75">Input data penduduk baru</div>
                            </div>
                        </a>
                        <a href="{{ route('kk.create') }}" class="btn border-0 text-start d-flex align-items-center p-3" style="background-color: rgba(25, 135, 84, 0.1); color: #198754;">
                            <div class="bg-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i data-lucide="file-plus" width="20" height="20"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Buat Kartu Keluarga</div>
                                <div class="small opacity-75">Registrasi KK baru</div>
                            </div>
                        </a>
                        <a href="{{ route('surat.index') }}" class="btn border-0 text-start d-flex align-items-center p-3" style="background-color: rgba(255, 193, 7, 0.1); color: #9c7b0f;">
                            <div class="bg-white p-2 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i data-lucide="mail" width="20" height="20"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Cek Permintaan Surat</div>
                                <div class="small opacity-75">Kelola surat masuk</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 h-100">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold d-flex align-items-center">
                        <i data-lucide="history" width="18" height="18" class="me-2 text-muted"></i> Permintaan Surat Terbaru
                    </h6>
                    <a href="{{ route('surat.index') }}" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Pemohon</th>
                                    <th>Jenis Surat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latest_surat as $surat)
                                <tr>
                                    <td class="ps-4 small text-secondary">{{ $surat->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="fw-medium">{{ $surat->penduduk->nama_lengkap ?? 'Unknown' }}</div>
                                        <div class="small text-muted">{{ $surat->penduduk->nik ?? '-' }}</div>
                                    </td>
                                    <td>{{ $surat->jenis_surat_label }}</td>
                                    <td>
                                        @if($surat->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($surat->status == 'diproses')
                                            <span class="badge bg-info text-dark">Diproses</span>
                                        @elseif($surat->status == 'selesai' || $surat->status == 'disetujui')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($surat->status == 'ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada permintaan surat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important;
    }
    .transition-all {
        transition: all .2s ease-in-out;
    }
</style>
@endsection
