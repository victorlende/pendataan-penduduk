@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Kelola Template Surat</h3>
        <a href="{{ route('surat.index') }}" class="btn btn-light">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode Template</th>
                        <th>Judul Surat</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($templates as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><code>{{ $t->key }}</code></td>
                        <td>{{ $t->title }}</td>
                        <td class="text-center">
                            <a href="{{ route('letter-templates.edit', $t->id) }}" class="btn btn-primary btn-sm">
                                <i data-lucide="pencil" style="width: 16px; height: 16px;"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
