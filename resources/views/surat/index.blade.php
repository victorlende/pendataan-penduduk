@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Permohonan Surat Keterangan</h3>
    </div>

            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
        
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-bordered table-hover" id="surat-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Jenis Surat</th>
                                    <th>Keperluan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($surat as $key => $s)
                                <tr>
                                    <td>{{ $s->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $s->penduduk->nama_lengkap }}</td>
                                    <td>{{ $s->jenis_surat_label }}</td>
                                    <td>{{ $s->keperluan }}</td>
                                    <td class="text-center">
                                        @php
                                            $badgeClass = match($s->status) {
                                                'selesai' => 'success',
                                                'diproses' => 'warning',
                                                'ditolak' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge rounded-pill bg-{{ $badgeClass }}">{{ ucfirst($s->status) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <form method="POST" action="{{ route('surat.updateStatus',$s->id) }}" class="d-flex justify-content-center align-items-center gap-2">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm w-auto" onchange="this.style.display='none'; this.nextElementSibling.classList.remove('d-none'); this.form.submit()">
                                                <option value="pending" {{ $s->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="diproses" {{ $s->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="selesai" {{ $s->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="ditolak" {{ $s->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                            </select>
                                            <div class="spinner-border spinner-border-sm text-primary d-none" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
        
                    <div class="d-flex justify-content-center mt-3">
                            {{-- {{ $surat->links() }} --}}
                    </div>
                </div>
            </div>

</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#surat-table').DataTable();
    });
</script>
@endsection

