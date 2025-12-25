@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Laporan Data Penduduk</h3>
            <p class="text-secondary mb-0">Statistik demografi kependudukan</p>
        </div>
        <!-- <div>
            <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                <i data-lucide="printer" width="16" height="16" class="me-1"></i> Cetak Laporan
            </button>
        </div> -->
    </div>

    <!-- Row 1: Gender & Religion (Pie) -->
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

    <!-- Row 2: Age & Education -->
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

    <!-- Row 3: Job & Marital Status -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card h-100 flat-card">
                <div class="card-header bg-transparent border-bottom py-3 fw-bold text-secondary">Pekerjaan (Top 10)</div>
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
    // Smooth/Pastel Colors
    const colors = [
        '#a8d5fa', // Soft Blue
        '#fbb4ae', // Soft Red/Pink
        '#ccebc5', // Soft Green
        '#decbe4', // Soft Purple
        '#fed9a6', // Soft Orange
        '#ffffcc', // Soft Yellow
        '#e5d8bd', // Soft Brown
        '#b3cde3', // Blue Grey
        '#fddaec'  // Pink
    ];
    
    // Border colors (slightly darker for definition)
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

    // 1. Gender Chart
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

    // 2. Age Chart
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

    // 3. Education Chart
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

    // 4. Job Chart
    const jobCtx = document.getElementById('jobChart').getContext('2d');
    new Chart(jobCtx, {
        type: 'bar',
        indexAxis: 'y', // Horizontal bar
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

    // 5. Marital Status Chart
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

    // 6. Religion Chart
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
