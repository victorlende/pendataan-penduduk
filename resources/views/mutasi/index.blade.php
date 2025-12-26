@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Mutasi Penduduk</h3>
        <a href="{{ route('mutasi.create') }}" class="btn btn-primary">Lapor Mutasi</a>
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive mt-3">
                <table class="table table-sm table-bordered table-hover" id="mutasi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Penduduk</th>
                            <th>Jenis Mutasi</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mutasi as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($m->tanggal_mutasi)->format('d-m-Y') }}</td>
                            <td>{{ $m->penduduk->nama_lengkap ?? 'Data dihapus' }}</td>
                            <td>
                                @if($m->jenis_mutasi == 'Meninggal')
                                    <span class="badge bg-dark">Meninggal</span>
                                @elseif($m->jenis_mutasi == 'Pindah')
                                    <span class="badge bg-warning text-dark">Pindah</span>
                                @else
                                    <span class="badge bg-secondary">{{ $m->jenis_mutasi }}</span>
                                @endif
                            </td>
                            <td>{{ $m->keterangan }}</td>
                            <td class="text-nowrap text-center">
                                <button type="button" class="btn btn-sm btn-icon-action" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('mutasi.destroy', $m->id) }}" title="Hapus" aria-label="Hapus" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    <p>Apakah Anda yakin ingin menghapus data mutasi ini?</p>
                    <small class="text-muted">Aksi ini akan mengembalikan status penduduk menjadi <b>Tetap</b> jika status saat ini masih sesuai dengan jenis mutasi yang dihapus.</small>
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
        $('#mutasi-table').DataTable();

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var modal = $(this);
            modal.find('#deleteForm').attr('action', action);
        });
    });
</script>
@endsection
