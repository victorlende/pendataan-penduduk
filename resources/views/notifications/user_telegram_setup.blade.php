@extends('layouts.app')

@section('content')
<div class="container-fluid d-flex align-items-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            
            @if(!$currentChatId)
            <div class="text-center mb-4 mt-3">
                <h3 class="fw-bold text-dark">Hubungkan Telegram</h3>
                <p class="text-secondary">Supaya notifikasi surat masuk langsung ke HP Anda.</p>
            </div>
            @endif

            <div class="card border rounded-4">
                <div class="card-body p-2">

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center mb-4 rounded-3 border-0 bg-success bg-opacity-10 text-success">
                            <!-- <i data-lucide="check-circle" class="me-2"></i> -->
                            <div class="fw-bold">{{ session('success') }}</div>
                        </div>
                    @endif


                    @if($currentChatId)
                        <div class="text-center py-4 mb-4 bg-light rounded-3 border border-success border-opacity-25">
                            <div class="mb-2 d-inline-flex">
                                <i data-lucide="badge-check" class="text-success" style="width: 32px; height: 32px;"></i>
                            </div>
                            <h4 class="fw-bold text-success mb-1">Sudah Terhubung!</h4>
                            <p class="text-secondary mb-0">Anda akan menerima notifikasi otomatis.</p>
                            <small class="text-secondary font-monospace opacity-50">ID: {{ $currentChatId }}</small>
                        </div>
                    @else
                 
                        <div class="mb-4">
                            <label class="fw-bold text-secondary small mb-3 text-uppercase ls-1">Ikuti 2 Langkah Mudah:</label>
                            
                           
                            <div class="d-flex align-items-center mb-3 p-3 border rounded-3">
                                <div class="me-3">
                                    <span class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 40px; height: 40px;">1</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Chat ke Bot Desa</h6>
                                    <p class="text-secondary small mb-2">Klik tombol di bawah, lalu klik <strong>Start</strong> di aplikasi Telegram.</p>
                                    <a href="https://t.me/simpendudukdesanaisau_bot" target="_blank" class="btn btn-primary w-100 rounded-pill fw-bold d-flex align-items-center justify-content-center gap-2">
                                        <i data-lucide="send" style="width: 18px; height: 18px;"></i> Buka Aplikasi Telegram
                                    </a>
                                </div>
                            </div>

                         
                            <div class="d-flex align-items-start p-3 border rounded-3">
                                <div class="me-3">
                                    <span class="bg-white border border-2 border-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 40px; height: 40px;">2</span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Pilih Nama Anda</h6>
                                    <p class="text-secondary small mb-2">
                                        Setelah chat bot, kembali ke sini dan klik tombol <strong>"Cari Pesan Saya"</strong>.
                                    </p>
                                    
                                    <a href="{{ route('notifications.userTelegramSetup') }}" class="btn btn-outline-primary w-100 rounded-pill mb-3 d-flex align-items-center justify-content-center gap-2">
                                        <i data-lucide="refresh-cw" style="width: 18px; height: 18px;"></i> Cari Pesan Saya
                                    </a>

                                  
                                    @if(count($updates) > 0)
                                        <div class="list-group rounded-3 overflow-hidden border">
                                            @foreach($updates as $update)
                                                @if(isset($update['message']))
                                                    <div class="list-group-item list-group-item-action d-flex align-items-center p-3 border-0 border-bottom">
                                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                            <i data-lucide="user" class="text-secondary"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-bold text-dark">
                                                                {{ $update['message']['from']['first_name'] ?? '' }} 
                                                                {{ $update['message']['from']['last_name'] ?? '' }}
                                                            </div>
                                                            <div class="text-secondary small">
                                                                Pesan: "{{ $update['message']['text'] ?? '-' }}"
                                                            </div>
                                                            <div class="text-secondary small" style="font-size: 10px;">
                                                                {{ \Carbon\Carbon::createFromTimestamp($update['message']['date'])->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <form method="POST" action="{{ route('notifications.saveUserTelegramId') }}">
                                                                @csrf
                                                                <input type="hidden" name="telegram_chat_id" value="{{ $update['message']['chat']['id'] }}">
                                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 fw-bold">
                                                                    Hubungkan
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @elseif(request()->has('updates'))
                                        <div class="alert alert-warning border-0 small text-center rounded-3">
                                            Belum ada pesan masuk. Pastikan Anda sudah chat <code>/start</code> ke bot.
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endif

                   
                    <div class="text-center mt-4">
                        <a class="text-secondary text-decoration-none small collapsed d-flex align-items-center justify-content-center gap-1" data-bs-toggle="collapse" href="#manualInput" role="button" aria-expanded="false">
                            Masalah? Input ID Manual <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
                        </a>
                    </div>
                    
                    <div class="collapse mt-3" id="manualInput">
                        <div class="card card-body bg-light border-0 rounded-3">
                            <form method="POST" action="{{ route('notifications.saveUserTelegramId') }}">
                                @csrf
                                <div class="form-floating mb-2">
                                    <input type="text" name="telegram_chat_id" class="form-control border-0" id="floatingInput" placeholder="123456" value="{{ $currentChatId ?? '' }}">
                                    <label for="floatingInput">Telegram Chat ID</label>
                                </div>
                                <button type="submit" class="btn btn-secondary w-100 rounded-pill">Simpan ID</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <div class="text-center mt-4 mb-5">
                <a href="{{ route('surat.my') }}" class="text-decoration-none fw-bold text-primary d-flex align-items-center justify-content-center gap-1">
                    <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i> Kembali ke Surat Saya
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
