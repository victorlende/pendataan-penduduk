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
            <div class="card border-0 mb-3">
                <div class="card-header bg-white fw-bold d-flex align-items-center justify-content-between py-3">
                    <span class="text-dark">
                        <i data-lucide="tags" style="width: 18px; height: 18px;" class="me-2 align-text-bottom text-primary"></i>
                        Variabel
                    </span>
                    <small class="text-muted fw-normal" style="font-size: 0.8em;">Klik untuk menyalin</small>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto;">
                        @foreach($availableVariables as $key => $desc)
                        <button type="button" 
                                class="list-group-item list-group-item-action d-flex flex-column align-items-start py-3 variable-btn" 
                                onclick="copyToClipboard('{{ $key }}', this)"
                                title="Salin {{ $key }}">
                            <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                <code class="fw-bold text-primary bg-primary bg-opacity-10 px-2 py-1 rounded transition-all">{{ $key }}</code>
                                <i data-lucide="copy" style="width: 14px; height: 14px;" class="text-muted opacity-50 copy-icon"></i>
                            </div>
                            <small class="text-muted lh-sm">{{ $desc }}</small>
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="alert alert-light border  d-flex gap-3 align-items-start">
                <i data-lucide="info" class="text-info mt-1 flex-shrink-0" style="width: 18px; height: 18px;"></i>
                <div class="small text-muted lh-sm">
                    <strong>Tips:</strong> Klik salah satu variabel di atas untuk menyalin kodenya, lalu tempel (<strong>Ctrl+V</strong>) di dalam editor surat.
                </div>
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

    function copyToClipboard(text, element) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(function() {
                showCopyFeedback(element);
            }).catch(err => {
                console.error('Async: Could not copy text: ', err);
                fallbackCopyTextToClipboard(text, element);
            });
        } else {
            fallbackCopyTextToClipboard(text, element);
        }
    }

    function fallbackCopyTextToClipboard(text, element) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        
        // Ensure it's not visible but part of the DOM
        textArea.style.position = "fixed";
        textArea.style.left = "-9999px";
        textArea.style.top = "0";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            if (successful) {
                showCopyFeedback(element);
            } else {
                console.error('Fallback: Copying text command was unsuccessful');
                alert('Gagal menyalin text. Silakan salin manual.');
            }
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
            alert('Gagal menyalin text. Silakan salin manual.');
        }

        document.body.removeChild(textArea);
    }

    function showCopyFeedback(element) {
        const codeEl = element.querySelector('code');
        if (!codeEl) return;
        
        const originalText = codeEl.innerText;
        const originalClass = codeEl.className;
        
        // Visual feedback
        codeEl.innerText = 'Disalin!';
        codeEl.className = 'fw-bold text-success bg-success bg-opacity-10 px-2 py-1 rounded transition-all';
        
        setTimeout(() => {
            codeEl.innerText = originalText;
            codeEl.className = originalClass;
        }, 1000);
    }
</script>
@endsection
