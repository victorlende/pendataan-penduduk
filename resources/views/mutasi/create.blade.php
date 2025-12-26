@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-8 col-lg-6">
        <h3 class="mb-4">Lapor Mutasi Penduduk</h3>

        <div class="card">
            <div class="card-body">
                <div class="alert alert-info d-flex align-items-start gap-2" style="border: 1px solid #eaecf0;">
                    <i data-lucide="info" class="flex-shrink-0 mt-1" style="width: 18px; height: 18px;"></i>
                    <div>
                        Fitur ini digunakan untuk melaporkan penduduk yang <b>Meninggal Dunia</b> atau <b>Pindah Domisili</b>.
                        Status penduduk akan otomatis diperbarui setelah disimpan.
                    </div>
                </div>

                <form action="{{ route('mutasi.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="penduduk_id" class="form-label">Pilih Penduduk</label>
                        <select class="form-select @error('penduduk_id') is-invalid @enderror" id="penduduk_id" name="penduduk_id" required>
                            <option value="" disabled selected>- Cari Nama / NIK -</option>
                            @foreach($penduduk as $p)
                                <option value="{{ $p->id }}" {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_lengkap }} ({{ $p->nik }}) - {{ $p->status_penduduk }}
                                </option>
                            @endforeach
                        </select>
                        @error('penduduk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis_mutasi" class="form-label">Jenis Mutasi</label>
                        <select class="form-select @error('jenis_mutasi') is-invalid @enderror" id="jenis_mutasi" name="jenis_mutasi" required>
                            <option value="" disabled selected>- Pilih Jenis -</option>
                            <option value="Meninggal" {{ old('jenis_mutasi') == 'Meninggal' ? 'selected' : '' }}>Meninggal Dunia</option>
                            <option value="Pindah" {{ old('jenis_mutasi') == 'Pindah' ? 'selected' : '' }}>Pindah Domisili</option>
                        </select>
                        @error('jenis_mutasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_mutasi" class="form-label">Tanggal Peristiwa</label>
                        <input type="date" class="form-control @error('tanggal_mutasi') is-invalid @enderror" id="tanggal_mutasi" name="tanggal_mutasi" value="{{ old('tanggal_mutasi', date('Y-m-d')) }}" required>
                        @error('tanggal_mutasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Contoh: Pindah ke Atambua, Meninggal karena sakit, dll.">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('mutasi.index') }}" class="btn btn-light">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#penduduk_id').select2({
            theme: 'bootstrap-5',
            placeholder: '- Cari Nama / NIK -',
            allowClear: true
        });
    });
</script>
@endsection
