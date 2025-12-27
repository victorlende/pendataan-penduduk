@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Penduduk</h3>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kk_id" class="form-label">Keluarga (KK)</label>
                        <select class="form-select @error('kk_id') is-invalid @enderror" id="kk_id" name="kk_id" required>
                            <option value="" disabled>Pilih Nomor KK</option>
                            @foreach($kks as $kk)
                                <option value="{{ $kk->id }}" {{ old('kk_id', $penduduk->kk_id) == $kk->id ? 'selected' : '' }}>{{ $kk->no_kk }} - {{ $kk->kepala_keluarga ?? $kk->alamat }}</option>
                            @endforeach
                        </select>
                        @error('kk_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="col-md-6 mb-3">
                         <div class="row">
                             <div class="col-md-6">
                                <label for="dusun_id" class="form-label">Dusun</label>
                                <select class="form-select @error('dusun_id') is-invalid @enderror" id="dusun_id" name="dusun_id" required>
                                    <option value="" disabled>Pilih Dusun</option>
                                    @foreach($dusuns as $dusun)
                                        <option value="{{ $dusun->id }}" {{ old('dusun_id', $penduduk->dusun_id) == $dusun->id ? 'selected' : '' }}>{{ $dusun->nama_dusun }}</option>
                                    @endforeach
                                </select>
                                @error('dusun_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                             </div>
                             @php
                                 $rt_rw = explode('/', $penduduk->rt_rw);
                                 $rt = $rt_rw[0] ?? '';
                                 $rw = $rt_rw[1] ?? '';
                             @endphp
                             <div class="col-md-3">
                                 <label for="rt" class="form-label">RT</label>
                                 <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt" value="{{ old('rt', $rt) }}" required maxlength="3">
                                 @error('rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                             </div>
                              <div class="col-md-3">
                                 <label for="rw" class="form-label">RW</label>
                                 <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw" value="{{ old('rw', $rw) }}" required maxlength="3">
                                  @error('rw')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                             </div>
                         </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik', $penduduk->nik) }}" required maxlength="16">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}" required>
                        @error('nama_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="no_telp" class="form-label">Nomor Telepon/WA</label>
                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp', $penduduk->no_telp) }}">
                        @error('no_telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir->format('Y-m-d')) }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" disabled>Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                         <select class="form-select @error('golongan_darah') is-invalid @enderror" id="golongan_darah" name="golongan_darah">
                            <option value="" disabled>Pilih Gol. Darah</option>
                            @foreach(['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gd)
                                <option value="{{ $gd }}" {{ old('golongan_darah', $penduduk->golongan_darah) == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                            @endforeach
                            <option value="-" {{ old('golongan_darah', $penduduk->golongan_darah) == '-' ? 'selected' : '' }}>Tidak Tahu / -</option>
                        </select>
                         @error('golongan_darah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="agama" class="form-label">Agama</label>
                         <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                            <option value="" disabled>Pilih Agama</option>
                            @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agm)
                                <option value="{{ $agm }}" {{ old('agama', $penduduk->agama) == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                            @endforeach
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                     <div class="col-md-4 mb-3">
                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                        <select class="form-select @error('pendidikan_terakhir') is-invalid @enderror" id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                            <option value="" disabled>Pilih Pendidikan</option>
                             @foreach(['Tidak/Belum Sekolah', 'SD/Sederajat', 'SLTP/Sederajat', 'SLTA/Sederajat', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'] as $pend)
                                <option value="{{ $pend }}" {{ old('pendidikan_terakhir', $penduduk->pendidikan_terakhir) == $pend ? 'selected' : '' }}>{{ $pend }}</option>
                            @endforeach
                        </select>
                        @error('pendidikan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}" list="pekerjaanList">
                        <datalist id="pekerjaanList">
                            <option value="Belum/Tidak Bekerja">
                            <option value="Pelajar/Mahasiswa">
                            <option value="Mengurus Rumah Tangga">
                            <option value="PNS">
                            <option value="TNI">
                            <option value="POLRI">
                            <option value="Wiraswasta">
                            <option value="Petani/Pekebun">
                            <option value="Peternak">
                            <option value="Nelayan/Perikanan">
                            <option value="Karyawan Swasta">
                            <option value="Buruh Harian Lepas">
                        </datalist>
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                         <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                         <select class="form-select @error('kewarganegaraan') is-invalid @enderror" id="kewarganegaraan" name="kewarganegaraan" required>
                            <option value="WNI" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                            <option value="WNA" {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA</option>
                        </select>
                         @error('kewarganegaraan')
                            <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                         <select class="form-select @error('status_perkawinan') is-invalid @enderror" id="status_perkawinan" name="status_perkawinan" required>
                             <option value="" disabled>Pilih Status</option>
                           @foreach(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $sp)
                                <option value="{{ $sp }}" {{ old('status_perkawinan', $penduduk->status_perkawinan) == $sp ? 'selected' : '' }}>{{ $sp }}</option>
                            @endforeach
                        </select>
                        @error('status_perkawinan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="col-md-4 mb-3">
                         <label for="status_dalam_keluarga" class="form-label">Status Hub. Keluarga</label>
                         <select class="form-select @error('status_dalam_keluarga') is-invalid @enderror" id="status_dalam_keluarga" name="status_dalam_keluarga" required>
                            <option value="" disabled>Pilih Status</option>
                            @foreach(['Kepala Keluarga', 'Istri', 'Anak', 'Suami', 'Famili Lain', 'Orang Tua', 'Mertua', 'Menantu', 'Cucu', 'Lainnya'] as $shk)
                                <option value="{{ $shk }}" {{ old('status_dalam_keluarga', $penduduk->status_dalam_keluarga) == $shk ? 'selected' : '' }}>{{ $shk }}</option>
                            @endforeach
                        </select>
                        @error('status_dalam_keluarga')
                             <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="status_penduduk" class="form-label">Status Penduduk</label>
                        <select class="form-select @error('status_penduduk') is-invalid @enderror" id="status_penduduk" name="status_penduduk" required>
                            <option value="Tetap" {{ old('status_penduduk', $penduduk->status_penduduk) == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                            <option value="Pendatang" {{ old('status_penduduk', $penduduk->status_penduduk) == 'Pendatang' ? 'selected' : '' }}>Pendatang</option>
                            <option value="Pindah" {{ old('status_penduduk', $penduduk->status_penduduk) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                             <option value="Meninggal" {{ old('status_penduduk', $penduduk->status_penduduk) == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                        @error('status_penduduk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                     <div class="col-md-6 mb-3">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror" id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $penduduk->nama_ayah) }}" required>
                         @error('nama_ayah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror" id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $penduduk->nama_ibu) }}" required>
                         @error('nama_ibu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat_lengkap" class="form-label">Alamat Lengkap (Sesuai KTP)</label>
                    <textarea class="form-control @error('alamat_lengkap') is-invalid @enderror" id="alamat_lengkap" name="alamat_lengkap" rows="2" required>{{ old('alamat_lengkap', $penduduk->alamat_lengkap) }}</textarea>
                    @error('alamat_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                 <div class="mb-3">
                    <label for="photo_ktp" class="form-label">Foto KTP <small class="text-muted">(Upload untuk ganti)</small></label>
                    <input type="file" class="form-control @error('photo_ktp') is-invalid @enderror" id="photo_ktp" name="photo_ktp" accept="image/*">
                    @error('photo_ktp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($penduduk->photo_ktp)
                        <div class="mt-2">
                             <a href="{{ asset('storage/' . $penduduk->photo_ktp) }}" target="_blank" class="text-decoration-none">
                                <img src="{{ asset('storage/' . $penduduk->photo_ktp) }}" alt="Foto KTP" class="img-thumbnail" style="max-height: 150px;">
                                <div class="small text-muted mt-1"><i data-lucide="eye" style="width: 14px; height: 14px;"></i> Lihat Foto Saat Ini</div>
                             </a>
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('penduduk.index') }}" class="btn btn-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Batal mengubah data dan kembali ke halaman utama">Batal</a>
                    <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Simpan perubahan data penduduk">Update</button>
                </div>
            </form>
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
