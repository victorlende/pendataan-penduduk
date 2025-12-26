@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1 fw-bold">Verifikasi Akun Masyarakat</h3>
            <p class="text-muted mb-0 small">Kelola permintaan verifikasi akun dari masyarakat</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="badge bg-primary" style="font-size: 0.95rem; padding: 0.5rem 1rem;">
                <i data-lucide="users" style="width: 16px; height: 16px;"></i>
                <span class="ms-2">{{ $users->count() }} Menunggu</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="verifikasi-table">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 15%;">Tanggal Daftar</th>
                                <th style="width: 20%;">Nama</th>
                                <th style="width: 15%;">NIK</th>
                                <th style="width: 20%;">Email</th>
                                <th style="width: 10%;" class="text-center">Status</th>
                                <th style="width: 15%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #f3f4f6; border-radius: 8px;">
                                        <span class="fw-semibold text-secondary small">{{ $index + 1 }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i data-lucide="calendar" style="width: 16px; height: 16px; color: #6b7280;"></i>
                                        <div>
                                            <div class="fw-medium" style="font-size: 0.875rem;">{{ $user->created_at->format('d M Y') }} {{ $user->created_at->format('H:i') }}</div>
                                            <!-- <div class="text-muted small">{{ $user->created_at->format('H:i') }}</div> -->
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div>
                                            <div class="fw-semibold">{{ $user->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($user->penduduk)
                                        <div class="d-flex align-items-center gap-2">
                                            <i data-lucide="credit-card" style="width: 16px; height: 16px; color: #6b7280;"></i>
                                            <span class="font-monospace">{{ $user->penduduk->nik }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i data-lucide="mail" style="width: 16px; height: 16px; color: #6b7280;"></i>
                                        <span style="font-size: 0.875rem;">{{ $user->email }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($user->penduduk)
                                        <span class="badge badge-pills bg-success">
                                            <span>Aktif</span>
                                        </span>
                                    @else
                                        <span class="badge badge-pills bg-warning">
                                            <span>Belum Aktif</span>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <form action="{{ route('verifikasi.approve', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success d-flex align-items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menyetujui akun ini?')" data-bs-toggle="tooltip" title="Terima Akun">
                                                <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                                                <span>Terima</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('verifikasi.reject', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menolak akun ini?')" data-bs-toggle="tooltip" title="Tolak Akun">
                                                <i data-lucide="x" style="width: 14px; height: 14px;"></i>
                                                <span>Tolak</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; background: linear-gradient(135deg, #34d399 0%, #10b981 100%); border-radius: 50%;">
                            <i data-lucide="check-circle" style="width: 40px; height: 40px; color: white;"></i>
                        </div>
                    </div>
                    <h5 class="fw-semibold mb-2">Semua Akun Terverifikasi</h5>
                    <p class="text-muted mb-0">Tidak ada akun yang perlu diverifikasi saat ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#verifikasi-table').DataTable({
            language: {
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Data tidak ditemukan",
                search: "Cari:",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            },
            order: [[1, 'desc']], // Sort by date
            pageLength: 10
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Reinitialize Lucide icons
        lucide.createIcons();
    });
</script>
@endsection
