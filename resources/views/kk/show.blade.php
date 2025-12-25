@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Kartu Keluarga</h3>
        <a href="{{ route('kk.index') }}" class="btn btn-light">Kembali</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Informasi KK
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">No. KK</dt>
                <dd class="col-sm-9">{{ $kk->no_kk }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ $kk->alamat }}</dd>

                <dt class="col-sm-3">RT/RW</dt>
                <dd class="col-sm-9">{{ $kk->rt }}/{{ $kk->rw }}</dd>

                <dt class="col-sm-3">Dusun</dt>
                <dd class="col-sm-9">{{ $kk->dusun->nama_dusun ?? 'N/A' }}</dd>
                
                <dt class="col-sm-3">Diinput oleh</dt>
                <dd class="col-sm-9">{{ $kk->creator->name ?? 'N/A' }}</dd>
                
                <dt class="col-sm-3">Waktu Input</dt>
                <dd class="col-sm-9">{{ $kk->created_at->format('d F Y, H:i:s') }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            Anggota Keluarga
            {{-- <a href="#" class="btn btn-primary btn-sm">Tambah Anggota</a> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Jenis Kelamin</th>
                            <th>Status dlm Keluarga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kk->penduduks as $penduduk)
                        <tr>
                            <td>{{ $penduduk->nik }}</td>
                            <td>{{ $penduduk->nama_lengkap }}</td>
                            <td>{{ $penduduk->jenis_kelamin }}</td>
                            <td>{{ $penduduk->status_dalam_keluarga ?? '-' }}</td>
                            <td>
                                <a href="{{ route('penduduk.show', $penduduk->id) }}" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada anggota keluarga di KK ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
