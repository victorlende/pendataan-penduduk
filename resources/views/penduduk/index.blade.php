@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Penduduk</h3>
        <a href="{{ route('penduduk.create') }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Penduduk Baru">Tambah Penduduk</a>
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

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

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
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#penduduk-table').DataTable();

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
        })
    });
</script>
@endsection
