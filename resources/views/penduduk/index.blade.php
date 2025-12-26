@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Penduduk</h3>
        <a href="{{ route('penduduk.create') }}" class="btn btn-primary">Tambah Penduduk</a>
    </div>
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills mb-4"> 
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'all' ? 'bg-dark text-white active' : 'text-dark' }}" 
            href="{{ route('penduduk.index', ['status' => 'all']) }}">Semua</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'pending' ? 'bg-dark text-white active' : 'text-dark' }}" 
            href="{{ route('penduduk.index', ['status' => 'pending']) }}">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'verified' ? 'bg-dark text-white active' : 'text-dark' }}" 
            href="{{ route('penduduk.index', ['status' => 'verified']) }}">Verified</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'rejected' ? 'bg-dark text-white active' : 'text-dark' }}" 
            href="{{ route('penduduk.index', ['status' => 'rejected']) }}">Rejected</a>
        </li>
    </ul>


            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Form -->
            <div class="card mb-4" style="background-color: #f9fafb; border: 1px solid #e5e7eb;">

                <div class="collapse show" id="filterCollapse">
                    <div class="card-body">
                        <form action="{{ route('penduduk.index') }}" method="GET" id="filterForm">
                            <input type="hidden" name="status" value="{{ $currentStatus }}">

                            <div class="row g-3">
                                <!-- Filter NIK -->
                                <div class="col-md-3">
                                    <label for="filter_nik" class="form-label fw-medium">NIK</label>
                                    <input type="text" class="form-control" id="filter_nik" name="nik"
                                           placeholder="Cari NIK..." value="{{ request('nik') }}">
                                </div>

                                <!-- Filter Nama -->
                                <div class="col-md-3">
                                    <label for="filter_nama" class="form-label fw-medium">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="filter_nama" name="nama"
                                           placeholder="Cari nama..." value="{{ request('nama') }}">
                                </div>

                                <!-- Filter Jenis Kelamin -->
                                <div class="col-md-3">
                                    <label for="filter_jk" class="form-label fw-medium">Jenis Kelamin</label>
                                    <select class="form-select" id="filter_jk" name="jenis_kelamin">
                                        <option value="">Semua</option>
                                        <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>

                                <!-- Filter Dusun -->
                                <div class="col-md-3">
                                    <label for="filter_dusun" class="form-label fw-medium">Dusun</label>
                                    <select class="form-select" id="filter_dusun" name="dusun_id">
                                        <option value="">Semua Dusun</option>
                                        @foreach(\App\Models\Dusun::all() as $dusun)
                                            <option value="{{ $dusun->id }}" {{ request('dusun_id') == $dusun->id ? 'selected' : '' }}>
                                                {{ $dusun->nama_dusun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Filter RT -->
                                <div class="col-md-2">
                                    <label for="filter_rt" class="form-label fw-medium">RT</label>
                                    <input type="text" class="form-control" id="filter_rt" name="rt"
                                           placeholder="RT..." value="{{ request('rt') }}">
                                </div>

                                <!-- Filter RW -->
                                <div class="col-md-2">
                                    <label for="filter_rw" class="form-label fw-medium">RW</label>
                                    <input type="text" class="form-control" id="filter_rw" name="rw"
                                           placeholder="RW..." value="{{ request('rw') }}">
                                </div>

                                <!-- Filter Agama -->
                                <div class="col-md-3">
                                    <label for="filter_agama" class="form-label fw-medium">Agama</label>
                                    <select class="form-select" id="filter_agama" name="agama">
                                        <option value="">Semua Agama</option>
                                        <option value="Islam" {{ request('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ request('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ request('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ request('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ request('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ request('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                </div>

                                <!-- Filter Status Kependudukan -->
                                <div class="col-md-3">
                                    <label for="filter_status_penduduk" class="form-label fw-medium">Status Kependudukan</label>
                                    <select class="form-select" id="filter_status_penduduk" name="status_penduduk">
                                        <option value="">Semua Status</option>
                                        <option value="Tetap" {{ request('status_penduduk') == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                        <option value="Sementara" {{ request('status_penduduk') == 'Sementara' ? 'selected' : '' }}>Sementara</option>
                                    </select>
                                </div>

                                <!-- Filter Pekerjaan -->
                                <div class="col-md-2">
                                    <label for="filter_pekerjaan" class="form-label fw-medium">Pekerjaan</label>
                                    <input type="text" class="form-control" id="filter_pekerjaan" name="pekerjaan"
                                           placeholder="Pekerjaan..." value="{{ request('pekerjaan') }}">
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2 mt-4">
                                <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                    <i data-lucide="search" style="width: 16px; height: 16px;"></i>
                                    Terapkan Filter
                                </button>
                                <a href="{{ route('penduduk.index', ['status' => $currentStatus]) }}" class="btn btn-light d-flex align-items-center gap-2">
                                    <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                                    Reset Filter
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-sm table-bordered table-hover" id="penduduk-table">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Dusun</th>
                            <th class="text-center">Status Verifikasi</th>
                            <th class="text-center">Status Kependudukan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penduduk as $p)
                        <tr>
                            <td>{{ $p->nik }}</td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->kk->dusun->nama_dusun ?? 'N/A' }}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-{{ $p->status == 'verified' ? 'success' : ($p->status == 'pending' ? 'warning' : 'danger') }}">{{ $p->status }}</span>
                            </td>
                            <td class="text-center">{{ $p->status_penduduk }}</td>
                            <td class="text-nowrap text-center">
                                <a href="{{ route('penduduk.show', $p->id) }}" class="btn btn-sm btn-icon-action" title="Detail" aria-label="Detail" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                                <a href="{{ route('penduduk.edit', $p->id) }}" class="btn btn-sm btn-icon-action" title="Edit" aria-label="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                                </a>

                                <button type="button" class="btn btn-sm btn-icon-action" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('penduduk.destroy', $p->id) }}" title="Hapus" aria-label="Hapus" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>

                                @if($p->status === 'pending')
                                    <form action="{{ route('penduduk.verify', $p->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-icon-action" title="Verifikasi" aria-label="Verifikasi" data-bs-toggle="tooltip" data-bs-placement="top">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // DataTable without search (because we have custom filter)
        $('#penduduk-table').DataTable({
            searching: false,  // Disable default search
            language: {
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(difilter dari _MAX_ total data)",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var modal = $(this);
            modal.find('#deleteForm').attr('action', action);
        });

        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Reinitialize Lucide icons after page load
        lucide.createIcons();
    });
</script>
@endsection
