@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Surat Saya</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#requestModal">
            <i data-lucide="plus-circle" class="me-1"></i> Buat Pengajuan
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover" id="surat-warga-table">
                            <thead>
                                <tr>
                                    <th>No Surat</th>
                                    <th>Tanggal</th>
                                    <th>Jenis Surat</th>
                                    <th>Keperluan</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($surat as $s)
                                <tr>
                                    <td>{{ $s->nomor_surat }}</td>
                                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $s->jenis_surat_label }}</td>
                                    <td>{{ $s->keperluan }}</td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = match($s->status) {
                                                'disetujui' => 'success',
                                                'pending' => 'warning',
                                                'ditolak' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $badgeClass }}">{{ ucfirst($s->status_label) }}</span>
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

    <!-- Modal Pengajuan -->
    <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Buat Pengajuan Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('surat.storeRequest') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jenis_surat" class="form-label">Jenis Surat</label>
                            <select class="form-select @error('jenis_surat') is-invalid @enderror" id="jenis_surat" name="jenis_surat" required>
                                <option value="" disabled selected>-- Pilih Jenis --</option>
                                <option value="domisili">Surat Keterangan Domisili</option>
                                <option value="tidak_mampu">Surat Keterangan Tidak Mampu</option>
                                <option value="usaha">Surat Keterangan Usaha</option>
                                <option value="kelahiran">Surat Keterangan Kelahiran</option>
                                <option value="kematian">Surat Keterangan Kematian</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keperluan" class="form-label">Keperluan</label>
                            <textarea class="form-control" id="keperluan" name="keperluan" rows="3" placeholder="Contoh: Untuk persyaratan mendaftar sekolah" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('#surat-warga-table').DataTable();
    });
</script>
@endsection
