@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Edit Template: {{ $template->title }}</h3>
        <a href="{{ route('letter-templates.index') }}" class="btn btn-light">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('letter-templates.update', $template->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Isi Surat</label>
                            <textarea name="content" id="editor">{{ $template->content }}</textarea>
                            <div class="form-text">
                                Gunakan editor di atas untuk menyusun format surat. Variabel dalam kurung siku <code>[...]</code> jangan diubah formatnya.
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header bg-light fw-bold">Variabel Tersedia</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small" style="max-height: 400px; overflow-y: auto;">
                        @foreach($availableVariables as $key => $desc)
                        <li class="list-group-item">
                            <code class="fw-bold text-primary">{{ $key }}</code>
                            <div class="text-muted" style="font-size: 0.85em;">{{ $desc }}</div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="alert alert-info small">
                <i data-lucide="info" style="width: 16px; height: 16px;" class="me-1"></i>
                Salin kode variabel (contoh: <code>[NAMA]</code>) ke dalam editor surat.
            </div>
        </div>
    </div>
</div>

<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [ 
                'heading', '|', 
                'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'insertTable', 'tableColumn', 'tableRow', 'mergeTableCells', '|',
                'undo', 'redo'
            ],
            table: {
                contentToolbar: [ 'tableColumn', 'tableRow', 'mergeTableCells' ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
