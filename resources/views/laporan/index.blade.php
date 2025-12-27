@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Laporan Data Penduduk</h3>
            <p class="text-secondary mb-0">Statistik demografi kependudukan</p>
        </div>
        <div class="d-flex gap-2">
            <!-- Form Simpan Rekap -->
            <form action="{{ route('laporan.store') }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menyimpan snapshot laporan saat ini?')">
                @csrf
                <button type="submit" class="btn btn-outline-success">
                    Generate Data Laporan
                </button>
            </form>
            
            <!-- Button Download -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#downloadModal">
                Download Data
            </button>
        </div>
    </div>

    <!-- History Table (Moved to Top) -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Riwayat Laporan Statistik</h5>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover mb-0" id="rekap-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Generate</th>
                            <th class="text-center">Total Penduduk</th>
                            <th class="text-center">Total KK</th>
                            <th class="text-center">Lahir (Total)</th>
                            <th class="text-center">Meninggal (Total)</th>
                            <th class="text-center">Pindah (Total)</th>
                            <th class="text-center">Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $row->created_at->format('d-m-Y') }} 
                                <span class="text-muted small">({{ $row->created_at->format('H:i') }})</span>
                            </td>
                            <td class="text-center">{{ number_format($row->total_penduduk) }}</td>
                            <td class="text-center">{{ number_format($row->total_kk) }}</td>
                            <td class="text-center">
                                {{ number_format($row->total_lahir) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($row->total_meninggal) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($row->total_pindah) }}
                            </td>
                            <td class="text-center">
                                {{ $row->creator->name ?? 'System' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-muted">
                                Belum ada riwayat laporan tersimpan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 flat-card">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold text-secondary">Jenis Kelamin</div>
                <div class="card-body">
                    <div style="max-height: 350px; display: flex; justify-content: center;">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100 flat-card">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold text-secondary">Agama</div>
                <div class="card-body">
                    <div style="max-height: 350px; display: flex; justify-content: center;">
                        <canvas id="religionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 flat-card">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold text-secondary">Kelompok Umur</div>
                <div class="card-body">
                    <canvas id="ageChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100 flat-card">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold text-secondary">Pendidikan Terakhir</div>
                <div class="card-body">
                    <canvas id="eduChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>


    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 flat-card">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold text-secondary">Pekerjaan</div>
                <div class="card-body">
                    <canvas id="jobChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100 flat-card">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold text-secondary">Status Perkawinan</div>
                <div class="card-body">
                    <div style="max-height: 350px; display: flex; justify-content: center;">
                        <canvas id="maritalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="downloadModalLabel">Download Data Penduduk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('laporan.download') }}" method="GET" id="downloadForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Filter Berdasarkan (Optional)</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">Semua Data Penduduk</option>
                                <option value="rekap_laporan" class="fw-bold">-- Riwayat Rekapitulasi Laporan --</option>
                                <option value="jenis_kelamin">Jenis Kelamin</option>
                                <option value="agama">Agama</option>
                                <option value="kelompok_umur">Kelompok Umur</option>
                                <option value="pendidikan_terakhir">Pendidikan Terakhir</option>
                                <option value="pekerjaan">Pekerjaan</option>
                                <option value="status_perkawinan">Status Perkawinan</option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-download">
                            <span class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                            <span class="btn-text">Download Excel</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .flat-card {
        border: 1px solid #e5e7eb; /* Soft border */
        border-radius: 12px;
        box-shadow: none !important;
    }
    .card-header {
        font-size: 0.95rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.getElementById('downloadForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('.btn-download');
        const spinner = btn.querySelector('.spinner-border');
        const text = btn.querySelector('.btn-text');
        
        btn.disabled = true;
        spinner.classList.remove('d-none');
        text.textContent = 'Downloading...';

        setTimeout(() => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            text.textContent = 'Download Excel';

        }, 3000);
    });

    const colors = [
        '#a8d5fa', 
        '#fbb4ae', 
        '#ccebc5',
        '#decbe4', 
        '#fed9a6', 
        '#ffffcc', 
        '#e5d8bd', 
        '#b3cde3', 
        '#fddaec'  
    ];
    
    const borderColors = [
        '#36a2eb', '#ff6384', '#4bc0c0', '#9966ff', '#ff9f40', '#ffcd56', '#d8b365', '#5d9ecb', '#f781bf'
    ];

    const chartOptions = {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: { family: "'Inter', sans-serif" }
                }
            }
        },
        elements: {
            bar: { borderRadius: 4, borderWidth: 1 }
        }
    };


    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($gender->keys()) !!},
            datasets: [{
                data: {!! json_encode($gender->values()) !!},
                backgroundColor: ['#a8d5fa', '#fbb4ae'], 
                borderColor: ['#36a2eb', '#ff6384'],
                borderWidth: 1
            }]
        },
        options: chartOptions
    });


    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($umur_stats)) !!},
            datasets: [{
                label: 'Jumlah Penduduk',
                data: {!! json_encode(array_values($umur_stats)) !!},
                backgroundColor: '#ccebc5',
                borderColor: '#4bc0c0',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...chartOptions,
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                x: { grid: { display: false } }
            }
        }
    });

    const eduCtx = document.getElementById('eduChart').getContext('2d');
    new Chart(eduCtx, {
        type: 'bar',
        indexAxis: 'y',
        data: {
            labels: {!! json_encode($pendidikan->keys()) !!},
            datasets: [{
                label: 'Jumlah',
                data: {!! json_encode($pendidikan->values()) !!},
                backgroundColor: '#a8d5fa',
                borderColor: '#36a2eb',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...chartOptions,
            scales: { x: { grid: { color: '#f3f4f6' } }, y: { grid: { display: false } } }
        }
    });


    const jobCtx = document.getElementById('jobChart').getContext('2d');
    new Chart(jobCtx, {
        type: 'bar',
        indexAxis: 'y', 
        data: {
            labels: {!! json_encode($pekerjaan->keys()) !!},
            datasets: [{
                label: 'Jumlah',
                data: {!! json_encode($pekerjaan->values()) !!},
                backgroundColor: '#fed9a6',
                borderColor: '#ff9f40',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            ...chartOptions,
            scales: { x: { grid: { color: '#f3f4f6' } }, y: { grid: { display: false } } }
        }
    });


    const maritalCtx = document.getElementById('maritalChart').getContext('2d');
    new Chart(maritalCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($perkawinan->keys()) !!},
            datasets: [{
                data: {!! json_encode($perkawinan->values()) !!},
                backgroundColor: colors,
                borderColor: 'white',
                borderWidth: 2
            }]
        },
        options: { ...chartOptions, cutout: '65%' }
    });


    const religionCtx = document.getElementById('religionChart').getContext('2d');
    new Chart(religionCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($agama->keys()) !!},
            datasets: [{
                data: {!! json_encode($agama->values()) !!},
                backgroundColor: colors,
                borderColor: 'white',
                borderWidth: 2
            }]
        },
        options: chartOptions
    });
</script>
@endsection
