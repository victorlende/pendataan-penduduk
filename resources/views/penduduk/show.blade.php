@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Detail Penduduk</h3>
            <p class="text-muted mb-0">Informasi lengkap data penduduk</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('penduduk.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
            </a>
            <a href="{{ route('penduduk.edit', $penduduk->id) }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i data-lucide="pencil" style="width: 16px; height: 16px;"></i> Edit Data
            </a>
        </div>
    </div>

    <!-- Main Profile Card -->
    <div class="card border border-light mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-4">
                @if($penduduk->photo_ktp)
                    <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; border: 3px solid #f1f5f9; flex-shrink: 0;">
                        <img src="{{ Storage::url($penduduk->photo_ktp) }}" class="w-100 h-100" style="object-fit: cover;" alt="Foto Profil">
                    </div>
                @else
                    <div class="bg-light border rounded-circle d-flex align-items-center justify-content-center text-secondary fw-bold flex-shrink-0" 
                         style="width: 100px; height: 100px; font-size: 2rem;">
                        {{ substr($penduduk->nama_lengkap, 0, 1) }}
                    </div>
                @endif
                
                <div class="flex-grow-1">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div>
                            <h2 class="h4 fw-bold mb-1">{{ $penduduk->nama_lengkap }}</h2>
                            <div class="d-flex align-items-center gap-3 text-muted">
                                <span class="d-flex align-items-center gap-1">
                                    <i data-lucide="hash" style="width: 16px;"></i> {{ $penduduk->nik }}
                                </span>
                                <span class="d-flex align-items-center gap-1">
                                    <i data-lucide="map-pin" style="width: 16px;"></i> {{ $penduduk->dusun->nama_dusun ?? '-' }}
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-{{ $penduduk->status == 'verified' ? 'success' : ($penduduk->status == 'pending' ? 'warning' : 'danger') }} border border-light px-3 py-2 rounded-pill">
                                {{ ucfirst($penduduk->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Col 1: Personal Info -->
        <div class="col-md-6">
            <div class="card border border-light h-100">
                <div class="card-header bg-white border-bottom border-light py-3">
                    <h5 class="card-title fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-secondary" style="width: 20px;"></i> Informasi Pribadi
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Tempat, Tgl Lahir</label>
                             <span class="fw-medium text-dark">{{ $penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->translatedFormat('d F Y') }}</span>
                         </div>
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Jenis Kelamin</label>
                             <span class="fw-medium text-dark">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                         </div>
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Agama</label>
                             <span class="fw-medium text-dark">{{ $penduduk->agama }}</span>
                         </div>
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Status Kawin</label>
                             <span class="fw-medium text-dark">{{ $penduduk->status_perkawinan }}</span>
                         </div>
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Pendidikan</label>
                             <span class="fw-medium text-dark">{{ $penduduk->pendidikan_terakhir ?? '-' }}</span>
                         </div>
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Pekerjaan</label>
                             <span class="fw-medium text-dark">{{ $penduduk->pekerjaan ?? '-' }}</span>
                         </div>
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Gol. Darah</label>
                             <span class="fw-medium text-dark">{{ $penduduk->golongan_darah ?? '-' }}</span>
                         </div>
                         <div class="col-sm-6">
                             <label class="small text-muted fw-bold text-uppercase d-block mb-1">Kewarganegaraan</label>
                             <span class="fw-medium text-dark">{{ $penduduk->kewarganegaraan }}</span>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Col 2: Address & Family -->
        <div class="col-md-6">
             <!-- Address Card -->
             <div class="card border border-light mb-4">
                <div class="card-header bg-white border-bottom border-light py-3">
                    <h5 class="card-title fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="map" class="text-secondary" style="width: 20px;"></i> Alamat & Kontak
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Alamat Lengkap</label>
                            <span class="d-block p-2 bg-light border border-light rounded">{{ $penduduk->alamat_lengkap }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Dusun</label>
                            <span class="fw-medium text-dark">{{ $penduduk->dusun->nama_dusun ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">RT / RW</label>
                            <span class="fw-medium text-dark">{{ $penduduk->rt_rw }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Kelurahan</label>
                            <span class="fw-medium text-dark">{{ $penduduk->kelurahan ?? '-' }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Kecamatan</label>
                            <span class="fw-medium text-dark">{{ $penduduk->kecamatan ?? '-' }}</span>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Kontak (HP/WA)</label>
                            @if($penduduk->no_telp)
                                <span class="fw-medium text-dark d-flex align-items-center gap-2">
                                    {{ $penduduk->no_telp }}
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $penduduk->no_telp)) }}" target="_blank" class="text-success small text-decoration-none">
                                        <i data-lucide="message-circle" style="width: 14px;"></i> Chat WA
                                    </a>
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family Card -->
            <div class="card border border-light">
                <div class="card-header bg-white border-bottom border-light py-3">
                    <h5 class="card-title fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="users" class="text-secondary" style="width: 20px;"></i> Keluarga
                    </h5>
                </div>
                <div class="card-body p-4">
                     <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">No. Kartu Keluarga</label>
                            <span class="fw-bold text-primary">{{ $penduduk->no_kk }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Status Hubungan</label>
                            <span class="fw-medium text-dark">{{ $penduduk->status_dalam_keluarga }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Nama Ayah</label>
                            <span class="fw-medium text-dark">{{ $penduduk->nama_ayah }}</span>
                        </div>
                        <div class="col-sm-6">
                            <label class="small text-muted fw-bold text-uppercase d-block mb-1">Nama Ibu</label>
                            <span class="fw-medium text-dark">{{ $penduduk->nama_ibu }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($penduduk->photo_ktp)
        <!-- Full Width: Documents -->
        <div class="col-12">
            <div class="card border border-light">
                 <div class="card-header bg-white border-bottom border-light py-3">
                    <h5 class="card-title fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="file-text" class="text-secondary" style="width: 20px;"></i> Dokumen KTP
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-4">
                        <div class="border border-light rounded p-2 bg-light">
                            <img src="{{ Storage::url($penduduk->photo_ktp) }}" class="rounded img-fluid" style="max-height: 250px;" alt="Foto KTP">
                        </div>
                        <div>
                             <a href="{{ Storage::url($penduduk->photo_ktp) }}" target="_blank" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-2">
                                <i data-lucide="external-link" style="width: 14px;"></i> Lihat Ukuran Penuh
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Metadata -->
        <div class="col-12 text-center text-muted small mt-4">
            <p class="mb-0">Data ini diinput oleh <strong>{{ $penduduk->creator->name ?? 'System' }}</strong> pada {{ $penduduk->created_at->format('d M Y, H:i') }}</p>
            <p>Terakhir diperbarui pada {{ $penduduk->updated_at->format('d M Y, H:i') }}</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        lucide.createIcons();
    });
</script>
@endsection
