@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Detail Penduduk</h3>
        <a href="{{ route('penduduk.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali ke halaman utama">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active text-dark" id="pribadi-tab" data-bs-toggle="tab" data-bs-target="#pribadi" type="button" role="tab" aria-controls="pribadi" aria-selected="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Tampilkan data pribadi penduduk">Data Pribadi</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="alamat-tab" data-bs-toggle="tab" data-bs-target="#alamat" type="button" role="tab" aria-controls="alamat" aria-selected="false" data-bs-toggle="tooltip" data-bs-placement="top" title="Tampilkan alamat dan kontak penduduk">Alamat & Kontak</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="lainnya-tab" data-bs-toggle="tab" data-bs-target="#lainnya" type="button" role="tab" aria-controls="lainnya" aria-selected="false" data-bs-toggle="tooltip" data-bs-placement="top" title="Tampilkan data lainnya dari penduduk">Data Lainnya</button>
                </li>
                 @if($penduduk->photo_ktp)
                <li class="nav-item" role="presentation">
                    <button class="nav-link text-dark" id="ktp-tab" data-bs-toggle="tab" data-bs-target="#ktp" type="button" role="tab" aria-controls="ktp" aria-selected="false" data-bs-toggle="tooltip" data-bs-placement="top" title="Tampilkan foto KTP penduduk">Foto KTP</button>
                </li>
                @endif
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                {{-- Data Pribadi Tab --}}
                <div class="tab-pane fade show active" id="pribadi" role="tabpanel" aria-labelledby="pribadi-tab">
                    <dl class="row">
                        <dt class="col-sm-3">NIK</dt>
                        <dd class="col-sm-9">{{ $penduduk->nik }}</dd>

                        <dt class="col-sm-3">Nama Lengkap</dt>
                        <dd class="col-sm-9">{{ $penduduk->nama_lengkap }}</dd>

                        <dt class="col-sm-3">No. KK</dt>
                        <dd class="col-sm-9">{{ $penduduk->no_kk }}</dd>

                        <dt class="col-sm-3">Status Verifikasi</dt>
                        <dd class="col-sm-9"><span class="badge badge-pills bg-{{ $penduduk->status == 'verified' ? 'success' : ($penduduk->status == 'pending' ? 'warning' : 'danger') }}">{{ $penduduk->status }}</span></dd>

                        <dt class="col-sm-3">Jenis Kelamin</dt>
                        <dd class="col-sm-9">{{ $penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>

                        <dt class="col-sm-3">Tempat, Tanggal Lahir</dt>
                        <dd class="col-sm-9">{{ $penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->isoFormat('D MMMM Y') }}</dd>

                        <dt class="col-sm-3">Agama</dt>
                        <dd class="col-sm-9">{{ $penduduk->agama }}</dd>

                        <dt class="col-sm-3">Pendidikan Terakhir</dt>
                        <dd class="col-sm-9">{{ $penduduk->pendidikan_terakhir ?? '-' }}</dd>

                        <dt class="col-sm-3">Pekerjaan</dt>
                        <dd class="col-sm-9">{{ $penduduk->pekerjaan ?? '-' }}</dd>

                        <dt class="col-sm-3">Status Perkawinan</dt>
                        <dd class="col-sm-9">{{ $penduduk->status_perkawinan }}</dd>

                        <dt class="col-sm-3">Golongan Darah</dt>
                        <dd class="col-sm-9">{{ $penduduk->golongan_darah ?? '-' }}</dd>

                        <dt class="col-sm-3">Kewarganegaraan</dt>
                        <dd class="col-sm-9">{{ $penduduk->kewarganegaraan ?? '-' }}</dd>
                    </dl>
                </div>

                {{-- Alamat & Kontak Tab --}}
                <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                    <dl class="row">
                        <dt class="col-sm-3">RT/RW</dt>
                        <dd class="col-sm-9">{{ $penduduk->rt_rw }}</dd>

                        <dt class="col-sm-3">Kelurahan</dt>
                        <dd class="col-sm-9">{{ $penduduk->kelurahan ?? '-' }}</dd>

                        <dt class="col-sm-3">Kecamatan</dt>
                        <dd class="col-sm-9">{{ $penduduk->kecamatan ?? '-' }}</dd>

                        <dt class="col-sm-3">Alamat Lengkap</dt>
                        <dd class="col-sm-9">{{ $penduduk->alamat_lengkap }}</dd>

                        <dt class="col-sm-3">No. Telepon</dt>
                        <dd class="col-sm-9">{{ $penduduk->no_telp ?? '-' }}</dd>
                    </dl>
                </div>

                {{-- Data Lainnya Tab --}}
                <div class="tab-pane fade" id="lainnya" role="tabpanel" aria-labelledby="lainnya-tab">
                    <dl class="row">
                        <dt class="col-sm-3">Status dalam Keluarga</dt>
                        <dd class="col-sm-9">{{ $penduduk->status_dalam_keluarga ?? '-' }}</dd>

                        <dt class="col-sm-3">Nama Ayah</dt>
                        <dd class="col-sm-9">{{ $penduduk->nama_ayah ?? '-' }}</dd>

                        <dt class="col-sm-3">Nama Ibu</dt>
                        <dd class="col-sm-9">{{ $penduduk->nama_ibu ?? '-' }}</dd>

                        <dt class="col-sm-3">Diinput oleh</dt>
                        <dd class="col-sm-9">{{ $penduduk->creator->name ?? 'N/A' }} ({{ $penduduk->creator->email ?? '' }})</dd>

                        <dt class="col-sm-3">Waktu Input</dt>
                        <dd class="col-sm-9">{{ $penduduk->created_at->format('d F Y, H:i:s') }}</dd>
                    </dl>
                </div>

                {{-- Foto KTP Tab --}}
                @if($penduduk->photo_ktp)
                <div class="tab-pane fade" id="ktp" role="tabpanel" aria-labelledby="ktp-tab">
                    <img src="{{ Storage::url($penduduk->photo_ktp) }}" class="img-fluid" alt="Foto KTP">
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
