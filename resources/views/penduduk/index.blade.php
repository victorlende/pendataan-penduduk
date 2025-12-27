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
            href="{{ route('penduduk.index', ['status' => 'pending']) }}">
                Pending
                @if($pendingCount > 0)
                    <span class="text-danger fw-bold ms-1">( {{ $pendingCount }} ) </span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'verified' ? 'bg-dark text-white active' : 'text-dark' }}" 
            href="{{ route('penduduk.index', ['status' => 'verified']) }}">Verified</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $currentStatus == 'rejected' ? 'bg-dark text-white active' : 'text-dark' }}" 
            href="{{ route('penduduk.index', ['status' => 'rejected']) }}">Ditolak</a>
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

            <style>
                .btn-action-verify {
                    background-color: rgba(74, 222, 128, 0.2); color: #15803d; border: 1px solid rgba(74, 222, 128, 0.4);
                }
                .btn-action-verify:hover {
                    background-color: rgba(74, 222, 128, 0.4); color: #15803d;
                }
                .btn-action-reject {
                    background-color: rgba(239, 68, 68, 0.2); color: #b91c1c; border: 1px solid rgba(239, 68, 68, 0.4);
                }
                .btn-action-reject:hover {
                    background-color: rgba(239, 68, 68, 0.4); color: #b91c1c;
                }

                .table-responsive {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }
                
                /* Sticky Column Styles */
                table#penduduk-table thead th:first-child,
                table#penduduk-table tbody td:first-child {
                    position: sticky;
                    left: 0;
                    background-color: #fff;
                    z-index: 10;
                    box-shadow: 2px 0 5px -2px rgba(0,0,0,0.1);
                    min-width: 150px;
                }

                table#penduduk-table thead th:nth-child(2),
                table#penduduk-table tbody td:nth-child(2) {
                    position: sticky;
                    left: 150px; /* Width of first column */
                    background-color: #fff;
                    z-index: 10;
                    box-shadow: 2px 0 5px -2px rgba(0,0,0,0.1);
                    min-width: 180px; /* Increased for buttons */
                }

                /* Ensure header is above body columns */
                table#penduduk-table thead th:first-child,
                table#penduduk-table thead th:nth-child(2) {
                    z-index: 20;
                    background-color: #f8f9fa; /* Match typical header bg */
                }
            </style>

            <!-- Removed manual .table-responsive wrapper -->
            <table class="table table-sm table-bordered table-hover text-nowrap" id="penduduk-table">
                <thead class="table-light">
                    <tr>
                        <th class="align-middle">NIK</th>
                        <th class="align-middle text-center">Aksi</th>
                        <th class="align-middle text-center">Status Verifikasi</th>
                        <th class="align-middle">Nama Lengkap</th>
                        <th class="align-middle">Dusun</th>
                        <th class="align-middle">RT/RW</th>
                        <th class="align-middle">Jenis Kelamin</th>
                        <th class="align-middle">Tempat, Tgl Lahir</th>
                        <th class="align-middle">Agama</th>
                        <th class="align-middle">Pendidikan</th>
                        <th class="align-middle">Pekerjaan</th>
                        <th class="align-middle">Status Kawin</th>
                        <th class="align-middle">SHDK</th>
                        <th class="align-middle">Nama Ayah</th>
                        <th class="align-middle">Nama Ibu</th>

                        <th class="align-middle text-center">Status Penduduk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penduduk as $p)
                    <tr>
                        <td>{{ $p->nik }}</td>
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
                                <button type="button" class="btn btn-sm btn-action-verify" data-bs-toggle="modal" data-bs-target="#verifyModal" data-action="{{ route('penduduk.verify', $p->id) }}" title="Verifikasi" aria-label="Verifikasi" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><path d="M20 6 9 17l-5-5"/></svg>
                                </button>
                                <button type="button" class="btn btn-sm btn-action-reject" data-bs-toggle="modal" data-bs-target="#rejectModal" data-action="{{ route('penduduk.reject', $p->id) }}" title="Tolak" aria-label="Tolak" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                </button>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-{{ $p->status == 'verified' ? 'success' : ($p->status == 'pending' ? 'warning' : 'danger') }}">{{ $p->status }}</span>
                        </td>
                        <td>{{ $p->nama_lengkap }}</td>
                        <td>{{ $p->dusun->nama_dusun ?? 'N/A' }}</td>
                        <td>{{ $p->rt_rw ?? '-' }}</td>
                        <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $p->tempat_lahir }}, {{ \Carbon\Carbon::parse($p->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                        <td>{{ $p->agama ?? '-' }}</td>
                        <td>{{ $p->pendidikan_terakhir ?? '-' }}</td>
                        <td>{{ $p->pekerjaan ?? '-' }}</td>
                        <td>{{ $p->status_perkawinan ?? '-' }}</td>
                        <td>{{ $p->status_dalam_keluarga ?? '-' }}</td>
                        <td>{{ $p->nama_ayah ?? '-' }}</td>
                        <td>{{ $p->nama_ibu ?? '-' }}</td>

                        <td class="text-center">{{ $p->status_penduduk }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
    </div>

    <!-- Modal Konfirmasi Verifikasi -->
    <div class="modal fade" id="verifyModal" tabindex="-1" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalLabel">Konfirmasi Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda telah memastikan validitas NIK dan kesesuaian data lainnya?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <form id="verifyForm" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Verifikasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Tolak -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Konfirmasi Penolakan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak data ini?</p>
                        <div class="mb-3">
                            <label for="alasan_penolakan" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="3" required placeholder="Contoh: Data NIK tidak valid / Foto KTP buram"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // DataTable configuration
        $('#penduduk-table').DataTable({
            searching: false,  // Disable default search
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'<'table-responsive'tr>>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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

        $('#verifyModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var modal = $(this);
            modal.find('#verifyForm').attr('action', action);
        });

        $('#rejectModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var modal = $(this);
            modal.find('#rejectForm').attr('action', action);
            modal.find('#alasan_penolakan').val(''); // Reset textarea
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
