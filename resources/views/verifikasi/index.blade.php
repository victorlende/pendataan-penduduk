@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Verifikasi Akun Masyarakat</h3>
    </div>

    <div class="card border-0">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="verifikasi-table">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal Daftar</th>
                                <th>Nama</th>
                                <th>NIK</th>
                                <th>Email</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    {{ $user->penduduk ? $user->penduduk->nik : '-' }}
                                    @if(!$user->penduduk)
                                        <span class="badge bg-danger">Tidak Terhubung</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    <form action="{{ route('verifikasi.approve', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui akun ini?')">
                                            <i data-lucide="check" style="width: 16px;"></i> Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('verifikasi.reject', $user->id) }}" method="POST" class="d-inline ms-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak akun ini?')">
                                            <i data-lucide="x" style="width: 16px;"></i> Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-muted mb-3">
                        <i data-lucide="check-circle" style="width: 48px; height: 48px; color: #d1d5db;"></i>
                    </div>
                    <h5 class="text-muted">Tidak ada akun yang perlu diverifikasi saat ini.</h5>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#verifikasi-table').DataTable();
    });
</script>
@endsection
