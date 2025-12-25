@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Data Dusun</h3>

    <div class="card col-md-6 mt-3">
        <div class="card-body">
            <form action="{{ route('dusun.update', $dusun->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_dusun" class="form-label">Nama Dusun</label>
                    <input type="text" class="form-control @error('nama_dusun') is-invalid @enderror" id="nama_dusun" name="nama_dusun" value="{{ old('nama_dusun', $dusun->nama_dusun) }}" required>
                    @error('nama_dusun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kepala_dusun" class="form-label">Nama Kepala Dusun</label>
                    <input type="text" class="form-control @error('kepala_dusun') is-invalid @enderror" id="kepala_dusun" name="kepala_dusun" value="{{ old('kepala_dusun', $dusun->kepala_dusun) }}" required>
                    @error('kepala_dusun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <a href="{{ route('dusun.index') }}" class="btn btn-light">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
