@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Kartu Keluarga</h3>

    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('kk.update', $kk->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="no_kk" class="form-label">Nomor Kartu Keluarga</label>
                    <input type="text" class="form-control @error('no_kk') is-invalid @enderror" id="no_kk" name="no_kk" value="{{ old('no_kk', $kk->no_kk) }}" required>
                    @error('no_kk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="dusun_id" class="form-label">Dusun</label>
                    <select class="form-select @error('dusun_id') is-invalid @enderror" id="dusun_id" name="dusun_id" required>
                        <option value="" disabled>Pilih Dusun</option>
                        @foreach($dusuns as $dusun)
                            <option value="{{ $dusun->id }}" {{ old('dusun_id', $kk->dusun_id) == $dusun->id ? 'selected' : '' }}>{{ $dusun->nama_dusun }}</option>
                        @endforeach
                    </select>
                    @error('dusun_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $kk->alamat) }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="rt" class="form-label">RT</label>
                        <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt" value="{{ old('rt', $kk->rt) }}" required>
                        @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="rw" class="form-label">RW</label>
                        <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw" value="{{ old('rw', $kk->rw) }}" required>
                        @error('rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <a href="{{ route('kk.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
