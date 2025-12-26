@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0">
                <div class="card-body">
                    
                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center mb-4">
                            <i data-lucide="check-circle" class="me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                    @endif

                    <!-- Konfigurasi Saat Ini -->
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <h6 class="text-uppercase text-muted fw-bold small mb-2">Konfigurasi Saat Ini</h6>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    @if($currentChatId)
                                        <div class="d-flex align-items-center">
                                            <code class="fs-5 fw-bold text-dark me-2">{{ $currentChatId }}</code>
                                            <span class="badge bg-success rounded-pill">Terhubung</span>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <span class="text-danger fw-bold">Belum Dikonfigurasi</span>
                                            <i data-lucide="alert-circle" class="text-danger ms-2"></i>
                                        </div>
                                    @endif
                                </div>
                                @if($currentChatId)
                                    <button class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" onclick="navigator.clipboard.writeText('{{ $currentChatId }}')">
                                        <i data-lucide="copy" style="width: 14px; height: 14px;"></i> Salin
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Instruksi -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Cara Mendapatkan Chat ID:</h6>
                        <ol class="list-group list-group-numbered list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Mulai Percakapan</div>
                                    Buka Telegram dan cari bot <strong>@simpendudukdesanaisau_bot</strong>, atau <a href="https://t.me/simpendudukdesanaisau_bot" target="_blank" class="text-decoration-none">Klik Disini</a>, lalu kirim pesan <code>/start</code>.
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Cek Pesan Masuk</div>
                                    Klik tombol <strong>Refresh Updates</strong> di bawah untuk melihat pesan terakhir yang masuk.
                                </div>
                            </li>
                            <!-- <li class="list-group-item d-flex justify-content-between align-items-start bg-transparent px-0">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Simpan Chat ID</div>
                                    Salin <strong>Chat ID</strong> dari tabel di bawah, lalu masukkan ke file <code>.env</code> project Anda:
                                    <div class="mt-2 p-2 bg-dark text-white rounded font-monospace small">
                                        TELEGRAM_ADMIN_CHAT_ID=xxxxxxxxx
                                    </div>
                                </div>
                            </li> -->
                        </ol>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0">Pesan Terakhir (Updates)</h6>
                        <a href="{{ route('notifications.adminTelegramSetup') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                            <i data-lucide="refresh-cw" style="width: 16px; height: 16px;"></i> Refresh Updates
                        </a>
                    </div>

                    @if(count($updates) > 0)
                        <div class="table-responsive border">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-3">Waktu</th>
                                        <th>Pengirim</th>
                                        <th>Pesan</th>
                                        <th>Chat ID</th>
                                        <th class="text-end pe-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($updates as $update)
                                        @if(isset($update['message']))
                                            <tr>
                                                <td class="ps-3 text-muted small">{{ date('d M Y, H:i', $update['message']['date']) }}</td>
                                                <td>
                                                    <div class="fw-bold">{{ $update['message']['from']['first_name'] ?? '' }}</div>
                                                    <!-- <small class="text-muted">{{ '@'.($update['message']['from']['username'] ?? '-') }}</small> -->
                                                </td>
                                                <td>{{ $update['message']['text'] ?? '-' }}</td>
                                                <td><code class="fw-bold text-primary">{{ $update['message']['chat']['id'] }}</code></td>
                                                <td class="text-end pe-3">
                                                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" onclick="navigator.clipboard.writeText('{{ $update['message']['chat']['id'] }}')">
                                                        Salin ID
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 border rounded bg-light">
                            <i data-lucide="inbox" class="text-muted mb-3" style="width: 48px; height: 48px;"></i>
                            <p class="text-muted mb-0">Belum ada pesan baru yang diterima bot.</p>
                            <small class="text-muted">Coba kirim pesan ke bot Telegram sekarang.</small>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
