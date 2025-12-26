@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Data Petugas Lapangan</h3>
        <a href="{{ route('petugas.create') }}" class="btn btn-primary">Tambah Petugas</a>
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
                <table class="table table-sm table-bordered table-hover" id="petugas-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor HP</th>
                            <th>Lokasi Tugas</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($petugas as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->phone_number }}</td>
                            <td>
                                @if($p->dusun)
                                    <span class="badge bg-info d-flex align-items-center gap-1 w-fit-content">
                                        <i data-lucide="map-pin" style="width: 12px; height: 12px;"></i>
                                        {{ $p->dusun->nama_dusun }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary opacity-50">Belum ada</span>
                                @endif
                            </td>
                            <td class="text-nowrap text-center">
                                <button type="button" class="btn btn-sm btn-icon-action" title="Atur Wilayah" data-bs-toggle="modal" data-bs-target="#assignModal{{ $p->id }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <i data-lucide="map-pin" style="width: 16px; height: 16px;"></i>
                                </button>
                                <a href="{{ route('petugas.edit', $p->id) }}" class="btn btn-sm btn-icon-action" title="Edit" aria-label="Edit" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <i data-lucide="pencil" style="width: 16px; height: 16px;"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-icon-action" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('petugas.destroy', $p->id) }}" title="Hapus" aria-label="Hapus" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
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
                    Apakah Anda yakin ingin menghapus petugas ini?
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
    @foreach($petugas as $p)
    <div class="modal fade" id="assignModal{{ $p->id }}" tabindex="-1" aria-labelledby="assignModalLabel{{ $p->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel{{ $p->id }}">Atur Wilayah Tugas - {{ $p->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('petugas.assignDusun', $p->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="dusun_id" class="form-label">Pilih Wilayah Dusun</label>
                            <select class="form-select" name="dusun_id" required>
                                <option value="" disabled selected>-- Pilih Dusun --</option>
                                @foreach($dusuns as $dusun)
                                    <option value="{{ $dusun->id }}" {{ $p->dusun_id == $dusun->id ? 'selected' : '' }}>
                                        {{ $dusun->nama_dusun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#petugas-table').DataTable();

        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var action = button.data('action');
            var modal = $(this);
            modal.find('#deleteForm').attr('action', action);
        });
    });
</script>
@endsection
